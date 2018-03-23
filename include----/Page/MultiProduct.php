<?php

abstract class Page_MultiProduct extends Page_Product
{
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
       $urls=Link::paddingRelativeUrl($this, $hrefs);
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
        return $simProdEles->count()>1?true:false;
    }
    
    
    
    protected function _getSimpleProdEles()
    {
        if(!isset($this->_simpleProdEles))
        {
            $selector=$this->_simpleProdEleSelector();
            $smpProdEles=$this->getElesBySelector($selector);
            $this->_simpleProdEles=$smpProdEles;
        }
        return $this->_simpleProdEles;
    }
    protected function _smpProdUrlAttrName()
    {
        return "href";
    }

    public function getProImgsFromOtherSmpProdPage()
    {
        $imgs=array();
        if($this->hasOtherSimpleProds())
        {
            $prodUrls=$this->getOtherSmpProdUrls();
            foreach($prodUrls as $prodUrl)
            {
                $class=get_class($this);
                $prodPage=new $class($prodUrl);
                $imgs=  array_merge($imgs,$prodPage->getProdImgs());
            }
        }
        return $imgs;
    }


//    static function getImgsFromProdPage(Page_Product $prodPage)
//    {
//        $imgs=array();
//        $imgs=$prodPage->getProdImgs();
//        if($prodPage->hasOtherSimpleProds())
//        {
//            $prodUrls=$prodPage->getOtherSmpProdUrls();
//            foreach($prodUrls as $prodUrl)
//            {
//                $prodPage=new $prodPage($prodUrl);
//                $imgs=  array_merge($imgs,$prodPage->getProdImgs());
//            }
//        }
//    }
    
}

