<?php

require_once('exTCPDF.php');


class PdfService
{

    private $pdf;
    private $htmlContent;
    private $creator;
    private $name;
    private $author;
    private $title;
    private $subject;
    private $singlePage = 1;
    private $allPages = [];

    private $addTampon = 0;

    public function __construct($orientation = "P")
    {
        $pdf = new exTCPDF($orientation, PDF_UNIT, PDF_PAGE_FORMAT, true , "UTF-8", false);
        $this->pdf = $pdf;
        $this->creator = PDF_CREATOR;
        $this->name = date('EKA-Ymdhis');
    }

    public function getPdf() {
        return $this->pdf;
    }

    public function setHtmlContent($htmlContent) {
        $this->htmlContent = $htmlContent;
        return $this;
    }

    public function getHtmlContent() {
        return $this->htmlContent;
    }

    public function setCreator($creator) {
        $this->creator = $creator;
        return $this;
    }

    public function getCreator() {
        return $this->creator;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    public function getSubject() {
        return $this->subject;
    }


    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setAddTampon($value)
    {
        $this->addTampon = $value;
    }

    public function getAddTampon()
    {
        return $this->addTampon;
    }

    public function setMultiplePage($value) {
        if($value == 1) $this->singlePage = 0;
        if($value == 0) $this->singlePage = 1;
    }

    public function addHtmlPage($htmlPage) {
        $this->allPages[] = $htmlPage;
    }

    public function renderHtml()
    {
        if ($this->singlePage == 1) {
            $this->renderHtmlSingle();
        } else {
            $this->renderHtmlMultiple();

        }
    }

    public function renderHtmlMultiple() {
        $pdf = $this->getPdf();

        $pdf -> SetCreator ($this->getCreator());
        $pdf -> SetAuthor ($this->getAuthor());
        $pdf -> SetTitle ($this->getTitle());
        $pdf -> SetSubject ($this->getSubject());

        $pdf -> setHeaderFont ( Array ( PDF_FONT_NAME_MAIN , '' , PDF_FONT_SIZE_MAIN ) ) ;
        $pdf -> setFooterFont ( Array ( PDF_FONT_NAME_DATA , '' , PDF_FONT_SIZE_DATA ) ) ;

        $pdf -> SetDefaultMonospacedFont ( PDF_FONT_MONOSPACED ) ;

        $pdf -> SetMargins ( PDF_MARGIN_LEFT , PDF_MARGIN_TOP , PDF_MARGIN_RIGHT ) ;
        $pdf -> SetHeaderMargin ( PDF_MARGIN_HEADER ) ;
        $pdf -> SetFooterMargin ( PDF_MARGIN_FOOTER ) ;

        $pdf -> SetAutoPageBreak ( TRUE , PDF_MARGIN_BOTTOM ) ;

        $pdf -> setImageScale ( PDF_IMAGE_SCALE_RATIO ) ;

        $pdf -> SetFont ( 'dejavusans' , '' , 10 ) ;

        foreach($this->allPages as $pagehtml) {
            $pdf -> AddPage ( ) ;
            $pdf -> writeHTML ( $pagehtml , true , false , true , false , '' ) ;
        }

        $pdf -> Output ($this->getName(), 'I' ) ;
    }



    public function renderHtmlSingle() {

        $pdf = $this->getPdf();
        $html = $this->getHtmlContent();

        $pdf -> SetCreator ($this->getCreator());
        $pdf -> SetAuthor ($this->getAuthor());
        $pdf -> SetTitle ($this->getTitle());
        $pdf -> SetSubject ($this->getSubject());

        $pdf -> setHeaderFont ( Array ( PDF_FONT_NAME_MAIN , '' , PDF_FONT_SIZE_MAIN ) ) ;
        $pdf -> setFooterFont ( Array ( PDF_FONT_NAME_DATA , '' , PDF_FONT_SIZE_DATA ) ) ;

        $pdf -> SetDefaultMonospacedFont ( PDF_FONT_MONOSPACED ) ;

        $pdf -> SetMargins ( PDF_MARGIN_LEFT , PDF_MARGIN_TOP , PDF_MARGIN_RIGHT ) ;
        $pdf -> SetHeaderMargin ( PDF_MARGIN_HEADER ) ;
        $pdf -> SetFooterMargin ( PDF_MARGIN_FOOTER ) ;

        $pdf -> SetAutoPageBreak ( TRUE , PDF_MARGIN_BOTTOM ) ;

        $pdf -> setImageScale ( PDF_IMAGE_SCALE_RATIO ) ;

        $pdf -> SetFont ( 'dejavusans' , '' , 10 ) ;

        $pdf -> AddPage ( ) ;

        $pdf -> writeHTML ( $html , true , false , true , false , '' ) ;

        // add signtature
        if($this->getAddTampon() == 1) {

            $tamponPath = IMG.'tamponEKA.png';
            $xTamponBase = 60;
            $yTamponBase = 220;
            $angleRotationBase = 0;

            $xTampon = $xTamponBase + rand(-20, 30);
            $yTampon = $yTamponBase + rand(-50, 10);
            $angleRotation = $angleRotationBase + rand(-6, 6);

            $widthTampon = 54.86;
            $heightTampon = 32.77;

            $pdf->StartTransform();
            $pdf->Rotate($angleRotation, $xTampon + ($widthTampon / 2), $yTampon + ($heightTampon / 2));

            $pdf->Image($tamponPath, $xTampon, $yTampon, $widthTampon, $heightTampon);

            $pdf->StopTransform();
        }



        $pdf -> Output ($this->getName(), 'I' ) ;

        //Option 2: Save PDF in the directory:
        //$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
        //echo 'Download PDF: '.$pdfName.'';
    }

}