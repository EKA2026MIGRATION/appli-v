<?php
use_helper('dates');
/**
 * Class CronController
 *
 */

require('php-library/twilio-php-master/Twilio/autoload.php');
use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;

class CronController extends Controller
{

  public function Authenticate()
  {
      $requestAuth["username"] = API_ADMIN_USERNAME;
      $requestAuth["password"] = API_ADMIN_PASSWORD;
      $params = $this->cURL(API.'user/api/authenticate', 'AJAX_CALL', $requestAuth, 'POST');

      return $params->token;
  }

  public function updatePresenceLastDayOfWeek() {
    $jwtToken = $this->Authenticate();

    if(strlen($jwtToken) > 3)
    {
       if($message = $this->cURLWithToken(API.'child/presence/update/last-day-of-week', 'PHP_CALL', '', 'POST', $jwtToken)) {
          echo json_encode(["message" => $message]);
       } else {
          echo json_encode(["message" => 'pb sur la mise à jour du dernier jour de la semaine']);
       }
    }
  }

  public function importTwillioCalls() {
      $jwtToken = $this->Authenticate();
      $client = new Client(TWILIO_ID, TWILIO_TOKEN);
      $targetDate = date('Y-m-d', strtotime('-1 day'));
      $calls = $client->calls
          ->read(['startTime' => $targetDate]);
      $nb = 0; $no = 0;
      foreach($calls as $call) {

          if($call->direction != "outbound-dial") continue;

          $extracted_data = [
              'call_sid' => $call->sid,
              'number' => $call->fromFormatted,
              'time' => $call->startTime->format('H:i:s'),
              'date' => $call->startTime->format('Y-m-d'),
              'status' => $call->status,
              'direction' => $call->direction,
              'duration' => $call->duration
          ];
          $response = $this->cURL(API.'calltwilio/create', 'AJAX_CALL', $extracted_data, 'POST');
          $message = $response->message;
          ($message == "CallTwilio created") ? $nb++ : $no++;
      }

      dd($nb.' calls imported - '.$no.' calls already exist');

  }

  public function updateReminder() {

      // retrieve all reminders with status awaiting
      $jwtToken = $this->Authenticate();

      $reminders = $this->cURL(API . 'reminder/list/awaiting/', 'PHP_CALL', '', 'GET', $jwtToken);

      foreach($reminders as $reminder) {

          $criteria   = $reminder->criteria;
          $comparison = $reminder->criteriaComparison;
          $value      = $reminder->criteriaValue;
          $currentElement = null;

          if($criteria == "date") {
              $currentElement = date('Y-m-d');
          } elseif($criteria == "km") {
              $currentElement = $reminder->vehicle->mileage;
          }

          if ($currentElement !== null) {
              $change = false;

              switch ($comparison) {
                  case "=":
                      $change = ($currentElement == $value);
                      break;
                  case ">":
                      $change = ($currentElement > $value);
                      break;
                  case "<":
                      $change = ($currentElement < $value);
                      break;
              }

              if ($change) {
                  $update = $this->cURL(API . 'reminder/nextStatus/' . $reminder->id, 'PHP_CALL', '', 'GET', $jwtToken);
              }
          }
      }
  }

  public function consolidationInvoice($request = null) {

    $jwtToken = $this->Authenticate();

    if(strlen($jwtToken) > 3) {
      // Si un ID est fourni, on l'ajoute à l'URL
      $url = API.'invoice/consolidation';
      if(isset($request->id) && !empty($request->id)) {
        error_log('CONSOLIDATION DEBUG - Invoice ID provided: ' . $request->id);
        $url .= '/'.$request->id;
      } else {
        error_log('CONSOLIDATION DEBUG - No invoice ID provided, running global consolidation');
      }
      error_log('CONSOLIDATION DEBUG - Calling URL: ' . $url);

      $message = $this->cURLWithToken($url, 'PHP_CALL', '', 'POST', $jwtToken);
    } else {
      $message = 'Erreur de connexion à l\'api';
    }

    $time = date('Y-m-d H:i:s');

    echo json_encode(["message" => $message]);

    $mailerService = new MailerService();
    $mailerService->setAdd('sandyrazafitrimo@gmail.com');
    $mailerService->setMessage(json_encode($message));
    $mailerService->setTitle("Energy Kids Academy - CRON CONSOLIDATION INVOICE ".$time);
    $mailerService->sendMail();

  }

  /**
   * Send email to parent child who add media yesterday
   * Cron every day at 7:
   */
  public function mediaAdded() {


      // retrieve child who add media yesterday
      $jwtToken = $this->Authenticate();

      $date = date('Y-m-d');
      $childs = $this->cURLWithToken(API.'child/media/added/'.$date, 'PHP_CALL', '', 'GET', $jwtToken);

      $listemail = [];

      if(empty($childs)) {
          echo "Aucun enfant n\'a ajouté de média hier";
          return;
      }

      foreach($childs as $child) {

            $childId = $child->childId;
            $childFirstname = $child->firstname;
            $childLastname = $child->lastname;

            foreach($child->persons as $person) {
                if($person->email != null) {
                    $childEmail = $person->email;

                    if(in_array($childEmail, $listemail)) {
                        continue;
                    }

                    $listemail[] = $childEmail;

                    $url = "https://energykidsacademy.fr/assets/img/energy-kids-academy.svg";
                    $params['child'] = ['firstname' => $childFirstname, 'parent' => 'Mme/M. '.$person->lastname, 'img' => $this->convertSvgToBase64($url)];

                    $message = $this->getRenderTemplate('render/sendMail/mediaAdded', $params);

                    $mailerService = new MailerService();
                    $mailerService->setAdd($childEmail);
                    $mailerService->setMessage($message);
                    $mailerService->setTitle("Energy Kids Academy - de nouvelle(s) photo(s) de votre enfant");
                    $mailerService->setTemplateEmail(true);
                    $mailerService->sendMail();
                }
            }
      }
  }



  public function informTaskStaff($request)
  {
    $jwtToken = $this->Authenticate();

    if(strlen($jwtToken) > 3)
    {
        $today = date('Y-m-d');
        $tomorrow = nextDay($today);


        // task todo date_limit < today (TASK LATE)
        if($tasksLateData = $this->cURLWithToken(API.'task/staff/late/limit/TODO/'.$today, 'PHP_CALL', '', 'GET', $jwtToken)) {

              foreach($tasksLateData as $task) {

                  $dateTask = explode('.', $task->dateTask->date);
                  $dateLimit = explode('.', $task->dateLimit->date);

                  $taskArray = [
                                  'name' => $task->name,
                                  'description' => $task->description,
                                  'dateTask' => showDate($dateTask[0], 'd/m/Y H:i'),
                                  'dateLimit' => showDate($dateLimit[0])
                                ];
                  $taskLates[$task->staff->staffId.'|'.$task->staff->person->email.'|'.$task->staff->person->firstname][$task->id] = $taskArray;
              }
        } else {
          $taskLates = [];
        }

          // task TO DO LIMIT TORROW

        if($tasksLimitData = $this->cURLWithToken(API.'task/staff/late/limit/TODO/'.$tomorrow.'/'.$tomorrow, 'PHP_CALL', '', 'GET', $jwtToken)) {

              foreach($tasksLimitData as $task) {

                  $dateTask = explode('.', $task->dateTask->date);
                  $dateLimit = explode('.', $task->dateLimit->date);

                  $taskLimitArray = [
                                  'name' => $task->name,
                                  'description' => $task->description,
                                  'dateTask' => showDate($dateTask[0], 'd/m/Y H:i'),
                                  'dateLimit' => showDate($dateLimit[0])
                                ];
                  $taskLimits[$task->staff->staffId.'|'.$task->staff->person->email.'|'.$task->staff->person->firstname][$task->id] = $taskLimitArray;
              }
        } else {
          $taskLimits = [];
        }


        // task TO_DO tomorrow
        if($taskTodosData = $this->cURLWithToken(API.'task/staff/list/step/TODO/0/'.$tomorrow.'/'.$tomorrow, 'PHP_CALL', '', 'GET', $jwtToken)) {

              foreach($taskTodosData as $task) {

                  $dateTask = explode('.', $task->dateTask->date);
                  $dateLimit = explode('.', $task->dateLimit->date);

                  $taskTodosArray = [
                                  'name' => $task->name,
                                  'description' => $task->description,
                                  'dateTask' => showDate($dateTask[0], 'd/m/Y H:i'),
                                  'dateLimit' => showDate($dateLimit[0])
                                ];
                  $taskTodos[$task->staff->staffId.'|'.$task->staff->person->email.'|'.$task->staff->person->firstname][$task->id] = $taskTodosArray;
              }
        } else {
          $taskTodos = [];
        }

        $tasks = [];
        foreach($taskLates as $user => $task) { $tasks[$user]['En retard'] = $task;}
        foreach($taskLimits as $user => $task) { $tasks[$user]['Date limite demain'] = $task;}
        foreach($taskTodos as $user => $task) { $tasks[$user]['A faire demain'] = $task;}

        // send all emails

        foreach($tasks as $user => $tasks) {

            $elements = explode('|', $user);

            $name = $elements[2];
            $email = $elements[1];
            $params['user']  = ['name' => $name, 'email' => $email];
            $params['tasks'] = $tasks;

            $message = $this->getRenderTemplate('render/sendMail/notificationTasks', $params);

            $mailerService = new MailerService();
            $mailerService->setAdd($email);
            $mailerService->setMessage($message);
            $mailerService->setTitle("Energy Kids Academy - Tâches pour le ".showDate($tomorrow));
          //  $mailerService->sendMail();

/****
 * 
 *  ENVOIE DES EMAILS DE TACHES DESACTIVES
 * 
 * 
 */



        }

        echo json_encode(["message" => 'email Tache Notification envoyés']);

        //$params['number'] = $this->cURLWithToken(API.'standard/tel/display', 'PHP_CALL', '', 'GET', $jwtToken);
    } else {
      echo json_encode(["message" => 'Erreur de connexion à l\'api']);
    }

  }

    public function convertSvgToBase64($imageUrl) {
        $imageContent = file_get_contents($imageUrl);

        if ($imageContent !== false) {
            // Convertir le contenu de l'image en base64
            $base64Image = base64_encode($imageContent);

            if ($base64Image !== false) {
                // Retourner la chaîne base64 de l'image
                return $base64Image;
            } else {
                return 'Erreur lors de la conversion en base64.';
            }
        } else {
            return 'Erreur lors de la lecture de l\'image SVG depuis l\'URL.';
        }
    }

}
