<?php

class OneTwoTwo_GD_Action_Log_GDDriverSchoolQuality
{
    public function execute()
    {
        $dateTime=new DateTime();
        $interval=new DateInterval('P2M');
        $dateTime->sub($interval);
        $month=$dateTime->format('Ym');
        foreach($this->_allZoneCodesOfGD() as $zone)
        {
            $action=new OneTwoTwo_GD_Action_DriverSchool_QualityList($month,$zone);
            $logFileName=mb_convert_encoding($zone, "gb2312").'_DriverSchool_Quality_'.$month.'.log';
            $items=$action->execute();
            $this->_log($logFileName, $items);
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
