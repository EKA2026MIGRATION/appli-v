<?php
class MyConfiguration
{
    /**
     * load the application
     */
    public static function start($url)
    {
        // errors: show only in local dev (never leak to users in prod), always log
        $isDev = in_array($_SERVER['REMOTE_ADDR'] ?? '', array('127.0.0.1', '::1'), true);
        ini_set('display_errors', $isDev ? '1' : '0');
        ini_set('log_errors', '1');
        error_reporting(E_ALL ^ E_DEPRECATED);

        // set time
        ini_set('date.timezone', 'Europe/Paris');

        // start session with hardened cookie params (secure only over HTTPS)
        $secureCookie = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443);
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'httponly' => true,
            'secure' => $secureCookie,
            'samesite' => 'Lax',
        ]);
        session_start();
        // start autoload
        spl_autoload_register(array(__CLASS__, 'autoload'));
        
        MyConfiguration::initParameters($url);
        require_once(APPLICATION.'Functions.php');
    }
    /**
     * create all parameters
     */
    private static function initParameters($url)
    {
        $root = $_SERVER['DOCUMENT_ROOT'];
        $host = $_SERVER['HTTP_HOST'];

        // load config from .env (single local config file, gitignored)
        $envConfig = __DIR__.'/../.env';
        $parameters = is_file($envConfig) ? parse_ini_file($envConfig) : array();
        $parameters_route = parse_ini_file('application/routes/routes.ini', true);
        $elements = explode('/', $url);
        // set parameters
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );

        if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            $beforeHost = "http://";
            define('HOST', $beforeHost.$host.$parameters['folder_app_dev'].'/');
            define('ROOT', $root.$parameters['folder_app_dev'].'/');
        }
        else
        {
            $beforeHost = "https://";
            define('HOST', $beforeHost.$host.$parameters['folder_app_prod'].'/');
            define('ROOT', $root.$parameters['folder_app_prod'].'/');
        }

        define('IP_CLUB', array('127.0.0','77.204.198', '217.181.222'));

        $authValid = false;
        foreach(IP_CLUB as $ip) {
            if(stripos( $_SERVER['REMOTE_ADDR'], $ip) !== false) {
                $authValid = true;
               // echo 'isvalid';
            }
        }


//        (in_array($_SERVER['REMOTE_ADDR'], IP_CLUB)) ? $authValid = true : $authValid = false;

        define('ACTIVITY_AUTH_VALID', $authValid);
        define('API', $parameters['api_call']);

        if(isset($elements[1]))
        {
            define('ROUTE', $elements[0]."/".$elements[1]);
        }
        else
        {
            // check url lenght for short url
            if(strlen($elements[0]) == 3){
                $shortCode = $elements[0];
                $elements[0] = "public";
                $elements[1] = "shortUrl";
                define('ROUTE', "public/shortUrl");

            } else {
                define('ROUTE', $elements[0]);
            }
        }

        define('ROUTE_FIRST_ELEMENT', $elements[0]);

        $currentController = $elements[0];

        define('SIZE_RECHERCHE', $parameters['size_recherche']);
        define('SIZE_LIST', $parameters['size_list']);
        define('WEEK_LIST', $parameters['week_list']);

        //set folders
        define('CONTROLLER', ROOT.'controller/');
        define('VIEW', ROOT.'view/');
        define('MODEL', ROOT.'model/');
        define('APPLICATION', ROOT.'application/');
        define('HELPER', ROOT.'application/helper/');
        define('SERVICES', ROOT.'services/');
        define('VENDOR', ROOT.'vendor/');

        // hasCredential()/hasRole() are used unconditionally in views (e.g. view/template/template.php)
        // so they must always be available, not only when a controller happens to load them.
        require_once(HELPER.'userSession.php');


        // set assets url
        define('ASSETS', HOST.'assets/');
        define('JS', ASSETS.'js/');
        define('CSS', ASSETS.'css/');
        define('IMG', ASSETS.'image/');

        $files_route = array();

        foreach($parameters_route as $key => $item){

              $files_route[$key]['css'] = explode(' ', $item['css']);
              $files_route[$key]['js'] = explode(' ', $item['js']);
        }

        define('FILES_ROUTE', $files_route);

        define('MAPS_API_KEY', $parameters['maps_api_key']);
        define('TWILIO_ID', $parameters['twilio_id']);
        define('TWILIO_TOKEN', $parameters['twilio_token']);

        define('SMTP_HOST', $parameters['smtpHost']);
        define('SMTP_USERNAME', $parameters['smtpUsername']);
        define('SMTP_PASSWORD', $parameters['smtpPassword']);
        define('SMTP_PORT', $parameters['smtpPort']);

        define('API_ADMIN_USERNAME', $parameters['apiAdminUsername']);
        define('API_ADMIN_PASSWORD', $parameters['apiAdminPassword']);

        define('SMS_FACTOR_TOKEN', $parameters['smsFactorToken']);
        define('FIREBASE_KEY', $parameters['firebaseKey']);

        define('AES_KEY', $parameters['aesKey']);
        define('AES_IV', $parameters['aesIv']);

        if(ROUTE == "auth/logout")
        {
            session_destroy();
            header('location: '.HOST.'auth/display');
            exit;
        }

        if(!isset($_SESSION['TOKEN']))
        {

            define('ROLE', 'NOTHING');
            define('TOKEN', '');


            if( ROUTE == "auth/display" OR 
                ROUTE == "auth/check" OR 
                ROUTE == "user/add" OR
                ROUTE == "twilio/forwardCall" OR
                ROUTE == "twilio/forwardSms" OR 
                ROUTE == "twilio/callLog" OR 
                ROUTE == "twilio/callLogDate" OR 
                ROUTE == "auth/lost-password" OR 
                ROUTE == "sendMailLostPassword" OR 
                ROUTE == "sendMailSurvey" OR 
                ROUTE == "auth/lost-password-confirm" OR 
                ROUTE == "sendRequest" OR 
                ROUTE == "sendSMS" OR
                ROUTE == "sendPush" OR
                ROUTE == "survey/session" OR
                $currentController == "public" OR
                $currentController == "livret" OR
                $currentController == "download" OR
                $currentController == "cron" OR
                $currentController == "mypublic" OR
                $currentController == "anniversaires"
            )
            {

            }
            else
            {
                header('location: '.HOST.'auth/display');
                exit;
            }
        }
        elseif(isset($_SESSION['TOKEN']))
        {
            if(ROUTE == "auth/display")
            {
                header('location: ../app/home');
                exit;
            }
            define('ROLE', $_SESSION['ROLE']);
            define('TOKEN', $_SESSION['TOKEN']);
            $ARRAY_PERSON_CONNECTED = json_decode(json_encode($_SESSION['PERSON_CONNECTED']), True);

            define('PERSON_CONNECTED', $ARRAY_PERSON_CONNECTED);

        }

    }
    /**
     * load class by autoload
     * @param $class
     */
    private static function autoload($class)
    {
        if(file_exists(MODEL.$class.'.php'))
        {
            include_once (MODEL.$class.'.php');
        }

        if (file_exists(APPLICATION.$class.'.php'))
        {
            include_once (APPLICATION.$class.'.php');
        }

        if (file_exists(SERVICES.$class.'.php'))
        {
            include_once (SERVICES.$class.'.php');
        }


        if (file_exists(CONTROLLER.$class.'.php'))
        {
            include_once(CONTROLLER.$class.'.php');
        }
    }

}
