<?php
/**
 * InvoiceSettingFixture
 *
 */
class PluginInvoiceSettingFixture extends CakeTestFixture {
	public $alias = 'InvoiceSetting';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'value' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'tag' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'tag' => array('column' => 'tag', 'unique' => 1)),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '4f9930c9-ec9c-4229-bff3-2c0f4d45b00a',
			'name' => 'Écuries et concours',
			'value' => 'Nom de la société',
			'tag' => 'name'
		),
		array(
			'id' => '4f9930c9-f8f8-4614-a73e-2c0f4d45b00a',
			'name' => 'Adresse de la Société',
			'value' => 'Adresse de la Société',
			'tag' => 'address'
		),
		array(
			'id' => '4f9930c9-e808-421c-95c2-2c0f4d45b00a',
			'name' => 'TVA applicable',
			'value' => 'TVA applicable',
			'tag' => 'vat'
		),
		array(
			'id' => '4f9930c9-e6b8-47d5-b274-2c0f4d45b00a',
			'name' => 'N° SIRET',
			'value' => 'N° SIRET',
			'tag' => 'siret'
		),
	);
}
