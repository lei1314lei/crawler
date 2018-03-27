<?php
/**
 * Created by PhpStorm.
 * User: joy.zhu
 * Date: 04/18/17
 * Time: 16:03
 */
class Shell  {

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
        $current = null;
        foreach ($_SERVER['argv'] as $arg) {
            $match = array();
            if (preg_match('#^--([\w\d_-]{1,})$#', $arg, $match) || preg_match('#^-([\w\d_]{1,})$#', $arg, $match)) {
                $current = $match[1];
                $this->_args[$current] = true;
            } else {
                if ($current) {
                    $this->_args[$current] = $arg;
                } else if (preg_match('#^([\w\d_]{1,})$#', $arg, $match)) {
                    $this->_args[$match[1]] = true;
                }
            }
        }
        return $this;
    }

    public function getVar($var) {
        return isset($this->_args[$var]) ? $this->_args[$var] : false;
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