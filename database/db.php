<?php

namespace Database;

class Db extends \mysqli
{

    public function __construct()
    {
        require_once('config.php');

        parent::__construct(
            $config['host'],
            $config['user'],
            $config['password']
        );

        if (!$this->select_db($config['db'])) {
            throw new \Errors\Exception_Handler("Не удалось соединиться c базой данных <strong>{$config['db']}</strong>");
        }

        $this->set_charset('utf8');
    }

    public function query($sql, $returnType = 'boolean')
    {
        $result = parent::query($sql);

        if (!$result) {
            throw new \Errors\Exception_Handler("<strong>E_WARNING</strong>: {$this->error} in <strong>{$sql}</strong>");
        }

        $returnResult = FALSE;
        switch ($returnType) {
            case 'boolean':
                if (is_bool($result)) $returnResult = $result;
                break;
            case 'array':
                if (is_object($result)) $returnResult = $result->fetch_all();
                break;
            case 'array_row':
                if (is_object($result)) $returnResult = $result->fetch_array();
                break;
            case 'object':
                if (is_object($result)) $returnResult = $result->fetch_fields();
                break;
            case 'object_row':
                if (is_object($result)) $returnResult = $result->fetch_object();
                break;
            case 'num_rows':
                if (is_object($result)) $returnResult = $result->num_rows;
                break;
        }

        if (!$returnResult) {
            throw new \Errors\Exception_Handler("Не удалось обработать результат SQL-запроса <strong>{$sql}</strong> как тип <strong>{$returnType}</strong>");
        }

        return($returnResult);
    }

}