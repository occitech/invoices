<?php
/**
 * Helper containing all the "Decoration" logic to format specific objects for displaying
 * Create helper methods here to reduce code duplication in views
 *
 * @todo Replace it with the Decorators plugin if the class starts to be too heavy https://github.com/joeytrapp/decorator
 */
class InvoiceDecoratorHelper extends AppHelper {
/**
 * Display a price with €
 *
 * @param int $price The price.
 * @return string The price with €
 */
	public function price($price) {
		$price .= '€';
		return $price;
	}
}