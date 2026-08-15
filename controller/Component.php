<?php
/**
 * Created by PhpStorm.
 * User: Rozenn
 * Date: 12/12/2018
 * Time: 20:01
 */

class Component extends Controller
{
    public function viewList($request)
    {
        $this->renderWithData('render/component/list', $this->cURL(API.'component/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET'));
    }
}