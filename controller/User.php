<?php
/**
 * Created by PhpStorm.
 * User: Rozenn
 * Date: 17/12/2018
 * Time: 12:29
 */

class User extends Controller
{
    public function viewModify($request)
    {
        if(isset($request->id))
        {
            $this->renderWithData('render/user/modify', $this->cURL(API.'user/api/display/'.$request->id, 'PHP_CALL', '', 'GET'));
        }
    }



    public function viewAdd($request)
    {
        if(isset($request->id))
        {
            $this->renderWithData('render/user/add', $this->cURL(API.'user/api/display/'.$request->id, 'PHP_CALL', '', 'GET'));

        }
        else
        {
            $this->render('render/user/add');
        }
    }

    public function viewList($request)
    {

        $this->renderWithData('render/user/list', $this->cURL(API.'user/api/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET'));


    }

    public function viewDisplay($request)
    {

        $params = array();
      
        if(isset($request->id))
        {

        	$params['user'] = $this->cURL(API.'user/api/display/'.$request->id, 'PHP_CALL', '', 'GET');
        	$params['persons'] = $this->cURL(API.'person/display/'.$request->id, 'PHP_CALL', '', 'GET');
            $this->renderWithData('render/user/display', $params);

        }
        else
        {
            header('location: '.HOST.'user/list');
        }


    }


}
