<?php

class Page_Pagination_Set {

    protected $_activePage;
    public function __construct(Pagination $activePage) {
        $this->_activePage=$activePage;
    }


    public function getAllItemsOfCategory($selector,$attrName,$addition=true)
    {
        $items=$this->_activePage->getAllItemsOnThisPage($selector, $attrName,$addition);
        $itemsPrev=$this->exhaustedItemsFromPrePage($this->_activePage,$selector,$attrName,$addition);
        $itemsNext=$this->exhaustedItemsFromNextPage($this->_activePage,$selector,$attrName,$addition);
        return array_merge($itemsPrev,$items,$itemsNext);
    }
    public function exhaustedItemsFromPrePage(Pagination $activePage,$selector,$attrName,$addition=true)
    {
        $prePage=$activePage->prePage();
        if($prePage)
        {
            $items=$prePage->getAllItemsOnThisPage($selector,$attrName,$addition);
            if($prePage->prePage())
            {
                $items=array_merge($items,$this->exhaustedItemsFromPrePage($prePage,$selector,$attrName,$addition));
            }
            return $items;
        }
        return array();
    }
    public function exhaustedItemsFromNextPage(Pagination $activePage,$selector,$attrName,$addition=true)
    {
        $nextPage=$activePage->nextPage();
        if($nextPage)
        {
            $items=$nextPage->getAllItemsOnThisPage($selector,$attrName,$addition);
            if($nextPage->nextPage())
            {
                $items=array_merge($items,$this->exhaustedItemsFromNextPage($nextPage,$selector,$attrName,$addition));
            }
            return $items;
        }
        return array();
    }
}
