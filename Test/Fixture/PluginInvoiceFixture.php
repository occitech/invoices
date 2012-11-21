<?php
class PluginInvoiceFixture extends CakeTestFixture {
	public $alias = 'Invoice';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'number' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'prefix' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10),
		'client_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'after' => 'prefix'),
		'client_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255, 'after' => 'client_id'),
		'client_address' => array('type' => 'text', 'null' => true, 'default' => NULL, 'after' => 'client_name'),
		'client_company' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
		'global_price' => array('type' => 'float', 'null' => false, 'default' => NULL, 'after' => 'client_address'),
		'payment_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'payment_ref' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'after' => 'client_address'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'client_id' => array('column' => 'client_id', 'unique' => 0)),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '2012-001',
			'number' => '2012-001',
			'prefix' => null,
			'client_id' => 'user-1',
			'client_name' => 'First User',
			'client_address' => null,
			'client_company' => null,
			'global_price' => 179.4,
			'payment_type' => 'CB',
			'payment_ref' => 'XXXWWWW65-666-EEEE',
			'created' => '2011-12-02 14:16:49',
		),
	);

}