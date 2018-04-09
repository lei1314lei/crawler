<?php

class OneTwoTwo_GD_SubjectType
{
    CONST TYPE_1='科目一';
    CONST TYPE_2='科目二';
    CONST TYPE_3='科目三';
    CONST TYPE_4='科目四';
    public static function subjectName($numb)
    {
        $name='';
        switch ($numb) {
            case 1:
                $name=OneTwoTwo_GD_SubjectType::TYPE_1;
                break;
            case 2:
                $name=OneTwoTwo_GD_SubjectType::TYPE_2;
                break;
            case 3:
                $name=OneTwoTwo_GD_SubjectType::TYPE_3;
                break;
            case 4:
                $name=OneTwoTwo_GD_SubjectType::TYPE_4;
                break;
        }
        return $name;
    }
}

