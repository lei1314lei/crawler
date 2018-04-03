<?php

class Base_Logger_Crawler extends log
{
    const KEY_INDEX='indexKey';
    const KEY_PAGE_URL='pageUrl';
    const KEY_ELE_SELCTOR="eleSelector";
    protected  $_allRows; 
    public function readAllRows()
    {
        $allRows=array();
        $fp=$this->_fp;
        fseek($fp, 0);
        while (($row = fgets($fp, 4096)) !== false) {
            $row=json_decode($row,true);
            $allRows[$row[self::KEY_INDEX]] =  $row;
        }
        if (!feof($fp)) {
            echo "Error: unexpected fgets() fail\n";
        }
        return  $allRows;
    }
    public function __construct($logFileName, $log_bath = null)
    {
        $titleRow=$targetTitleCol=null;
        $mod="a+";
        parent::__construct($logFileName, $titleRow , $targetTitleCol , $mod , $log_bath );
        $allRows=$this->readAllRows();
        $this->_allRows=$allRows;
    }
    /*
     * the Website_ElementException comes form the same page && same selector  will only be logged at the first time
     */
    public function logEx(Website_ElementException $ex)
    {
        $page=$ex->getObject();
        $url=$page->getPageUrl();
        $selector=$ex->getSelector();
        $key=self::key($url);
        $row=array('page-url'=>$url,self::KEY_ELE_SELCTOR=>$selector,'ExMsg'=>$ex->getMessage());
        //$row=array('page-url'=>$url,"selector"=>$selector,'msg'=>$ex->getMessage());
        $this->addRow($key,$row);
    }
    static public function key($url)
    {
        return MD5($url);
    }
    public function addRow($key,Array $row) {
        if(!$this->isLogged($key))
        {
            $row[self::KEY_INDEX]=$key;
            parent::addRow(json_encode($row));
            $this->_allRows[$key]=$row;
        }
    }
    public function isLogged($key)
    {
        return isset($this->_allRows[$key])?true:false;
    }
//    public function assembleRow($keyVal,$selector,Array $otherInfo)
//    {
//        $row[self::KEY_INDEX]=self::key($keyVal);
//        $row[self::KEY_PAGE_URL]=$pageUrl;
//        
//        return array_merge($row,$otherInfo);
//    }
}

