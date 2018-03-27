<?php

abstract class Website_Page_Pagination extends Website_Page
{
    public function getOtherPagination($selector,$attr)
    {
        $href=$this->getUniqeEleBySelector($selector,$attr);
        $url=Website_Link::paddingRelativeUrl($this, $href);
        $class=get_class($this);
        return new $class($url);
    }
    abstract protected function _nextPageLinkSelector();
    protected function _nextPageHrefAttr()
    {
        return 'href';
    }
    abstract protected function _prevPageLinkSelector();
    protected function _prevPageHrefAttr()
    {
        return 'href';
    }
    


    public function getNextPage() {
        try{
            $selector=$this->_nextPageLinkSelector();
            $attr=$this->_nextPageHrefAttr();
            $page = $this->getOtherPagination($selector,$attr);
            return $page;
        } catch (Website_ElementException $ex) {
            //暂时不处理：有可能activePage是最后一页 
        }
    }
    public function getPrevPage()
    {
        try {
            $selector=$this->_prevPageLinkSelector();
            $attr=$this->_prevPageHrefAttr();
            $page = $this->getOtherPagination($selector,$attr);
            return $page;
        } catch (Website_ElementException $ex) {
            //暂时不处理：有可能activePage是第一页
        }
    }
}
