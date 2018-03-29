<?php

abstract class Website_Page_Pagination_Category extends Website_Page_Pagination
{
    const DATA_PROD_URL="prodUrl";
    abstract public function prodLinkSelector();
    public function getProdsUrlInfo()
    {
        $selector=$this->prodLinkSelector();
        $hrefAttr=$this->getHrefAttr();
        $hrefs=$this->getElesBySelector($selector,$hrefAttr);
        foreach($hrefs as $href)
        {
            $url=  Website_Link::paddingRelativeUrl($this, $href);
            $data[Website_Page::DATA_ADDITION_FROM_PAGE]=$this->_pageUrl;
            $data[Website_Page::DATA_ADDITION_SELECTOR]=$selector;
            $data[Website_Page::DATA_ADDITION_ATTR]=$hrefAttr;
            $data[self::DATA_PROD_URL]=$url;
            //$data=$this->_withAddition(array('selector'=>$selector,"attrName"=>$hrefAttr,'attrVal'=>$url));
            $return[]=$data;
        }
        return $return;
    }
    public function getHrefAttr()
    {
        return "href";
    }

}
