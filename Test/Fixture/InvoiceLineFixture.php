<?php
/* InvoiceLine Fixture generated on: 2011-12-02 14:12:52 : 1322832532 */
class InvoiceLineFixture extends CakeTestFixture {
/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'product_model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'index'),
		'product_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'product_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'after' => 'product_id'),
		'excl_tax_price' => array('type' => 'float', 'null' => false, 'default' => NULL, 'after' => 'product_name'),
		'tva_rate' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'tva_price' => array('type' => 'float', 'null' => false, 'default' => NULL, 'after' => 'excl_tax_price'),
		'tva_rate' => array('type' => 'float', 'null' => false, 'default' => NULL, 'after' => 'tva_price'),
		'invoice_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'after' => 'tva_rate'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'invoice_id' => array('column' => 'invoice_id', 'unique' => 0),
			'product' => array('column' => array('product_model', 'product_id'), 'unique' => 0)
		),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 'invoice_line-1',
			'product_model' => 'subscription',
			'product_id' => '1',
			'product_name' => 'First Product',
			'excl_tax_price' => 100,
			'tva_price' => 19.6,
			'tva_rate' => 19.6,
			'invoice_id' => '2012-001'
		),
		array(
			'id' => 'invoice_line-2',
			'product_model' => 'subscription',
			'product_id' => '1',
			'product_name' => 'Second Product',
			'excl_tax_price' => 50,
			'tva_price' => 9.8,
			'tva_rate' => 19.6,
			'invoice_id' => '2012-001'
		),
		array(
			'id' => 'invoice_line-3',
			'product_model' => 'subscription',
			'product_id' => '1',
			'product_name' => 'Private individual 6 months',
			'excl_tax_price' => 0,
			'tva_price' => 0,
			'tva_rate' => 0,
			'invoice_id' => '2012-001'
		),
	);

}