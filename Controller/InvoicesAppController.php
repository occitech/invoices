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

	public function beforeRender() {
		if (method_exists($this, '_isAdminArea')) {
			$isAdminArea = $this->_isAdminArea();
		} else {
			$isAdminArea = !empty($this->request->params['prefix']) && $this->request->params['prefix'] === 'admin';
		}

		$this->set('isAdminArea', $isAdminArea);
		parent::beforeRender();
	}
}

?>