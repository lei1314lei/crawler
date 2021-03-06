<?php

class Hansgrohe_Action_DownloadProdImgs extends Hansgrohe_AbstractAction
{
    const LOG_FILE_FAILED="hansgrohe_prodImg_download_fail.log";
    const LOG_FILE_SUCCESS="hansgrohe_prodImg_download_success.log";
    protected $_failLogger;
    protected $_successLogger;
    protected function _initLogger()
    {
        $this->_failLogger=new Base_Logger_Crawler(self::LOG_FILE_FAILED);
        $this->_successLogger=new Base_Logger_Crawler(self::LOG_FILE_SUCCESS);
    }
    
    public function download($imgInfo,$overWrite=false)
    {
        $src=$imgInfo['src'];
        $imgName=$imgInfo['imgName'];
        $fullPath=_DOWNLOAD_.DS."hansgrohe".DS."prodImg".DS. $imgName.'.png';
        if(file_exists($fullPath) && !$overWrite)
        {
            $this->_successLogger->addRow(Base_Logger_Crawler::key($src),$imgInfo);
            $msg="Prod Img($imgName):Didn't dowload for the reason that is has already existed";
        }else{
            if($this->_downLoadImg($src,$fullPath))
            {
                $msg="Prod Img($imgName):Success to download";
                $this->_successLogger->addRow(Base_Logger_Crawler::key($src),$imgInfo);
            }else{
                $msg="Prod Img($imgName):Fail to download";
                $imgInfo["downloadError"]=error_get_last();
                $this->_failLogger->addRow(Base_Logger_Crawler::key($src),$imgInfo);
            }
        }
        if($this->_cmdMode)
        {
            echo $msg."\r\n";
        }
    }
    public function batchDownload($imgsInfo)
    {
        static $timer=0;
        foreach($imgsInfo as $info)
        {
            if($this->_cmdMode)
            {
                $timer++;
                echo    "Download Prod Img($timer):";       
            }
            $this->download($info);
        }
    }
    
//    
//    protected function _allImgsInfo($print)
//    {
//        $action=new Hansgrohe_Action_ExtractAllProductsImgInfo();
//        $action->execute($print);
//        
//        $logger=new Base_Logger_Crawler(Hansgrohe_Action_ExtractAllProductsImgInfo::LOG_FILE_SUCCESS);
//        $allImgsInfo=$logger->readAllRows();
//        return $allImgsInfo;
//    }
//
//    
//    public function execute($print=false,$overWrite=false)
//    {
//        
//        
//        
//        $this->_initLogger();
//        $allImgsInfo=$this->_allImgsInfo($print);
//        foreach($allImgsInfo as $key=>$imgInfo)
//        {
//            $src=$imgInfo['src'];
//            $imgName=$imgInfo['imgName'];
//            $fullPath=_DOWNLOAD_.DS."hansgrohe".DS."prodImg".DS. $imgName.'.png';
//            if(file_exists($fullPath) && !$overWrite)
//            {
//                $msg="Prod Img($key):Didn't dowload for the reason that is has already existed";
//                $this->_successLogger->addRow(Base_Logger_Crawler::key($src),$imgInfo);
//            }else{
//                if($this->_downLoadImg($src,$fullPath))
//                {
//                    $msg="Prod Img($key):Success to download";
//                }else{
//                    $msg="Prod Img($key):Fail to download";
//                    $imgInfo["downloadError"]=error_get_last();
//                    $this->_failLogger->addRow(Base_Logger_Crawler::key($src),$imgInfo);
//                }
//            }
//            if($print)
//            {
//                echo $msg."\r\n";
//            }
//        }
//    }
    protected function _downLoadImg($src,$fullPath)
    {
            $fullPath=mb_convert_encoding($fullPath, "gb2312");
            $data=@file_get_contents($src);
            $result=false;
            if($data)
            {
                //var_dump('breakpoint',$fullPath  );exit;
                $result=@file_put_contents($fullPath, $data);
            }
            return $result;
    }
}