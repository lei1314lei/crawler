<?php

class OneTwoTwo_GD_PublicityPage extends Website_Page
{
    //https://gd.122.gov.cn/publicitypage?size=20&page=1&tjyf=201802&fzjg=%E7%B2%A4A&fwdmgl=3001
    CONST Q_MONTH='tjyf'; 
    CONST Q_ZONE='fzjg';
    CONST Q_TYPE='fwdmgl';
    
    public function __construct(Array $queries) {
        $pageUrl=$this->_url($queries);
        parent::__construct($pageUrl, 122);
    }
    protected function _url($queries)
    {
        $uri='https://gd.122.gov.cn/publicitypage';
        $partsUrl=parse_url($uri);
        $partsUrl['query']=  implode('&', $queries);
        return Base_Url::buildUrl($partsUrl);
    }
    public function getItemsData()
    {
        $theadTDs=$this->getElesBySelector('thead')->find('td')->elements;
        $lineOfData['Title']=$this->_scanTDsVal($theadTDs);
        $bodyTrs=$this->getElesBySelector('tbody')->find('tr')->elements;

        foreach($bodyTrs as $key=>$bodyTr)
        {
            $TDs=array();
            foreach($bodyTr->childNodes as $i=>$node)
            {
                if($node instanceof DOMElement)
                {
                    $TDs[]=$node;
                }
            }
            $lineOfData[]=$this->_scanTDsVal($TDs);
           
        }
        return $lineOfData;
    }
    /*
     * return array($tdVal,$tdVal....)
     */
    protected function _scanTDsVal(Array $rwoOfTds)
    {
        $vals=array();
        foreach($rwoOfTds as $key=>$TD)
        {
            $nodeVal=$TD->nodeValue;
            $vals[]=$nodeVal;
        }
        return $vals;
    }
    public function totalOfPages()
    {
       $html=$this->getPageDoc()->htmlOuter();
       preg_match('/<a.*href="(.*)".*末页/',$html,$matches);
       $lastPageHref=$matches[1];
       $partsUrl=parse_url($lastPageHref);
       $queryItems=explode('&amp;',$partsUrl['query']);
       preg_match('/page=(\d+)/',$partsUrl['query'],$matches);
       return $matches[1];
    }
    protected static function _allQualityListPages($queryItems)
    {
       $pages=array();
       $firstPage=self::_page(1,$queryItems);
       $totalNumbOfPage=$firstPage->totalOfPages();
       foreach(range(1,$totalNumbOfPage) as $numb)
       {
           $pages[]=self::_page($numb,$queryItems);
       }
       return $pages;
    }
    protected static function _page($pageNumber,$queryItems)
    {
        $queryItems[]='page'.'='.$pageNumber;
//        $queryItems[]=OneTwoTwo_GD_PublicityPage::Q_ZONE.'='.$this->_zoneCode;
//        $queryItems[]=OneTwoTwo_GD_PublicityPage::Q_MONTH.'='.$this->_month;
//        $queryItems[]=OneTwoTwo_GD_PublicityPage::Q_TYPE.'='.self::Q_TYPE_VALUE;
        $page=new OneTwoTwo_GD_PublicityPage($queryItems);
        return $page;
    }
    /*
     * $queryItems  Array Format as:array('qField=qValue','qField=qValue')
     */
    public static function getAllItemsFromPaginations($queryItems)
    {
        $pages=self::_allQualityListPages($queryItems);
        $items=array();
        foreach($pages as $page)
        {
            //$partItems=$this->_getQualityItemsFromPage($page);
            $partItems=$page->getItemsData();
            $items=array_merge($items,$partItems);
        }
        return $items;
    }
}

