<?php

class Website_ElementException extends Exception
{
    protected $_object;
    protected $_selector;
    public function __construct(Website_Page $page ,$selector ,$message, $code=null, $previous=null) {
        $this->_object=$page;
        $this->_selector=$selector;
        parent::__construct($message, $code, $previous);
    }
    public function getObject()
    {
        return $this->_object;
    }
    public function getSelector()
    {
        return $this->_selector;
    }
}

