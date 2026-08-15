<?php
/**
 * Class SpotHit
 */

class SmsFactor extends Controller
{

    private $token;

    private $isUnicode;

    private $sender;

    public function __construct()
    {
        $this->token = SMS_FACTOR_TOKEN;
        $this->sender = "ENERGYKIDS";
    }

    private function send($content, $numbers = [], $sender = null) {
        $recipients = array();
        foreach ($numbers as $n) {
            $recipients[] = array('value' => $n);
        }
        
        if($sender) {
            $message = ['text' => $content, 'sender' => $sender, 'pushtype' => 'marketing', 'unicode' => $this->isUnicode]; //change unicode to 1 for special characters
        } else {
            $message = ['text' => $content,  'pushtype' => 'marketing'];
        }

        $postdata = array(
            'sms' => [
                'message' => $message,
                'recipients' => ['gsm' => $recipients],
            ]
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.smsfactor.com/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // gsm_id
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Bearer ' . $this->token));
        //if($_SERVER['REMOTE_ADDR'] == "127.0.0.1") {
        //    $response = "SMS envoyé virtuellement via SMS FACTOR";
        //} else {
            $response = curl_exec($ch);
        //}
        curl_close($ch);

        echo $response;
    }


    public function sendSMS($request) 
    {
        $content = $request->message;
        $number = $request->number;
        $signature = $request->signature;
        $isUnicode = $request->isUnicode;
        $this->isUnicode = $isUnicode;
        $numbers = array($number);
        $this->send($content."\r\n".$signature, $numbers, $this->sender);
    }

    /**
     * add url to MO event 
     */
    public function addMO($request) 
    {
           
        $postdata = array(
            'webhook' => array(
                'type' => 'MO',
                'url' => 'http://appli-v.net/public/smsFactor-webhookUpdateResponse'
            )
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.smsfactor.com/webhook");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Bearer ' . $this->token));
        $response = curl_exec($ch);
        curl_close($ch);
        dd($response);
    }

    /***
     * list all webhook
     * 
     */
    public function webhook($request) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.smsfactor.com/webhook");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Bearer ' . $this->token));
        $response = curl_exec($ch);
        curl_close($ch);

        dd($response);
    }

    public function deleteWebhook($request) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.smsfactor.com/webhook/".$request->id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Bearer ' . $this->token));
        $response = curl_exec($ch);
        curl_close($ch);

        dd($response);
    }

}