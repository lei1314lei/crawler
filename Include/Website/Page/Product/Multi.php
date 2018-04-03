<?php

abstract class Website_Page_Product_Multi  extends Website_Page_Product{
    protected  $_simpleProdEles; 
    abstract protected function _simpleProdEleSelector();
    
    
    public function getOtherSmpProdUrls(){
       $simProdEles=$this->_getSimpleProdEles();
       $urls=array();
       foreach($simProdEles as $ele)
       {
           $href=pq($ele)->attr($this->_smpProdUrlAttrName());
           $hrefs[]=$href;
       }
       $urls=Website_Link::paddingRelativeUrl($this, $hrefs);
       $pos=  array_search($this->_pageUrl, $urls);
       if($pos!==false)
       {
           unset($urls[$pos]); 
       }
       return $urls;
    }
    public function hasOtherSimpleProds()
    {
        $simProdEles=$this->_getSimpleProdEles();
        return count($simProdEles)>1?true:false;
    }
    
    
    
    protected function _getSimpleProdEles()
    {
        if(!isset($this->_simpleProdEles))
        {
            try {
                $selector=$this->_simpleProdEleSelector();
                $smpProdEles=$this->getElesBySelector($selector);
            } catch (Website_ElementException $ex) {
                $smpProdEles=array();
            }
            $this->_simpleProdEles=$smpProdEles;
        }
        return $this->_simpleProdEles;
    }
    protected function _smpProdUrlAttrName()
    {
        return "href";
    }

    public function getProImgsInfoFromOtherSmpProdPage()
    {
        $imgsInfo=array();
        $prodUrls=$this->getOtherSmpProdUrls();
        foreach($prodUrls as $prodUrl)
        {
            $class=get_class($this);
            $prodPage=new $class($prodUrl);
            $imgsInfo=  array_merge($imgsInfo,$prodPage->getProdImgsInfo());
        }
        return $imgsInfo;
    }

}

