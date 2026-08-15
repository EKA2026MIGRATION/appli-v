<?php


class Communication extends Controller
{
    public function viewSearch($request)
    {
        $params = [];
        $params['childs'] = $this->cURL(API.'child/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');
        $this->renderWithData('render/communication/search', $params);
    }

    public function showCampagn($request) {
        $params = [];

        $datas =  $this->cURL(API.'product/list', 'PHP_CALL', '', 'GET');
        foreach($datas as $product) {
            $params['listByProducts'][$product->categories[0]->name][] = [
                                                            "categoryPublicName" => $product->categories[0]->publicName,
                                                            "product" => $product
                                                        ];
        }
        $params['extractLists'] = $this->cURL(API.'extractList/list', 'PHP_CALL', '', 'GET');
        if($request->id != 0) {
            $params['campagn'] = $this->cURL(API.'historicSms/displayAll/'.$request->id, 'PHP_CALL', '' , 'GET');

            $params['buttons'] = array
            (
        
              array('href' => HOST.'communication/delete/id/'.$request->id.'/', "onclick" => null, "label" => 'Supprimer', 'icon' => 'delete'),
              array('href' => HOST.'communication/duplicate/id/'.$request->id.'/', "onclick" => null, "label" => 'Dupliquer', 'icon' => 'file_copy')
    
            );

        } else {
            $params['campagn'] = (object)['name' => null, 'id' => null, 'content' => null, 'signature' => null, 'unicode' => null];
        }

        $this->renderWithData('render/communication/show', $params);
    }
    
    public function duplicate($request) {
        $params = [];
        $params['campagns'] = $this->cURL(API.'historicSms/duplicate/'.$request->id, 'PHP_CALL', '', 'GET');
        $this->redirect('communication/showCampagn/id/'.$params['campagns'][0]->id.'/');

    }

    public function delete($request) {
        $params = [];
        $params['campagns'] = $this->cURL(API.'historicSms/delete/'.$request->id, 'PHP_CALL', '', 'DELETE');
    
        $this->redirect('communication/indexSms');
    }


    public function indexSms($request) {
        $params = [];
        $params['campagns'] = $this->cURL(API.'historicSms/list', 'PHP_CALL', '', 'GET');
        $this->renderWithData('render/communication/indexSms', $params);
    }


    public function updateHistoricSms($request) {
        $datas = ['content' => $request->content, 'name' => $request->name, 'status' => 'create', 'id' => $request->id, 'signature' => $request->signature, 'unicode' => $request->isUnicode];
        $result = $this->cURL(API.'historicSms/create', 'PHP_CALL', $datas, 'POST');
        echo json_encode($result);
    }


    public function extractListDisplay($request) {
        $list   = $this->cURL(API.'extractList/display/'.$request->id, 'PHP_CALL', '' , 'GET');
        $childs = $this->cURL(API.'extractList/listExecuteContent/'.$request->id, 'PHP_CALL', '' , 'GET');
        echo json_encode(["title" => $list->title, "childs" => $childs]);
    }

    public function updateDoSend($request) {
        $datas = ['historicSmsListId' => $request->historicSmsListId];
        $result = $this->cURL(API.'historicSmsList/updateDoSend', 'PHP_CALL', $datas, 'POST');
        echo json_encode($result);
    } 

    public function doSend($request) {
        $params['historicSms'] = $this->cURL(API.'historicSms/displayAll/'.$request->id.'/notSent/50/', 'PHP_CALL', '' , 'GET');

        if(count((array) $params['historicSms']->phoneNumbers) < 1 && $params['historicSms']->phoneNumbers == "create") {

            // update historicSms to seent
            $datas = ['status' => 'sent'];
            $result = $this->cURL(API.'historicSms/modify/'.$request->id, 'PHP_CALL', $datas, 'PUT');
        }
        $this->renderWithData('render/communication/doSend', $params);
    }

    public function historicSmsList($request) {

        ini_set('memory_limit','256M');


        $result = $this->cURL(API.'historicSms/displayAll/'.$request->id, 'PHP_CALL', '' , 'GET');

        $childs = [];

        foreach($result->phoneNumbers as $i => $data) {
            (isset($data->childId)) ? $childId = $data->childId : $childId = $i ;
            $element = explode('-', $data->phoneName);
            $phoneName = trim($element[count((array) $element)-1]); 
            $phones[$childId][] = ['phone' => $data->phoneNumber, 'name' => $phoneName ];
        }
        
        foreach($result->phoneNumbers  as $i => $data) {
            (isset($data->childId)) ? $childId = $data->childId : $childId = $i ;
            $element = explode('-', $data->phoneName);

            (isset($data->childFullnameReverse)) ? $childName = $data->childFullnameReverse : $childName = trim($element[0])    ;

            $childs[$childName][] = [
                                                    'childId'         => $childId,
                                                    'fullnameReverse' => $childName,
                                                    'registrationId'  => "",
                                                    'updatedAt'       => "",
                                                    'status'          => "",
                                                    'sessions'        => "",
                                                    'phones'          => $phones[$childId],
                                                    'personal'        => ""
            ];
        }
        ksort($childs);

        echo json_encode(["title" => $result->name, "childs" => $childs]);

    }
}