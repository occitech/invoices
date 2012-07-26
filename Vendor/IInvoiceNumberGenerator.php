<?php
/**
 * Interface a class must implement to be used as Invoice number generator
 *
 */
interface IInvoiceNumberGenerator {

/**
 * Generate an unique invoice number
 *
 * @param string $latestNumber Latest invoice number known by the system. (The passed value will be null for first order)
 * @param int $tryCount Count of the current try of invoice number generation (On first call its value is 1)
 * @return string Invoice number to use
 * @access public
 */
	public static function generateInvoiceNumber($latestNumber, $tryCount);

}