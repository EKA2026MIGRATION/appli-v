<?php

/**
 * Class Food
 */
class Food extends Controller
{
    public function viewAdd($request)
    {
        if (isset($request->id)) {
            $this->renderWithData('render/food/add', $this->cURL(API . 'food/display/' . $request->id, 'PHP_CALL', '', 'GET'));
        } else {

            $this->render('render/food/add');
        }
    }

    public function viewList($request)
    {
        $params = array();
        $params['actives'] = $this->cURL(API.'food/list/active', 'PHP_CALL', '' , 'GET');
        $params['disabled'] = $this->cURL(API.'food/list/disabled', 'PHP_CALL', '' , 'GET');
        $params['archived'] = $this->cURL(API.'food/list/archived', 'PHP_CALL', '' , 'GET');
        $this->renderWithData('render/food/list', $params);
    }

    public function viewDisplay($request)
    {
        if(isset($request->id))
        {
            $this->renderWithData('render/food/display', $this->cURL(API.'food/display/'.$request->id, 'PHP_CALL', '' , 'GET'));
        }
        else
        {
            header('location: '.HOST.'food/list');
        }
    }
}