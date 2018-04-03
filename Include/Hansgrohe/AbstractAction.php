<?php

abstract class Hansgrohe_AbstractAction
{
    protected $_successLogger;
    protected $_failLogger;
    protected $_exceptionLoger;
    protected $_cmdMode=false;
    abstract protected function _initLogger();
    
    public function __construct() {
        $this->_initLogger();
    }
    public function __destruct() {
       $this->_unsetLogger();
    }
    
    protected function _unsetLogger()
    {
        $this->_successLogger=null;
        $this->_failLogger=null;
        $this->_exceptionLoger=null;
    }
    public function setToBeCmdMode()
    {
        $this->_cmdMode=true;
        return $this;
    }
}
