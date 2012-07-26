<?php
App::uses('AppController', 'Controller');
class InvoicesAppController extends AppController {
/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Auth',
		'Session',
		'RequestHandler'
	);

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'Session',
	);
}

?>