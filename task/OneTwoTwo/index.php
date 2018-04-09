<?php
$include="../../EnvInit.php";
include_once $include;


$action = new OneTwoTwo_GD_Action_Persistence_GDExamineesInEachExmRoom();
$action->execute();exit;

$action = new OneTwoTwo_GD_Action_Persistence_GDDriverSchoolQuality();
$action->execute();exit;


//$targetMonth=201803;
//$targetSbjNumb=3;
//
//$action=new OneTwoTwo_GD_Action_ExaminationRoom_NumbOfExamineeList($targetMonth,OneTwoTwo_GD_Zone::CODE_GZ);
//$items=$action->execute();
//
//
//function colNumbOfExmRoom()
//{
//    return 1;//  
//}
//function colNumbOfSubject($sbjNumb)
//{
//    $return='';
//    switch ($sbjNumb) {
//        case 1:
//        $return=2;
//            break;
//        case 2:
//        $return=3;
//            break;
//        case 3:
//        $return=4;
//            break;
//    }
//    if(!$return) throw new Exception("subject number is out of range");
//    return $return;
//}
//function isExmRoomForSbj($roomName,$sbjNumb)
//{
//    $sbjName=OneTwoTwo_GD_SubjectType::subjectName($sbjNumb);
//    $patter="/$sbjName/";
//    return preg_match($patter,$roomName)?true:false;
//}
//$targetItems=array();
//foreach($items as $key=>$rowData )
//{
//    $colNumbOfExmRoom=colNumbOfExmRoom();
//    $roomName=$rowData[$colNumbOfExmRoom];
//    if($key==="Title" || isExmRoomForSbj($roomName, $targetSbjNumb))
//    {
//        $colNumbOfSubject=colNumbOfSubject($targetSbjNumb);
//        $totalNumbOfExaminee=$rowData[$colNumbOfSubject];
//        $str=$rowData[0]." | $roomName | $totalNumbOfExaminee";
//        
//        $targetItems[]=$str;
//    }
//}
//var_dump($targetItems); 
//exit; 
