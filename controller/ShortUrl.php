<?php

/**
 * Class ShortUrl
 */
class ShortUrl extends Controller
{
 
    public function list($request)
    {
        $params = array();
        $params['shortUrls'] = $this->cURL(API.'shortUrl/list', 'PHP_CALL', '' , 'GET');
       
        $this->renderWithData('render/shortUrl/list', $params);
    }


    public function create($request)
    {
        $datas = [
            'original_url' => $request->original_url,
        ];
        $response = $this->cURL(API.'shortUrl/create', 'PHP_CALL', $datas, 'POST');
        $this->redirect('shortUrl/list');
    }

}