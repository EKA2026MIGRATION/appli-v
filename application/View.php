<?php

/**
 * Class View
 * organize the view
 */
class View
{

    private $template;
    private $App = 0;
    private $originalRequest;


    public function setOriginalRequest($request) {
      $this->originalRequest = $request;
    }

    public function getOriginalRequest()
    {
        return $this->originalRequest;
    }

    /**
     * set the template.
     * @param null $template
     * @return $this
     */
    public function setTemplate($template)
    {
        if(preg_match("/app/i", $template)) {
            $this->App = 1;
            $el = explode('/', $template);
            $template = $el[1];
        }

        $this->template = $template;
        return $this;
    }

    public function getRenderTemplate($params)
    {
        $template = $this->template;
        ob_start();

        if($this->App == 1)
        {
            include(APPLICATION.'pages/'.$template.'.php');

        } else {
            include(VIEW.$template.'.php');
        }
        $contentPage = ob_get_clean();

        return $contentPage;
    }


    /**
     * render the template
     * @param array $params
     */
    public function render($params)
    {

        $originalRequest = $this->getOriginalRequest();
        $template = $this->template;
        ob_start();

        if($this->App == 1)
        {
            include(APPLICATION.'pages/'.$template.'.php');

        } else {
            include(VIEW.$template.'.php');
        }
        $contentPage = ob_get_clean();

        if(ROUTE != "auth/display" AND ROUTE != "auth/lost-password" AND ROUTE != "auth/lost-password-confirm" AND ROUTE != "public/tv")
        {
            include_once (VIEW.'template/template.php');
        }
        elseif(ROUTE == "public/tv")
        {
            include_once (VIEW.'template/tv.php');
        }
        else
        {
            include_once (VIEW.'template/template_2.php');
        }

    }

    /**
     * render the view without base template
     * @param array $params
     */
    public function renderWithoutTemplate($params)
    {
        $template = $this->template;
        include(VIEW.$template.'.php');
    }


    /**
     * redirect to the route
     * @param $route
     */
    public function redirect($route)
    {
        header("Location: ".HOST.$route);
        exit;
    }

}
