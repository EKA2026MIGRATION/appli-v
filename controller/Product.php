<?php


/**
 * Class Product
 *
 */

class Product extends Controller
{
    public function viewList($request)
    {

        $params['datas'] =  $this->cURL(API.'product/list', 'PHP_CALL', '', 'GET');
        foreach($params['datas'] as $product) {
            $params[$product->categories[0]->name][] = [
                                                            "categoryPublicName" => $product->categories[0]->publicName,
                                                            "product" => $product
                                                        ];
        }

        unset($params['datas']);

        $this->renderWithData('render/product/list', $params);
    }

    public function viewArchived($request)
    {

        $params['datas'] =  $this->cURL(API.'product/list/archived', 'PHP_CALL', '', 'GET');
        foreach($params['datas'] as $product) {
            $params[$product->categories[0]->name][] = [
                                                            "categoryPublicName" => $product->categories[0]->publicName,
                                                            "product" => $product
                                                        ];
        }
        unset($params['datas']);
        $this->renderWithData('render/product/archived', $params);
    }

    
    

    public function viewAdd($request)
    {

        $params = array();

        $params['categories'] = $this->cURL(API.'category/listStandard', 'PHP_CALL', '' , 'GET');
        $params['components'] = $this->cURL(API.'component/list', 'PHP_CALL', '' , 'GET');
        $params['families'] = $this->cURL(API.'family/list', 'PHP_CALL', '' , 'GET');
        $params['seasonActive'] = $this->cURL(API.'season/list/active', 'PHP_CALL', '' , 'GET');
        $params['seasonDraft'] = $this->cURL(API.'season/list/draft?page=1&size='.SIZE_LIST, 'PHP_CALL', '' , 'GET');
        
        $params['seasons'] = array_merge((array) $params["seasonActive"], (array) $params["seasonDraft"]);


        $params['locations'] = $this->cURL(API.'location/list', 'PHP_CALL', '', 'GET');
        $params['sports'] = $this->cURL(API.'sport/list', 'PHP_CALL', '', 'GET');
        $params['mails'] = $this->cURL(API.'mail/list', 'PHP_CALL', '', 'GET');

        if(isset($request->id))
        {
            $params['product'] = $this->cURL(API.'product/display/'.$request->id, 'PHP_CALL', '', 'GET');

        }
        elseif(isset($request->duplicate))
        {
            $params['duplicate'] = true;
            $params['product'] = $this->cURL(API.'product/display/'.$request->duplicate, 'PHP_CALL', '', 'GET');

        }

        $this->renderWithData('render/product/add', $params);

    }

    public function listChild($request) {
        $params = [];

        $params['product'] = $this->cURL(API.'product/display/'.$request->id, 'PHP_CALL', '' , 'GET');
        $params['childs']  =  $this->cURL(API.'product/registrations/'.$request->id, 'PHP_CALL', '' , 'GET');
        
        if(isset($request->mode)) {
            if($request->mode == "json") {
                echo json_encode(["title" => $params['product']->nameFr, "childs" => $params['childs']]);
                exit;
            }
        }

        return $this->renderWithData('render/product/listChild', $params);

    }

    public function fastUpdate($request) {

        $datas['idList'] = $request->idList;
        $datas['visibility'] = $request->visibility;

        $response = $this->cURL(API.'product/fastUpdate', 'AJAX_CALL', $datas, 'POST');

        dd($response);

    }

    public function viewAssignProduct($request)
    {
        $this->render('render/product/assignProduct');
    }

    public function viewDisplay($request)
    {
        if(isset($request->id))
        {
            $this->renderWithData('render/product/display', $this->cURL(API.'product/display/'.$request->id, 'PHP_CALL', '' , 'GET'));
        }
        else
        {
            header('location: '.HOST.'product/list');
        }

    }

    public function viewMail($request)
    {

        $params['mails'] =  $this->cURL(API.'mail/list', 'PHP_CALL', '', 'GET');

        $this->renderWithData('render/product/mail', $params);
    }

    public function viewDisplayMail($request)
    {

        if(isset($request->id))
        {
            $params = $this->cURL(API.'mail/display/'.$request->id, 'PHP_CALL', '' , 'GET');
            $this->renderWithData('render/product/displayMail', $params);
        }
        else
        {
            header('location: '.HOST.'product/mail');
        }
    }

    public function viewCreateMail($request)
    {
        $this->render('render/product/createMail');
    }
    

}
