<?php
//CREATE TABLE `examinees_in_each_room` (
// `zone` varchar(255) NOT NULL,
// `date` int(6) NOT NULL,
// `room_name` varchar(255) NOT NULL,
// `numb_sbj_1` varchar(10) NOT NULL COMMENT '科目一考试人数',
// `numb_sbj_2` varchar(10) NOT NULL COMMENT '科目二考试人数',
// `numb_sbj_3` varchar(10) NOT NULL COMMENT '科目三考试人数',
// `numb_sbj_4` varchar(10) NOT NULL COMMENT '安全文明考试人数',
// UNIQUE KEY `month` (`date`,`zone`,`room_name`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8
class OneTwoTwo_GD_Action_Persistence_GDExamineesInEachExmRoom
{
    protected $_tab="examinees_in_each_room";
    protected $_db='gd122';


    protected function _convertToTabCols(Array $titleRow,$allMatch=true)
    {
        $cols=array();
        foreach($titleRow as $title)
        {
            switch ($title) {
                case '日期':
                    $cols[]="date";
                    break;
                case '考场名称':
                    $cols[]="room_name";
                    break;
                case '科目一考试人数':
                    $cols[]="numb_sbj_1";
                    break;
                case '科目二考试人数':
                    $cols[]="numb_sbj_2";
                    break;
                case '科目三考试人数':
                    $cols[]="numb_sbj_3";
                    break;
                case '安全文明考试人数':
                    $cols[]="numb_sbj_4";
                    break;
            }
        }
        if($allMatch)
        {
            var_dump($cols,$titleRow);
            if(!$cols || count($cols)!==count($titleRow)) throw new Exception("Unexcepted total number of table cols");
        }
        return $cols;
    }
    public function execute()
    {
        $dateTime=new DateTime();
        $interval=new DateInterval('P2M');
        $dateTime->sub($interval);
        $month=$dateTime->format('Ym');
        foreach($this->_allZoneCodesOfGD() as $zone)
        {
            $action=new OneTwoTwo_GD_Action_ExaminationRoom_NumbOfExamineeList($month,$zone);
            $logFileName=mb_convert_encoding($zone, "gb2312").'_Examinee_in_ech_ExmRoom_'.$month.'.log';
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
        mysql_select_db($this->_db, $lnk) or die ('Can\'t use foo : ' . mysql_error());
        
        
        $tabCols[]='zone';
        $query='';
        //$query="set character_set_client=utf8;";
        $query.="insert IGNORE  into {$this->_tab} (".implode(',',$tabCols).") value ";
        $valueItemsForTab=array();
        foreach($rowItems as $rowData)
        {
            $rowData[]=$zone;
           
            $valueItemsForTab[]=" ('" .implode("','",$rowData) . "')";
           //  var_dump($tabCols,$valueItemsForTab);exit;
        }
        $query.=implode(',',$valueItemsForTab)." ;";
        
        echo $query;
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
