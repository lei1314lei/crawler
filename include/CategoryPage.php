<?php
/**
 * Created by PhpStorm.
 * User: joy.zhu
 * Date: 04/14/17
 * Time: 15:44
 */
class CategoryPage extends Page{

    public $categoryUrls =  array();
    public $product_urls_log_dir = null;
    public $download_log;
    public $selector;



   public function __construct($log_dir)
    {
        $this->product_urls_log_dir = $log_dir;
        $this->download_log = new Log("download_log.csv",null,null,"w+",$log_dir);
        $this->_error = new Log("error.log",null,null,null,$log_dir);
        $this->categoryUrls = $this->getAllCategoryUrl();

    }
    public function getAllCategoryUrl() {
        return array();
    }


    /*
    * @param filename is used to save url data
    */
    public function getAllProductUrl($filename) {
        $url_log = new Log($filename,null,null,"w+",$this->product_urls_log_dir);
        foreach($this->categoryUrls as $url) {
            $this->_loadPage($url);
            $this->getUrls($url_log);
        }
    }

    /*get products url from currentPage*/
    protected function getUrls($url_log) {

        /* TODO there is should be exception to detect connection as sometime there is connectin issue
        */
        $this->download_log->addRow("Download form " .$this->_currentPage);
        foreach(pq($this->selector) as $v) {
            if($href = pq($v)->attr("href")) {
                $value = $this->beforeRecord($href);
                $url_log->addRow($value);
            }
        }
        return $this;
    }

    /*
     * Can do some data format or modification before record to file
     */
    public function beforeRecord($href) {
        return $href;
    }
}
?>