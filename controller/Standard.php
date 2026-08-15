<?php
require_once(HELPER.'dates.php');
require('php-library/twilio-php-master/Twilio/autoload.php');
use Twilio\TwiML\VoiceResponse;
use Twilio\Rest\Client;

class Standard extends Controller
{

    public function Authenticate()
    {
        $requestAuth["username"] = API_ADMIN_USERNAME;
        $requestAuth["password"] = API_ADMIN_PASSWORD;
        $params = $this->cURL(API.'user/api/authenticate', 'AJAX_CALL', $requestAuth, 'POST');
        return $params->token;
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

    public function all($request) {

        // if $from and $to doesn't not exist
        if(!isset($request->from) && !isset($request->to))
        {
            $today = date('Y-m-d');
            $params['to'] = nextDay($today, 1);
            $params['from'] =  getStartMonth($params['to']);
        }
        else
        {
            $params['from'] = $request->from;
            $params['to'] = $request->to;
        }
        $params['calls'] = $this->cURL(API.'calltwilio/retrieve/all/'.$params['from'].'/'.$params['to'], 'PHP_CALL', '' , 'GET');

        $this->renderWithData('render/standard/all', $params );
    }

    public function viewCallTwilio($request) {


        $params = [];
        if(!isset($request->dateStart))
        {
            $today = date('Y-m-d');
            $params['dateEnd'] = nextDay($today, 1);
            $params['dateStart'] =  getStartMonth($params['dateEnd']);
        }
        else
        {
            $params['dateStart'] = $request->dateStart;
            $params['dateEnd'] = $request->dateEnd;
        }

        $params['call_twilios'] = $this->cURL(API.'call/twilio/list/'.$params['dateStart'].'/'.$params['dateEnd'].' 23:59:59', 'PHP_CALL', '' , 'GET');

        dd($params['call_twilios']);

        $this->renderWithData('render/ticket/calls', $params );

    }

    /**
     * Import a csv file with Twilio calls
     * Persist in API
     *
     * @param $request
     * @return void
     */
    public function importCsvTwilioCalls($request) {
        $file = ROOT.'uploads/standard/twilio_calls.csv';

        $nb = 0; $no = 0;

        if (($handle = fopen($file, "r")) !== FALSE) {

            $header = fgetcsv($handle, 1000, ",");

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $row = array_combine($header, $data);

                if($row['Direction'] == "Incoming") continue;

                $extracted_data = [
                    'call_sid' => $row['Call Sid'],
                    'number' => $row['From'],
                    'time' => explode(' ', $row['Start Time'])[0],
                    'date' => explode(' ', $row['Start Time'])[2],
                    'status' => $row['Status'],
                    'direction' => $row['Direction'],
                    'duration' => $row['Duration']
                ];

                // envoie des dannées vers l'api
                $response = $this->cURL(API.'calltwilio/create', 'AJAX_CALL', $extracted_data, 'POST');

                $message = $response->message;

                ($message == "CallTwilio created") ? $nb++ : $no++;
            }
            fclose($handle);

            dd($nb.' calls imported - '.$no.' calls already exist');

        }
    }



    public function extractTwilioCalls($request) {
        $client = new Client(TWILIO_ID, TWILIO_TOKEN);

        $calls = $client->calls->read([
                "startTime" => new \DateTime('2023-08-29T00:00:00Z'),
                "status" => "completed"
            ]
        );
        $i = 0;
        $lastNumber = '';
        $jwtToken = $this->Authenticate();


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

        dd($callLog);

    }



}
