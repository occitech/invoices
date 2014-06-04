# Invoicing plugin for CakePHP

This plugin allows you to quickly add the most common Invoicing features to your CakePHP application. Invoices can be created from anywhere with any type of content (Invoice Line), the plugin will manage HTML and PDF rendering for your users.

## Stability

We have been using this plugin on several client projects in production for a while, so consider it as stable enough!

It literally took years before open sourcing it, and we have not yet wanted to spend more time on documentation, continuous integration or further refactorings.
**Please star the repository to show your interest**, or even better send us PRs to improve the Plugin we will appreciate! You can also [hire us](mailto:contact@occitech.fr) to do it for you ;)

## Installation

* Add 'pdf' in `Router::parseExtensions()` in `Config/routes.php`
* Add plugin in bootstrap with bootstrap
```
CakePlugin::loadAll(array(
	'Invoices' => array('bootstrap' => true),
));
```

## Dependencies

* This plugin use the search plugin of CakeDC (Tested with version 1.1).
* This plugin use the migrations plugin of CakeDC (Tested with version 2.1).
* This plugin use the partial plugin of joeytrapp.
* This plugin use the TCPDF (Tested with version 5.9.137).
* This plugin use the jquery (Tested with version 1.7.1).
* This plugin use the TwitterBootstrapFormHelper of Occitech.

## Configuration

* The plugin allows you to change the client related Model.
	`Configure::write('Invoices.UserClass', 'MyUserClass');`

* The plugin allows you to use a logo in invoices.
```
	`Configure::write('Invoices.logo', array(
		'image' => 'logo.jpg',
		'alt' => 'My company logo',
		'title' => ''My company name'
	));
```

* The plugin allows you to use your Decorator helper.
	`Configure::write('Invoices.Decorator', 'MyDecorator');`

# Licence

[MIT](LICENSE)