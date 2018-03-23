<?php

class Hansgrohe_Product extends Website_Page_Product_Multi
{
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
        $title=$this->_getPageTitle();
        return $title;
    }
    protected function _getPageTitle()
    {
        $title=strip_tags(pq('.page-title')->htmlOuter());
        return trim($title);
    }
}