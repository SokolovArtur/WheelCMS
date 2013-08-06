<?php

namespace Errors;

class Error_Handler
{

    public static function handler($type, $error, $file, $line)
    {
        $type = self::getNameErrors($type);
        $message = "<strong>{$type}</strong>: {$error} in <strong>{$file}</strong> on line <strong>{$line}</strong>";

        throw new \Errors\Exception_Handler($message);

        return(TRUE);
    }

    public static function shutdownHandler()
    {
        $errorInfo = error_get_last();
        if (isset($errorInfo)) {
            $errorsTypes = array(0, 1, 4, 16, 32, 64, 128);

            if (array_search($errorInfo['type'], $errorsTypes)) {
                $typeError = self::getNameErrors($errorInfo['type']);
                $message = "<strong>{$typeError}</strong>: {$errorInfo['message']} in <strong>{$errorInfo['file']}</strong> on line <strong>{$errorInfo['line']}</strong>";

                $Error_Output = singleton('\Errors\Error_Output');
                $Error_Output->displayErrors($message);
            }
        }
    }

    public static function getNameErrors($errorNumber)
    {
        switch ($errorNumber) {
            case 1:
                return('E_ERROR');
            case 2:
                return('E_WARNING');
            case 4:
                return('E_PARSE');
            case 8:
                return('E_NOTICE');
            case 16:
                return('E_CORE_ERROR');
            case 32:
                return('E_CORE_WARNING');
            case 64:
                return('E_COMPILE_ERROR');
            case 128:
                return('E_COMPILE_WARNING');
            case 256:
                return('E_USER_ERROR');
            case 512:
                return('E_USER_WARNING');
            case 1024:
                return('E_USER_NOTICE');
            case 2048:
                return('E_STRICT');
            case 4096:
                return('E_RECOVERABLE_ERROR');
            case 8192:
                return('E_DEPRECATED');
            case 16384:
                return('E_USER_DEPRECATED');
            default:
                return('Неизвестная ошибка');
        }
    }

}