<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Page {
    protected $_webBaseUrl;
    protected $_currentPage;
    public $charset = "utf-8";
    protected $_error;
    protected $_pageLoadLoger;

    protected function _fullPath($path){
        return $this->_webBaseUrl.'/'.$path;
    }

    protected function _pageLoadLoger()
    {
        if(!isset($this->_pageLoadLoger))
        {
            $this->_pageLoadLoger=new log('LogFile-PageLoad.log');
        }
        return $this->_pageLoadLoger;
    }

    public function before($html){ // if data need to be deal with before
        return $this;
    }
    protected function loadPage($productUrl){
        
        $this->_currentPage=$productUrl;
        $html=  file_get_contents($productUrl);
        if(false===$html)
        {
            throw new PageLoadException("load page failed:$productUrl");
        }
        $this->before($html);
        phpQuery::newDocumentHTML($html,$this->charset);
    }
    public function __construct()
    {
       
    }
}