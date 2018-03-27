<?php

class Website_Page{
    protected $_pageUrl;
    protected $_doc;
    protected $_charset="utf-8";
    const DATA_FROM='data-from';


    public function getPageUrl()
    {
        return $this->_pageUrl;
    }
    public function __construct($pageUrl) {
        if(!$pageUrl) throw new Exception('invalid page url');
        $this->_pageUrl=$pageUrl;
    }
    protected function _getDocFromFileCache()
    {
        
    }
    public function setPageDoc($html)
    {
        if(isset($this->_doc))
        {
            throw new Exception("Page doc has already been setted.Page URL is".$this->_pageUrl);
        }
        $this->_doc=phpQuery::newDocumentHTML($html,$this->_charset);
        
        return $this;
    }
    /*
     * return doc or false
     */
    public function getPageDoc()
    {
        if(!isset($this->_doc))
        {
            $html=$this->_getDocFromFileCache();
            if(empty($html))
            {
                $html=  @file_get_contents($this->_pageUrl);
            }
            if(false===$html)
            {
               return false;
            }
            $this->_doc=phpQuery::newDocumentHTML($html,$this->_charset);
            //phpQuery::selectDocument($doc);
        }
        return $this->_doc;
    }
    protected function _getElements($selector)
    {
        $extractFailedMsg="can't extract elements by selector:$selector";
        if(!$selector)
        {
            throw new Website_ElementException($this,$extractFailedMsg);
        }
        $doc=$this->getPageDoc();
        if(false===$doc) throw new Website_ElementException($this,"page document hasn't been loaded");
        phpQuery::selectDocument($doc);
        
        $eles=pq($selector);
        if(false===$eles || $eles->count()==0)
        {
            throw new Website_ElementException($this,$extractFailedMsg);
        }
        return $eles;
    }
    public function getElesBySelector($selector,$attrName=null)
    {
        $eles=$this->_getElements($selector);
        if(is_null($attrName)) return $eles;
        $return=array();
        foreach ($eles as $ele)
        {
            $return[]=$this->_extractAttr($ele,$attrName);
        }
        return $return;
    }
    protected function _extractAttr($ele,$attrName)
    {
            $attrVal=pq($ele)->attr($attrName);
            if(is_null($attrVal))
            {
                throw new Website_NonEleAttrException("there is not attribute:{$attrName} in element.".pq($ele)->htmlOuter());
            }else{
                return $attrVal;
            }
    }


    public function getUniqeEleBySelector($selector,$attrName=null)
    {
        $eles=$this->_getElements($selector);
        if($eles->count()>1)
        {
            throw new Website_ElementException("there are more than one elements by '$selector'");
        }
        foreach($eles as $ele)
        {
            if(is_null($attrName)) return $ele;
            return $this->_extractAttr($ele, $attrName);
        }
    }
}
