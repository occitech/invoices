<?php
	$title_for_layout = sprintf(__d('invoices', 'Invoice n°%s', $invoice['Invoice']['number']));
	$this->set(compact('title_for_layout'));
	$this->Html->css('/invoices/css/invoices', null, array('inline' => false));
?>
<div class="invoice view">
	<?php
		$logoImg = Configure::read('Invoices.logo.image');
		if (!empty($logoImg)) {
			echo $this->Html->image($logoImg, array(
				'title' => Configure::read('Invoices.logo.title'),
				'alt' => Configure::read('Invoices.logo.alt'),
				'class' => 'logo_invoice'
			));
		}

		echo $this->element('invoices/compagny');
		echo $this->element('invoices/client');

		echo $this->element('invoices/date');
		echo $this->element('invoices/invoice_num');

		echo $this->element('invoices/details');

		echo $this->element('invoices/end_text');
	?>
</div>