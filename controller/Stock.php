<?php
require_once(HELPER.'userSession.php');
require_once(HELPER.'dates.php');

class Stock extends Controller
{

    public function viewList($request)
    {
        $params = [];

        $params['buttons'] = array
        (
            array(
                 'attributes' => ['id' => 'createList'],
                 "href" => HOST."stock/order",
                 "onclick" => "",
                 "label" => "Course",
                 "icon" => "sell"
             ),
            array(
                'attributes' => ['id' => 'editStock'],
                "href" => HOST."stock/edit/",
                "onclick" => "",
                "label" => "Modifier",
                "icon" => "edit"
            ),
        );



        $params['stockProducts']  = $this->cURL(API.'stockProduct/list', 'PHP_CALL', '' , 'GET');
        $params['latestDate'] = $this->cURL(API.'stockProduct/inventory/latest/date', 'PHP_CALL', '' , 'GET');
        $this->renderWithData('render/stock/list', $params);
    }


    public function edit($requet) {
        $params = [];
        $params['stockProducts']  = $this->cURL(API.'stockProduct/list', 'PHP_CALL', '' , 'GET');

        $this->renderWithData('render/stock/edit', $params);
    }

    public function order($request) {
        $params = [];

        if(isset($request->date)) {
            $date = $request->date;
            $status = "show";
        } else {
            $date = date('Y-m-d');
            $status = "create";
        }

        $params['date'] = $date;
        $params['status'] = $status;
        $params['stockProducts']  = $this->cURL(API.'stockProduct/list', 'PHP_CALL', '' , 'GET');
        $params['latestDate'] = $this->cURL(API.'stockProduct/inventory/latest/date', 'PHP_CALL', '' , 'GET');
        $params['orderProducts']  = $this->cURL(API.'stockOrder/listContent/'.$date, 'PHP_CALL', '' , 'GET');

        $this->renderWithData('render/stock/order', $params);
    }

    public function orderList($requet) {
        $params = [];
        $params['latestDate'] = $this->cURL(API.'stockProduct/inventory/latest/date', 'PHP_CALL', '' , 'GET');
        $params['stockOrders'] = $this->cURL(API.'stockOrder/list', 'PHP_CALL', '', 'GET');

        $this->renderWithData('render/stock/orderList', $params);
    }


    public function inventory($request)
    {


        if(!isset($request->date))
        {
            $date = date('Y-m-d');
        }
        else
        {
            $date = $request->date;
        }

        $params = [];
        $params['date'] = $date;
        $params['stockProducts']  = $this->cURL(API.'stockProduct/inventory/'.$date, 'PHP_CALL', '' , 'GET');

        $this->renderWithData('render/stock/inventory', $params);
    }

}
