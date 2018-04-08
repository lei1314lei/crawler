<?php
$include="../../EnvInit.php";
include_once $include;
class DownloadProductImg_Shell extends Shell{

    public function run() {
        if($this->getCmd("help")) {
            echo $this->usageHelp();
        }else{
            foreach($this->_cmds as $cmd=>$v)
            {
                $params=$this->getParams($cmd);
                call_user_func_array(array($this,$cmd),$params);
            }
        }
    }
    public function downloadHqPics()
    {
        $logger=new Base_Logger_Crawler("v2_lq_hansgrohe_imgInfo.log");
        $imgsInfo=$logger->readAllRows();
        foreach($imgsInfo as $key=>$imgInfo)
        {
            $imgInfo['src']=preg_replace("/\?.+/", "", $imgInfo['src']);
            $imgsInfo[$key]=  $imgInfo;
        }
        $action=new Hansgrohe_Action_DownloadProdImgs();
        $action->setToBeCmdMode();
        $action->batchDownload($imgsInfo);
    }
    public function downloadAllProdsImg()
    {
//        $action=new Hansgrohe_Action_DownloadProdImgs();
//        $action->setToBeCmdMode();
//        $imgsInfo=$this->extractProdsImgInfo('ALL');
        
        $logger=new Base_Logger_Crawler(Hansgrohe_Action_ExtractProductImgsInfo::LOG_FILE_SUCCESS);
        $imgsInfo=$logger->readAllRows();
        
        $action=new Hansgrohe_Action_DownloadProdImgs();
        $action->setToBeCmdMode();
        $action->batchDownload($imgsInfo);
    }
    public function extractProdUrlsInfo()
    {
            $cateogryUrls= array(
                'https://www.hansgrohe.de/bad/produkte',
                'https://www.hansgrohe.de/bad/produkte/duschen',
                'https://www.hansgrohe.de/bad/produkte/armaturen',
                'https://www.hansgrohe.de/bad/produkte/thermostate',
                'https://www.hansgrohe.de/bad/produkte/badaccessoires',
                'https://www.hansgrohe.de/bad/produkte/installationstechnik',
                'https://www.hansgrohe.de/bad/produkte/ablaufsysteme',
                'https://www.hansgrohe.de/bad/produkte/linien',
                'https://www.hansgrohe.de/kueche/produkte',
                'https://www.hansgrohe.de/kueche/produkte/spuelenkombinationen',
                'https://www.hansgrohe.de/kueche/produkte/kuechenarmaturen',
                'https://www.hansgrohe.de/kueche/produkte/kuechenspuelen',
                'https://www.hansgrohe.de/kueche/produkte/linien',
                );
            $action=new Hansgrohe_Action_ExtractProdUrlsInfo();
            $action->setToBeCmdMode();
            $prodUrls=$action->batchExtractFromCategories($cateogryUrls); 
            return $prodUrls;
    }
    public function extractProdsImgInfo($prodUrl='ALL')
    {
        if('ALL'==$prodUrl)
        {
            $prodUrls=$this->extractProdUrlsInfo();
            $action=new Hansgrohe_Action_ExtractProductImgsInfo();
            $action->setToBeCmdMode();
            $imgsInfo=$action->batchExtract($prodUrls);
            return $imgsInfo;
        }else{
            $page = new Hansgrohe_Product($url);
            $imgsInfo=$page->getProdImgsInfo();
            $imgsInfo=  array_merge($imgsInfo,$page->getProImgsInfoFromOtherSmpProdPage());
            foreach($imgsInfo as $imgInfo)
            {
                var_dump($imgInfo);
            }
        }
        
    }
    
    public function downloadProdPage($url='ALL')
    {
       if("ALL"===$url)
       {
         //  var_dump('ALL');exit;
            $action=new Hansgrohe_Action_DownloadAllProductsPage();
           // $action->execute(true);
            $action->tmp(true);
       }else{
        //   var_dump($url);exit;
            $page = new Hansgrohe_Product($url);
            if(false!==$page->getPageDoc())
            {
                echo "Success to download page.  \r\n The key for cache is ".website_page::cacheKey($url);
            }else{
                echo "Failed to  download page.";
            }
       }
    }

    public function usageHelp() {
        return <<<USAGE
Usage:  php -f cmd.php -- [options]
  --downloadHqPics <manufacturer> 
  --downloadAllProdsImg  <manufacturer>  
  --downloadProdPage
  --extractProdUrlsInfo  
  --extractProdsImgInfo  <productUrl>  
        
  all    fetch all <manufacturer> Data
  help                          This help
USAGE;
    }

}
$shell=new DownloadProductImg_Shell();
$shell->run();