<?php
	$title_for_layout = sprintf(__d('invoices', 'Invoice n°%s', $invoice['Invoice']['number']));
	$this->set(compact('title_for_layout'));
	$this->InvoicePdf->addPage('', 'USLETTER');
	$this->InvoicePdf->setFont('helvetica', '', 12);

	$logoImg = Configure::read('Invoices.logo.image');
	if (!empty($logoImg)) {
		$this->InvoicePdf->Image($logoImg, '', '', 0, 0, 'PNG', FULL_BASE_URL, 'N', false, 300, 'C');
	}

	$this->InvoicePdf->writeHTML($this->element('invoices/compagny'));
	$this->InvoicePdf->writeHTML('<div></div>');
	$this->InvoicePdf->writeHTML('<div></div>');
	$this->InvoicePdf->writeHTML($this->element('invoices/client'));

	if (!empty($invoiceSettings) && !empty($invoiceSettings['before_product'])) {
		$this->InvoicePdf->writeHTML('<div></div>');
		$this->InvoicePdf->writeHTML('<div></div>');
		$this->InvoicePdf->writeHTML(nl2br(h($invoiceSettings['before_product'])));
	}

	$this->InvoicePdf->writeHTML('<div></div>');
	$this->InvoicePdf->writeHTML('<div></div>');
	$this->InvoicePdf->writeHTML($this->element('invoices/date'));
	$this->InvoicePdf->writeHTML($this->element('invoices/invoice_num'));

	$this->InvoicePdf->writeHTML('<div></div>');
	$this->InvoicePdf->writeHTML('<div></div>');
	$this->InvoicePdf->writeHTML($this->element('invoices/details'));

	if (!empty($invoiceSettings) && !empty($invoiceSettings['after_product'])) {
		$this->InvoicePdf->writeHTML('<div></div>');
		$this->InvoicePdf->writeHTML('<div></div>');
		$this->InvoicePdf->writeHTML('<div></div>');
		$this->InvoicePdf->writeHTML(nl2br(h($invoiceSettings['after_product'])));
	}

	$this->InvoicePdf->writeHTML('<div></div>');
	$this->InvoicePdf->writeHTML('<div></div>');
	$this->InvoicePdf->writeHTML($this->element('invoices/end_text'));

	echo $this->InvoicePdf->render($title_for_layout);
?>