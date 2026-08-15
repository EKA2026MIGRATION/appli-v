<?php
require_once(HELPER.'dates.php');

class Task extends Controller
{
    public function view($request) {

        $params = array();


        $params['buttons'] = array
        (
          array("href" => "javascript:void(0)", "onclick" => "showAddTaskForm()", "label" => "Affecter une tâche", "icon" => "add"),
          array("href" => "javascript:void(0)", "onclick" => "manageBasicTask()", "label" => "Gérer les tâches", "icon" => "edit")

        );

        $params['basicTasks']= $this->cURL(API.'task/list', 'PHP_CALL', '', 'GET');



        (!isset($request->date_ref)) ? $date_ref = date('Y-m-d') : $date_ref = $request->date_ref;
        $date_ref = getDateStartWeek($date_ref);

        $params['callBack'] = 'task/view/date_ref/'.$date_ref.'/';

        $tasksStaffs = array();
        $currentDate = $date_ref;
        for($i = 0; $i < 7; $i++)
        {
                if(!$taskAday = $this->cURL(API.'task/staff/list/'.$currentDate, 'PHP_CALL', '', 'GET')) $taskAday = null;
                $params['tasks'][$currentDate]= $taskAday;
                $currentDate = nextDay($currentDate);
                unset($taskAday);
        }

        $params['date_ref'] = $date_ref;
        $params['staff'] = $this->cURL(API.'staff/list', 'PHP_CALL', '', 'GET');

        $params['staffs'] = $this->cURL(API.'staff/list/', 'PHP_CALL', '', 'GET');
        $params['supervisor']= $this->cURL(API.'staff/supervisor', 'PHP_CALL', '', 'GET');

        $this->renderWithData('render/task/view', $params);

    }

    public function add($request)
    {


        (isset($request->step)) ? $step = $request->step : $step = "DONE";
        (isset($request->supervisorId)) ? $supervisorId = $request->supervisorId : $supervisorId = null;

        if(isset($durationDay)) {
          $duration = $request->durationDay.':'.$request->durationHour.':'.$request->durationMinute;
        } else {
          $duration = "00:00:10";
        }

        $date_task = $request->dateTodo.' '.$request->timeTodo.':00';

        if(!isset($request->listStaffId)) {
          $listIdStringArr = [$request->staffId];
        } else {
          $listIdStringArr = explode(',', $request->listStaffId);
          unset($listIdStringArr[0]);
        }



        if($step == 'DONE') {
              $dateLimit = $date_task;
        } else {
              if(!isset($request->dateLimit)) {
                $dateLimit = $request->dateTodo.' 23:59:59';
              } else {
                $el = explode(' ', $request->dateLimit);
                if(!isset($el[1])) {
                  $dateLimit = $request->dateLimit.' 23:59:59';
                } else {
                  $dateLimit = $request->dateLimit;
                }
              }
        }


        foreach($listIdStringArr as $staffId) {
              $datas = [
                                  'name' => $request->name,
                                  'description' => $request->description,
                                  'staff_id' => $staffId,
                                  'date_task' => $date_task,
                                  'supervisor_id' => $supervisorId,
                                  'step' => $step,
                                  'remote_address' => $_SERVER['REMOTE_ADDR'],
                                  'duration' => $duration,
                                  'date_limit' => $dateLimit,
                                  'type' => $request->type
                              ];

              $response = $this->cURL(API.'task/staff/create', 'AJAX_CALL', $datas, 'POST');
        }

        if($request->callBack != "") {
            $callBack = str_replace('-', '/', $request->callBack);
           $this->redirect($callBack);
       } else {
           $this->redirect('task/view');
       }

    }

    // add basic task
    public function addBasicToStaff($request) {

      $staff_id = $request->staffId;
      $task_id  = $request->taskId;
      $date     = $request->date;
      if(!$criticity = $request->criticity) $criticity = 1; 
      $remoteAddress = $_SERVER['REMOTE_ADDR'];

      $datas = array('criticity' => $criticity, 'name' => null, 'description' => null, 'type' => 'basic', 'step' => 'TODO', 'task_id' => $task_id, 'staff_id' => $staff_id, 'date_task' => $date, 'remote_address' => $remoteAddress);
      $response = $this->cURL(API.'task/staff/create', 'AJAX_CALL', $datas, 'POST');

      $params = [];
      
      $this->renderHtml('render/task/_addBasicToStaff', $params);

    }

    public function unaffectBasickTaskStaff($request) {
      $taskStaffId  = $request->taskStaffId;
      $datas = array('taskStaffId' => $taskStaffId);
      $response = $this->cURL(API.'task/staff/delete', 'AJAX_CALL', $datas, 'DELETE');

      $params = [];
      $this->renderHtml('render/task/_addBasicToStaff', $params);
  }

    


    public function deleteBasicTask($request)
    {
          $params = [];
          $datas = ['taskId' => $request->taskId ];
          $response = $this->cURL(API.'task/deleteBasicTask', 'AJAX_CALL', $datas, 'POST');
          $this->renderHtml('render/task/message', $params);
    }

    public function dispatch($request)
    {

          (!isset($request->date_ref)) ? $date_ref = date('Y-m-d') : $date_ref = $request->date_ref;
          $params = [];
          $params['date_ref'] = $date_ref;
          $params['basicTasks']= $this->cURL(API.'task/list', 'PHP_CALL', '', 'GET');
          $params['staffTasks'] = $this->cURL(API.'task/staff/list/'.$date_ref, 'PHP_CALL', '', 'GET');
          $params['staffs'] = $this->cURL(API.'staff/presence/list/all/'.$date_ref, 'PHP_CALL', '', 'GET');

          $arr = []; $arr2 = [];

          foreach($params['staffTasks'] as $staffTask) {
              $arr[trim($staffTask->name)][] = '<span id="span-'.$staffTask->id.'" onclick="retrieveTask('.$staffTask->id.')">'.$staffTask->staff->person->firstname.' '.$staffTask->staff->person->lastname.'</span>';
              if($staffTask->step == "DONE") $arr2[trim($staffTask->name)] =  $staffTask->id;
              
          }

          $params['tasksAffected'] = $arr;
          $params['tasksDone']     = $arr2;

          $this->renderWithData('render/task/dispatch', $params);
    }

    public function editTask($request)
    {
          $params = [];
          $taskStaffId = $request->id;
          $params['task'] = $this->cURL(API.'task/staff/display/'.$taskStaffId, 'AJAX_CALL', [], 'GET');
          $params['staffs'] = $this->cURL(API.'staff/list/', 'PHP_CALL', '', 'GET');
          $params['supervisor']= $this->cURL(API.'staff/supervisor', 'PHP_CALL', '', 'GET');

          $params['callBack'] = $request->callBack;

          $this->renderWithData('render/task/edit', $params);
    }

    public function updateTask($request) {
          (isset($request->supervisorId)) ? $supervisorId = $request->supervisorId : $supervisorId = null;
          $duration = $request->durationDay.':'.$request->durationHour.':'.$request->durationMinute;
          $dateLimit = $request->dateLimit.' 23:59:59';

          $datas = [
                              'id' => $request->taskStaffId,
                              'name' => $request->name,
                              'description' => $request->description,
                              'staff_id' => $request->staffId,
                              'date_task' => $request->dateTodo.' '.$request->timeTodo.':00',
                              'supervisor_id' => $supervisorId,
                              'step' => $request->step,
                              'remote_address' => $_SERVER['REMOTE_ADDR'],
                              'duration' => $duration,
                              'date_limit' => $dateLimit,
                              'type' => $request->type

                          ];

          $response = $this->cURL(API.'task/staff/update', 'PHP_CALL', $datas, 'POST');


          if($request->callBack != "") {
              $callBack = str_replace('-', '/', $request->callBack);
             $this->redirect($callBack);
         } else {
           $this->redirect('task/view/date_ref/'.$request->dateTodo.'/');
         }

    }

    public function addBasickTask($request)
    {
          $params = [];
          $datas = ['task_name' => $request->name, 'moment' => $request->moment];
          $response = $this->cURL(API.'task/addBasicTask/', 'AJAX_CALL', $datas, 'POST');
          $this->renderHtml('render/task/message', $params);
    }

    public function deleteTask($request) {
      $taskStaffId  = $request->id;
      $datas = array('taskStaffId' => $taskStaffId);
      $response = $this->cURL(API.'task/staff/delete', 'AJAX_CALL', $datas, 'DELETE');

      if(isset($request->callBack)) {
          $callBack = str_replace('-','/', $request->callBack);
         $this->redirect($callBack);
     } else {
         $this->redirect('task/list');

     }
    }

    public function modifyStep($request)
    {
        $datas = [
                            'task_staff_id' => $_GET['id'],
                            'step' => 'DONE'
                        ];
        $response = $this->cURL(API.'task/staff/modify/step', 'AJAX_CALL', $datas, 'POST');

        if($_GET['callBack']!= "") {
            $callBack = str_replace('-','/', $_GET['callBack']);
           $this->redirect($callBack);
       } else {
           $this->redirect('task/list');

       }

    }


}
