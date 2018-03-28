<?php

class Hansgrohe_CategoryPagination extends Website_Page_Pagination_Category{
    public function __construct($pageUrl) {
        $siteCode="Hansgrohe";
        parent::__construct($pageUrl, $siteCode);
    }
    public function prodLinkSelector() {
        return ".product-mini__link";
    }
    protected function _prevPageLinkSelector() {
        return "[rel=prev]";
    }
    protected function _nextPageLinkSelector() {
        return "[rel=next]";
    }
}

