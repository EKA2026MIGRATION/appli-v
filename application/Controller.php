<?php

/**
 * Class Controller
 *
 * to organize all controller and create the view
 */
class Controller
{

    private $view;
    private $originalRequest;

    public function __construct($request = null)
    {

        $this->view = new View();

        if($request) {
            $this->setOriginalRequest($request);
            $this->view->setOriginalRequest($request);
        }


        if(isset($_SESSION['IDENTIFIER']))
        {
            $personConnected = $this->cURL(API.'person/display/'.$_SESSION['IDENTIFIER'], 'PHP_CALL', '', 'GET');
            $_SESSION['PERSON_CONNECTED'] = $personConnected;
        }
    }

    public function setOriginalRequest($request) {
      $this->originalRequest = $request;
    }

    public function getOriginalRequest()
    {
        return $this->originalRequest;
    }

    public function render($template)
    {
        $myView = $this->view;
        $myView->setTemplate($template);
        $myView->render('');
    }

    public function renderWithData($template, $data)
    {
        $myView = $this->view;
        $myView->setTemplate($template);
        $data = (object) $data;
        $myView->render($data);
    }

    public function getRenderTemplate($template, $data) {
        $myView = $this->view;
        $myView->setTemplate($template);
        $data = (object) $data;
        return $myView->getRenderTemplate($data);
    }

    public function renderHtml($template, $data = null)
    {
        $myView = $this->view;
        $myView->setTemplate($template);
        $data = (object) $data;
        $myView->renderWithoutTemplate($data);
    }

    public function redirect($route)
    {
      $this->view->redirect($route);
    }

    public function renderJson($data) {
        echo json_encode($data);
    }

    public function renderExcel($html, $name) {
        header('Content-Encoding: UTF-8');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-Disposition: attachment; filename=".$name.".xls");
        echo chr(239) . chr(187) . chr(191)   ;     
        echo $html;
    }

    public function cURL($url, $type, $data, $method)
    {

        $headers = array();
        if(isset($data['token']))
        {
            $headers[] = "Authorization: Bearer ".$data['token'];
        }
        elseif(TOKEN != '')
        {
            $headers[] = "Authorization: Bearer ".TOKEN;
        }

        if($data != '')
        {
            $data_string = json_encode($data);

            if($url == API."vehicle/checkup/valid")
            {
                $data_string = str_replace("\\", '', $data_string);
            }


            $headers[] = "Content-Type: application/json";
            $headers[] = "Content-Length: ".strlen($data_string);
        }

        $state_ch = curl_init();
        curl_setopt($state_ch, CURLOPT_URL, $url);
        curl_setopt($state_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($state_ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($state_ch, CURLOPT_CUSTOMREQUEST, $method);

        if($data != '')
        {
            curl_setopt($state_ch, CURLOPT_POSTFIELDS, $data_string);
        }

        curl_setopt($state_ch, CURLOPT_HTTPHEADER, $headers);
        $state_result = curl_exec ($state_ch);
        $data = json_decode($state_result);
        if(isset($data->error) && $type == "PHP_CALL")
        {

        }
        elseif(isset($data->error) && $type == "AJAX_CALL")
        {

        }
        //print_r($data);
        return $data;

    }
    public function cURLWithToken($url, $type, $data, $method, $token)
    {

        $headers = array();
        $headers[] = "Authorization: Bearer ".$token;



        if($data != '')
        {
        $data_string = json_encode($data);
        $headers[] = "Content-Type: application/json";
        $headers[] = "Content-Length: ".strlen($data_string);
        }


        $state_ch = curl_init();
        curl_setopt($state_ch, CURLOPT_URL, $url);
        curl_setopt($state_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($state_ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($state_ch, CURLOPT_CUSTOMREQUEST, $method);

        if($data != '')
        {
            curl_setopt($state_ch, CURLOPT_POSTFIELDS, $data_string);
        }

        curl_setopt($state_ch, CURLOPT_HTTPHEADER, $headers);
        $state_result = curl_exec ($state_ch);
        $data = json_decode($state_result);
        if(isset($data->error) && $type == "PHP_CALL")
        {

        }
        elseif(isset($data->error) && $type == "AJAX_CALL")
        {

        }
        //print_r($data);
        return $data;

    }

}
