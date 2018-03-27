<?php

class Website_ElementException extends Exception
{
    protected $_object;
    public function __construct(Website_Page $page ,$message, $code=null, $previous=null) {
        $this->_object=$page;
        parent::__construct($message, $code, $previous);
    }
    public function getObject()
    {
        return $this->_object;
    }
}

