<?php

abstract class Page_Category extends Page
{
    abstract public function prePage();
    abstract public function nextPage();
    public function getAllItemsOnThisPage($selector, $attrName)
    {
        $return=array();
        $items=$this->getElesBySelector($selector, $attrName);
        foreach($items as $item)
        {
            $data['selector']=$selector;
            $data[$attrName]=$item;
            $data[Page::FLAG_PAGE_URL]=$this->_pageUrl;
            $return[]=$data;
        }
        return $return;
    }
    public function getAllItemsOfCategory($selector,$attrName)
    {
        $items=$this->getAllItemsOnThisPage($selector, $attrName);
        $itemsPrev=$this->exhaustedItemsFromPrePage($this,$selector,$attrName);
        $itemsNext=$this->exhaustedItemsFromNextPage($this,$selector,$attrName);
        return array_merge($itemsPrev,$items,$itemsNext);
    }
    public function exhaustedItemsFromPrePage($cPage,$selector,$attrName)
    {
        $prePage=$cPage->prePage();
        if($prePage)
        {
            $items=$prePage->getAllItemsOnThisPage($selector,$attrName);
            if($prePage->prePage())
            {
                $items=array_merge($items,$this->exhaustedItemsFromPrePage($prePage,$selector,$attrName));
            }
            return $items;
        }
        return array();
    }
    public function exhaustedItemsFromNextPage($cPage,$selector,$attrName)
    {
        $nextPage=$cPage->nextPage();
        if($nextPage)
        {
            $items=$nextPage->getAllItemsOnThisPage($selector,$attrName);
            if($nextPage->nextPage())
            {
                $items=array_merge($items,$this->exhaustedItemsFromNextPage($nextPage,$selector,$attrName));
            }
            return $items;
        }
        return array();
    }
    public function pagination($selector,$hrefAttr='href')
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
}

