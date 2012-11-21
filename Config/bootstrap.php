<?php
Configure::write('Invoices', array(
	'UserClass' => 'User',
	'Decorator' => 'Invoices.InvoiceDecorator',
	'logo' => false
));
?>
