<?php

/**
 * PHPStan bootstrap for appli-v.
 *
 * This does NOT reproduce MyConfiguration::start() (config/config.php) — that
 * method makes live cURL calls to the API, touches $_SESSION, and can exit()
 * on a redirect. None of that belongs in static analysis. This file only
 * defines the constants and loads the global functions that would exist at
 * runtime, so PHPStan can resolve them instead of reporting them as unknown.
 */

define('ROOT', __DIR__ . '/../');
define('HELPER', ROOT . 'application/helper/');
define('CONTROLLER', ROOT . 'controller/');
define('APPLICATION', ROOT . 'application/');
define('MODEL', ROOT . 'model/');
define('SERVICES', ROOT . 'services/');
define('VENDOR', ROOT . 'vendor/');

define('HOST', 'http://appli-v/');
define('API', 'http://api.appli-v/');

define('ASSETS', HOST . 'assets/');
define('JS', ASSETS . 'js/');
define('CSS', ASSETS . 'css/');
define('IMG', ASSETS . 'image/');

define('IFRAME', 0);
define('ROLE', 'NOTHING');
define('TOKEN', '');
define('PERSON_CONNECTED', []);

require_once APPLICATION . 'Functions.php';

foreach (glob(HELPER . '*.php') as $helperFile) {
    require_once $helperFile;
}
