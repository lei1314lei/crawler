<?php

class Website_PaginationSet
{
    protected $_activePagination;
    public function __construct(Website_Page $page) {
        $this->_activePagination=$page;
    }
    /*
     * return all of items in every Pagination
     */
    public function getAllItems($selector,$attr)
    {
        return $this->_getAllItemsByMethod("getElesBySelector",$selector,$attr);
    }
    /*
     * $method  String  method Belong To Pagination
     */
    protected function _getAllItemsByMethod($method,$selector,$attr)
    {
        $items=  call_user_func(array($this->_activePagination,$method), $selector,$attr);
        $prevItems=$this->_exhaustedItemsFromPrePage($this->_activePagination,$method,$selector,$attr);
        $nextItems=$this->_exhaustedItemsFromNextPage($this->_activePagination,$method,$selector,$attr);
        return array_merge($prevItems,$items,$nextItems);

    }
    protected function _exhaustedItemsFromPrePage(Website_Page_Pagination $activePage,$method,$selector,$attr)
    {
        $prePage=$activePage->getPrevPage();
        if($prePage)
        {
            //$items=$prePage->getAllItemsOnThisPage($selector,$attrName);
            $items=  call_user_func(array($prePage,$method), $selector,$attr);
            if($prePage->getPrevPage())
            {
                $items=array_merge($items,$this->exhaustedItemsFromPrePage($prePage,$method,$selector,$attr));
            }
            return $items;
        }
        return array();
    }
    protected function _exhaustedItemsFromNextPage(Website_Page_Pagination $activePage,$method,$selector,$attr)
    {
        $nextPage=$activePage->getNextPage();
        if($nextPage)
        {
            $items=call_user_func(array($nextPage,$method), $selector,$attr);
            if($nextPage->getNextPage())
            {
                $items=array_merge($items,$this->exhaustedItemsFromNextPage($nextPage,$method,$selector,$attr));
            }
            return $items;
        }
        return array();
    }
}
