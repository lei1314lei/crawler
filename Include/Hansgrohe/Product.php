<?php

class Hansgrohe_Product extends Website_Page_Product_Multi
{
    public function __construct($pageUrl) {
        $siteCode="Hansgrohe";
        parent::__construct($pageUrl, $siteCode);
    }
    protected function _imgSelector() {
        return ".product-images__image img";
    }
    protected function _getAttrSrcName(){
        return "data-src";
    }
    protected function _simpleProdEleSelector() {
        return ".product-surface.js-surface-selector [href]";
    }
    protected function _imgName() {
        $title=strip_tags(pq('.page-title')->htmlOuter());
        return trim($title);
    }
}