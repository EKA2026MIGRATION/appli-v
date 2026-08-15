<?php


/**
 * Class Survey
 *
 */
class Survey extends Controller
{
    public function viewList($request)
    {
        $params = array();
        $params['surveys'] = $this->cURL(API . 'survey/list', 'PHP_CALL', '', 'GET');
        $path    = 'assets/image/icons';
        $files = scandir($path);
        $params['icons'] = $files;
        $this->renderWithData('render/survey/list', $params);
    }


    public function SendSurvey($request) {
      $message = '';
      $message .= '<p>Bonjour,</p>';
      $message .= "<p>Afin de vous apporter un service toujours meilleur, nous vous invitons à répondre à notre enquête de satisfaction pour la journée du <strong>".$request->date."</strong> concernant <strong>".$request->firstname."</strong>. Toutes vos remarques et suggestions nous seront utiles et cela vous prendra moins de 5 minutes.</p>";
      $message .= '<p><a href="'.$request->url.'" class="btn-2">Répondre au sondage</a></p>';
      $message .= '<p>Nous vous remercions pour votre participation</p>';
      $message .= "<p>L'équipe Energy Kids Academy</p>";
      $email = $request->email;
      $mailerService = new MailerService();
      $mailerService->setAdd($email);
      $mailerService->setMessage($message);
      $mailerService->setTitle("Nouveau sondage pour ".$request->firstname." - Energy Kids Academy");
      $mailerService->sendMail();
      echo json_encode(["success" => true]);
    }


    public function viewEdit($request)
    {
      $params = array();
  

      if (isset($request->id)) {
        $params['survey'] = $this->cURL(API . 'survey/display/'.$request->id, 'PHP_CALL', '', 'GET');
        $this->renderWithData('render/survey/edit', $params);
      } else {
        header('location: ' . HOST . 'survey/list');
      }
    }
  

    public function viewCreate($request)
    {
        $params = array();
        $path    = 'assets/image/icons';
        $files = scandir($path);
        $params['icons'] = $files;
        $this->renderWithData('render/survey/create', $params);
    }

}

