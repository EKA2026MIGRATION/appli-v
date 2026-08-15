<?php

/**
 * Class Auth
 * Users Authentification
 */

class Auth extends Controller
{

    public function displayAuth($request)
    {
        $this->render('render/auth/auth');
    }

    public function lostPassword($request)
    {
        $this->render('render/auth/lost-password');
    }

    public function lostPasswordConfirm($request)
    {
        $params['token'] = $request->token;

        $this->renderWithData('render/auth/lost-password-confirm', $params);
    }

    public function checkAuth($request)
    {
        // prevent session fixation: issue a fresh session id on login
        session_regenerate_id(true);

    	$data = array();
    	$data['token'] = $request->token;
    	$personConnected = $this->cURL(API.'person/display/'.$request->user['identifier'], 'PHP_CALL', $data, 'GET');
        $_SESSION['TOKEN'] = $request->token;
        $_SESSION['IDENTIFIER'] = $request->user['identifier'];
		$roles = explode(',', $request->user['roles']);
        if($roles[0] == '') unset($roles[0]);
        $_SESSION['ROLE'] = array_values(array_filter($roles));

        $credentials =  $this->cURL(API.'credential/user/'.$request->user['identifier'], 'PHP_CALL', $data, 'GET');

        foreach($credentials as $credential) {
            $arr[] = $credential->name;
        }

        $_SESSION['start'] = true;

        $_SESSION['CREDENTIALS'] = $arr;

		$_SESSION['PERSON_CONNECTED'] = $personConnected;

		echo json_encode(['msg' => 'ok', 'TOKEN' => $request->token]);
    }

}
