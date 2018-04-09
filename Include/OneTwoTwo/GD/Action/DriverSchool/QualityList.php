<?php

class OneTwoTwo_GD_Action_DriverSchool_QualityList
{
    protected $_zoneCode;
    protected $_month;
    public function __construct($month,$zoneCode) {
        $this->_month=$month;  //tjyf=201802
        $this->_zoneCode=urlencode($zoneCode); //fzjg=粤A
    }
    public function execute()
    {
        $queryItems[]=OneTwoTwo_GD_PublicityPage::Q_ZONE.'='.$this->_zoneCode;
        $queryItems[]=OneTwoTwo_GD_PublicityPage::Q_MONTH.'='.$this->_month;
        $queryItems[]=OneTwoTwo_GD_PublicityPage::Q_TYPE.'='.OneTwoTwo_GD_PublicityPageType::TYPE_DRIVER_SCHOOL_QUALITY;
        $items=OneTwoTwo_GD_PublicityPage::getAllItemsFromPaginations($queryItems);
        return $items;
    }
//    protected function _allQualityListPages()
//    {
//       $pages=array();
//       $firstPage=$this->_page(1);
//       $totalNumbOfPage=$firstPage->totalOfPages();
//       foreach(range(1,$totalNumbOfPage) as $numb)
//       {
//           $pages[]=$this->_page($numb);
//       }
//       return $pages;
//    }
//   protected function _totalOfPages()
//   {
//       $page=$this->_page(1);
//       $html=$page->getPageDoc()->htmlOuter();
//       preg_match('/<a.*href="(.*)".*末页/',$html,$matches);
//       $lastPageHref=$matches[1];
//       $partsUrl=parse_url($lastPageHref);
//       $queryItems=explode('&amp;',$partsUrl['query']);
//       preg_match('/page=(\d+)/',$partsUrl['query'],$matches);
//       return $matches[1];
//   }

//   protected function _page($pageNumber)
//    {
//        $queryItems[]='page'.'='.$pageNumber;
//        $queryItems[]=OneTwoTwo_GD_PublicityPage::Q_ZONE.'='.$this->_zoneCode;
//        $queryItems[]=OneTwoTwo_GD_PublicityPage::Q_MONTH.'='.$this->_month;
//        $queryItems[]=OneTwoTwo_GD_PublicityPage::Q_TYPE.'='.self::Q_TYPE_VALUE;
//        $page=new OneTwoTwo_GD_PublicityPage($queryItems);
//        return $page;
//    }

//    /*
//     * return array(array($tdVal,$tdVal....),array($tdVal,$tdVal....)....);
//     */
//    protected function _scanTDsVal(Array $rwoOfTds)
//    {
//        $vals=array();
//        foreach($rwoOfTds as $key=>$TD)
//        {
//            $nodeVal=$TD->nodeValue;
//            $vals[]=$nodeVal;
//        }
//        return $vals;
//    }
//    protected function _getQualityItemsFromPage($page)
//    {
//        $theadTDs=$page->getElesBySelector('thead')->find('td')->elements;
//        $lineOfData['Title']=$this->_scanTDsVal($theadTDs);
//        $bodyTrs=$page->getElesBySelector('tbody')->find('tr')->elements;
//
//        foreach($bodyTrs as $key=>$bodyTr)
//        {
//            $TDs=array();
//            foreach($bodyTr->childNodes as $i=>$node)
//            {
//                if($node instanceof DOMElement)
//                {
//                    $TDs[]=$node;
//                }
//            }
//            $lineOfData[]=$this->_scanTDsVal($TDs);
//           
//        }
//        return $lineOfData;
//    }
}
