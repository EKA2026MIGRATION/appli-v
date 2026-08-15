<?php


class Week extends Controller
{
    public function viewList($request)
    {
        $this->renderWithData('render/week/list', $this->cURL(API.'week/list?page=1&size='.WEEK_LIST, 'PHP_CALL', '', 'GET'));
    }
}