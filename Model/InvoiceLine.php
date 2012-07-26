<?php
App::uses('Invoices.InvoicesAppModel', 'Model');
/**
 * InvoiceLine model
 *
 */
class InvoiceLine extends InvoicesAppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = '';

/**
 * Validation rules - initialized in constructor
 *
 * @var array
 */
	public $validate = array();

/**
 * Fields with decimal values - initialized in constructor
 *
 * @var array
 */
	public $decimals = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Invoice' => array(
			'className' => 'Invoices.Invoice',
			'foreignKey' => 'invoice_id',
		)
	);

/**
 * Constructor
 *
 * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		$this->validate = array(
			'product_model' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('invoices', 'Please enter a product Model Class', true),
					'allowEmpty' => false,
					'required' => true,
					'last' => false,
				),
				'maxlength' => array(
					'rule' => array('maxlength', 100),
					'message' => __d('invoices', 'The product Model Class should not exceed 100 characters', true),
				),
			),
			'product_id' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('invoices', 'Please enter a product id', true),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'product_name' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('invoices', 'Please enter a product name', true),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'excl_tax_price' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('invoices', 'Please a decimal value for ecl. tax price', true),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'tva_price' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('invoices', 'Please enter a decimal value for tva price', true),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'tva_rate' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('invoices', 'Please enter a decimal value for tva rate', true),
					'allowEmpty' => false,
					'required' => true,
				),
			),
		);

		parent::__construct($id, $table, $ds);
	}
}