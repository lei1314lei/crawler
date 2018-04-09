<?php

class OneTwoTwo_GD_Action_ExaminationRoom_NumbOfExamineeList
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
        $queryItems[]=OneTwoTwo_GD_PublicityPage::Q_TYPE.'='.OneTwoTwo_GD_PublicityPageType::TYPE_NUMBER_OF_EXAMINEE;
        $items=OneTwoTwo_GD_PublicityPage::getAllItemsFromPaginations($queryItems);
        return $items;
    }
}