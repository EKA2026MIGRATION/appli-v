<?php
use_helper('dates, age, translation');

/**
 * Class Public
 *
 */

class MyPublic extends Controller
{

    private $jwtToken;

    public function __construct() {

        $requestAuth["username"] = API_ADMIN_USERNAME;
        $requestAuth["password"] = API_ADMIN_PASSWORD;
        $params = $this->cURL(API.'user/api/authenticate', 'AJAX_CALL', $requestAuth, 'POST');
  
        $this->jwtToken = $params->token;

        parent::__construct();
    }

    public function downloadInvoice($request) {
        $invoiceId = decodeInt($request->v);

        $view = $request->i;

        $invoice = $this->cURLWithToken(API.'invoice/display/'.$invoiceId, 'PHP_CALL', '', 'GET',  $this->jwtToken);

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

        $invoice->invoiceProducts = $new_invoiceProducts;

        $params['invoice'] = $invoice;

        $params['view'] = $view;

        $pdf = new PdfService();

        $pdf->setTitle('DownloadInvoice');

        $pdf->setAddTampon(1);

        $html = $this->getRenderTemplate('render/invoice/pdfCustomer', $params);

        $pdf->setHtmlContent($html);

        $pdf->renderHtml();

    }

    public function displayTv($request) {
        
        $files_accepted = ['jpg', 'jpeg', 'png'];
    
        $date = date('Y-m-d');
        $date = '2024-11-27'; // to test

        $params = array();

        $params['date'] = $date;
        $params['background'] = ['transport' => 'theme-foot.jpg', 'activity' => 'theme-tennis.jpg'];

        // uplaod tv pic
        $path    = 'uploads/tv';
        $files = scandir($path);
        foreach($files as $file) {
            $element = explode('.', $file);
            if(isset($element[1]) && (in_array($element[1], $files_accepted))) {
                $pics[] = $file;
            }
        }

        $params['pic'] = $pics;     
        

        // background pic and bgChoice
        $pathBackgroundImage   = 'uploads/tv/background';
        $filesBackground = scandir($pathBackgroundImage);
        
        
        $filesBackgroundPush = array();
        $i = 0;
        foreach($filesBackground as $background) {
            if(strlen($background) > 5) {
                $filesBackgroundPush[$i] = $background;
                $i++;
            } 
            
        }

        if(count((array) $filesBackgroundPush) > 1) {
            $bgChoice = $filesBackgroundPush[mt_rand(0, count((array) $filesBackgroundPush) - 1)];
        } else {
            $bgChoice = $filesBackgroundPush[0];
        }
        
        $params['backgrounds'] = $filesBackgroundPush;


        $settings = $this->cURLWithToken(API.'television/list', 'PHP_CALL', '', 'GET', $this->jwtToken);

        foreach($settings as $setting) {

            $elements = explode(':', $setting->start);
            $start = intval($elements[0].$elements[1]);
            $elements = explode(':', $setting->end);
            $end = intval($elements[0].$elements[1]);

            if($setting->module == "activity") $backgroundImg = $bgChoice;
            if($setting->module == "transport") $backgroundImg = $bgChoice;
          
            // add gallery

            (isset($request->age)) ? $age = $request->age : $age = 0;


            $sequences[] = [ 
                                'start' => $start,
                                'end' => $end,
                                'module' => $setting->module,
                                'background' => $backgroundImg,
                                'age' => $age
                            ]; 
        }

        $params['jsonSequences'] = json_encode($sequences);       

        $this->renderWithData('render/public/channel', $params);

    }

    public function showCardChallenge($request)
    {
        $arr = explode('I', $request->challenge);
        $childId = $arr[1];
        $child = $this->cURLWithToken(API.'child/display/'.$childId, 'PHP_CALL', '', 'GET',  $this->jwtToken);
        $this->renderHtml('render/public/cardChallenge', ['child' => $child]);
    }


    public function showInstant($request) {

        $ref   = date('H:i:s');
        $date  = date('Y-m-d');

     //   $ref = "15:00:00"; // to test
     //    $date = date('2024-12-11'); // to test


        if(isset($request->age)) {
            $age = $request->age;
        } else {
            $age = 0;
        }

        $start = lessHour($ref); //1
        $end   = addHour($ref); //2

        if(isset($request->module)) {
            $module = ucfirst($request->module);
        } else {
            $module = "Activity";
        }

        if($module == "Activity") {
            $params['groups'] = $this->cURLWithToken(API.'group-activity/tv-list/'.$date.'/'.$start.'/'.$end ,'PHP_CALL', '', 'GET', $this->jwtToken);

        } else if($module == "Transport") {
            $params['groups'] = $this->cURLWithToken(API.'ride/tv-list/'.$date.'/'.$start.'/'.$end ,'PHP_CALL', '', 'GET', $this->jwtToken);
        } else {

        }

        $params['module'] = $module;
        $params['time'] = explode(':', $ref)[0];

        $params['age'] = $age;

        if($params['time'] >= '14') {
            $template ="_instantSupervision";
        } else {
            $template = "_instant".$module;
        }

        $this->renderHtml('render/public/'.$template, $params);
    }


    public function webhookUpdateResponse($request) {

        ini_set("allow_url_fopen", "On");

        $entityBody = file_get_contents('php://input'); // doesn't work on server

        $data = json_decode($entityBody, true);

        $contents = $data['message'].' '.$data['from'].' '.$data['last_message_id'];
    

        echo "content:<br/>".$contents;


        // dtata in bdd

        $email = "sandyrazafitrimo@gmail.com";
        $mailerService = new MailerService();
        $mailerService->setAdd($email);
        $mailerService->setMessage($entityBody);
        $mailerService->setTitle("Energy Kids Webhook update Response ");
        $mailerService->sendMail();

    }


    public function webhookStop($request) {

        ini_set("allow_url_fopen", "On");

        $entityBody = file_get_contents('php://input'); // doesn't work on server

        $data = json_decode($entityBody, true);

        $contents = $data['message'].' '.$data['from'].' '.$data['last_message_id'].' '.$data['date'];

        $email = "sandyrazafitrimo@gmail.com";
        $mailerService = new MailerService();
        $mailerService->setAdd($email);
        $mailerService->setMessage($contents);
        $mailerService->setTitle("Energy Kids Webhook stop");
        $mailerService->sendMail();


        // retrieve person from number
        $fromPerson = $this->cURLWithToken(API.'person/from/'.$data['from'], 'PHP_CALL', '', 'GET', $this->jwtToken);

        // get all persons
        $allPersons = $fromPerson->getChild()->getPersons();

/*
        // update
        foreach($allPersons as $person) {
            $result = $this->cURLWithToken(API.'person/blackListed/'.$person.'/1', 'PHP_CALL', '', 'GET', $this->jwtToken);

        }

        $contents += "<br/>".$result;
*/
        $email = "sandyrazafitrimo@gmail.com";
        $mailerService = new MailerService();
        $mailerService->setAdd($email);
        $mailerService->setMessage($contents.' '.$fromPerson->getId());
        $mailerService->setTitle("Energy Kids Webhook stop");
        $mailerService->sendMail();




    }




    public function showSurveySession($request) {
        $surveySessionId = decodeInt($request->assigned);

        if(isset($request->update)) {
            $datas['questionId']       = $request->questionsId;
            $datas['surveySessionId']  = $surveySessionId;
            $datas['questionTypeNote'] = $request->questionTypeNote;
            $result = $this->cURL(API.'surveySession/updateQuestions', 'PHP_CALL', $datas, 'POST');            
            $params['activeForm'] = "unactive";
            $params['message'] = "updated";
        } else {
            $params['activeForm'] = "active";
            $params['message'] = null;
        }

        $params['surveySession'] = $this->cURL(API . 'surveySession/display/'.$surveySessionId, 'PHP_CALL', '', 'GET');


        $params['status'] = $params['surveySession']->status;



        if($params['status'] == "answered") {
            $params['activeForm'] = "unactive";
        }

        //remove on prod
        //$params['activeForm'] = "active";

        $this->renderHtml('render/public/surveySession', $params);

    }


    public function showBooklet($request) {
        $bookletChildId = decodeInt($request->enfant);
        $datas  = $this->cURL(API.'bookletchild/display/'.$bookletChildId, 'PHP_CALL', '' , 'GET');
        $params['bookletChild'] = $datas->bookletChildArray;

        $params['bookletChild']->child->age = showAge($params['bookletChild']->child->birthdate);

        $params['bookletChild']->child->childHand     = trans($params['bookletChild']->child->childHand);
        $params['bookletChild']->child->childFoot     = trans($params['bookletChild']->child->childFoot);
        $params['bookletChild']->child->guidingEye    = trans($params['bookletChild']->child->guidingEye);
        $params['bookletChild']->child->sportifProfil = trans($params['bookletChild']->child->sportifProfil);

        if($params['bookletChild']->child->childHand == "droit") $params['bookletChild']->child->childHand = "droite" ;


        $params['bookletChild']->dateEvaluationFr = showDate($params['bookletChild']->dateEvaluation);

        $navigation = [
                        ['name' => $datas->bookletChildArray->booklet->name, 'template' => 'cover'],
                        ['name' => $datas->bookletChildArray->child->fullname, 'template' => 'child']
                    ];

        $coverHtml = $this->getRenderTemplate('render/booklet/template/cover', []);
        $childHtml = $this->getRenderTemplate('render/booklet/template/child', []);

        $templates = ['cover' => $coverHtml, 'child' => $childHtml];
        foreach($datas->bookletChildArray->booklet->boards as $board) {
            $template = "board";
            $navigation[] = [
                                'name'          => $board->name,
                                'template'      => $template,
                                'description'   => $board->description,
                                'backgroundImg' => $board->photo2,
                                'totemImg'      => $board->photo1,
                                'responses'     => $board->response,
                                'iconImg'       => $board->icon
                            ];


                            // a changer par la suite, juste utile pour la page coach
                            $temporaryBackgroudImg = $board->photo2;

            if(!isset($templates[$template])) {
                $templates[$template] = $this->getRenderTemplate('render/booklet/template/'.$template, []); 
            } 
        }

        $navigation[] = ['name' => "Le mot du coach", 'template' => 'coach', 'backgroundImg' => $temporaryBackgroudImg];

        $navigation[1]['backgroundImg'] = 'uploads/livret/background/city-street-child.png';

        $templates['coach'] = $this->getRenderTemplate('render/booklet/template/coach', []);

        $params['templates'] = $templates;

        $params['navigation'] = $navigation;

        $this->renderHtml('render/public/bookletChild', $params);
    }

    public function getTemplate($request) {
        $this->renderHtml('render/booklet/template/'.$request->type, []);
    }

    public function shortUrl($request) {
        
        $shortUrl = $this->cURLWithToken(API.'shortUrl/retrieve/'.$request->shortCode,'PHP_CALL', '', 'GET', $this->jwtToken);
        if($shortUrl == "not_found") {
            return $this->redirect('error404');
            exit;
        } else {
            header('Location: '.$shortUrl->originalUrl);
            exit;
        }
    }


    public function showInvitations($request) {
        $this->renderHtml('render/public/invitations', []);
    }
   
}