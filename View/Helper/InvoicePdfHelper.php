<?php
 
class InvoicePdfHelper extends AppHelper {
 
    public $InvoicePdf;

/**
 * Constructor of helper
 */
   public function __construct() {
        App::import('Vendor', 'Invoices.InvoiceFormatedPdf', array('file' => 'invoice_formated_pdf.php'));
        $this->InvoicePdf = new InvoiceFormatedPdf();

        $this->InvoicePdf->setPrintHeader(false);
        $this->InvoicePdf->setPrintFooter(true);
    }
 
/**
 * Call librairy function
 */
    function __call($method, $args) {
        return call_user_func_array(array($this->InvoicePdf, $method), $args);
    }
 
/**
 * allows to render the
 *
 * @param string $title Name of pdf.
 * @return the document as a string.
 */
    function render($title = 'Invoice') {
        return $this->InvoicePdf->output($title, 'I');
    }
}
 
?>