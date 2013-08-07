<?php

namespace Database;

class Db extends \mysqli
{

    private $_host = 'localhost';
    private $_user = 'root';
    private $_password;
    private $_db;

    public function __construct()
    {
        parent::__construct(
            $this->_host,
            $this->_user,
            $this->_password
        );

        if (!$this->select_db($this->_db)) {
            throw new \Errors\Exception_Handler("Не удалось соединиться c базой данных <strong>{$this->_db}</strong>");
        }

        $this->set_charset('utf8');
    }

    public function query($sql, $returnType = 'array')
    {
        $result = parent::query($sql);

        if (!$result) {
            throw new \Errors\Exception_Handler("<strong>Не удалось выполнить SQL-запрос</strong>: {$this->error}");
        }

        switch ($returnType) {
            case 'array':
                $return = $result->fetch_all();
                break;
            case 'array_row':
                $return = $result->fetch_array();
                break;
            case 'object':
                $return = $result->fetch_fields();
                break;
            case 'object_row':
                $return = $result->fetch_object();
                break;
            case 'row':
                $return = $result->fetch_assoc();
                break;
            case 'num_rows':
                $return = $result->num_rows;
                break;
            default:
                $return = FALSE;
        }

        $result->close();

        return($return);
    }

}