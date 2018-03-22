<?php
/**
 * Created by PhpStorm.
 * User: joy.zhu
 * Date: 04/14/17
 * Time: 15:44
 */
abstract class CategoryPage extends Page{

    public $categoryUrls =  array();
    public $product_urls_log_dir = null;
    public $download_log;
    //public $selector;


    abstract protected function _getProductUrlSelector();
    public function __construct($log_dir)
    {
        $this->product_urls_log_dir = $log_dir;
        $this->download_log = new Log("download_log.csv",null,null,"w+",$log_dir);
        $this->_error = new Log("error.log",null,null,null,$log_dir);
        $this->categoryUrls = $this->_getAllCategoryUrl();

    }
    abstract protected function _getAllCategoryUrl() ;


    /*
    * @param filename is used to save url data
    */
    public function recordAllProductUrl($filename) {
        $loger = new Log($filename,null,null,"w+",$this->product_urls_log_dir);
        foreach($this->categoryUrls as $url) {
            $this->loadPage($url);
            $this->_recordProdUrls($loger,$url);
        }
    }

    /*get products url from currentPage*/
    protected function _recordProdUrls($loger,$categoryUrl) {

        /* TODO there is should be exception to detect connection as sometime there is connectin issue
        */
        $this->download_log->addRow("Download form " .$this->_currentPage);
        $prodEles=pq($this->_getProductUrlSelector());

        foreach($prodEles as $v) {
            if($href = pq($v)->attr("href")) {
                $value = $this->_beforeRecord($href,$categoryUrl);
                $loger->addRow($value);
            }else{
                throw new NoProductUrlException("can't extract product url");
            }
        }
            
        

        return $this;
    }

    /*
     * Can do some data format or modification before record to file
     */
    protected function _beforeRecord($href,$categoryUrl) {
        $parts=parse_url($href);
        
        if(isset($parts['host']))
        {
            return $href;
        }else{
            $cURLParts=parse_url($categoryUrl);
            if(isset($cURLParts['scheme']))
            {
                $parts['scheme']=$cURLParts['scheme'];
            }
            if(isset($cURLParts['host']))
            {
                $parts['host']=$cURLParts['host'];
            }else{
                throw new Exception("unexcepted category url:there is no  part of 'host'({$categoryUrl})");
            }
            if(isset($cURLParts['port']))
            {
                $parts['port']=$cURLParts['port'];
            }
            if(preg_match('/^[^\/]/',$parts['path']))
            {
                $cURLParts=parse_url($categoryUrl);
                $upOneDir=$this->_upOneDir($cURLParts['path']);
                $parts['path']='/'.$upOneDir.'/'.$parts['path'];
            }
            return Base_Url::buildUrl($parts);
        }
    }
    protected function _upOneDir($path)
    {
        $path=trim($path,'/');
        $items=  explode('/', $path);
        array_pop($items);
        return implode('/', $items);
    }
}
?>