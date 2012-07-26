<?php
App::import('Vendor','Invoices.tcpdf/tcpdf');

class InvoiceFormatedPdf  extends TCPDF
{
	protected $_footerText  = "";
	protected $_footerFont  = PDF_FONT_NAME_MAIN ;
	protected $_footerFontSize = 8;

	/**
	* Overwrites the default footer
	* set the text in the view using
	* $fpdf->xfootertext = 'Copyright Â© %d YOUR ORGANIZATION. All rights reserved.';
	*/
	function Footer()
	{
		$footer = Configure::read('Invoices.Pdf.footerTextContent');
		if (!empty($footer['footerTextContent'])) {
			$this->_footerText = $footer['footerTextContent'];
			if (!empty($footer['footerTextSize'])) {
				$this->_footerFontSize = $footer['footerTextSize'];
			}
			$year = date('Y');
			$footertext = sprintf($this->_footerText, $year);
			$this->SetY(-20);
			$this->SetTextColor(0, 0, 0);
			$this->SetFont($this->_footerFont,'',$this->_footerFontSize);
			$this->Cell(0,$this->_footerFontSize, $footertext,'T',1,'C');
		}
	}
}