<?php
/* InvoiceLine Test cases generated on: 2011-12-02 14:12:52 : 1322832532*/
App::uses('Invoices.InvoiceSetting', 'Model');
App::import('Vendor', 'Invoices.SimpleAppTestCase');

class InvoiceSettingTest extends SimpleAppTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.invoices.plugin_invoice',
		'plugin.invoices.plugin_invoice_client',
		'plugin.invoices.plugin_invoice_line',
		'plugin.invoices.plugin_invoice_setting',
	);

/**
 * First record from fixtures
 *
 * @var array
 */
	protected $_record = array();

/**
 * Model being tested
 *
 * @var InvoiceLine
 */
	public $InvoiceSetting;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InvoiceSetting =
		$this->InvoiceLine = ClassRegistry::init(array(
			'class' => 'Invoices.InvoiceSetting',
			'table' => 'plugin_invoice_settings',
			'ds' => 'test',
			'alias' => 'InvoiceSetting'
		));

		$this->_record = $this->InvoiceSetting->find();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InvoiceSetting);
		parent::tearDown();
	}

/**
 * Test validation rules
 *
 * @return void
 */
	public function testValidation() {
		$this->assertValid($this->InvoiceSetting, $this->_record);
	}

	public function testMandatoryFields() {
		// Test mandatory fields
		$data = array('InvoiceSetting' => array('id' => 'new-id'));
		$expectedErrors = array('name', 'value', 'tag');
		$this->assertValidationErrors($this->InvoiceSetting, $data, $expectedErrors);
	}

	public function testUniqueTag() {
		$data = $this->_record;
		$data['InvoiceSetting']['id'] = 'new-id';
		$expectedErrors = array('tag');
		$this->assertValidationErrors($this->InvoiceSetting, $data, $expectedErrors);
	}
}