<?php
App::import('Vendor', 'Invoices.IInvoiceNumberGenerator');
App::uses('Invoices.InvoicesAppModel', 'Model');
/**
 * Invoice model
 *
 */
class Invoice extends InvoicesAppModel implements IInvoiceNumberGenerator {
/**
 * Class name
 *
 * @var string
 */
	public $name = 'Invoice';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

/**
 * Validation rules - initialized in constructor
 *
 * @var array
 */
	public $validate = array();

/**
 * Specific behaviors
 *
 * @var array
 */
	public $actsAs = array('Search.Searchable');

/**
 * Filters args for Search.Searchable
 *
 * @var array
 */
	public $filterArgs = array(
		array('name' => 'created', 'type' => 'like'),
		array('name' => 'client_name', 'type' => 'like'),
		array('name' => 'price', 'type' => 'expression', 'method' => 'makeRangePrice', 'field' => 'Invoice.global_price BETWEEN ? AND ?'),
	);

/**
 * belongsTo associations - initialized in constructor
 *
 * @var array
 */
	public $belongsTo = array();

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'InvoiceLine' => array(
			'className' => 'Invoices.InvoiceLine',
			'dependent' => true
		)
	);

/**
 * Invoice number generator class name (self by default)
 *
 * @var IInvoiceNumberGenerator
 * @access private
 */
	private $__invoiceNumberGenerator;

/**
 * Is the id of invoice table identical to the number
 *
 * @var IInvoiceNumberGenerator
 * @access private
 */
	private $__idIsNumber = true;

/**
 * Attribute used for temporary storing data between save callbacks
 *
 * @var array
 * @access protected
 */
	protected $_save = array();

/**
 * Constructor
 *
 * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		$userClass = Configure::read('Invoices.UserClass');
		$this->__idIsNumber = Configure::read('Invoices.isIsNumber');
		if (is_null($this->__idIsNumber)) {
			$this->__idIsNumber = true;
		}

		$maxLengthRule = create_function('$limit', <<<FUNC
			return array('maxLength' => array(
				'rule' => array('maxLength', \$limit),
				'message' => sprintf(__('Le field must not exceed %s characters', true), \$limit),
				'allowEmpty' => true,
				'required' => false,
				'last' => false,
			));
FUNC
		);
		$this->validate = array(
			'prefix' => $maxLengthRule(10),
			'payment_type' => $maxLengthRule(20),
			'payment_ref' => $maxLengthRule(100),
		);

		$this->belongsTo = array(
			'Client' => array(
				'className' => $userClass,
				'foreignKey' => 'client_id',
			)
		);

		parent::__construct($id, $table, $ds);
		$this->_setInvoiceNumberGenerator(Configure::read('Invoice.invoiceNumberGenerator'));
	}

/**
 * Before save callback
 * 	- Generates a unique invoice number
 *
 * @return boolean Whether the save can continue or not
 * @access public
 */
	public function beforeSave() {
		$_cacheQueries = $this->cacheQueries;
		$this->cacheQueries = false;
		if (empty($this->id)) {
			$lastInvoiceNumber = $this->find('first', array(
				'fields' => array($this->alias . '.number'),
				'order' => array($this->alias . '.created DESC'),
				'recursive' => -1
			));
			$lastInvoiceNumber = isset($lastInvoiceNumber[$this->alias]['number']) ? $lastInvoiceNumber[$this->alias]['number'] : null;

			$try = 1;
			do {
				$invoiceNumber = call_user_func(array($this->__invoiceNumberGenerator, 'generateInvoiceNumber'), $lastInvoiceNumber, $try);
				if ($try++ > 10 || empty($invoiceNumber)) {
					trigger_error(__d('invoices', '10 unsuccessful tries for invoice number generation. Check the generation algorithm.', true), E_USER_WARNING);
					$invoiceNumber = String::uuid();
				}
				$duplicate = $this->find('count', array(
					'conditions' => array($this->escapeField('number') => $invoiceNumber)
				));
			} while(!empty($duplicate));

			$this->data[$this->alias]['number'] = $invoiceNumber;
			if ($this->__idIsNumber) {
				$this->data[$this->alias]['id'] = $invoiceNumber;
			} else {
				$this->data[$this->alias]['id'] = String::uuid();
			}
		} else {
			$this->_save['initial_state'] = $this->find('first', array(
				'recursive' => -1,
				'conditions' => array($this->alias . '.' . $this->primaryKey => $this->id)
			));
		}
		$this->cacheQueries = $_cacheQueries;
		return true;
	}

/**
 * Method allowing to retrieve all details for a Invoice with related information
 *
 * @throws OutOfBoundsException if the entry is not found
 * @param string $id Invoice id, optional [default: $this->id]
 * @return array Invoice data
 */
	public function view($id = null) {
		if (is_null($id)) {
			$id = $this->id;
		}
		$invoice = $this->find('first', array(
			'contain' => array('InvoiceLine'),
			'conditions' => array($this->alias . '.' . $this->primaryKey => $id)
		));

		if (empty($invoice)) {
			throw new OutOfBoundsException(__d('invoices', 'Invalid Invoice', true));
		}
		return $invoice;
	}

/**
 * Generate an invoice.
 *
 * @param array $client The client.
 *	The array must have keys : 'client_id', 'client_name' and 'client_address'.
 * @param array $invoiceLines The invoice lines.
 *	The array must contain an array for each invoice line.
 *	Each array of invoice line must have keys : 'product_model', 'product_id', 'product_name',
 *	'excl_tax_price', 'tva_price' and 'tva_rate'.
 * @param array $payment Payment information with the following keys: payment_type, payment_ref. Optional
 * @param string $prefix Prefix for the invoice number.
 * @return boolean True if the invoice is generated.
 */
	public function generate($client, $invoiceLines, $payment = array(), $prefix = null) {
		$invoice = array($this->alias => array(
			'prefix' => $prefix,
			'client_id' => $client['client_id'],
			'client_name' => $client['client_name'],
			'client_address' => $client['client_address'],
			'payment_type' => empty($payment['payment_type']) ? null : $payment['payment_type'],
			'payment_ref' => empty($payment['payment_ref']) ? null : $payment['payment_ref'],
		));

		$invoice['InvoiceLine'] = $invoiceLines;
		$invoice[$this->alias]['global_price'] = $this->getGlobalPrice($invoice);
		$this->create($invoice);
		$success = $this->saveAssociated($invoice);

		if ($success) {
			$this->Client->id = $client['client_id'];
			if (!$this->Client->exists()) {
				$this->log(sprintf(__d('invoices', 'The client of invoice n°%s do not exists.', true), $this->id));
			}
		} else {
			$date = strftime('%d %B %Y at %H:%M:%S');
			$this->log(sprintf(__d('invoices', 'The invoice for client %s the %s was not generate.', true),$client['client_id'],$date));
		}

		return $success;
	}

/**
 * Define the array for range of price
 *
 * @param array $data data of search.serchable
 * @return array the range
 */
	public function makeRangePrice($data) {
		$min = empty($data['min_price'])?0:$data['min_price'];
		$max = empty($data['max_price'])?PHP_INT_MAX:$data['max_price'];
		return array($min, $max);
	}

/**
 * Return the global price of the invoice
 *
 * @param mixed $invoice Either an invoice with invoice lines, either its id
 * @return float The global price.
 */
	public function getGlobalPrice($invoice = null) {
		$globalPrice = 0.0;
		if(empty($invoice) || !is_array($invoice) || empty($invoice['InvoiceLine'])) {
			if (!is_null($invoice)) {
				$this->id = $invoice;
			}

			if ($this->exists()) {
				$invoiceLines = $this->InvoiceLine->find('all', array(
					'conditions' => array('InvoiceLine.invoice_id' => $this->id),
					'fields' => array('SUM(InvoiceLine.excl_tax_price + InvoiceLine.tva_price) as global_price'),
				));

				$globalPrice = floatval($invoiceLines[0][0]['global_price']);
			} else {
				trigger_error(__d('invoices', 'Invoices.Invoice::getGlobalPrice - Either $invoice is not an id, either their is no "InvoiceLine" key in array', true), E_USER_WARNING);
			}
		} else {
			foreach ($invoice['InvoiceLine'] as $invoiceLine) {
				$globalPrice += $invoiceLine['excl_tax_price'] + $invoiceLine['tva_price'];
			}
		}

		return $globalPrice;
	}

/**
 * Add key for range
 *
 * @param array $data Criteria of key->value pairs from post/named parameters
 * @return array Array of conditions that express the conditions needed for the search.
 */
	public function parseCriteria($data) {
		if (!empty($data['min_price']) || !empty($data['max_price'])) {
			$data['price'] = true;
		}
		return parent::parseCriteria($data);
	}

/**
 * Generate an unique invoice number with the following format: YYYY-xxx (e.g: 20100319-001)
 *
 * @param string $latestNumber Latest invoice number known by the system
 * @param int $tryCount Count of the current try of invoice number generation (On first call its value is 1)
 * @return string Invoice number to use
 * @access public
 */
	public static function generateInvoiceNumber($latestNumber, $tryCount) {
		$base = date('Y');
		$increment = 0;
		if (!empty($latestNumber)) {
			list($latestBase, $latestIncrement) = explode('-', $latestNumber);
			if ($latestBase == $base) {
				$increment = (int) $latestIncrement;
			}
		}

		$increment = (int) $increment + $tryCount;
		return $base . '-' . str_pad($increment, 3, '0', STR_PAD_LEFT);
	}

/**
 * Sets the invoice number generator class after checking it is a valid class.
 * If the class is invalid an error is triggered.
 *
 * @param mixed $generator Generator class. It can be the class object or a class name
 * @return void
 * @access protected
 */
	protected function _setInvoiceNumberGenerator($generator = null) {
		if (empty($generator)) {
			$generator = $this;
		}

		if ( (is_string($generator) && !class_exists($generator)) || !in_array('IInvoiceNumberGenerator', class_implements($generator))) {
			trigger_error(sprintf(
				__d('invoices', 'Invalid class %s for invoice number generation. It must implement the IInvoiceNumberGenerator interface.', true),
				is_string($generator) ? $generator : get_class($generator)
			), E_USER_ERROR);
		} else {
			$this->__invoiceNumberGenerator = $generator;
		}
	}
}