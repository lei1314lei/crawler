<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Page {
    protected $_webBaseUrl;
    protected $_currentPage;
    public $charset = "utf-8";
    protected $_error;

    protected function _fullPath($path){
        return $this->_webBaseUrl.'/'.$path;
    }

    protected function _loadPage($productUrl){
        $this->_currentPage=$productUrl;
        //TODO 1. use curl instead 2. deal with memory exceed.
        $html=  file_get_contents($productUrl);
       // $this->before($html);
        phpQuery::newDocumentHTML($html,$this->charset);
        
    }
    public function __construct()
    {
       
    }
}