<?php
class AddInvoicesSettings extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'invoice_settings' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'after' => 'id'),
					'value' => array('type' => 'text', 'null' => false, 'default' => NULL, 'after' => 'name'),
					'tag' => array('type' => 'string', 'null' => false, 'default' => NULL, 'after' => 'value', 'key' => 'unique'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'tag' => array('column' => 'tag', 'unique' => 1),
					),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'invoice_settings'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		$success = true;

		if ($direction == 'up') {
			$InvoiceSettings = $this->generateModel('InvoiceSetting');

			$data = array();
			$data[] = array('InvoiceSetting' => array(
				'name' => 'Nom de la société',
				'value' => 'Nom de la société',
				'tag' => 'name',
			));
			$data[] = array('InvoiceSetting' => array(
				'name' => 'Adresse de la Société',
				'value' => 'Adresse de la Société',
				'tag' => 'address',
			));
			$data[] = array('InvoiceSetting' => array(
				'name' => 'TVA applicable',
				'value' => 'TVA applicable',
				'tag' => 'vat',
			));
			$data[] = array('InvoiceSetting' => array(
				'name' => 'N° SIRET',
				'value' => 'N° SIRET',
				'tag' => 'siret',
			));

			$InvoiceSettings->saveMany($data);
		}

		return $success;
	}
}
