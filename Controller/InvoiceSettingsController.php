<?php
App::uses('AppController', 'Controller');
/**
 * InvoiceSettings Controller
 *
 * @property InvoiceSetting $InvoiceSetting
 */
class InvoiceSettingsController extends AppController {


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->InvoiceSetting->recursive = 0;
		$this->set('invoiceSettings', $this->paginate());
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!empty($id)) {
			$this->InvoiceSetting->id = $id;
		}

		if (!$this->InvoiceSetting->exists()) {
			throw new NotFoundException(__d('invoices', 'Invalid invoice setting'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->InvoiceSetting->save($this->request->data, true, array('value'))) {
				$this->Session->setFlash(__d('invoices', 'Invoice setting has been successfully saved.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('invoices', 'Invoice setting could not be saved.'));
			}
		} else {
			$this->request->data = $this->InvoiceSetting->read(null, $this->InvoiceSetting->id);
		}
	}
}
