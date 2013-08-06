<?php

namespace Core;

class Template
{

    protected static $_title;
    protected static $_description;
    protected static $_keywords;
    protected static $_robots = 'all';

    public function displayTemplate($templateFile)
    {
        $Router = singleton('\Core\Router');
        $module = $Router->getModule();

        $templatePath = $_SERVER['DOCUMENT_ROOT'] . "/modules/{$module}/template/{$templateFile}.phtml";
        if (file_exists($templatePath)) {
            require_once($templatePath);
        } else {
            throw new \Errors\Exception_Handler("Не удалось найти файл <strong>{$templatePath}</strong>");
        }
    }

}