<?php
require_once(HELPER.'dates.php');
require('php-library/twilio-php-master/Twilio/autoload.php');
use Twilio\TwiML\VoiceResponse;
use Twilio\Rest\Client;

class Ticket extends Controller
{

    public function Authenticate()
    {
        $requestAuth["username"] = API_ADMIN_USERNAME;
        $requestAuth["password"] = API_ADMIN_PASSWORD;
        $params = $this->cURL(API.'user/api/authenticate', 'AJAX_CALL', $requestAuth, 'POST');
        return $params->token;
    }

    public function stats($request) {

      $params = array();
      $params['categories'] = $this->cURL(API.'category/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET'); 
      $params['location'] = $this->cURL(API.'location/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET'); 
      $this->renderWithData('render/ticket/stats', $params);
    }

    public function viewDisplay($request)
    {
        if(isset($request->id))
        {
            $params = [];
            $params['ticket'] = $this->cURL(API.'ticket/display/'.$request->id, 'PHP_CALL', '' , 'GET');
            $this->renderWithData('render/ticket/display', $params);
        }
        else
        {
            header('location: '.HOST.'ticket/list');
        }
    }

    public function viewRdv($request)
    {
        if(!isset($request->date))
        {
            $date = date('Y-m');
        }
        else
        {
            $date = $request->date;
        }

        $params = array();
        $params['date'] = $date;
        $params['rdv'] = $this->cURL(API.'rdv/list/'.$date, 'PHP_CALL', '' , 'GET');
        $this->renderWithData('render/ticket/rdv', $params);
    }

    public function viewCalls($request) {

        $params = array();
        $nb = 100;
        $jwtToken = $this->Authenticate();
        $lastNumber = '';
        $client = new Client(TWILIO_ID, TWILIO_TOKEN);
        $calls = $client->calls
            ->read(array(), $nb);
        $i = 0;

        foreach ($calls as $call ) {
            if ($lastNumber != $call->from) {
                if (!isset($request->all)) {
                    $fromPerson = $this->cURLWithToken(API . 'person/from/' . $call->from, 'PHP_CALL', '', 'GET', $jwtToken);

                    if (isset($fromPerson->error)) {
                        $callLog[$i]['fromPerson'] = '';
                    } else {
                        $callLog[$i]['fromPerson'] = $fromPerson[0][0];
                    }
                }
                $callLog[$i]['number'] = $call->from;
                $date = $call->dateCreated;
                $callLog[$i]['date_req'] = $date;
                $date->add(new DateInterval('PT60M'));
                $callLog[$i]['full_date'] = $date->format('d/m/Y H:i:s');
                $callLog[$i]['time'] = $date->format('H:i');
                $callLog[$i]['date'] = $date->format('Y-m-d');
                $callLog[$i]['date_fr'] = $date->format('d/m/Y');
                $callLog[$i]['direction'] = $call->direction;
                $callLog[$i]['duration'] = $call->duration;
            }
            $lastNumber = $call->from;
            $i++;
        }
        $params['calls'] = $callLog;

        $this->renderWithData('render/ticket/calls', $params );

    }


    public function list($request) {

      if(isset($request->all))
      {
        $nb = 100;
      }
      else
      {
        $nb = 60;
      }

      $client = new Client(TWILIO_ID, TWILIO_TOKEN);
      $calls = $client->calls
                      ->read(array(), $nb);

      //$i = 0;
      foreach ($calls as $call ) {
          if($call->to != "+33644641085") {

              $date = $call->dateCreated;
              $key = $call->from.$date->format('YmdHis');
              $callLog[$key]['number'] = $call->from;
              $callLog[$key]['date_req'] = $date;
              $callLog[$key]['date'] = $date->format('d/m/Y H:i:s');
              $callLog[$key]['to'] = $call->to;
              $callLog[$key]['duration'] = $call->duration;
          }
      }


      $params = array();
      $params['tickets'] = $this->cURL(API.'ticket/list', 'PHP_CALL', '', 'GET');
      $params['rdv'] = $this->cURL(API.'rdv/list', 'PHP_CALL', '', 'GET');

      foreach($params['tickets'] as $key => $ticket )
      {
          $keyCall = $ticket->tel.str_replace(array(' ', '-', ':'), '', $ticket->dateCall);
          $params['tickets'][$key]->keyCall = $keyCall;
          if(isset($callLog[$keyCall])) {
              $receivedBy = $callLog[$keyCall]['to'];
              $callDuration = $callLog[$keyCall]['duration'];
          } else {
              $receivedBy = null;
              $callDuration = null;
          }
          $params['tickets'][$key]->receivedBy = $receivedBy;
          $params['tickets'][$key]->duration = $callDuration;
      }
      $this->renderWithData('render/ticket/list', $params);
    }


}
