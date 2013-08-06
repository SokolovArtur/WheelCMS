<?php

namespace Core;

class Model
{

    public function getModel($modelName)
    {
        $Router = singleton('\Core\Router');
        $module = $Router->getModule();

        $modelClass = '\\Modules\\' . ucfirst($module) . '\\Model\\' . ucfirst($modelName);
        return(singleton($modelClass));
    }

}