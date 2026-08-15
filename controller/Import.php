<?php

/**
 * Class Home.
 *
 * use to show the home page
 */
class Import extends Controller
{
    public function data($request)
    {
        $params = [];

        if (!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }
        $params['date'] = $date;

        $this->renderWithData('render/import/data', $params);
    }

    public function transport($request)
    {
        $params = [];

        $params['messages'] = $this->cURL(API.'migration/retrieve/transport/'.$request->date, 'PHP_CALL', '', 'GET');

        $this->renderHtml('render/import/transportResult', $params);
    }

    public function child($request)
    {
        $params = [];

        $params['messages'] = $this->cURL(API.'migration/import/child', 'PHP_CALL', '', 'GET');

        $this->renderHtml('render/import/childResult', $params);
    }

    public function activity($request)
    {
        $params = [];

        $params['messages'] = $this->cURL(API.'migration/retrieve/activity/'.$request->date, 'PHP_CALL', '', 'GET');

        $this->renderHtml('render/import/activityResult', $params);
    }
}
