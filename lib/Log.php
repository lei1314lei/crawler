<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class log
{
    protected $_fp;
    protected $_allOriginalRows = array();
    protected $_titleRow;
    protected $_targetTitleCol;
    protected $_targetIndex;
    protected $_colDelimiter = ',';
    protected $_originalTargetList = array();

    public function __construct($logFileName, $titleRow = null, $targetTitleCol = null, $mod = null, $log_bath = null)
    {
        try {

            // define log path
            if ($log_bath == null) {
                $this->_logBaseDir = dirname(dirname(__FILE__)) . DS . "log";
            } else {
                $this->_logBaseDir = $log_bath;
            }
            if (!is_dir(dirname($this->_logBaseDir . DS . $logFileName))) {
                mkdir(dirname($this->_logBaseDir . DS . $logFileName), 0777, true);
            }
            if($mod == null) $mod = "a+";
            $this->_fp = fopen($this->_logBaseDir . DS . $logFileName, $mod);
            if(!$this->_fp) {
                throw new Exception("something happen when open file ".$this->_logBaseDir . DS . $logFileName);
            }
            $this->_titleRow = $titleRow;
            $this->_targetTitleCol = $targetTitleCol;
            
            if (fgets($this->_fp) === false && $this->_titleRow) {
                fwrite($this->_fp, $titleRow);
            }

        } catch (Exception $e) {
             echo $e->getMessage();
    }
    }

    public function getOriginalTargList()
    {
        return $this->_originalTargetList;
    }

    public function setColDelimiter($delimiter)
    {
        $this->_colDelimiter = $delimiter;
        return $this;
    }

    public function getColDelimiter()
    {
        return $this->_colDelimiter;
    }

    public function getAllOriginalRows()
    {
        return $this->_allOriginalRows;
    }

    public function loadAllRows()
    {
        while ($row = fgets($this->_fp)) {
            $this->_allOriginalRows[] = $row;
            $this->_originalTargetList[] = $this->_getTargetFromRow($row);
        }
    }

    protected function _getTargetFromRow($row)
    {
        $arr = explode($this->getColDelimiter(), $row);
        if (!isset($arr[$this->getTargetIndex()])) {
            var_dump($this->getTargetIndex(), $arr);
            exit;
        }
        return $arr[$this->getTargetIndex()];
    }

    public function getTargetIndex()
    {
        if (!$this->_targetIndex) {
            $this->_targetIndex = array_search($this->_targetTitleCol, explode($this->_colDelimiter, $this->_titleRow));
        }
        return $this->_targetIndex;
    }

    public function setTargetIndex($indexNum)
    {
        $this->_targetIndex = $indexNum;
        return $this;
    }

    public function addRow($row)
    {
        fwrite($this->_fp, $row.PHP_EOL);
    }

    public function __destruct()
    {
        fclose($this->_fp);
    }
}

