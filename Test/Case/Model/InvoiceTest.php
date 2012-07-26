<?php
/* Invoice Test cases generated on: 2011-12-02 14:12:49 : 1322831809*/
//App::uses('Invoices.Invoice', 'Model');
App::import('Model', 'Invoices.Invoice');
App::import('Vendor', 'Invoices.SimpleAppTestCase');

/**
 * Client model
 *
 * @package invoices
 * @subpackage invoices.tests.cases.model
 */
class InvoiceClient extends CakeTestModel {
/**
 * Table to use
 *
 * @var string
 */
	public $useTable = 'invoice_clients';
}

/**
 * Spy model allowing to access CartOrder's protected attributes
 *
 */
class SpyInvoice extends Invoice {
	public $useDbConfig = 'test';
	public $cacheSources = false;
	public function setInvoiceNumberGenerator($val) {
		$this->_setInvoiceNumberGenerator($val);
	}
}

class TestInvoiceNumberGenerator implements IInvoiceNumberGenerator {
/**
 * Test invoice number generation method with incorrect generation logic (returns the latestInvoice number)
 *
 * @param string $latestNumber Latest invoice number known by the system
 * @param int $tryCount Count of the current try of invoice number generation (On first call its value is 1)
 * @return string Invoice number to use
 * @access public
 */
	public static function generateInvoiceNumber($latestNumber, $tryCount) {
		return $latestNumber;
	}
}

/**
 * InvoiceTestCase
 *
 * @package invoices
 * @subpackage invoices.tests.cases.model
 */
class InvoiceTest extends SimpleAppTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.invoices.invoice',
		'plugin.invoices.invoice_client',
		'plugin.invoices.invoice_line',
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
 * @var Invoice
 */
	public $Invoice;

/**
 * Internally saved variables
 *
 * @var array
 */
	private $__saves = array();

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->__saves['UserClass'] = Configure::read('Invoices.UserClass');
		$this->__saves['idIsNumber'] = Configure::read('Invoices.idIsNumber');
		Configure::write('Invoices.UserClass', 'InvoiceClient');
		Configure::write('Invoices.idIsNumber', true);
		$this->Invoice = new SpyInvoice();
		$this->Invoice->setInvoiceNumberGenerator($this->Invoice);

		$this->_record = $this->Invoice->find();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('Invoices.UserClass', $this->__saves['UserClass']);
		Configure::write('Invoices.idIsNumber', $this->__saves['idIsNumber']);
		parent::tearDown();
		unset($this->Invoice);
		ClassRegistry::flush();
	}

/**
 * Test validation rules
 *
 * @return void
 */
	public function testValidation() {
		$this->assertValid($this->Invoice, $this->_record);

		// Test mandatory fields
		$data = array('Invoice' => array('id' => 'new-id'));
		$expectedErrors = array();
		$this->assertValidationErrors($this->Invoice, $data, $expectedErrors);

		$data = $this->_record;
		$data['Invoice']['prefix'] = str_pad('too long', 20);
		$data['Invoice']['payment_type'] = str_pad('too long', 25);
		$data['Invoice']['payment_ref'] = str_pad('too long', 200);
		$expectedErrors = array('prefix', 'payment_type', 'payment_ref');
		$this->assertValidationErrors($this->Invoice, $data, $expectedErrors);
	}

/**
 * Test the view method
 *
 * @return void
 */
	public function testView() {
		$this->Invoice->id = $this->_record['Invoice']['id'];
		$result = $this->Invoice->view();
		$this->assertEqual(array_keys($result), array('Invoice', 'InvoiceLine'));
		$this->assertEqual($result['Invoice'], $this->_record['Invoice']);
		$this->assertEqual(count($result['InvoiceLine']), 3);

		$this->expectException('OutOfBoundsException');
		$this->Invoice->view('invalid-invoice');
	}

/**
 * Test the generate method
 */
	public function testGenerate() {
		$invoice = $this->_getNewRecord();
		$client = $invoice['Invoice'];
		unset($client['prefix']);
		$invoiceLine = $invoice['InvoiceLine'];

		$result = $this->Invoice->generate($client, $invoiceLine);
		$resultInvoice = $this->Invoice->read();

		$this->assertTrue($result);
		$this->assertWithinMargin($resultInvoice['Invoice']['global_price'], 119.6, 0.0001);

		$this->Invoice->setInvoiceNumberGenerator('TestInvoiceNumberGenerator');
		$this->Invoice->create($invoice);
		$this->expectError('PHPUnit_Framework_Error');
		$result = $this->Invoice->generate($client, $invoiceLine);
		$resultInvoice = $this->Invoice->read();
		$this->assertTrue($this->__isUuid($resultInvoice['Invoice']['id']));
	}

	public function testGenerateGenerateIdCanBeDifferantFromNumber() {
		Configure::write('Invoices.isIsNumber', false);
		$this->Invoice = new SpyInvoice();
		$this->Invoice->setInvoiceNumberGenerator($this->Invoice);

		$invoice = $this->_getNewRecord();
		$client = $invoice['Invoice'];
		unset($client['prefix']);
		$invoiceLine = $invoice['InvoiceLine'];

		$result = $this->Invoice->generate($client, $invoiceLine);
		$resultInvoice = $this->Invoice->read();

		$this->assertTrue($result);
		$this->assertNotEquals($resultInvoice['Invoice']['id'], $resultInvoice['Invoice']['number']);
		$this->assertTrue($this->__isUuid($resultInvoice['Invoice']['id']));
	}

	public function testGenerateWithPaymentDetails() {
		$invoice = $this->_getNewRecord();
		$client = $invoice['Invoice'];
		unset($client['prefix']);
		$invoiceLine = $invoice['InvoiceLine'];
		$payment = array('payment_type' => 'CB', 'payment_ref' => 'foobar');

		$result = $this->Invoice->generate($client, $invoiceLine, $payment);
		$resultInvoice = $this->Invoice->read();

		$this->assertTrue($result);
		$this->assertWithinMargin($resultInvoice['Invoice']['global_price'], 119.6, 0.0001);
		$this->assertIdentical('foobar', $resultInvoice['Invoice']['payment_ref']);
	}

/**
 * Test the makeRangePrice method
 */
	public function testMakeRangePrice() {
		$result = $this->Invoice->makeRangePrice(array('min_price' => 10, 'max_price' => 20));
		$expected = array(10, 20);
		$this->assertEqual($result, $expected);
	}
	public function testMakeRangePriceNoMax() {
		$result = $this->Invoice->makeRangePrice(array('min_price' => 10, 'max_price' => 0));
		$expected = array(10, PHP_INT_MAX);
		$this->assertEqual($result, $expected);
	}
	public function testMakeRangePriceNoMin() {
		$result = $this->Invoice->makeRangePrice(array('min_price' => 0, 'max_price' => 20));
		$expected = array(0, 20);
		$this->assertEqual($result, $expected);
	}

/**
 * Test the getGlobalPrice method
 */
	public function testGetGlobalPriceWithInvoice() {
		$invoice = $this->_getNewRecord();
		$globalPrice = $this->Invoice->getGlobalPrice($invoice);

		$this->assertWithinMargin(119.6, $globalPrice, 0.0001);
	}

	public function testGetGlobalPriceWithId() {
		$globalPrice = $this->Invoice->getGlobalPrice('2012-001');
		$this->assertWithinMargin(179.4, $globalPrice, 0.0001);
	}

	public function testGetGlobalPriceWithInvalidId() {
		$this->expectError('PHPUnit_Framework_Error');
		$this->Invoice->getGlobalPrice('invalid-id');
	}

	public function testGetGlobalPriceWithNoParameters() {
		$this->Invoice->id = '2012-001';
		$globalPrice = $this->Invoice->getGlobalPrice();
		$this->assertWithinMargin(179.4, $globalPrice, 0.0001);
	}

	public function testGetGlobalPriceWithNoParametersAndNoId() {
		$this->expectError('PHPUnit_Framework_Error');
		$this->Invoice->getGlobalPrice();
	}

/**
 * Test generateInvoiceNumber method
 *
 * @return void
 * @access public
 */
	public function testGenerateInvoiceNumberFirst() {
		$expectedBase = date('Y');
		$result = $this->Invoice->generateInvoiceNumber(null, 1);
		$this->assertEqual($result, $expectedBase . '-001');
	}

	public function testGenerateInvoiceNumber() {
		$expectedBase = date('Y');
		$result = $this->Invoice->generateInvoiceNumber($expectedBase . '-001', 1);
		$this->assertEqual($result, $expectedBase . '-002');
	}

	public function testGenerateInvoiceNumberMultiTry() {
		$expectedBase = date('Y');
		$result = $this->Invoice->generateInvoiceNumber($expectedBase . '-001', 2);
		$this->assertEqual($result, $expectedBase . '-003');
	}

	public function testGenerateInvoiceNumberWithCorrectBase() {
		$expectedBase = date('Y');
		$result = $this->Invoice->generateInvoiceNumber($expectedBase . '-999', 1);
		$this->assertEqual($result, $expectedBase . '-1000');
	}

	public function testGenerateInvoiceNumberWithOldBase() {
		$expectedBase = date('Y');
		$result = $this->Invoice->generateInvoiceNumber('invalid-base-001', 1);
		$this->assertEqual($result, $expectedBase . '-001');
	}

/**
 * Test _setInvoiceNumberGenerator call with an invalid invoice number generator
 *
 * @return void
 * @access public
 */
	public function testSetInvalidInvoiceNumberGenerator() {
		$this->expectError('PHPUnit_Framework_Error');
		$this->Invoice->setInvoiceNumberGenerator($this);

		$this->expectError('PHPUnit_Framework_Error');
		$this->Invoice->setInvoiceNumberGenerator('InvalidGenerator');

		// Must not trigger anything
		$this->Invoice->setInvoiceNumberGenerator('TestInvoiceNumberGenerator');
	}

/**
 * Return a new fill record of invoice.
 *
 * @return array
 */
	protected function _getNewRecord() {
		return array(
			'Invoice' => array(
				'prefix' => '',
				'client_id' => 'user-1',
				'client_name' => 'First User',
				'client_address' => 'Place de la Concorde, 75008 Paris, France',
			),
			'InvoiceLine' => array(
				array(
					'product_model' => 'product',
					'product_id' => 'product-1',
					'product_name' => 'First Product',
					'excl_tax_price' => 100,
					'tva_price' => 19.6,
					'tva_rate' => 19.6,
				)
			)
		);
	}
/**
 * Checks that a value is a valid uuid - http://tools.ietf.org/html/rfc4122
 *
 * @param string $check Value to check
 * @return boolean Success
 */
	private function __isUuid($check) {
		return (bool) preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $check);
	}
}