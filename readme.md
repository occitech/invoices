# Content plugin for CakePHP

## Installation

Add 'pdf in Router::parseExtensions() in Config/routes.php

## Dependencies

This plugin use the search plugin of CakeDC (Tested with version 1.1).
This plugin use the migrations plugin of CakeDC (Tested with version 2.1).
This plugin use the partial plugin of joeytrapp.
This plugin use the TCPDF (Tested with version 5.9.137).
This plugin use the jquery (Tested with version 1.7.1).
This plugin use the TwitterBootstrapFormHelper of Occitech.

## Configuration

The plugin allows you to change the client related Model.
To do so, register your config file using the following statement before the Invoice Model is loaded :
	`Configure::write('Invoices.UserClass', 'UserClass');

The plugin allows you to use a logo in invoices.
To do so, register your config file using the following statement before the Invoice Model is loaded :
	`Configure::write('Invoices.UserClass', array(
		'image' => 'logo.jpg',
		'alt' => 'Logo de mon entreprise'
		'title' => ''Nom de mon entreprise'
	);
