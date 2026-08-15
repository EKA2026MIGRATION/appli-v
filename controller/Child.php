<?php
use_helper('dates');
/**
 * Class Child
 */

class Child extends Controller
{
    public function viewDisplay($request) // Profil of one child
    {

        if(isset($request->to)){
            $to = $request->to;
            $to2 = $to;
        } else {
            $to = date('Y-m-d');
            $to = nextDay($to, 1);
            $to2 = nextDay($to, 120);
        }

        if(isset($request->from)){
            $from = $request->from;
            $from2 = $from;
        } else {
            $from = prevDay($to, 120);
            $from2 = prevDay($to, 50);
        }

        if(isset($request->id))
        {

            $params = [];
            $params['child'] = $this->cURL(API.'child/display/'.$request->id, 'PHP_CALL', '' , 'GET');
            $presences = $this->cURL(API.'child/presence/display/'.$request->id.'/'.$from2.'/'.$to2, 'PHP_CALL', '' , 'GET');

            (isset($presences->error)) ? $params['presences']  = [] : $params['presences'] = $presences;


            $params['registrations'] = $this->curl(API.'registration/childList/'.$request->id.'/'.$from.'/'.$to, 'PHP_CALL', '' , 'GET');
            $pickups = $this->curl(API.'pickup/listByChildId/'.$request->id.'/'.$from2.'/'.$to2, 'PHP_CALL', '' , 'GET');

            (isset($pickups->error)) ? $params['pickups']  = [] : $params['pickups'] = $pickups;


            $params['surveys'] = $this->cURL(API . 'survey/list', 'PHP_CALL', '', 'GET');
            $params['surveySessions'] = $this->cURL(API . 'surveySession/list/'.$request->id, 'PHP_CALL', '', 'GET');
            $params['cart'] = $this->cURL(API.'registration/child-list/'.$request->id.'/cart', 'PHP_CALL', '','GET');

            $params['invoices'] = [];

            if(isset($request->year)) {
                $year= $request->year;
            } else {
                $el = explode('-', $to); $year = $el[0];
            }
        
            $persons = $params['child']->persons;
            foreach($persons as $person) {
                if($invoices = $this->curl(API."invoice/listByPerson/".$person->personId.'/'.$year, 'PHP_CALL', '' , 'GET')) {
                    $params['invoices'] = $params['invoices'] + $invoices;
                }
            }


            $params['to'] = $to;
            $params['from'] = $from;

            $params['to2'] = $to2;
            $params['from2'] = $from2;

            $params['year'] = $year;

            $params['dateStart'] = $year.'-01-01';
            $params['dateEnd']   = $year.'-12-31';
            
            $params['buttons'] = array
            (
                array(
                    'attributes' => ['data-open' => 'revealSearchAssociatedChild'],
                    "href" => "javascript:void(0)",
                    "onclick" => "associateChild(".$request->id.")",
                    "label" => "Associer un Enfant",
                        "icon" => "person_add"
                ),
                array(
                    "href" => HOST."child/add/id/".$request->id.'/',
                    "onclick" => "return:true",
                    "label" => "Modifier Fiche de l'enfant",
                    "icon" => "edit"),
                array(
                        "attributes" => ['id' => 'deleteChild', 'data-id-child' => $request->id],
                        "href" => "javascript:void(0)",
                        "onclick" => "",
                        "label" => "Supprimer",
                        "icon" => "delete"),
                array(
                    "href" => HOST."notification/vcf/type/child/id/".$request->id.'/',
                    "onclick" => "return:true",
                    "label" => "Télécharger le contact",
                    "icon" => "contact_phone"),
                array(
                    "href" => HOST."childFusion/index/id/".$request->id.'/',
                    "onclick" => "return:true",
                    "label" => "Fusionner de fiche",
                    "icon" => "people")
        );

            $this->renderWithData('render/child/display', $params);
        }
        else
        {
            header('location: '.HOST.'child/list');
        }
    }

    public function school($request) {
        $result = $this->cURL(API.'child/school', 'PHP_CALL', '', 'GET');

        $params['schools'] = $result->schools;
        $params['childs']  = $result->childs;


        $this->renderWithData('render/child/school', $params);


    }

    public function reloadAjax($request) {
        
        if($request->partData == "presence") {
            $params['presences'] = $this->cURL(API.'child/presence/display/'.$request->childId.'/'.$request->from.'/'.$request->to, 'PHP_CALL', '', 'GET');
            $this->renderHtml('render/child/_presencesList', $params);
        }

        if($request->partData == "pickup") {
            $params['pickups'] = $this->curl(API.'pickup/listByChildId/'.$request->childId.'/'.$request->from.'/'.$request->to, 'PHP_CALL', '' , 'GET');
            $this->renderHtml('render/child/_pickupsList', $params);
        }
        if($request->partData == "registration") {
            $params['registrations'] = $this->curl(API.'registration/childList/'.$request->childId.'/'.$request->from.'/'.$request->to, 'PHP_CALL', '' , 'GET');
            $this->renderHtml('render/registration/_list', $params);
        }       
    }


    public function viewAdd($request) // Form to add Child
    {
    
       $coachs = $this->cURL(API.'staff/list/coach?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');
       $driver = $this->cURL(API.'staff/list/driver?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');
       //$trainee = $this->cURL(API.'staff/list/trainee?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');

        $params['staffs'] = array_merge((array) $coachs, (array) $driver);


        if(isset($request->id))
        { 
            $params['child'] = $this->cURL(API.'child/display/'.$request->id, 'PHP_CALL', '', 'GET');
            $this->renderWithData('render/child/add', $params);
        }
        else
        {
            $this->renderWithData('render/child/add', $params);
        }
        
    }

    public function viewList($request) // List of all child 
    {
        $this->renderWithData('render/child/list', $this->cURL(API.'child/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET'));
    }

    public function showFusion($request) {
        $idArrayList = explode(',', $request->listId);
        foreach ($idArrayList as $childId) {
            $params['childs'][] = $this->cURL(API.'child/display/'.$childId, 'PHP_CALL', '' , 'GET');
        }
        return $this->renderWithData('render/child/fusion', $params);
    }

    public function updateData($request) {

        $params['data'] = $this->cURL(API.'migration/update/child/'.$request->childId, 'PHP_CALL', '' , 'GET');

        $this->redirect('transport/ride/date/'.$request->date.'/idDriver/'.$request->staffId.'/');
        
    }

    public function addJustificatif($request)
    {

        if(isset($_FILES['justificatif'])) {
            $type = 'justificatif';
        } else {
            $type = 'qrcode';
        }

        if(isset($_FILES[$type]) && $_FILES[$type]['error'] == 0) {

            $fileTmpPath = $_FILES[$type]['tmp_name'];
            $fileName = $_FILES[$type]['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $allowedfileExtensions = ['pdf', 'jpg', 'png', 'jpeg'];
            $allowedMimeTypes = [
                'pdf'  => ['application/pdf'],
                'jpg'  => ['image/jpeg'],
                'jpeg' => ['image/jpeg'],
                'png'  => ['image/png'],
            ];

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $realMimeType = finfo_file($finfo, $fileTmpPath);
            finfo_close($finfo);

            if(in_array($fileExtension, $allowedfileExtensions) && in_array($realMimeType, $allowedMimeTypes[$fileExtension])) {

                $filename = date('YmdHis').rand(0, 1000);
                $uploadFileDir = ROOT.'assets/document/'.$filename.'.'.$fileExtension;
                $dest_path = $uploadFileDir;
                $url_link = 'https://appli-v.net/assets/document/'.$filename.'.'.$fileExtension;

                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    $ids = $request->ids;
                    $result = $this->cURL(API.'child/addJustificatif', 'PHP_CALL', ['ids' => $ids, 'url' => $url_link, 'type' => $type], 'POST');
                    $idsarr = explode('|', $ids);
                    $this->redirect('child/display/id/'.$idsarr[0].'/');
                } else {
                    echo 'Il y a eu une erreur lors du transfert de votre fichier.';
                }
            } else {
                echo 'Upload non autorisé pour les fichiers de ce type.';
            }
        } else {
            echo 'Aucun fichier envoyé ou une erreur est survenue.';
        }
    }

    public function deleteJustificatif($request)
    {

        $childId = $request->childid;
        $ids = implode(',', [$childId]);
        $type = $request->type;
        $result = $this->cURL(API.'child/removeDocument', 'PHP_CALL', ['ids' => $ids, 'type' => $type], 'POST');
        $this->redirect('child/display/id/'.$childId.'/');
    }

}