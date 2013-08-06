<?php

namespace Modules\Main\Controller;

use Core\Controller;

class Index extends Controller
{

    public function __construct()
    {
        parent::__construct();

        self::$_title = 'Добро пожаловать';
        self::$_robots = 'none';

        $this->displayTemplate('tmp');
    }

    public function body() {}

    public function todayDate()
    {
        $this->_View->date = date('d.m.Y');
    }

}