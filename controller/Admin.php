<?php

class Admin extends Controller
{

    public function index($request) {

        $params = array();

        $this->renderWithData('render/admin/index', $params);
    }


}
