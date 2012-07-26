<?php
class InvoiceClientFixture extends CakeTestFixture {
/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 8, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255),
		'address' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 'user-1',
			'name' => 'First User',
			'address' => 'Place de la Concorde, 75008 Paris, France',
		),
	);

}