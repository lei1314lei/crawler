<?php

class Base_Url{
   static public function buildUrl($parts)
   {
        if(isset($parts['scheme']))
        {
            $return=$parts['scheme']?$parts['scheme']:'http';
            $return.="://";;
        }
        if(isset($parts['host']))
        {
            $return.=$parts['host'];
        }else{
            throw new Exception("there must be host in the parts of URL:".  json_encode($parts));
        }
        if(isset($parts['port']))
        {
            $return.=":".$parts['port'];
        }
        $return.=$parts['path'];
        if(isset($parts['query']))
        {
            $return.="?".$parts['query'];
        }
        if(isset($parts['fragment']))
        {
            $return.="#".$parts['query'];
        }
        return $return;
   }
}

