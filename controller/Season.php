<?php
/**
 * Created by PhpStorm.
 * User: Rozenn
 * Date: 18/12/2018
 * Time: 15:40
 */

class Season extends Controller
{
    public function viewList($request)
    {
        $params=[];
        $params['actives'] = $this->cURL(API.'season/list/active?page=1&size='.SIZE_LIST, 'PHP_CALL', '' , 'GET');
        $params['disabled'] = $this->cURL(API.'season/list/disabled?page=1&size='.SIZE_LIST, 'PHP_CALL', '' , 'GET');
        $params['draft'] = $this->cURL(API.'season/list/draft?page=1&size='.SIZE_LIST, 'PHP_CALL', '' , 'GET');

        $this->renderWithData('render/season/list', $params);
    }
}