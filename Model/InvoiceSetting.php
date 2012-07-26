<?php
App::uses('Invoices.InvoicesAppModel', 'Model');
/**
 * InvoiceLine model
 *
 */
class InvoiceSetting extends InvoicesAppModel {
/**
 * Validation rules - initialized in constructor
 *
 * @var array
 */
	public $validate = array();
/**
 * Constructor
 *
 * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		$this->validate = array(
			'name' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('invoices', 'Saisissez un nom svp.'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'value' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('invoices', 'Saisissez une valeur svp.'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'tag' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('invoices', 'Saisissez un tag svp.'),
					'allowEmpty' => false,
					'required' => true,
					'last' => false
				),
				'isUnique' => array(
					'rule' => array('isUnique'),
					'message' => __d('invoices', 'Le tag doit être unique'),
				)
			),
		);

		parent::__construct($id, $table, $ds);
	}
}