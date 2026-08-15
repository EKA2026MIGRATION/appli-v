<?php
use_helper('dates');
/**
 * Class ChildFusion
 */

class ChildFusion extends Controller
{
    public function show($request)
    {
        $params = [];
        $params['childs'] = $this->cURL(API.'child/search/same/'.$request->id, 'PHP_CALL', '' , 'GET');     

        $this->renderWithData('render/childFusion/show', $params);
    }

    public function doFusion($request) 
    {
        //$params['child'] = $this->cURL(API.'child/display/'.$request->id, 'PHP_CALL', '' , 'GET');     
    }


}