<?php
App::uses('Invoice.InvoiceAppController', 'Controller');
/**
 * Invoices controller
 * Allows to manage Invoices
 *
 * @property Invoice $Invoice
 */
class InvoicesController extends InvoicesAppController {
/**
 * Invoices specific helpers
 *
 * @var array
 */
	public $helpers = array('Invoices.InvoicePdf', 'Invoices.InvoiceDecorator');

/**
 * Before filter callback
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('view', 'index');
	}

/**
 * Specific components
 *
 * @var array
 */
	public $components = array('Search.Prg', 'Session');

/**
 * Preset variables for Search.Searchable
 *
 * @var array
 */
	public $presetVars = array(
		array('field' => 'created', 'type' => 'value'),
		array('field' => 'client_name', 'type' => 'value'),
		array('field' => 'min_price', 'type' => 'value'),
		array('field' => 'max_price', 'type' => 'value'),
	);

/**
 * Allows to see the invoice or download a pdf version of invoice
 *
 * @param string $id The invoice $id
 * @return void
 */
	public function view ($id) {
		try {
			$invoice = $this->Invoice->view($id);
		} catch (OutOfBoundsException $exc) {
			$this->Session->setFlash($exc->getMessage(), 'error');
			return $this->redirect($this->referer(), 404);
		}
		if ($invoice['Invoice']['client_id'] != $this->__getAuthUserId()) {
			$this->Session->setFlash(__d('invoices', 'You are not allowed to see this invoice.'));
			return $this->redirect($this->referer());
		}

		$InvoiceSettings = ClassRegistry::init('Invoices.InvoiceSetting');
		$invoiceSettings = $InvoiceSettings->find('list', array('fields' => array('tag', 'value')));

		$this->set(compact('invoice', 'invoiceSettings'));
	}

/**
 * List the Invoices of the current user
 *
 * @return void
 */
	public function index () {
		$this->Prg->commonProcess();
		$searchOptions = array('conditions' => $this->Invoice->parseCriteria($this->request->params['named']));
		$this->paginate = array('limit' => 10) + array_merge_recursive(
			array(
				'conditions' => array('Invoice.client_id' => $this->__getAuthUserId()),
				'order' => 'Invoice.created DESC',
			),
			$this->paginate,
			$searchOptions
		);

		$invoices = $this->paginate();
		$this->set(compact('invoices'));
	}

/**
 * Allows to see the invoice or download a pdf version of invoice
 *
 * @param string $id The invoice $id
 * @return void
 */
	public function admin_view ($id) {
		try {
			$invoice = $this->Invoice->view($id);
		} catch (OutOfBoundsException $exc) {
			$this->Session->setFlash($exc->getMessage(), 'error');
			return $this->redirect($this->referer(array('action' => 'index')), 403);
		}
		$InvoiceSettings = ClassRegistry::init('Invoices.InvoiceSetting');
		$invoiceSettings = $InvoiceSettings->find('list', array('fields' => array('tag', 'value')));

		$this->set(compact('invoice', 'invoiceSettings'));
		$this->render('view');
	}

/**
 * List the Invoices
 *
 * @return void
 */
	public function admin_index () {
		$this->Prg->commonProcess();
		$searchOptions = array('conditions' => $this->Invoice->parseCriteria($this->request->params['named']));
		$this->paginate = array('limit' => 10) + array_merge_recursive(
			array(
				'order' => 'Invoice.created DESC',
			),
			$this->paginate,
			$searchOptions
		);

		$invoices = $this->paginate();
		$this->set(compact('invoices'));
	}

	private function __getAuthUserId() {
		$userModel = Configure::read('Invoice.UserModel');
		if (empty($userModel)) {
			$userModel = 'User';
		}
		$userPrimaryKey = Configure::read('Invoice.UserPrimaryKey');
		if (empty($userPrimaryKey)) {
			$userPrimaryKey = 'id';
		}

		$authUserId = $this->Auth->user($userPrimaryKey);
		if (empty($authUserId)) {
			$authUser = $this->Auth->user($userModel);
			$authUserId = $authUser[$userPrimaryKey];
		}

		return $authUserId;
	}
}