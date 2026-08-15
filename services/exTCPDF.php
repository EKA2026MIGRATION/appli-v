<?php
require_once('tcpdf/tcpdf.php');


class exTCPDF extends TCPDF
{
	public function Footer($position = '-15', $text = 1) {
		$this->setY($position);
	  	$this->SetFont('helvetica', 'I', 6);
        // Page texte si text = null
        if($text == null) {
        	$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        } else {
        	 $this->Cell(0, 10, "SARL Sporting Club de Bièvres « Energy Kids Academy » au capital de 100 000 euros - Siège social : lieu-dit Les Jonnières, 91570 Bièvres - RCS Evry 394 295 042 00029 code NAF 9312Z", 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }
}