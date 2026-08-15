<?php

/**
 * Class Notification.
 */
class Notification extends Controller
{
    public function sendPush($request)
    {

        return true;

        $url = 'https://fcm.googleapis.com/fcm/send';

        $notification = array('text' => $request->message);

        $arrayToSend = array('to' => $request->deviceId, 'notification' => $notification, 'priority' => 'high');

        $fields = json_encode($arrayToSend);

        $headers = array(
      'Authorization: key='.FIREBASE_KEY,
      'Content-Type: application/json',
      );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);

        curl_close($ch);

    }

    public function sendMail($request)
    {
        $mailerService = new MailerService();
        $mailerService->setAdd($request->email);
        $mailerService->setTitle($request->subject);
        $mailerService->setMessage($request->message);
        $mailerService->setTemplateEmail(true);
        $mailerService->sendMail();

        echo json_encode(['success' => true]);
    }

    public function createVcf($request)
    {

        // create this 3 array
        $arrayAddr = []; $arrAddrIdList = [];
        $arrayTel = []; $arrayTelIdList = [];
        $arrayEmail = [];

        if ($request->type == 'child') {
            $object = $this->cURL(API.'child/display/'.$request->id, 'PHP_CALL', '', 'GET');

            $persons = $object->persons;
            foreach ($persons as $person) {
                $arrayAddr = $this->createAddrIdList($person);
                $arrayTel = $this->createTelIdList($person);
                if(!in_array($person->email, $arrayEmail)) $arrayEmail[] = $person->email;
                $filename = $object->childId;
            }

        }

        if($request->type == "person") {
            $object = $this->cURL(API.'person/display/'.$request->id, 'PHP_CALL', '', 'GET');
            $arrayAddr = $this->createAddrIdList($object);
            $arrayTel = $this->createTelIdList($object);
            $arrayEmail[] = $object->email;
            $filename = $object->personId;
        }


        $vcard = new VCard();
        $vcard->setFilename($filename);
        $vcard->setFirstname($object->firstname);
        $vcard->setLastname($object->lastname);

        foreach ($arrayEmail as $email) {
            $vcard->addEmail($email);
        }

        foreach ($arrayTel as $tels) {
            $vcard->addPhone($tels['tel'], $tels['name']);
        }

        foreach ($arrayAddr as $adds) {
            $vcard->addAddress($adds['name'], null, $adds['street'], $adds['city'], null, $adds['zip'], $adds['country']);
        }

        $vcard->download();
    }

    public function createTelIdList($person) {
        $arrayTelIdList = [];
        foreach ($person->phones as $phone) {
            $currentTelId = $phone->phone;
            if (!in_array($currentTelId, $arrayTelIdList)) {
                $arrayTel[] = ['tel' => $phone->phone, 'name' => $phone->name];
            }
            $arrayTelIdList[] = $currentTelId;
        }

        return $arrayTel;
    }


    public function createAddrIdList($person) {
        $arrAddrIdList = [];
        foreach ($person->addresses as $address) {
            $currentAddrId = $address->address;
            if(!in_array($currentAddrId, $arrAddrIdList)){
                $arrayAddr[] = ['street' => $address->address,
                    'name' => $address->name,
                    'zip' => $address->postal,
                    'city' => $address->town,
                    'country' => $address->country,
                ];
                $arrAddrIdList[] = $currentAddrId;
            }
        }
        return $arrayAddr;
    }

    public function notificationList($request) {

        $params['notifications'] = $this->cURL(API.'notification/byPersonId/'.$request->personId, 'PHP_CALL', '', 'GET');
        $params['person_id'] = $request->personId;
        $this->renderHtml('render/notification/_list', $params);

    }


    public function removePerson($request) {

        $this->cURL(API.'notification/removePerson/'.$request->notificationId.'/'.$request->personId, 'PHP_CALL', '', 'DELETE');
        $params = [];
        $this->renderHtml('render/notification/_delete', $params);

    }

    public function notificationAll($request) {

        $this->cURL(API.'notification/deleteAllByPersonId/'.$request->personId, 'PHP_CALL', '', 'DELETE');
        $params = [];
        $this->renderHtml('render/notification/_delete', $params);

    }



}


