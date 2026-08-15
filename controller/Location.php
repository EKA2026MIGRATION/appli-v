<?php


class Location extends Controller
{
    public function viewList($request)
    {
        $this->renderWithData('render/location/list', $this->cURL(API.'location/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET'));
    }
}