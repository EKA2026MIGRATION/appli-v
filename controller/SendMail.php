<?php


/**
 * Send Mail Controller
 */
class SendMail extends Controller
{
    public function uberRide($request)
    {

        $mailerService = new MailerService();

        $params = [];
        
        $emailString  = $request->emails;
        $addresString = $request->content;
        $dateDay = $request->dateDay;

        $addresss = explode('|', $addresString);

        $addressArray = [];
        foreach($addresss as $address) {
            $addressArray[] = $address;
        }

        $params['addressArray'] = $addressArray;
        $params['transport'] = $request->title;

        $message = $this->getRenderTemplate('render/sendMail/uberRideEmailTemplate', $params);


        $emails = explode('|', $emailString);

        $params['emailList'] = $emails;

        $mailerService->setAdd(implode(',', $emails));
        $mailerService->setTitle("Transport Energy Kids Academy - ".$dateDay);
        $mailerService->setMessage($message);

       echo $mailerService->sendMail();


     
        /*
        foreach($emails as $email) {
            if($email != "") {
                $mailerService->setAdd($email);
                $mailerService->setMessage($message);
                $mailerService->setTitle("Transport Energy Kids Academy - ".$dateDay);
                $mailerService->sendMail();
                $infos[] = "message envoyé à ".$email.'<br.>';

            }
        }*/

      //  $params['info'] = $infos;
        $this->renderHtml('render/sendMail/uberRide', $params);

    }
}