<?php

namespace Core;

class Controller extends Template
{

    protected $_Model;
    protected $_View;

    public function __construct()
    {
        $this->_Model = singleton('\Core\Model');
        $this->_View = singleton('\Core\View');
    }

    protected function _executeAction($action)
    {
        $this->$action();
        $this->_View->displayView($action);
    }

}