<?php
/**
 * Created by PhpStorm.
 * User: joy.zhu
 * Date: 04/18/17
 * Time: 16:03
 */
class Shell  {

    protected $_cmds;
    protected  $_args;
    /**
     * Initialize application and parse input parameters
     *
     */
    public function __construct()
    {
        $this->_parseArgs();
        $this->_validate();
    }

    protected function _parseArgs()
    {
        $cmd = null;
        foreach ($_SERVER['argv'] as $arg) {
            $match = array();
            if (preg_match('#^--([\w\d_-]{1,})$#', $arg, $match) || preg_match('#^-([\w\d_]{1,})$#', $arg, $match)) {
                $cmd = $match[1];
                $this->_cmds[$cmd]=true;
            } else {
                if ($cmd) {
                    $this->_args[$cmd][] = $arg;
                } 
            }
        }
        return $this;
    }

    public function getCmd($cmd)
    {
        return isset($this->_cmds[$cmd]) ? $this->_cmds[$cmd] : false;
    }
    public function getParams($cmd)
    {
        if(isset($this->_args[$cmd]))
        {
            $params=$this->_args[$cmd];
            return $params;
        }
        return array();
    }

    /**
     * Validate arguments
     *
     */
    protected function _validate()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            die('This script cannot be run from Browser. This is the shell script.');
        }
    }

}
?>