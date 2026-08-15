<?php
require_once(HELPER.'userSession.php');
require_once(HELPER.'dates.php');
require_once(HELPER.'age.php');
require_once(HELPER.'photo.php');
require_once(HELPER.'buttons.php');
require_once(HELPER.'pickupStatus.php');

class Activity extends Controller
{

    const FOOD_CATEGORIES = array(
        'starchy' => 'Féculents',
        'accompaniment' => 'Accompagnement',
        'condiment' => 'Condiment',
        'vegetables' => 'Légumes',
        'sandwich' => 'Sandwich'
    );

    private $groupAge = ['A' => '3-6 ans','B' => '7 - 10 ans', 'C' => '10 - 13 ans', 'D' => '+ de 13 ans'];


    // UTILISER ADD BASIC TASK DANS LE TASK CONTROLLER // addBasicTaskToStaff
    public function addTask($request) {

      $coach_id = $request->coachId;
      $task_id  = $request->taskId;
      $date = date('Y-m-d H:i:s');
      $date_request = date('Y-m-d');
      $remoteAddress = $_SERVER['REMOTE_ADDR'];

      $datas = array('name' => null, 'description' => null, 'step' => 'DONE', 'task_id' => $task_id, 'staff_id' => $coach_id, 'date_task' => $date, 'remote_address' => $remoteAddress);
      $response = $this->cURL(API.'task/staff/create', 'AJAX_CALL', $datas, 'POST');

      $params['tasksStaff']= $this->cURL(API.'task/staff/retrieve/'.$coach_id.'/'.$date_request, 'PHP_CALL', '', 'GET');

      $this->renderHtml('render/activity/_taskList', $params);

    }

    // UTILISE DELETE BASIC DANS LE TASK CONTROLLER // unnafectBasickTaskStaff
    public function deleteTask($request) {
        $taskStaffId  = $request->taskStaffId;
        $datas = array('taskStaffId' => $taskStaffId);
        $response = $this->cURL(API.'task/staff/delete', 'AJAX_CALL', $datas, 'DELETE');

        $coach_id = $request->coachId;
        $date_request = $request->dateTask;
        $params['tasksStaff']= $this->cURL(API.'task/staff/retrieve/'.$coach_id.'/'.$date_request, 'PHP_CALL', '', 'GET');

        $this->renderHtml('render/activity/_taskList', $params);
    }


    public function viewDisplay($request) {

        if(!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }

        if(isset($request->idCoach)) {
            $staffId = $request->idCoach;
        } else {
            $staffId = getCurrentStaffId();
        }

        $params = array();

        $params['callBack'] = 'activity/display';

        $params['date'] = $date;
        $params['groups'] = $this->cURL(API.'group-activity/display/'.$date.'/'.$staffId, 'PHP_CALL', '' , 'GET');
        $i = 0;

        foreach ($params['groups'] as $group) {
            $i++;
            $params['group'][$i] = $this->cURL(API.'group-activity/display/'.$group->groupActivityId.'/', 'PHP_CALL', '' , 'GET');       
        }
        
        $params['active_staff'] = $this->cURL(API.'staff/display/'.$staffId, 'PHP_CALL', '' , 'GET');
        $params['coachs'] = $this->cURL(API.'staff/presence/list/all/'.$date, 'PHP_CALL', '', 'GET');
        $params['tasks']= $this->cURL(API.'task/list', 'PHP_CALL', '', 'GET');
        $params['tasksStaff']= $this->cURL(API.'task/staff/retrieve/'.$staffId.'/'.$date, 'PHP_CALL', '', 'GET');
        $params['staff'] = $this->cURL(API.'staff/display/'.$staffId, 'PHP_CALL', '', 'GET');
        $params['tasks_aday'] = $this->cURL(API.'task/staff/retrieve/'.$staffId.'/'.$date, 'PHP_CALL', '', 'GET');
        $this->renderWithData('render/activity/display', $params);
    }

    public function viewDispatchBeta($request) {

        $params = [];

        // current date
        if (!isset($request->date)) {
            $date = date('Y-m-d');
            $month = date('Y-m');
        } else {
            $date = $request->date;
            $m = explode('-', $request->date);
            $month = $m[0].'-'.$m[1];
        }
        $params['date'] = $date;

        // staffs presents current day
        $staff_presence = $this->cURL(API.'staff/presence/list/all/'.$date, 'PHP_CALL', '', 'GET');

        $datas = [];

        foreach($staff_presence as $staffPresence) {

            if($staffPresence->staff->staffId == "71") continue;


            if($staffPresence->typeName != "PRESENCE" && $staffPresence->typeName != "CATCHING" && $staffPresence->typeName != "BONUS") continue;

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
                    'id' => $staffPresence->staff->staffId,
                    'name' => $staffPresence->staff->fullname,
                    'maxChild' => $staffPresence->staff->maxChildren,
                    'capacityDriver' => $places,
                    'location' => str_replace("'", " ", $staffPresence->location)
                ];
            }
        }

        $params['staff_presence'] = $datas;

        // create childs list pickup order by age
        $params['pickups'] = $this->cURL(API.'pickup-activity/listPickupaday/'.$date, 'PHP_CALL', '', 'GET');

        // create group list
        $groups = $this->cURL(API.'group-activity/listADay/'.$date, 'PHP_CALL', '', 'GET');

        if(isset($groups->groups)) {
            $params['groups'] = $groups->groups;
        } else {
            $params['groups'] = null;
        }

        if(isset($groups->groups)) {
            $params['staffsByGroup'] = $groups->staffs;
        } else {
            $params['staffsByGroup'] = null;
        }


        // buttons
        $params['buttons'] = array
        (
            array("href" => "javascript:void(0)", "onclick" => "createGroupActivity()", "label" => "Créer un groupe", "icon" => "add"),
            array('href' => HOST.'activity/duplicate/date/'.$date.'/', "onclick" => null, "label" => 'Dupliquer une journée', 'icon' => 'file_copy'),
           // array("href" => "javascript:void(0)", "onclick" => "openRevealJS('revealCreatePickupActivity');changeActionPickupActivity()", "label" => "Créer une activité", "icon" => "add"),
            array("href" => "javascript:void(0)", "onclick" => "affect()", "label" => "Affecter", "icon" => "code"),
            array("href" => "javascript:void(0)", "onclick" => "unaffect()", "label" => "Désaffecter", "icon" => "code"),
            array("href" => "javascript:void(0)", "onclick" => "deleteAll()", "label" => "TOUT SUPPRIMER", "icon" => "delete"),

        );

        $this->renderWithData('render/activity/beta/dispatch', $params);

    }

    public function duplicate($request) {

        $date = $request->date;
        $params = [];
        $params['date'] = $date;
        $this->renderWithData('render/activity/beta/duplicate', $params);
    }


    public function executeDuplicate($request) {
        $source = $request->source;
        $target = $request->target;

        $params['data'] = $this->cURL(API.'group-activity/duplicate/'.$source.'/'.$target, 'PHP_CALL', '' , 'GET');

        if(isset($params['data']->messages->forced_id_child_list)) {
                foreach($params['data']->messages->forced_id_child_list as $elements) {
                    $time = explode('|', $elements->group_start_time);
                    foreach($elements->group_start_staff as $staff) {
                        $staffidArray[] = $staff->staffId;
                    }

                    $datas = [  'date'          => $target,
                                'start'         => $time[0],
                                'end'           => $time[1],
                                'sport_id'      => $elements->group_start_sport_id,
                                'age'           => $elements->group_start_age, 
                                'staff_string'  => implode(',', $staffidArray)
                    ];

                    $groups = $this->cURL(API.'group-activity/search/criterias', 'PHP_CALL', $datas , 'POST');
                    $forcedChildList[] = ['childListElements' => $elements, 'groups' => $groups];
                }
                $params['forcedChildList'] = $forcedChildList;
        }
        $this->renderHtml('render/activity/beta/duplicateResult', $params);
    }


    public function viewCreatePickup($request)
    {
        if(!isset($request->date))
        {
            $date = date('Y-m-d');
        }
        else
        {
            $date = $request->date;
        }

        $params = array();

        $params['child'] = $request->child;        
        $params['locations'] = $this->cURL(API.'location/list', 'PHP_CALL', '', 'GET');
        $params['sports'] = $this->cURL(API.'sport/list', 'PHP_CALL', '', 'GET');
        $params['groups'] = $this->cURL(API.'group-activity/list/'.$date, 'PHP_CALL', '', 'GET');
        $params['date'] = $date;

      //  echo "<pre>"; print_r($params['groups']); exit;

        $this->renderWithData('render/activity/_createPickupInline', $params);

    }

    public function loadOneGroup($request)
    {
        $params = array();
        $params['idGroup'] = $request->idGroup;
        $params['date'] = $request->date;
        $params['group'] = $this->cURL(API.'group-activity/display/'.$request->idGroup, 'PHP_CALL', '' , 'GET');

        $this->renderHtml('render/activity/_loadOneGroup', $params);

    }

    public function loadNpec($request)
    {

        $params = array();
        $params['date'] = $request->date;
        $params['sports'] = $this->cURL(API.'sport/list', 'PHP_CALL', '', 'GET');
        $params['pickups'] = $this->cURL(API.'pickup-activity/list/'.$request->date.'?size=300', 'PHP_CALL', '', 'GET');


        $this->renderHtml('render/activity/_loadNpec', $params);

    }


    public function updateAllRegistration($request) {
        $params = [];
        $params['sportSelected'] = $request->sportSelected;
        $params['currentActivity'] = $this->cURL(API.'pickup-activity/display/'.$request->pickupId, 'PHP_CALL', '', 'GET');
        $params['activities']      = $this->cURL(API.'pickup-activity/associatedByRegistration/'.$request->pickupId, 'PHP_CALL', '', 'GET');
        $this->renderWithData('render/activity/_updateAllRegistration', $params);
    }

    public function doUpdateAllRegistration($request) {


        $datas = ['pickupActivityIds' =>  $request->activitysAssociated, 'sportId' => $request->newSport];

        $response = $this->cURL(API.'pickup-activity/updateAllRegistration', 'AJAX_CALL', $datas, 'POST');
        $this->renderHtml('render/activity/_doUpdateAllRegistration');

    }

}
