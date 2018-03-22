<?php
/**
 * Created by PhpStorm.
 * User: joy.zhu
 * Date: 04/14/17
 * Time: 15:44
 */
class Duravit_CategoryPage extends CategoryPage{

    public $categoryUrls =  array();
    protected $_webBaseUrl = "http://www.duravit.cn";
    protected $selector = "#products .resizable .flex-grid .text-block a";

    // get all categoryurl form footer "系列"
    protected function _getAllCategoryUrl() {
        $data =  array();
        $categorySelector = "#footer .footernav>li";
        $this->loadPage($this->_webBaseUrl);
        $i = 0;
        foreach(pq($categorySelector) as $k=>$v) {
            if($k >=3) continue;
            $a = pq($v)->find("ul li a");
            if($a->length) {
                foreach ($a as $sub_v) {
                    $url = $this->_webBaseUrl.pq($sub_v)->attr("href");
                    array_unshift($data,$url);
                    $this->download_log->addRow($url);
                }

            }
        }
        return $data;
    }

    protected function _beforeRecord($href)
    {
        /*  change "/website/%E9%A6%96%E9%A1%B5/%E4%BA%A7%E5%93%81/%E4%BA%A7%E5%93%81/%E7%B3%BB%E5%88%97/%E7%A2%97%E7%9B%86.cn-zh.html;jsessionid=9ABF555384156649E52B0848E36F6028/p-91247"
                  to /website/%E9%A6%96%E9%A1%B5/%E4%BA%A7%E5%93%81/%E4%BA%A7%E5%93%81/%E7%B3%BB%E5%88%97/%E7%A2%97%E7%9B%86.cn-zh.html/p-91247">
				*/
        return $this->_webBaseUrl.preg_replace("{;jsessionid=(.+)/}","/",$href);
    }

}
?>