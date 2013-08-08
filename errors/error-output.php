<?php

namespace Errors;

class Error_Output
{

    private $_config = array();

    public function __construct()
    {
        require_once('config.php');
        $this->_config = $config;
    }

    public function displayErrors($message)
    {
        ob_clean();

        if ($this->_config['debug']) {
            require_once('page/error.phtml');
        } else {
            error_log($message);

            $this->showStaticError('500');
        }

        exit();
    }

    public function showStaticError($pageName)
    {
        $pagePath = $_SERVER['DOCUMENT_ROOT'] . "/errors/page/{$pageName}.phtml";
        if (file_exists($pagePath)) {
            ob_clean();

            require_once($pagePath);

            exit();
        } else {
            throw new \Errors\Exception_Handler("Не удалось найти файл <strong>{$pagePath}</strong>");
        }
    }

}