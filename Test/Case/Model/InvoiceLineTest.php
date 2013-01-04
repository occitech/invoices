<?php
/* InvoiceLine Test cases generated on: 2011-12-02 14:12:52 : 1322832532*/
App::uses('Invoices.InvoiceLine', 'Model');
App::import('Vendor', 'Invoices.SimpleAppTestCase');

class InvoiceLineTest extends SimpleAppTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.invoices.plugin_invoice',
		'plugin.invoices.plugin_invoice_client',
		'plugin.invoices.plugin_invoice_line',
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
	public $InvoiceLine;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InvoiceLine = ClassRegistry::init(array(
			'class' => 'Invoices.InvoiceLine',
			'table' => 'plugin_invoice_lines',
			'ds' => 'test',
			'alias' => 'InvoiceLine'
		));

		$this->InvoiceLine->recursive = -1;
		$this->_record = $this->InvoiceLine->find('first');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InvoiceLine);
		parent::tearDown();
	}

/**
 * Test validation rules
 *
 * @return void
 */
	public function testValidation() {
		$this->assertValid($this->InvoiceLine, $this->_record);
	}

	public function testValidationWithComa() {
		$recordWithComa = $this->InvoiceLine->read(null, 'invoice_line-2');
		$this->assertValid($this->InvoiceLine, $recordWithComa);
	}

	public function testValidationWithZeo() {
		$recordWithZero = $this->InvoiceLine->read(null, 'invoice_line-3');
		$this->assertValid($this->InvoiceLine, $recordWithZero);
	}

	public function testMandatoryFields() {
		// Test mandatory fields
		$data = array('InvoiceLine' => array('id' => 'new-id'));
		$expectedErrors = array('product_model', 'product_id', 'product_name', 'excl_tax_price', 'tva_price', 'tva_rate');
		$this->assertValidationErrors($this->InvoiceLine, $data, $expectedErrors);
	}

	public function testValidationWithProductModelTooLong() {
		$data = $this->_record;
		$data['InvoiceLine']['product_model'] = str_pad('too long', 1000);
		$expectedErrors = array('product_model');
		$this->assertValidationErrors($this->InvoiceLine, $data, $expectedErrors);
	}

	public function testValidationNaNPrices() {
		$data = $this->_record;
		$data['InvoiceLine']['excl_tax_price'] = 'NaN';
		$data['InvoiceLine']['tva_price'] = 'NaN';
		$data['InvoiceLine']['tva_rate'] = 'NaN';
		$expectedErrors = array('excl_tax_price', 'tva_price', 'tva_rate');
		$this->assertValidationErrors($this->InvoiceLine, $data, $expectedErrors);
	}
}