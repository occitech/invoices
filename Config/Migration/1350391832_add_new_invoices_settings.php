<?php
class AddNewInvoicesSettings extends CakeMigration {

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
		),
		'down' => array(
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
		$InvoiceSetting = ClassRegistry::init('Invoices.InvoiceSetting');
		$success = true;

		if ($direction == 'up') {
			$InvoiceSetting->create();
			$success = $success && $InvoiceSetting->save(array(
				'name' => 'Texte à afficher après la liste des produits',
				'value' => '',
				'tag' => 'after_product'
			), true, array('name', 'tag'));

			$InvoiceSetting->create();
			$success = $success && $InvoiceSetting->save(array(
				'name' => 'Texte à afficher avant la liste des produits',
				'value' => '',
				'tag' => 'before_product'
			), true, array('name', 'tag'));
		} else {
			$success = $success && $InvoiceSetting->deleteAll(array(
				'InvoiceSetting.tag' => array('before_product', 'after_product')
			));
		}

		return $success;
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
