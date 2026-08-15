<?php


class CustomerSite extends Controller
{

    public function viewDisplay($request) {

        $params = array();
        $params['categories'] = $this->cURL(API.'category/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET'); 
        $params['products'] = $this->cURL(API.'product/list?page=1&size=200', 'PHP_CALL', '', 'GET');
        $params['product_cancelled_date'] = $this->cURL(API.'product-cancelled-date/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');         
        $this->renderWithData('render/customerSite/display', $params);

    }

    public function viewGymnases($request) {

        $products =  $this->cURL(API.'product/list/frontvisibility/11', 'PHP_CALL', '', 'GET');
        $locations = $this->cURL(API.'location/list/gymnase', 'PHP_CALL', '', 'GET'); // OK

        $arr = [];

        $params['products'] = $products;
        $params['locations'] = $locations;
        $this->renderWithData('render/customerSite/gymnases', $params);

    }

}
