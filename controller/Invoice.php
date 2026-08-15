<?php
use_helper('dates');
/**
 * Class Invoice
 *
 */

class Invoice extends Controller
{

    public function create($request)
    {
        if (!hasCredential('invoice::access')) $this->redirect('app/home');

        if(isset($request->childId)) {
            $params['child'] = $this->cURL(API.'child/display/'.$request->childId, 'PHP_CALL', '' , 'GET');
        }

        $params['categories'] = $this->cURL(API.'category/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');
        //$params['products'] = $this->cURL(API.'product/list', 'PHP_CALL', '', 'GET');
        $params['components'] = $this->cURL(API.'component/list', 'PHP_CALL', '' , 'GET');

        $this->renderWithData('render/invoice/create', $params);

    }

    public function update($request)
    {
        if (!hasCredential('invoice::update')) $this->redirect('app/home');
    }

    public function list($request)
    {
        if (!hasCredential('invoice::access')) $this->redirect('app/home');

        if(!isset($request->dateStart))
        {
            $today = date('Y-m-d');
            $params['dateEnd'] = nextDay($today, 1);
            $params['dateStart'] =  getStartMonth($params['dateEnd']);
        }
        else
        {
            $params['dateStart'] = $request->dateStart;
            $params['dateEnd'] = $request->dateEnd;
        }

        $params['buttons'] = array
        (
            array(
                'attributes' => ['id' => 'exportExcel', 'target' => '_blank'],
                "href" => HOST."invoice/exportAllPdf/dateStart/".$params['dateStart'].'/dateEnd/'.$params['dateEnd'].'/',
                "onclick" => "",
                "label" => "Export PDF",
                "icon" => "table_view",
            ),
        );

        $result  = $this->cURL(API.'invoice/latest/'.$params['dateStart'].'/'.$params['dateEnd'], 'PHP_CALL', '', 'GET');
        $params['invoices'] = array_reverse((array) $result);

        $this->renderWithData('render/invoice/list', $params);

    }

    public function exportAllPdf($request) {

        if (!hasCredential('invoice::access')) $this->redirect('app/home');

        $components = $this->cURL(API.'component/list', 'PHP_CALL', '', 'GET');
        $newComponents = [$components[2], $components[3], $components[4], $components[5], $components[6], $components[8], $components[0], $components[1]];
        $params['components'] = $newComponents;


        if(!isset($request->dateStart))
        {
            $today = date('Y-m-d');
            $params['dateEnd'] = nextDay($today, 1);
            $params['dateStart'] =  getStartMonth($params['dateEnd']);
        }
        else
        {
            $params['dateStart'] = $request->dateStart;
            $params['dateEnd'] = $request->dateEnd;
        }

        $invoices  = $this->cURL(API.'invoice/latest/'.$params['dateStart'].'/'.$params['dateEnd'].' 23:59:59', 'PHP_CALL', '', 'GET');

        $pdf = new PdfService();

        $pdf->setName('Invoices-'.$params['dateStart'].'-'.$params['dateEnd'].'.pdf');

        $pdf->setTitle('DownloadInvoices');

        $pdf->setMultiplePage(1);

        foreach($invoices as $invoice) {

            if($invoice->status == "payed-draft") continue;

            $invoice = $this->cURL(API.'invoice/display/'.$invoice->invoiceId, 'PHP_CALL', '', 'GET');

            $invoice->invoiceProducts = $this->createNewInvoiceProducts($invoice);

            $params['invoice'] = $invoice;

            $params['view'] = "full";

            $html = $this->getRenderTemplate('render/invoice/pdfCustomer', $params);

            $pdf->addHtmlPage($html);

        }

        $pdf->renderHtml();

    }

    public function display($request) {

        if (!hasCredential('invoice::access')) $this->redirect('app/home');

        $invoice = $this->cURL(API.'invoice/display/'.$request->id, 'PHP_CALL', '', 'GET');

        $new_invoiceProducts = [];
        foreach($invoice->invoiceProducts as $invoiceProduct) {

            $alldates = explode('|', $invoiceProduct->descriptionFr->dates);

            if( count((array) $alldates) > 7 ) {
                $nb = count((array) $alldates);
                $theDatesString = $nb.' dates - du '.showDate($alldates[0]).' au '.showDate($alldates[$nb-1]);
            } else {
                foreach($alldates as $date) {
                    $arr[] = showDate($date);
                }
                $theDatesString = implode('|', $arr);
                unset($arr);
            }
                      
            if(key_exists($invoiceProduct->nameFr, $new_invoiceProducts)) {
                $new_invoiceProducts[$invoiceProduct->nameFr]['quantity']++;
                $new_invoiceProducts[$invoiceProduct->nameFr]['description'][$invoiceProduct->descriptionFr->child_name][] = $theDatesString;
            } else {
                $new_invoiceProducts[$invoiceProduct->nameFr] = [
                                                                    'product' => $invoiceProduct,
                                                                    'quantity' => $invoiceProduct->quantity
                ];

                if(isset($invoiceProduct->descriptionFr->dates)) {
                    $elements = explode('|', $invoiceProduct->descriptionFr->dates) ;
                    $nbElements = count((array) $elements);
                    if($nbElements > 0) {
                        $i = 0;
                        foreach($elements as $element) {
                            if($i == 0) $first = showDate($element);
                            $dateFr[] = showDate($element);
                            $last = showDate($element);
                            $i++;
                        }
                        $datesToShow = implode('|', $dateFr);
                    } else {
                        $datesToShow = showDate($invoiceProduct->descriptionFr->dates);
                    }
                    $new_invoiceProducts[$invoiceProduct->nameFr]['description'][$invoiceProduct->descriptionFr->child_name][] = $datesToShow;
                    if($nbElements > 5) {
                        $new_invoiceProducts[$invoiceProduct->nameFr]['description2'] = $nbElements.' dates du '.$first.' au '.$last;
                    }
                    unset($dateFr);
                }
            }
          
        }

        $invoice->invoiceProducts = $new_invoiceProducts;

        $params['invoice'] = $invoice;

        $components = $this->cURL(API.'component/list', 'PHP_CALL', '', 'GET');
        $newComponents = [$components[2], $components[3], $components[4], $components[5], $components[6], $components[8], $components[0], $components[1]];
        $params['components'] = $newComponents;
        
        $this->renderHtml('render/invoice/display', $params);
    }

    public function balanceSheet($request)
    {
        if (!hasCredential('invoice::access')) $this->redirect('app/home');

        if(!isset($request->dateStart))
        {   
            $today = date('Y-m-d');
            $params['dateEnd'] = nextDay($today, 1);
            $params['dateStart'] =  getStartMonth($params['dateEnd']);
            $params['modePayement'] = 'all';
        }
        else
        {
            $params['dateStart'] = $request->dateStart;
            $params['dateEnd'] = $request->dateEnd;
            $params['modePayement'] = $request->modePayement;
        }
        
        $params['buttons'] = array
        (
           /* array(
                'attributes' => ['id' => 'exportPdf'],
                "href" => HOST."invoice/exportPdf",
                "onclick" => "",
                "label" => "Export Pdf",
                "icon" => "picture_as_pdf"
            ),*/
            array(
                'attributes' => ['id' => 'exportExcel'],
                "href" => HOST."invoice/exportExcel",
                "onclick" => "",
                "label" => "Export Excel",
                 "icon" => "table_view"
            ),
        );

        $apiRequest = 'invoice/search/'.$params['dateStart'].'/'.$params['dateEnd'].'/'.$params['modePayement'];

        $params['invoices'] = $this->cURL(API.$apiRequest, 'PHP_CALL', '', 'GET');
        $components = $this->cURL(API.'component/list', 'PHP_CALL', '', 'GET');

        $newComponents = [$components[2], $components[3], $components[4], $components[5], $components[6], $components[7], $components[8], $components[0], $components[1]];
        $params['components'] = $newComponents;
        $this->renderWithData('render/invoice/balanceSheet', $params);

    }

    public function extract($request) {

        if (!hasCredential('invoice::access')) $this->redirect('app/home');

        $month = $request->month;
        $year  = $request->year;

        $start = $year.'-'.$month.'-01';
        $end   = $year.'-'.$month.'-'.date('t', strtotime($start));

        $apiRequest = 'invoice/search/'.$start.'/'.$end.'/all';
        $params['invoices']  = $this->cURL(API.$apiRequest, 'PHP_CALL', '', 'GET');

        $components = $this->cURL(API.'component/list', 'PHP_CALL', '', 'GET');
        $newComponents = [$components[2], $components[3], $components[4], $components[5], $components[6], $components[7], $components[8], $components[0], $components[1]];

        //$newComponents = [$components[2], $components[3], $components[4], $components[5], $components[6], $components[8], $components[0], $components[1]];
        $params['components'] = $newComponents;

        // export excel
        $html = $this->getRenderTemplate('render/invoice/extractData', $params);

        echo $html;
    }

    public function byYear($request) {
        if (!hasCredential('invoice::access')) $this->redirect('app/home');

        if($request->year) {
            $params['year'] = $request->year;
        } else {
            $params['year'] = date('Y');
        }

        $this->renderWithData("render/invoice/byYear", $params);
    }

    public function exportExcel($request) {
        if (!hasCredential('invoice::access')) $this->redirect('app/home');

        if(!isset($request->dateStart))
        {   
            $params['dateEnd'] = date('Y-m-d');
            $params['dateStart'] =  getStartMonth($params['dateEnd']);
            $params['modePayement'] = 'all';
        }
        else
        {
            $params['dateStart'] = $request->dateStart;
            $params['dateEnd'] = $request->dateEnd;
            $params['modePayement'] = $request->modePayement;
        }

        $apiRequest = 'invoice/search/'.$params['dateStart'].'/'.$params['dateEnd'].'/'.$params['modePayement'];
        $params['invoices'] = $this->cURL(API.$apiRequest, 'PHP_CALL', '', 'GET');

        $components = $this->cURL(API.'component/list', 'PHP_CALL', '', 'GET');
        $newComponents = [$components[2], $components[3], $components[4], $components[5], $components[6], $components[7], $components[8], $components[0], $components[1]];

        //$newComponents = [$components[2], $components[3], $components[4], $components[5], $components[6], $components[8], $components[0], $components[1]];
        $params['components'] = $newComponents;

        // export excel
        $html = $this->getRenderTemplate('render/invoice/exportExcel', $params);
        $name = "BILAN-CA-".date('Ymd-his');
       
        $this->renderExcel($html, $name);
      
    }


    public function exportPdf($request) {

        if (!hasCredential('invoice::access')) $this->redirect('app/home');

        if(!isset($request->dateStart))
        {   
            $params['dateEnd'] = date('Y-m-d');
            $params['dateStart'] =  getStartMonth($params['dateEnd']);
            $params['modePayement'] = 'all';
        }
        else
        {
            $params['dateStart'] = $request->dateStart;
            $params['dateEnd'] = $request->dateEnd;
            $params['modePayement'] = $request->modePayement;
        }

        $apiRequest = 'invoice/search/'.$params['dateStart'].'/'.$params['dateEnd'].'/'.$params['modePayement'];
        $params['invoices'] = $this->cURL(API.$apiRequest, 'PHP_CALL', '', 'GET');

        $components = $this->cURL(API.'component/list', 'PHP_CALL', '', 'GET');
        $newComponents = [$components[2], $components[3], $components[4], $components[5], $components[6], $components[8], $components[0], $components[1]];
        $params['components'] = $newComponents;

        // export pdf
        $name = "BILAN-CA-".date('Ymd-his');
        $pdf = new PdfService("L");
        $pdf->setTitle($name);
        $html = $this->getRenderTemplate('render/invoice/exportExcel', $params);
        $pdf->setHtmlContent($html);

        $pdf->renderHtml();
    }

    public function addComponent($request) {

        if (!hasCredential('invoice::update')) return $this->renderJson(['error' => 'forbidden']);

        $datas = [
            'invoiceProductId' => $request->invoiceProductId,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'componentId' => $request->componentId
        ];

        $response = $this->cURL(API.'invoice/invoiceProduct/addComponent', 'AJAX_CALL', $datas, 'PUT');
        $response->invoiceProductId = $request->invoiceProductId;

        return $this->renderJson($response);

    }

    public function deleteComponent($request) {

        if (!hasCredential('invoice::update')) return $this->renderJson(['error' => 'forbidden']);

        $datas = [
            'invoiceComponentId' => $request->invoiceComponentId,
        ];


        $response = $this->cURL(API.'invoiceProduct/deleteComponent', 'AJAX_CALL', $datas, 'DELETE');
        $response->invoiceProductId = $request->invoiceProductId;

        return $this->renderJson($response);

    }

    public function createNewInvoiceProducts($invoice) {
        $new_invoiceProducts = [];

        foreach($invoice->invoiceProducts as $invoiceProduct) {

            $alldates = explode('|', $invoiceProduct->descriptionFr->dates);

            if( count((array) $alldates) > 7 ) {
                $nb = count((array) $alldates);
                $theDatesString = $nb.' dates - du '.showDate($alldates[0]).' au '.showDate($alldates[$nb-1]);
            } else {
                foreach($alldates as $date) {
                    $arr[] = showDate($date);
                }
                $theDatesString = implode('|', $arr);
                unset($arr);
            }

            if(key_exists($invoiceProduct->nameFr, $new_invoiceProducts)) {
                $new_invoiceProducts[$invoiceProduct->nameFr]['quantity']++;
                $new_invoiceProducts[$invoiceProduct->nameFr]['description'][$invoiceProduct->descriptionFr->child_name][] = $theDatesString;
            } else {
                $new_invoiceProducts[$invoiceProduct->nameFr] = [
                    'product' => $invoiceProduct,
                    'quantity'       => $invoiceProduct->quantity
                ];

                if(isset($invoiceProduct->descriptionFr->dates)) {
                    $elements = explode('|', $invoiceProduct->descriptionFr->dates) ;
                    $nbElements = count((array) $elements);
                    if($nbElements > 0) {
                        $i = 0;
                        foreach($elements as $element) {
                            if($i == 0) $first = showDate($element);
                            $dateFr[] = showDate($element);
                            $last = showDate($element);
                            $i++;
                        }
                        $datesToShow = implode('|', $dateFr);
                    } else {
                        $datesToShow = showDate($invoiceProduct->descriptionFr->dates);
                    }
                    $new_invoiceProducts[$invoiceProduct->nameFr]['description'][$invoiceProduct->descriptionFr->child_name][] = $datesToShow;
                    if($nbElements > 5) {
                        $new_invoiceProducts[$invoiceProduct->nameFr]['description2'] = $nbElements.' dates du '.$first.' au '.$last;
                    }
                    unset($dateFr);
                }
            }

        }

        return $new_invoiceProducts;
    }
}
