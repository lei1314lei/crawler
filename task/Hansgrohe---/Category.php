<?php

class Hansgrohe_Category extends PaginationSet
{
    
    public function getAllProdUrls()
   {
       $selector=$this->_prodLinkSelector();
       $attrName=$this->_prodLinkAttrName();
       $hrefsInfos=$this->getAllItemsOfCategory($selector,$attrName);
       $urls=array();
       foreach($hrefsInfos as $key=>$hrefInfo)
       {
           $href=$hrefInfo[$attrName];
           $urls[]=Link::paddingRelativeUrl($this, $href);
       }
       return $urls;
   }
}

