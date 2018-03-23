<?php

abstract class Page_Pagination extends Page{
    abstract public function prePage();
    abstract public function nextPage();
    
    protected function _withAddition(Array $data)
    {
        $data[Page::DATA_FROM]=$this->_pageUrl;
        return $data;
    }
    
    public function getOtherPagination($selector,$hrefAttr='href')
    {
        $herf=$this->getUniqeEleBySelector($selector,$hrefAttr);
        if(!$herf)
        {
            return null;
        }else{
            $url=Link::paddingRelativeUrl($this, $herf);
            $class=get_class($this);
            return new $class($url);
        }
    }
    public function getAllItemsOnThisPage($selector, $attrName,$addition=true)
    {
        $return=array();
        $items=$this->getElesBySelector($selector, $attrName);
        foreach($items as $item)
        {
            if($addition)
            {
                $data=$this->_withAddition(array('selector'=>$selector,"Attr"=>"$attrName",'value'=>$item));
            }else{
                $data=$item;
            }
            $return[]=$data;
        }
        return $return;
    }
}