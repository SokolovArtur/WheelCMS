<?php

session_start();

ob_start();

function __autoload($className)
{
    $className = strtolower($className);
    $classPath = $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', '/', str_replace('_', '-', $className)) . '.php';
    if (file_exists($classPath)) {
        require_once($classPath);
    }
}

function singleton($className)
{
    static $instances = array();

    if (!array_key_exists($className, $instances)) {
        if (class_exists($className)) {
            $instances[$className] = new $className();
        } else {
            throw new \Errors\Exception_Handler("Не удалось найти класс <strong>{$className}</strong>");
        }
    }

    return($instances[$className]);
}

set_error_handler(array('\Errors\Error_Handler', 'handler'));
set_exception_handler(array('\Errors\Exception_Handler', 'handler'));

register_shutdown_function(array('\Errors\Error_Handler', 'shutdownHandler'));

$Router = singleton('\Core\Router');
$module = $Router->getModule();
$controller = $Router->getController();

$controllerClass = '\\Modules\\' . ucfirst($module) . '\\Controller\\' . ucfirst($controller);
$App = singleton($controllerClass);

echo(ob_get_clean());