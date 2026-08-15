<?php
require_once(HELPER.'userSession.php');
require_once(HELPER.'dates.php');


class Credential extends Controller
{

    public function list($request) {

        $profils = ['MANAGER', 'COACH', 'DRIVER'];
        $params['credentials']= $this->cURL(API.'credential/list', 'PHP_CALL', '', 'GET'); 
        $params['profils'] = $profils;

        foreach($profils as $profil) {
            $roles = $this->cURL(API.'credential/list/'.$profil, 'PHP_CALL', '', 'GET');
            foreach($roles as $role) {
                $params[$profil][] = $role->name;
            } 
        }
        $this->renderWithData('render/credential/list', $params);
    }

}
