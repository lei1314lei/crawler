<?php

class OneTwoTwo_GD_Zone
{
    CONST CODE_GZ   ="粤A";  //广州
    CONST CODE_SZ   ="粤B";  //深圳
    CONST CODE_ZH   ="粤C";  //珠海
    CONST CODE_ST   ="粤D";  //汕头
    CONST CODE_FS   ="粤E";  //佛山
    CONST CODE_SG   ="粤F";  //韶关
    CONST CODE_ZJ   ="粤G";  //湛江
    CONST CODE_ZQ   ="粤H";  //肇庆
    CONST CODE_JM   ="粤J";  //江门
    CONST CODE_MM   ="粤K";  //茂名
    CONST CODE_HZ   ="粤L";  //惠州
    CONST CODE_MZ   ="粤M";  //梅州
    CONST CODE_SW   ="粤N";  //汕尾
    CONST CODE_HY   ="粤P";  //河源
    CONST CODE_YJ   ="粤Q";  //阳江
    CONST CODE_QY   ="粤R";  //清远
    CONST CODE_DG   ="粤S";  //东莞
    CONST CODE_ZS   ="粤T";  //中山
    CONST CODE_CZ   ="粤U";  //潮州
    CONST CODE_JY   ="粤V";  //揭阳
    CONST CODE_YF   ="粤W";  //云浮
    
    public static function allZoneCodeVals()
    {
        $oClass = new ReflectionClass(__CLASS__);
        $cProperties=$oClass->getConstants();
        $return=array();
        foreach($cProperties as $CSTkey=>$codeVal)
        {
            if(preg_match('/CODE_/',$CSTkey))
            {
                $return[]=$codeVal;
            }
        }
        return $return;
    }
}
