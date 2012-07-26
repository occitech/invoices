<?php
class InvoicesSchema extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = 'Initial Invoices plugin schema';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'invoices' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
					'prefix' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10),
					'client_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'after' => 'prefix'),
					'client_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255, 'after' => 'client_id'),
					'client_address' => array('type' => 'text', 'null' => true, 'default' => NULL, 'after' => 'client_name'),
					'global_price' => array('type' => 'float', 'null' => false, 'default' => NULL, 'after' => 'client_address'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'after' => 'client_address'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'client_id' => array('column' => 'client_id', 'unique' => 0),
					)
				),
				'invoice_lines' => array(
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
				),
			)
		),
		'down' => array(
			'drop_table'=> array(
				'invoices', 'invoice_lines'
			)
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
		return true;
	}
}
?>