<?php

namespace Core;

final class Router
{

    private $_module = 'main';
    private $_controller = 'index';
    private $_param = array();

    public function __construct()
    {
        if (isset($_SERVER['PATH_INFO'])) {
            $uriPath = $_SERVER['PATH_INFO'];

            if ($this->_checkValidityUriPath($uriPath)) {
                $route = $this->_parseUriPath($uriPath);

                $this->_module = $route['module'];
                $this->_controller = $route['controller'];
                $this->_param = $route['param'];

                if (!$this->existsController()) {
                    $Error_Output = singleton('\Errors\Error_Output');
                    $Error_Output->showStaticError('404');
                }
            } else {
                $Error_Output = singleton('\Errors\Error_Output');
                $Error_Output->showStaticError('404');
            }
        }
    }

    public function getModule()
    {
        return($this->_module);
    }

    public function getController()
    {
        return($this->_controller);
    }

    public function getParam()
    {
        return($this->_param);
    }

    public function existsController($controller = NULL, $module = NULL)
    {
        if (is_null($module)) $module = $this->_module;
        if (is_null($controller)) $controller = $this->_controller;

        $controllerFilePath = $_SERVER['DOCUMENT_ROOT'] . "/modules/{$module}/controller/{$controller}.php";
        return(file_exists($controllerFilePath) ? TRUE : FALSE);
    }

    private function _checkValidityUriPath($uriPath)
    {
        $uriPath = trim($uriPath, '/');
        $result = preg_match_all('/^((admin\/)?[a-z\_\-]+\/[a-z\_\-]+(\/[0-9]+)*)?$/', $uriPath, $matches);
        return(($result == 0) ? FALSE : TRUE);
    }

    private function _parseUriPath($uriPath)
    {
        $uriPath = explode('/', trim(str_replace('-', '_', $uriPath), '/'));

        $module = '';
        if ($uriPath[0] == 'admin') {
            $module .= array_shift($uriPath) . '/';
        }
        $module = (empty($uriPath)) ? 'main' : array_shift($uriPath);

        $controller = (empty($uriPath)) ? 'index' : array_shift($uriPath);

        $param = $uriPath;

        return(array(
            'module' => $module,
            'controller' => $controller,
            'param' => $param
        ));
    }

}