<?php

class FrontController
{
    const DEFAULT_CONTROLLER = "Home";
    const DEFAULT_ACTION = "index";
    const CONTROLLER_PATH = 'controller/';
    const CONTROLLER_FILE = 'index.php';

    private $controller = self::DEFAULT_CONTROLLER;
    private $action = self::DEFAULT_ACTION;
    private $params = array();

    private $_loader;
    private $_controllerObject;

    public function __construct()
    {
        $this->_loader = Loader::getInstance();
        $this->parseUri();
    }

    private function parseUri()
    {
        // strip the controllerfile out of the scriptname
        $scriptPrefix = str_replace(self::CONTROLLER_FILE, '', $_SERVER['SCRIPT_NAME']);
        $uri = str_replace(self::CONTROLLER_FILE, '', $_SERVER['REQUEST_URI']);

        // get the part of the uri, starting from the position after the scriptprefix
        $path = substr($uri, strlen($scriptPrefix));

        // strip non-alphanumeric characters out of the path
        $path = preg_replace('/[^a-zA-Z0-9]\//', "", $path);

        // trim the path for /
        $path = trim($path, '/');

        // explode the $path into three parts to get the controller, action and parameters
        // the @-sign is used to supress errors when the function after it fails
        @list($controller, $action, $params) = explode("/", $path, 3);

        if (isset($controller)) {
            $this->setController($controller);
        }
        if (isset($action)) {
            $this->setAction($action);
        }
        if (isset($params)) {
            $this->setParams(explode("/", $params));
        }
    }

    private function setController($controller)
    {
        $controller = ($controller) ? $controller : self::DEFAULT_CONTROLLER;
        $this->controller = ucfirst(strtolower($controller)) . 'Controller';

        // create an instance of the controller as an object
        $this->_controllerObject = $this->_loader->getController($this->controller, self::DEFAULT_CONTROLLER);

        return $this;
    }

    private function setAction($action)
    {
        // check if method exists
        if (!method_exists($this->controller, $action)) {
            die("Action '$action' does not exist in class '$this->controller'.");
        } else {
            $this->action = $action;
        }

        return $this;
    }

    private function setParams(array $params)
    {
        // loop through each element of the parameters to urldecode it
        array_walk($params, create_function('&$val', '$val = urldecode($val);'));

        $this->params = $params;
        return $this;
    }

    public function run()
    {
        // checking the parameter count, using Reflection (http://www.php.net/reflection)
        $reflector = new ReflectionClass($this->controller);
        $method = $reflector->getMethod($this->action);
        $parameters = $method->getNumberOfRequiredParameters();

        if (($parameters) > count($this->params)) {
            die("Action '$this->action' in class '$this->controller' expects $parameters mandatory parameter(s), you only provided " . count($this->params) . ".");
        }

        // call the method based on $this->action and the params
        call_user_func_array(array($this->_controllerObject, $this->action), $this->params);
    }

}