<?php

class Loader
{
    private static $instance = null;
    private $_model_path = 'model/';
    private $_view_path = 'view/';
    private $_layout_path = 'view/_layouts/';
    private $_partial_path = 'view/_partials/';
    private $_controller_path = 'controller/';

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getController($controllerName)
    {
        $controllerFile = $this->_getFile($controllerName, $this->_controller_path);
        require_once($controllerFile);

        return new $controllerName();
    }

    public function getModelMapper($modelName)
    {
        $modelName = ucfirst($modelName);
        $modelMapper = $modelName . 'Mapper';

        $modelFile = $this->_getFile($modelName, $this->_model_path);
        $modelMapperFile = $this->_getFile($modelMapper, $this->_model_path);

        require_once($modelFile);
        require_once($modelMapperFile);
        try {
            return new $modelMapper();
        } catch (Exception $e) {
            exit;
        }
    }

    public function getLayout($layout)
    {
        return $this->_getTemplatePart($layout, $this->_layout_path);
    }

    public function getPartial($partial)
    {
        return $this->_getTemplatePart($partial, $this->_partial_path);
    }

    public function getView($view)
    {
        return $this->_getTemplatePart($view, $this->_view_path);
    }

    private function _getTemplatePart($name, $path)
    {
        $name = strtolower($name);
        return $this->_getFile($name, $path);

    }

    private function _getFile($name, $path)
    {
        $file = APPLICATION_PATH . $path . $this->_addExtension($name);

        if (file_exists($file)) {
            return $file;
        } else {
            error_log("File not found: $file");
            exit;
        }
    }

    private function _addExtension($filename)
    {
        return (substr($filename, -4) == '.php') ? $filename : $filename . '.php';
    }
} 