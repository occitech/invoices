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

		if (!empty($invoiceSettings) && !empty($invoiceSettings['before_product'])) {
			echo $this->Html->div('before-product-text', nl2br(h($invoiceSettings['before_product'])));
		}

		echo $this->element('invoices/date');
		echo $this->element('invoices/invoice_num');

		echo $this->element('invoices/details');

		if (!empty($invoiceSettings) && !empty($invoiceSettings['after_product'])) {
			echo $this->Html->div('after-product-text', nl2br(h($invoiceSettings['after_product'])));
		}

		echo $this->element('invoices/end_text');
	?>
</div>