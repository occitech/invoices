<?php
class AddedPaymentInformationFields extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	var $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	var $migration = array(
		'up' => array(
			'create_field' => array(
				'invoices' => array(
					'payment_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
					'payment_ref' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'invoices' => array('payment_type', 'payment_ref')
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
	function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	function after($direction) {
		return true;
	}
}
?>