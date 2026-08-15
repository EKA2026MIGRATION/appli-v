<?php
/**
 * Class Routeur
 *
 * create routes and find controller
 */

class Routeur
{
    private $url;
    private $routes;
    private $request;
    public function __construct($url)
    {
        $routes = parse_ini_file('routes/routes.ini', true);
        $this->routes = $routes;
        $this->url = $url;
        $route  = $this->getRoute();
        $params = $this->getParams();

        if(strlen($route) == 3) {
            $params = ['shortCode' => $route];
            $route  = "public/shortUrl";
        }

        $request = new Request();
        $request->setRoute($route);
        $request->setParams($params);
        $this->request = $request;
    }
    public function getRoute()
    {
        $elements = explode('/', $this->url);
        if(isset($elements[1]))
        {
            return $elements[0].'/'.$elements[1];
        }
        else
        {
            return $elements[0];
        }

    }
    public function getParams()
    {
        $params = array();
        // extract GET params

        $elements = explode('/', $this->url);

        if(isset($elements[1]))
        {
            unset($elements[0]);
            unset($elements[1]);
            $firstI = 2;
        }
        else
        {
            unset($elements[0]);
            $firstI = 1;
        }

        for($i = $firstI; $i<count((array) $elements); $i++)
        {
            $params[$elements[$i]] = $elements[$i+1];
            $i++;
        }

        if(isset($params['iframe']))
        {
            define('IFRAME', 1);
        }
        else
        {
            define('IFRAME', 0);
        }

        // extract POST params
        if($_POST)
        {
            foreach($_POST as $key => $val)
            {
                $params[$key] = $val;
            }
        }

        return $this->sanitizeParams($params);
    }

    /**
     * Defense-in-depth hardening on every incoming value (route segments + $_POST):
     * strips null bytes/control characters and caps pathological string length.
     * This is NOT business validation (per-field type/format/whitelist checks
     * still belong in the controller) — it only protects against malformed input.
     */
    private function sanitizeParams($params)
    {
        foreach ($params as $key => $val) {
            if (is_array($val)) {
                $params[$key] = $this->sanitizeParams($val);
            } elseif (is_string($val)) {
                $val = str_replace("\0", '', $val);
                $val = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $val);
                if (strlen($val) > 2000000) {
                    $val = substr($val, 0, 2000000);
                }
                $params[$key] = trim($val);
            }
        }

        return $params;
    }
    public function renderController()
    {

        $request = $this->request;

        if(key_exists($request->getRoute(), $this->routes))
        {
            $controller = $this->routes[$request->getRoute()]['controller'];
            $method     = $this->routes[$request->getRoute()]['method'];
            $security   = $this->routes[$request->getRoute()]['security'];
            $security = explode(',', $security);

            // Vérification des accès
            if (in_array(ROLE, $security) OR in_array("ALL", $security)) {
                $currentController = new $controller($request);
                $requestObjets =  (object) $request->getParams();
                $currentController->$method($requestObjets);
            }
            else
            {
                $currentController = new ErrorPage();
                $currentController->showAccess();

            }
        } else {
            $currentController = new ErrorPage();
            $currentController->show404();

        }
    }

}
