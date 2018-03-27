<?php

abstract class Website_PaginationSet_Category extends Website_PaginationSet
{
//    abstract protected function _logger();
//    protected function _log(Exception $ex,$msg)
//    {
//        $logger=$this->_logger();
//        $logger->addRow($msg);
//        $EXCEPTIONLOGGER->record($ex);
//        return $this;
//    }
    public function __construct(Website_Page_Pagination_Category $page) {
        parent::__construct($page);
    }
//    public function getAllProdsUrlInfo(){
//        $selector=$this->_activePagination->prodLinkSelector();
//        $attr=$this->_activePagination->getHrefAttr();
//        $paginations=getAllPaginations();
//        $urlsInfo=array();
//        foreach($paginations as $pagination)
//        {
//            try{
//                $infos=$pagination->getProdsUrlInfo($selector,$attr);
//            } catch (ElementException $ex) {
//                $page=$ex->getObject();
//                $msg="pagination failed to get product urls.\r\n";
//                $msg="page url:".$page->getPageUrl();
//                $this->_log($ex,$msg);
//                continue;
//            }
//            $urlsInfo=  array_merge($urlsInfo,$infos);
//        }
//        $urlsInfo=array();
//        //$urlsInfo=$this->_itemsFromAllPaginationByMethod("getProdsUrlInfo",$selector,$attr);
//        return $urlsInfo;
//    }
}
