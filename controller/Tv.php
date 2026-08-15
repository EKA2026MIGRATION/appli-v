<?php

class Tv extends Controller
{

    public function viewSettings($request)
    {
        
        $params = array();
        $path    = 'uploads/tv';
        $files = scandir($path);
        foreach ($files as $key => $link) {
            if(is_dir($path.'/'.$link)){
                unset($files[$key]);
            }
        }
        $params['pic'] = $files;

        $pathBackgroundImage   = 'uploads/tv/background';
        $filesBackground = scandir($pathBackgroundImage);
        $params['picBackground'] = $filesBackground;

        $params['tv'] = $this->cURL(API.'television/list', 'PHP_CALL', '', 'GET');

        $this->renderWithData('render/tv/settings', $params);

    }
    public function removeImg($request)
    {
        unlink($pic = $request->pic);

        echo json_encode(['status' => true]);
    }


}

