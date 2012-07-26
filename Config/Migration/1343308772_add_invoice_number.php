<?php
class AddInvoiceNumber extends CakeMigration {

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
			'create_field' => array(
				'invoices' => array(
					'number' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'after' => 'id'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'invoices' => array('number')
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
			$Invoice = $this->generateModel('Invoice');
			$success= $Invoice->updateAll(array('number' => 'id'));
		}

		return $success;
	}
}
