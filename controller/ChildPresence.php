<?php
use_helper('dates');

/**
 * Class ChildPresence
 */

class ChildPresence extends Controller
{


    public function viewList($request)
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
        $params['date'] = $date;
        $params['child_presence'] = $this->cURL(API.'child/presence/list/'.$date, 'PHP_CALL', '', 'GET');
        $params['locations'] = $this->cURL(API.'location/list', 'PHP_CALL', '', 'GET');     
        
        $this->renderWithData('render/childPresence/list', $params);
    }  
    
    public function viewListWeek($request)
    {

        $params = array();

        $params['locations'] = $this->cURL(API.'location/list', 'PHP_CALL', '', 'GET');

        if(!isset($request->date))
        {
            $dateRef = date('Y-m-d');
        }
        else
        {
            $dateRef = $request->date;
        }
        $monday = getDateStartWeek($dateRef);
        $params['presences'] = $this->cURL(API.'child/presence/listWeek/'.$monday, 'PHP_CALL', '', 'GET');

        $date = $monday;
        for($i = 0; $i < 7; $i++) {
            $params['staff_presence'][$i] = $this->cURL(API.'staff/presence/list/all/'.$date, 'PHP_CALL', '', 'GET');
            $date = nextDay($date);
        }
        $params['dateRef'] = $dateRef;  
                
        $this->renderWithData('render/childPresence/listWeek', $params);
    }   

    public function delete($request) {
        $params['childPresence'] = $this->cURL(API.'child/presence/retrieve/'.$request->id, 'PHP_CALL', '', 'GET');
        return $this->renderWithData('render/childPresence/delete', $params);
    }

    public function confirmDelete($request) {
        $result = $params['child_presence'] = $this->cURL(API.'child/presence/delete/'.$request->childPresenceId, 'PHP_CALL', '', 'DELETE');
        $_SESSION['message'] = $result->message;
        $this->redirect($request->backUrl);
    }
}

