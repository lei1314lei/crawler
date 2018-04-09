<?php
//CREATE TABLE `driverschool_quality` (
// `zone` varchar(255) NOT NULL,
// `school_name` varchar(255) NOT NULL,
// `rate_illegal` varchar(10) NOT NULL COMMENT '3年内驾龄 交通违法率',
// `rate_accident` varchar(10) NOT NULL COMMENT '3年内驾龄 交通肇事率',
// `max_examinee` int(10) NOT NULL COMMENT '最大 培训人数',
// `rate_pass_sbj_1` varchar(10) NOT NULL COMMENT '科目一考试合格率',
// `rate_pass_sbj_2` varchar(10) NOT NULL COMMENT '科目二考试合格率',
// `month` int(6) NOT NULL,
// UNIQUE KEY `month` (`month`,`zone`,`school_name`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8
class OneTwoTwo_GD_Action_Persistence_GDDriverSchoolQuality
{
    protected $_month;
    public function __construct($month) {
        $this->_month=$month;
    }

    protected function _convertToTabCols(Array $titleRow,$allMatch=true)
    {
        $cols=array();
        foreach($titleRow as $title)
        {
            switch ($title) {
                case '驾校名称':
                    $cols[]="school_name";
                    break;
                case '3年内驾龄交通违法率':
                    $cols[]="rate_illegal";
                    break;
                case '3年内驾龄交通肇事率':
                    $cols[]="rate_accident";
                    break;
                case '最大培训人数':
                    $cols[]="max_examinee";
                    break;
                case '科目一考试合格率':
                    $cols[]="rate_pass_sbj_1";
                    break;
                case '科目二考试合格率':
                    $cols[]="rate_pass_sbj_2";
                    break;
            }
        }
        if($allMatch)
        {
            if(!$cols || count($cols)!==count($titleRow)) throw new Exception("Unexcepted total number of table cols");
        }
        return $cols;
    }
    public function execute()
    {
        $month=$this->_month;
        foreach($this->_allZoneCodesOfGD() as $zone)
        {
            $action=new OneTwoTwo_GD_Action_DriverSchool_QualityList($month,$zone);
            $logFileName=mb_convert_encoding($zone, "gb2312").'_DriverSchool_Quality_'.$month.'.log';
            $items=$action->execute();
            $titleItem=$items['Title'];
            $tabCols=$this->_convertToTabCols($titleItem);
             unset($items['Title']);
            $this->_persistence($tabCols, $items,$month,$zone);
            //  $this->_log($logFileName, $items);
        }
    }
    protected function _persistence(Array $tabCols, Array $rowItems,$month,$zone)
    {

        $lnk = mysql_connect('localhost', 'root', '')
               or die ('Not connected : ' . mysql_error());

        // make foo the current db
        mysql_select_db('gd122', $lnk) or die ('Can\'t use foo : ' . mysql_error());
        
        
        $tabCols[]='month';
        $tabCols[]='zone';
        $query='';
        //$query="set character_set_client=utf8;";
        $query.="insert IGNORE  into DriverSchool_Quality (".implode(',',$tabCols).") value ";
        $valueItemsForTab=array();
        foreach($rowItems as $rowData)
        {
            $rowData[]=$month;
            $rowData[]=$zone;
           
            $valueItemsForTab[]=" ('" .implode("','",$rowData) . "')";
        }
        $query.=implode(',',$valueItemsForTab)." ;";
        
        $this->_query("set names utf8");
        $this->_query($query);
    }
    protected function _query($query)
    {
        $result=mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
    }
    protected function _log($logFileName,$items)
    {
        $logger=new log($logFileName);
        foreach($items as $item)
        {
            $logger->addRow(implode(',', $item));
        }
    }
    protected function _allZoneCodesOfGD()
    {
        return OneTwoTwo_GD_Zone::allZoneCodeVals();
    }
}
