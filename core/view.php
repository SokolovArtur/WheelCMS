<?php

namespace Core;

class View
{

    private $_data;

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function __get($name)
    {
        return($this->_data[$name]);
    }

    public function displayView($viewFile)
    {
        $Router = singleton('\Core\Router');
        $module = $Router->getModule();
        $controller = $Router->getController();

        $viewPath = $_SERVER['DOCUMENT_ROOT'] . "/modules/{$module}/view/{$controller}/{$viewFile}.phtml";
        if (file_exists($viewPath)) {
            require_once($viewPath);
        } else {
            throw new \Errors\Exception_Handler("Не удалось найти файл <strong>{$viewPath}</strong>");
        }
    }

}