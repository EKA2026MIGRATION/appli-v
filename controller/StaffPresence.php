<?php

use_helper('dates');
use_helper('team');

class StaffPresence extends Controller
{
    public function viewDisplay($request)
    {
        if (isset($request->id)) {
            $id = $request->id;
        } else {
            $id = 1;
        }

        if (!isset($request->date)) {
            $date = date('Y-m');
        } else {
            $date = $request->date;
        }

        $params['teams'] = [
                                1 => 'coach',
                                2 => 'driver',
                                3 => 'maintenace',
                                4 => 'secrétariat',
                                5 => 'TIC',
        ];

        $params['staff'] = $this->cURL(API.'staff/list/all?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');
        $params['member'] = $this->cURL(API.'staff/display/'.$id, 'PHP_CALL', '', 'GET');
        $params['actives'] = $this->cURL(API.'season/list/active?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');
        $params['weeks'] = $this->cURL(API.'week/list?page=1&size='.WEEK_LIST, 'PHP_CALL', '', 'GET');
        $params['products'] = $this->cURL(API.'product/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');
        $params['categories'] = $this->cURL(API.'category/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');
        $params['locations'] = $this->cURL(API.'location/list', 'PHP_CALL', '', 'GET');
        $params['date'] = $date;

        $this->renderWithData('render/staffPresence/display', $params);
    }

    public function viewCalendar($request)
    {

        // if user is admin or if ^request->staffId exists

        if (!hasCredential('staff::planification') && !isset($request->staffId)) $this->redirect('app/home');

        if (!isset($request->date)) {
            $date = date('Y-m-d');
            $month = date('m');
            $year = date('Y');
        } else {
            $date = $request->date;
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
        }

        $params = array();

        if(isset($request->staffId)) {
            $params['currentStaffId'] = $request->staffId;
        } else {
            $params['currentStaffId'] = null;
        }

        $params['date'] = $date;
        $params['month'] = $month;
        $params['year'] = $year;

        $params['teams'] = [
            1 => 'coach',
            2 => 'driver',
            3 => 'maintenace',
            4 => 'secrétariat',
            5 => 'TIC',
        ];

        $this->renderWithData('render/staffPresence/homeVue', $params);
    }

    public function viewJson($request)
    {
        if (isset($request->staffId)) {
            $id = $request->staffId;
        } else {
            $id = PERSON_CONNECTED['personId'];
        }

        if (!isset($request->date)) {
            $date = date('Y-m');
        } else {
            $date = $request->date;
        }

        $params['presence'] = $this->cURL(API.'staff/presence/display/'.$id.'/'.$date, 'PHP_CALL', '', 'GET');
        $json = array();
        $i = 0;

        foreach ($params['presence'] as $presence) {
            // $title = trans($presence->typeName);
            $title = $presence->location;
            if ($presence->typeName != 'ABSENCE') {
                $title .= ' '.showHour($presence->start).' à '.showHour($presence->end).' ';
            }

            if ($presence->teamsIdList) {
                $title .= '('.showTeamsStaff($presence->teamsIdList).')';
            }

            $json[$i]['className'] = 'type'.$presence->typeName;
            $json[$i]['title'] = $title;
            $json[$i]['date'] = $presence->date;
            $json[$i]['id'] = $presence->staffPresenceId;
            $json[$i]['start'] = $presence->date.' '.$presence->start;
            $json[$i]['end'] = $presence->date.' '.$presence->end;
            $json[$i]['teamsIdList'] = $presence->teamsIdList;
            $json[$i]['extendedProps']['description'] = 'description';

            ++$i;
        }

        echo json_encode($json);
    }

    public function calendarResumeJson($request)
    {
        if (!isset($request->date)) {
            $date = date('Y-m');
        } else {
            $date = showDate($request->date, 'Y-m');
        }

        $i = 0;
        $json = array();

        $params['presences'] = $this->cURL(API.'staff/presence/list/all/'.$date, 'PHP_CALL', '', 'GET');

        foreach ($params['presences'] as $presence) {
            ($presence->staff) ? $fullname = $presence->staff->person->firstname.' '.$presence->staff->person->lastname : $fullname = '';
            $json[$i]['title'] = $fullname;
            $json[$i]['date'] = $presence->date;
            $json[$i]['id'] = $presence->staffPresenceId;
            $json[$i]['start'] = $presence->date.' '.$presence->start;
            $json[$i]['end'] = $presence->date.' '.$presence->end;
            $json[$i]['teamsIdList'] = $presence->teamsIdList;

            ++$i;
        }

        echo json_encode($json);
    }
}
