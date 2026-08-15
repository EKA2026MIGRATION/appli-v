<?php

/**
 * Class Registration
 */

class Registration extends Controller
{
    public function viewDisplay($request) 
    {
        if(isset($request->id))
        {
            $this->renderWithData('render/registration/display', $this->cURL(API.'registration/display/'.$request->id, 'PHP_CALL', '' , 'GET')); 
        }
        else
        {
            header('location: '.HOST.'registration/list');
        }
    }

    public function viewNewAdd($request) 
    {
            if(isset($request->id)) {
                $params['child'] = $this->cURL(API.'child/display/'.$request->id, 'PHP_CALL', '', 'GET');
                $params['presences'] = $this->cURL(API.'child/presence/latest/created/'.$request->id, 'PHP_CALL', '', 'GET');
                $params['cart'] = $this->cURL(API.'registration/child-list/'.$request->id.'/cart', 'PHP_CALL', '','GET');
            }

            $params['categories'] = $this->cURL(API.'category/list', 'PHP_CALL', '', 'GET');
            $params['products'] = $this->cURL(API.'product/list?page=1&size=200', 'PHP_CALL', '', 'GET');

            foreach ($params['categories'] as $key => $category) {
                foreach ($category->products as $t => $product) {


                    if(isset($product->suppressed) && $product->suppressed == 1) {
                        unset($category->products[$t]);
                        continue;
                    }

                    // Vérifie la visibilité
                    if ($product->visibility == 'frontvisibility' || $product->visibility == 'backvisibility' ) {
                            continue;
                    } else {
                        unset($category->products[$t]);
                    }
                }
            }

            $message = "";
            if(isset($_SESSION['responses'])) {
                foreach($_SESSION['responses'] as $responses) {
                    if(isset($responses->status)) {
                        if($responses->status == "fail") {
                            if($responses->message == "another_registration_exist") {
                                $details = "Une inscription existe déjà : ";

                                foreach($responses->informations as $info) {
                                    $data[] = $info->date_fr;
                                }
                                $message = $details.' '.implode(' | ', $data);
                            }
                        }
                    }
                }
            };
            $params['message'] = $message;

            unset($_SESSION['responses']);

            $this->renderWithData('render/registration/newAdd', $params);

    }

    public function update($request) {

        if(isset($request->productALacarte)) {

            $type = "ALacarte";

            foreach($request->productALacarte as $date => $result) {
                if($date != 'checkbutton') {
                    if(isset($request->productALacarte['checkbutton'][$date]) ){
                        // $session[$result] = ['date' => $date];
                        $element = explode('-', $request->dateHourSession[$date]);
                        $id = $element[0]; $start = $element[1]; $end = $element[2];
                        $sessions[] = ['productId' => $id,'date' => $date, 'start' => $start, 'end' => $end];
                      
                    }
                }
            }
        } else if(isset($request->dateHourSession)) {

            $type = "basic";

            foreach($request->dateHourSession as $date => $dhs) {
                $sessions[$request->product][] = ['date' => $date, 'start' => $request->sessionStart, 'end' => $request->sessionEnd, 'productId' => $request->product];
            }
        }

        $elements = explode(',', $request->sportId);

        foreach($elements as $el) {
            $sports[] = ['sportId' => $el];
        }

        $datas = [
            'child'       => $request->childId,
            'address'     => $request->address,
            'freeAddress' => $request->freeAddress,
            'freePostal'  => $request->freePostal,
            'freeTown'    => $request->freeTown,
            'product'     => $request->product,
            'status'      => $request->status,
            'payed'       => $request->payed,
            'location'    => $request->locationId,
            'sessions'    => $sessions,
            'sports'      => $sports,
            'pickupDatePaiement' => $request->pickupDatePaiement

        ];


        foreach($sessions as $productId => $sessionAll) {


            if($type == "ALacarte") {
                unset($datas['sessions']);
                $datas['product'] = $sessionAll['productId'];
                unset($sessionAll['productId']);
                $datas['sessions'][] = $sessionAll;
            } else {
                $datas['product'] = $productId;
                $datas['sessions'] = $sessionAll;
            }


            $responses[] = $this->cURL(API.'registration/create', 'AJAX_CALL', $datas, 'POST');
        }


        // passser responses en session
      //  $_SESSION['responses'] = $responses;

        $url = 'registration/add/message/1/id/'.$request->childId.'/';
        $this->redirect($url);
    }

    public function viewList($request) 
    {

        $this->renderWithData('render/registration/list', $this->cURL(API.'registration/list/without-cart?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET'));
    }

    public function pickupsList($request) {
        $params['registrations'] = $this->cURL(API.'pickup/list-by-registration/'.$request->registrationId, 'PHP_CALL', '', 'GET');

        dd($params['registrations'] );
    }

    public function awaitingPayment($request) {
        $params = [];
        $result =  $this->cURL(API.'registration/awaiting-payment', 'PHP_CALL', [], 'GET');
       // echo 'resultssss<br/>';


        $params['registrations'] = $result->registrations;
        $params['childList']     = $result->childList;

        //dd($params['registrations']);
        return $this->renderWithData('render/registration/awaiting-payment', $params);

    }


}