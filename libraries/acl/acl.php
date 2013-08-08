<?php

namespace Libraries\Acl;

class Acl
{

    public function __construct()
    {
        if (!isset($_SESSION)) {
            throw new \Errors\Exception_Handler('Для корректной работы класса <strong>' . __CLASS__ . '</strong> требуется инициализированный механизм сессий');
        }
    }

    public function setAcl($role, $resource, $access = TRUE)
    {
        $_SESSION[$role][$resource] = (boolean) $access;
    }

    public function isAcl($role, $resource)
    {
        return(empty($_SESSION[$role][$resource]) ? FALSE : TRUE);
    }

    public function deleteAcl($role, $resource)
    {
        unset($_SESSION[$role][$resource]);
    }

    public function deleteRole($role)
    {
        unset($_SESSION[$role]);
    }

    public function deleteResource($resource)
    {
        foreach ($_SESSION as $key => $roles) {
            if (is_array($roles)) {
                if (array_key_exists($resource, $roles)) {
                    unset($_SESSION[$key][$resource]);
                }
            }
        }
    }

}