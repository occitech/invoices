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
			throw new NotFoundException(__d('invoices', 'Paramètre de facturation invalide'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->InvoiceSetting->save($this->request->data, true, array('value'))) {
				$this->Session->setFlash(__d('invoices', 'Le paramètre de facturation a bien été sauvegardé.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('invoices', 'Le paramètre de facturation n\'a pas pu être sauvegardé.'));
			}
		} else {
			$this->request->data = $this->InvoiceSetting->read(null, $this->InvoiceSetting->id);
		}
	}
}
