<?php

class Base_ExceptionLogger extends log
{
    public function record(Exception $ex)
    {
        var_dump($ex);exit;
    }
}

