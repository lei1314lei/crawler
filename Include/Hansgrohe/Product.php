<?php

class Hansgrohe_Product extends Website_Page_Product_Multi
{
    const SELECTOR_DATATRACT=".product-details";
    protected $_dataTrack;
    /*
     * return Array
     */
    public function getDataTrack()
    {
        if(!isset($this->_dataTrack))
        {
            $data=$this->getUniqeEleBySelector(self::SELECTOR_DATATRACT, "data-track");
            $this->_dataTrack=json_decode($data,true);
        }
        return $this->_dataTrack;
    }
    public function __construct($pageUrl) {
        parent::__construct($pageUrl, "Hansgrohe");
    }
    public function imgSelector() {
        return ".product-images__image img";
    }
    protected function _getAttrSrcName(){
        return "data-src";
    }
    protected function _simpleProdEleSelector() {
        return ".product-surface.js-surface-selector [href]";
    }
//    static public function decodeProdImgName($encodedName)
//    {
//        return urldecode($encodedName);
//    }
    protected function _imgName($i) {
        $trackData=$this->getDataTrack();
        if(!isset($trackData['id']))//product id
        {
            $msg="fail generate product img name: try to use unknown key 'id' extract data from trackData".  json_encode($trackData);
            throw new Website_ElementException($this,self::SELECTOR_DATATRACT,$msg);
        }
        $name=$trackData['id'];
        $name.='_'.$i;
        return $name;
//        if(!isset($trackData['productLine']))
//        {
//            $msg="fail generate product img name: try to use unknown key 'productLine' data from trackData".  json_encode($trackData);
//            throw new Website_ElementException($this,self::SELECTOR_DATATRACT,$msg);
//        }
//        $name.="_".$trackData['productLine'];
//        if(!$trackData['name'])
//        {
//            $msg="fail generate product img name: try to use unknown key 'name' data from trackData".  json_encode($trackData);
//            throw new Website_ElementException($this,self::SELECTOR_DATATRACT,$msg);
//        }
//        $name.="_".$trackData['name'];
//        return urlencode($name);

//        if(!isset($trackData['productLine']))
//        {
//            $msg="fail to generate img name:unknown key 'productLine' in trackData".  json_encode($trackData);
//            throw new Website_ElementException($this,self::SELECTOR_DATATRACT,$msg);
//        }
//        if(!isset($trackData['name']))
//        {
//            $msg="fail to generate img name:unknown key 'name' in trackData".  json_encode($trackData);
//            throw new Website_ElementException($this,self::SELECTOR_DATATRACT,$msg);
//        }
//        return $trackData['productLine'].'_'.$trackData['name'];
    }
    public function getProductId() {
        $trackData=$this->getDataTrack();
        if(!isset($trackData['id']))
        {
            $msg="fail to extract product id; try to use unknown key 'id' extract data from trackData".  json_encode($trackData);
            throw new Website_ElementException($this,self::SELECTOR_DATATRACT,$msg);
        }
        return $trackData['id'];
    }
}