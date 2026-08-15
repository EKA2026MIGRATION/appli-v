<?php
require_once(HELPER.'userSession.php');
require_once(HELPER.'dates.php');
require_once(HELPER.'age.php');
require_once(HELPER.'photo.php');
require_once(HELPER.'buttons.php');
require_once(HELPER.'pickupStatus.php');

class Dashboard extends Controller
{

    private $groupAge = ['A' => '3-6 ans','B' => '7 - 10 ans', 'C' => '10 - 13 ans', 'D' => '+ de 13 ans'];

    public function previsionnel($request) {
        $params = [];

        if (!isset($request->date)) {
            $date = date('Y-m-d');
            $month = date('Y-m');
        } else {
            $date = $request->date;
            $m = explode('-', $request->date);
            $month = $m[0].'-'.$m[1];
        }

        $params['date'] = $date;

        $params['buttons'] = array(
          array('href' => HOST.'dashboard/previsionnel/print/1/date/'.$date.'/', 'onclick' => null, 'label' => 'Imprimer', 'icon' => 'print', 'attributes' => ['target' => '_blank']),
        );


        $presences = $this->cURL(API.'child/presence/list/'.$date, 'PHP_CALL', '', 'GET');
        $arr = null; $totalChild = [];
        foreach($presences as $presence) {
            if($presence->age < 7) $groupeAge = 'A';
            if($presence->age >= 7 && $presence->age < 10) $groupeAge = 'B';
            if($presence->age >= 10 && $presence->age < 13) $groupeAge = 'C';
            if($presence->age >= 13) $groupeAge = 'D';
            $arr[$presence->nbSport][$presence->sports][$groupeAge][showMoment($presence->start, $presence->end)][$presence->age.$presence->lastname.$presence->firstname] = $presence; 
            
            $totalChild[$presence->childId] = $presence->childId;        
        }
        if($arr) ksort($arr);
        $params['presences'] = $arr;
        $params['groupAgeName'] = $this->groupAge;
        $params['totalChild'] = count((array) $totalChild);

        $staff_presence = $this->cURL(API.'staff/presence/list/all/'.$date, 'PHP_CALL', '', 'GET');

        foreach($staff_presence as $staffPresence) {

            if($staffPresence->staff->staffId == "71") continue;
            $roles = $staffPresence->staff->person->roles;

            foreach($roles as $role) {

                if($role == "ROLE_USER") continue;
                if($role == "ROLE_ADMIN") $currentRole = "SUPERVISEUR";
                if($role == "ROLE_COACH") $currentRole = "COACH";
                if($role == "ROLE_DRIVER") $currentRole = "DRIVER";
                if($role == "ROLE_MANAGER") $currentRole = "MANAGER";



                if(isset($staffPresence->staff->vehicle)) {
                    $places = $staffPresence->staff->vehicle->places;
                } else {
                    $places = 0;
                }


                $datas[$currentRole][] = [
                                            'name' => $staffPresence->staff->fullname,
                                            'maxChild' => $staffPresence->staff->maxChildren,
                                            'capacityDriver' => $places
                ];
            }

        }
        
        $params['staff_presence'] = $datas;


        if(isset($request->print)) {
            $this->renderHtml('render/dashboard/previsionnelPrint', $params);
        } else {
            $this->renderWithData('render/dashboard/previsionnel', $params);
        }

    }

    

}
