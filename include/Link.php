<?php

class Link 
{
    static protected function _paddingRelativeUrl(Page $page,$path)
    {
        if(self::isRelative($path))
        {
            $return=self::_toFullPath($page,$path);
        }else{
            $return=$path;
        }
        return $return;
    }

    static public function paddingRelativeUrl(Page $page,$path)
    {
          if(is_array($path))
          {
              foreach($path as $v)
              {
                  $return[]=self::_paddingRelativeUrl($page,$v);
              }
              return $return;
          }else{
              return self::_paddingRelativeUrl($page,$path);
          }
    }
    static public function isRelative($path)
    {
        $parts=parse_url($path);
        return isset($parts['host']) ? false:true;
    }
    static protected function _toFullPath($page,$path)
    {
            $pageUrlParts=parse_url($page->getPageUrl());
            $parts=parse_url($path);
            if(isset($pageUrlParts['scheme']))
            {
                $parts['scheme']=$pageUrlParts['scheme'];
            }
            if(isset($pageUrlParts['host']))
            {
                $parts['host']=$pageUrlParts['host'];
            }else{
                throw new Exception("unexcepted page url:there is no  part of 'host'({$categoryUrl})");
            }
            if(isset($pageUrlParts['port']))
            {
                $parts['port']=$pageUrlParts['port'];
            }
            if(preg_match('/^[^\/]/',$parts['path']))
            {
                $pageUrlParts=parse_url($categoryUrl);
                $upOneDir=$this->_upOneDir($pageUrlParts['path']);
                $parts['path']='/'.$upOneDir.'/'.$parts['path'];
            }
            return Base_Url::buildUrl($parts);
    }
}

