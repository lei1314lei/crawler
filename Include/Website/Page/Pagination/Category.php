<?php

abstract class Website_Page_Pagination_Category extends Website_Page_Pagination
{
    abstract public function prodLinkSelector();
    public function getProdsUrlInfo()
    {
        $selector=$this->prodLinkSelector();
        $hrefAttr=$this->getHrefAttr();
        $hrefs=$this->getElesBySelector($selector,$hrefAttr);
        foreach($hrefs as $href)
        {
            $url=  Website_Link::paddingRelativeUrl($this, $href);
            $data=$this->_withAddition(array('selector'=>$selector,"Attr"=>$hrefAttr,'value'=>$url));
            $return[]=$data;
        }
        return $return;
    }
    public function getHrefAttr()
    {
        return "href";
    }
    protected function _withAddition(Array $data)
    {
        $data[Website_Page::DATA_FROM]=$this->_pageUrl;
        return $data;
    }
}
