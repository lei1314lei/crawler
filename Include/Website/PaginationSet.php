<?php

class Website_PaginationSet
{
    protected $_activePagination;
    protected $_allPaginations;
    public function __construct(Website_Page $page) {
        $this->_activePagination=$page;
    }
    /*
     * return all of items in every Pagination
     */
    public function getAllItems($selector,$attr)
    {
        return $this->_itemsFromAllPaginationByMethod("getElesBySelector",$selector,$attr);
    }
    public function getTotalNumOfPaginations()
    {
        $allPaginations=$this->getAllPaginations();
        return count($allPaginations);
    }
    public function getAllPaginations()
    {
        if(!isset($this->_allPaginations))
        {
            $activePage=$this->_activePagination;
            $prevPages=$this->_allPrevPages($activePage);
            $nextPages=$this->_allNextPages($activePage);
            array_push($prevPages, $activePage);
            $this->_allPaginations= array_merge($prevPages,$nextPages);
        }
        return $this->_allPaginations;
    }
    protected function _allPrevPages($pagination)
    {
        $pages=array();
        $page=$pagination->getPrevPage();
        if($page)
        {
            $pages[]=$page;
            $pages=array_merge($pages,$this->_allPrevPages($page));
        }
        return $pages;
    }
    protected function _allNextPages($pagination)
    {
        $pages=array();
        $page=$pagination->getNextPage();
        if($page)
        {
            $pages[]=$page;
            $pages=array_merge($pages,$this->_allNextPages($page));
        }
        return $pages;
    }
    /*
     * $method  String  method Belong To Pagination
     */
    protected function _itemsFromAllPaginationByMethod($method,$selector,$attr)
    {
        $paginations=$this->getAllPaginations();
        $items=array();
        foreach($paginations as $$pagination)
        {
            $items=array_merge($items,$this->_getItemsFromPaginationByMethod($pagination,$method,$selector,$attr));
        }
        return $items;
    }
    protected function _getItemsFromPaginationByMethod($pagination,$method,$selector,$attr)
    {
        $items=  call_user_func(array($pagination,$method), $selector,$attr);
        return $items ;
    }
}
