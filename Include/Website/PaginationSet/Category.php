<?php

abstract class Website_PaginationSet_Category extends Website_PaginationSet
{
    public function __construct(Website_Page_Pagination_Category $page) {
        parent::__construct($page);
    }
    public function getAllProdsUrlInfo(){
        $selector=$this->_activePagination->prodLinkSelector();
        $attr=$this->_activePagination->getHrefAttr();
        $urlsInfo=$this->_getAllItemsByMethod("getProdsUrlInfo",$selector,$attr);
        return $urlsInfo;
    }
}
