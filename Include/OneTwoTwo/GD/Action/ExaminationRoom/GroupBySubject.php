<?php

class OneTwoTwo_GD_Action_ExaminationRoom_GroupBySubject
{
    protected $_month;
    protected $_zone;
    protected $_subject;
    public function __construct($month,$zone,$subjectNumb) {
        $this->_month=$month;
        $this->_zone=$zone;
    }
    public function execute()
    {
        $action=new OneTwoTwo_GD_Action_ExaminationRoom_NumbOfExamineeList(201802,OneTwoTwo_GD_Zone::CODE_GZ);
        $items=$action->execute();
    }
}

