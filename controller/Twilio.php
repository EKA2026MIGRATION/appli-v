<?php

/**
 * Class Twilio
 *
 */
require('php-library/twilio-php-master/Twilio/autoload.php');
use Twilio\TwiML\VoiceResponse;
use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;
$dateTimeZoneParis = new DateTimeZone("Europe/Paris");

class Twilio extends Controller
{

  public function Authenticate()
  {
      $requestAuth["username"] = API_ADMIN_USERNAME;
      $requestAuth["password"] = API_ADMIN_PASSWORD;
      $params = $this->cURL(API.'user/api/authenticate', 'AJAX_CALL', $requestAuth, 'POST');

      return $params->token;

  }


  public function sendSMS($request)
  {

    if($_SERVER['SERVER_ADDR'] == "127.0.0.1") {
      echo json_encode(["message" => 'SMS envoyé VIRTUELLEMENT - personne ne le recoit']);
    } else {
      $client = new Client(TWILIO_ID, TWILIO_TOKEN);

      // Use the client to do fun stuff like send text messages!
      $client->messages->create(
          // the number you'd like to send the message to
          $request->phone,
          array(
              // A Twilio phone number you purchased at twilio.com/console
              'from' => '+33644641085',
              // the body of the text message you'd like to send
              'body' => $request->content
          )
      );
      echo json_encode(["message" => 'SMS envoyé']);
    }
  }



  public function ForwardSms($request)
  {

    if(isset($request->From))
    {

      $client = new Client(TWILIO_ID, TWILIO_TOKEN);
      $messages = $client->messages
      ->read(array(), 50);

      foreach ($messages as $message ) {

        if($message->to == $request->From)
        {
          $body = $message->body;     
          break;
        }

      }

      $jwtToken = $this->Authenticate();

      if(strlen($jwtToken) > 3)
      {
        $params['number'] = $this->cURLWithToken(API.'standard/tel/display', 'PHP_CALL', '', 'GET', $jwtToken);
      }

      $phoneRegex = '';
      preg_match_all("/\+?(?:\d[-. ()]*){9,12}/", $body, $phoneRegex);

      if($phoneRegex != '')
      {
        $phoneForward = $phoneRegex[0][0];
      }
      else
      {
        $phoneForward = $params['number'];
        $phoneForward = str_replace('+33', '0', $phoneForward);
      }

      $message = "Message reçu sur le numéro Twilio de la part du : ".$request->From.""."\r\n\r\n"."Message : ".$request->Body;
      $client->messages->create(
        $phoneForward,
        array(
          'from' => '+33644641085',
          'body' => $message
        )
      );

    }

  }




  public function ForwardCall($request)
  {

    $jwtToken = $this->Authenticate();

    if(strlen($jwtToken) > 3)
    {

      $params['number'] = $this->cURLWithToken(API.'standard/tel/display', 'PHP_CALL', '', 'GET', $jwtToken);

      $response = new VoiceResponse();
      $response->dial($params['number']);
      echo $response;

    }
  }

  public function CallLog($request)
  {

    if(isset($request->all))
    {
      $nb = 100;
    }
    else
    {
      $jwtToken = $this->Authenticate();
      $nb = 9;
    }
    $lastNumber = '';
    $client = new Client(TWILIO_ID, TWILIO_TOKEN);
    $calls = $client->calls
                    ->read(array(), $nb);


    $i = 0;
    foreach ($calls as $call ) {
      if($lastNumber != $call->from)
      {
        if(!isset($request->all)) {
          $fromPerson = $this->cURLWithToken(API.'person/from/'.$call->from, 'PHP_CALL', '', 'GET', $jwtToken);

          if(isset($fromPerson->error)) {
            $callLog[$i]['fromPerson'] = 'Aucune personne associée';
          } else {
            $callLog[$i]['fromPerson'] = $fromPerson[0][0];
          }

        }
        $callLog[$i]['number'] = $call->from;
        $date = $call->dateCreated;
        $callLog[$i]['date_req'] = $date;
        $date->add(new DateInterval('PT60M'));
        $callLog[$i]['date'] = $date->format('d/m/Y H:i:s');
      }
      $lastNumber = $call->from;
      $i++;

    }

    echo json_encode(["callLog" => $callLog]);

  }

  public function CallLogDate($request)
  {
    $nb = 750;
    $client = new Client(TWILIO_ID, TWILIO_TOKEN);
    $calls = $client->calls
                    ->read(array(), $nb);

    $i = 0;
    $lastDate = '';
    $lastNumber =  '';
    foreach ($calls as $call ) {
        $date = $call->dateCreated;
        $date->add(new DateInterval('PT60M'));

      $dateArray = $date->format('d/m/Y');

      if($lastDate != $dateArray)
      {
        $i = 0;
      }
      if($lastNumber != $call->from)
      {
        $callLog[$dateArray][$i]['number'] = $call->from;
        $callLog[$dateArray][$i]['date_req'] = $date;
        $callLog[$dateArray][$i]['date'] = $date->format('d/m/Y H:i:s');
        $callLog[$dateArray][$i]['hour'] = $date->format('H:i:s');

        $nb = count((array) $callLog[$dateArray]);

        $callLog[$dateArray]['nb'] = $nb;

      }

      $lastDate = $dateArray;
      $lastNumber = $call->from;
      $i++;

    }


    echo json_encode(["callLog" => $callLog]);

  }



}
