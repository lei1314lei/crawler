<?php

class Hansgrohe_Action_DownloadAllProImgs
{
    const LOG_FILE_FAILED="hansgrohe_prodImg_download_fail.log";
    protected $_failLogger;
    protected function _initLogger()
    {
        $this->_failLogger=new Base_Logger_Crawler(self::LOG_FILE_FAILED);
    }
    protected function _allImgsInfo()
    {
        $logger=new Base_Logger_Crawler(Hansgrohe_Action_ExtractAllProductsImgInfo::LOG_FILE_SUCCESS);
        $allImgsInfo=$logger->readAllRows();
        return $allImgsInfo;
        $allImgsInfo=array();
        foreach($allRows as $item)
        {
            
            $name=$item['imgName'];
            $imgsName[$name][]=$item['src'];
        }
        return $allImgsInfo;
    }
    public function execute($print=false,$overWrite=false)
    {
        $this->_initLogger();
        $allImgsInfo=$this->_allImgsInfo();
        foreach($allImgsInfo as $key=>$imgInfo)
        {
            $src=$imgInfo['src'];
            $imgName=$imgInfo['imgName'];
            $fullPath=_DOWNLOAD_.DS."hansgrohe".DS."prodImg".DS. Hansgrohe_Product::decodeProdImgName($imgName).'.png';
//            $blank="&nbsp;";
//            $str="14884000-1--_Metris Select&nbsp;Einhebe";
//            $test='14884000-1--_Metris Select&nbsp;Einhebel-Küchenmischer 320 mit Ausziehauslauf_';
//            var_dump('breakpoint',$test,$blank,str_replace($blank,' ',$test));exit;
            if($overWrite)
            {
                if(file_exists($fullPath)){
                    $msg="Prod Img($key):Didn't dowload for the reason that is has already existed";
                }
            }else{
                if($this->_downLoadImg($src,$fullPath))
                {
                    $msg="Prod Img($key):Success to download";
                }else{
                    $msg="Prod Img($key):Fail to download";
                    $imgInfo["downloadError"]=error_get_last();
                    $this->_failLogger->addRow(Base_Logger_Crawler::key($src),$imgInfo);
                }
            }
            if($print)
            {
                echo $msg."\r\n";
            }
        }
    }
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