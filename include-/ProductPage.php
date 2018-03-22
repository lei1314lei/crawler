<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//include  "../Page.php";
abstract class ProductPage extends Page {
    protected $_pageUrl;
   // protected $_imgSelector;
    protected $_allProductUrls;
   // protected $_productNameSelector;
    protected $_imgSuffix;
    protected $_data = array(); //product info
    public $_error;
    protected $_log;
    public $charset = "utf-8";
    public $format;
    public $product_file_name_pre = "product_info";
    public $_data_download_dir = null;
    protected $_productlist;
    protected $_nofoundlog;
    
    /*$content should be array that key is name, value is selector
      like $content => array(
        "title" => array(
            selector=>"div.product-image-container div:first h2";
            format => "true"
    )
    );
     */
    
    public $content;
    
    protected function _addErrorInfo($info){
        $_error[]=$info;
    }
    protected function _logErrorInfo(){
        
    }
    public function getError(){
        return $this->error;
    }
    public function __construct($imgSelector, $productUrls) {
        
        $this->_allProductUrls=$productUrls;
        $this->_error = new Error();

    }
    public function setCharset($charset){
        $this->charset = $charset;
        return $this;
    }
//    public function setImgSelector($imgSelector){
//        $this->_imgSelector=$imgSelector;
//        return $this;
//    }
//    public function getImgSelector(){
//        return $this->_imgSelector ;
//    }
    public function loadAllProductImgs(){
        foreach($this->_allProductUrls as $productUrl){
            $imgFile=$this->_loadImgFromPage($productUrl);
            $imgLoger->addRow($imgFile);
        }

    }
    

    protected function _loadImgFromPage($productUrl){
        $this->loadPage($productUrl);
        $src=$this->_getImgSrc();
        $this->_setImgSuffix($src);
        $data=  file_get_contents($src);
        $imgName=IMG_SAVING_PATH.DS.'imgsLoaded'.DS.$this->_generateImgName();
        $fp=fopen($imgName,'w+');
        @fwrite($fp,$data); 
        fclose($fp);
        return $imgName;
    }
    protected function _getImgSrc()
    {
        $imgEles=pq($this->_imgSelector());
        foreach($imgEles as $v) {
            if($href = pq($v)->attr("src")) {
                return $href;
            }else{
                throw new NoImgException("can't extract img url");
            }
        }
    }

    /*
     * load product base info by joy
     */
//
//    public function loadPage($productUrl){
//        $this->_currentPage=$productUrl;
//        $html=  file_get_contents($productUrl);
//        $this->before($html);
//        phpQuery::newDocumentHTML($html,$this->charset);
//    }
//
//    public function before($html){ // if data need to be deal with before
//        return $this;
//    }
    protected function _setImgSuffix($src){
        $suffix=substr($src,strrpos($src,'.'));
        if(strpos($suffix,'?')) $suffix=preg_replace ("/\?.+/", '', $suffix);
        $this->_imgSuffix=$suffix;
    }
    protected function _getImgSuffix(){
        return  $this->_imgSuffix;
        return ".gif";
    }
    
    ////////////////////
//    protected function _generateImgName(){
//        //$prefix=$this->_imgmgNamePrefix();
//        $suffix=$this->_getImgSuffix();
//       // return $prefix.$suffix;
//    }
    abstract protected function _generateImgName();

    public function prepareLog() {
        $this->_log = new Log('product_download' . date('Ymdhis') . '.csv', null,null,null, $this->_data_download_dir);
        $this->_productlist = new Log('productlist'.date('Ymdhis').'.csv',null,null,null,$this->_data_download_dir);
        $this->_nofoundlog= new Log('nofound_log'.date('Ymdhis').'.txt',null,null,null,$this->_data_download_dir);
        return $this;

    }
    
   // abstract protected function _imgmgNamePrefix();
}

