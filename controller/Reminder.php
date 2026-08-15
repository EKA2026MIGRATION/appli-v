<?php

/**
 * Class Reminder
 *
 */
class Reminder extends Controller
{
    public function viewList($request)
    {
        $params = array();
        $this->renderWithData('render/reminder/list', $params);
    }

}

