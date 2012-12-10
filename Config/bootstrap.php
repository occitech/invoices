<?php
$__defaultsInvoicesSettings = array(
	'UserClass' => 'User',
	'Decorator' => 'Invoices.InvoiceDecorator',
	'logo' => false,
	'idIsNumber' => true
);
Configure::write(
	'Invoices',
		Configure::read('Invoices') ?
			array_merge($__defaultsInvoicesSettings, Configure::read('Invoices')) :
			$__defaultsInvoicesSettings
);
?>
