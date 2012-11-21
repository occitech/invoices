# Content plugin for CakePHP

## Installation

Add 'pdf' in Router::parseExtensions() in Config/routes.php
Add plugin in bootstrap with bootstrap
CakePlugin::loadAll(array(
	'Invoices' => array('bootstrap' => true),
));

## Dependencies

This plugin use the search plugin of CakeDC (Tested with version 1.1).
This plugin use the migrations plugin of CakeDC (Tested with version 2.1).
This plugin use the partial plugin of joeytrapp.
This plugin use the TCPDF (Tested with version 5.9.137).
This plugin use the jquery (Tested with version 1.7.1).
This plugin use the TwitterBootstrapFormHelper of Occitech.

## Configuration

The plugin allows you to change the client related Model.
	`Configure::write('Invoices.UserClass', 'MyUserClass');

The plugin allows you to use a logo in invoices.
	`Configure::write('Invoices.logo', array(
		'image' => 'logo.jpg',
		'alt' => 'My company logo'
		'title' => ''My company name'
	);

The plugin allows you to use your Decorator helper.
	`Configure::write('Invoices.Decorator', 'MyDecorator');
