<?php

namespace Errors;

class Exception_Handler extends \Exception
{

    public static function handler($exception)
    {
        $Error_Output = singleton('\Errors\Error_Output');
        $Error_Output->displayErrors($exception->getMessage());
    }

}