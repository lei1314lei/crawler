<?php

class Hansgrohe_CategoryPage extends CategoryPage
{
    protected function _getAllCategoryUrl() {
        return array(
            "https://www.hansgrohe.de/bad/produkte",
            "https://www.hansgrohe.de/kueche/produkte"
            );
    }
    protected function _getProductUrlSelector()
    {
       return ".product-mini__link";
    }
}

