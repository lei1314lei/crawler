<?php

class Hansgrohe_Action_DownloadAllProImgs
{
    const LOG_FILE_FAILED="prodImg_download_fail.log";
    protected $_failLogger;
    protected function _initLogger()
    {
        $this->_failLogger=new Base_Logger_Crawler(self::LOG_FILE_FAILED);
    }
    protected function _allImgs()
    {
        
    }
    public function execute($print=false)
    {
        $allImgs=$this->_allImgs();
        foreach($allImgs as $item)
        {
            $name=$item['name'];
            $src=$item['src'];
            $data=@file_get_contents($src);
            $result=false;
            if($data)
            {
                $result=@file_put_contents($name, $data);
            }
            if(!$result)
            {
                $this->_failLogger->addRow(Base_Logger_Crawler::key($src),$item);
            }
        }
    }
}