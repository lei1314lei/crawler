<?php

abstract class Page_Category extends Page_List_Pagination
{
    const FLAG_PROD_URL='product-url';

    abstract protected  function _prodLinkSelector();
    protected function _prodLinkAttrName()
    {
        return "href";
    }
    /*
     * return all product urls in this category
     * format as  $urls=array($prductUrl,.....);
     */
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
   /*
    * return all product url infos in this category,include page url..... 
    * format as  $urlsInfo=array(
    *             array(Page::DATA_FROM=>$pageUrl,$herfAttrName=>$productUrl,.....),
    *            );
    */
   public function getAllProdUrlsInfo()
   {
       $selector=$this->_prodLinkSelector();
       $attrName=$this->_prodLinkAttrName();
       $hrefsInfos=$this->getAllItemsOfCategory($selector,$attrName);
       $urlsInfo=array();
       foreach($hrefsInfos as $key=>$hrefInfo)
       {
           $href=$hrefInfo[$attrName];
           $hrefInfo[$attrName]=Link::paddingRelativeUrl($this, $href);
           $urlsInfo[$key]=$hrefInfo;
       }
       return $urlsInfo;
   }
}

