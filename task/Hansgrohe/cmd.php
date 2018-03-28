<?php
include_once "../EnvInit";
//$setting='../setting.php';
//var_dump(realpath($setting));
//include_once $setting;
class DownloadProductImg_Shell extends Shell{

    public function run() {
        if($this->getVar("help")) {
            echo $this->usageHelp();
        }elseif($this->getVar("allProductImg")){
            echo $this->getProductImgExhaustively($this->getVar("allProductImg"));
        }else {
            echo "Invalid parameters,please type help to ger more help!";
        }

    }
    
    public function getProductImgExhaustively($haha)
    {
        $EXCEPTIONLOGGER=new Base_ExceptionLogger('exception.log');
        $hnsgrhProdUrlSuccessLogger=new log("hansgrohe_prodUrl.log");
        $hnsgrhProdUrlFailLogger=new log("hansgrohe_prodUrl_failed.log");
        $hnsgrhImgInfoSuccessLogger=new log("hansgrohe_imgInfo.log");
        $hnsgrhImgInfoFailLogger=new log("hansgrohe_imgInfo_failed.log");
        
        $filename=_LOG_DIR_.DS."hansgrohe_prodUrl.log";
        $handle = @fopen($filename, "r");
        if ($handle) {
            while (($row = fgets($handle, 4096)) !== false) {
                $info=json_decode($row);
                $prodsUrl[]=$info->value;
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }
        $imgsInfo=array();
        foreach($prodsUrl as $prodUrl)
        {
            $prodPage=new Hansgrohe_Product($prodUrl);
            try{
                $imgInfos=$prodPage->getProdImgs();
                $otherSmpImgsInfos=$prodPage->getProImgsFromOtherSmpProdPage();

                $imgsInfo=array_merge($imgsInfo,$imgInfos,$otherSmpImgsInfos);
                $hnsgrhImgInfoSuccessLogger->addRow(json_encode($imgInfos));
            } catch (Website_ElementException $ex) {
                $page=$ex->getObject();
                $msg="product page failed to get img urls.";
                $error=array("msg"=>$msg,"page-url"=>$page->getPageUrl());
                $hnsgrhImgInfoFailLogger->addRow(json_encode($error));
                continue;
            }catch(Exception $ex)
            {
                $EXCEPTIONLOGGER->record($ex);
            }

        }
    }

    public function usageHelp() {
        return <<<USAGE
Usage:  php -f cmd.php -- [options]
  --info <manufacturer> fetch <manufacturer> Data 
  --url  <manufacturer>  fetch all manufacturers product urls data
  all    fetch all <manufacturer> Data
  help                          This help
USAGE;
    }

}
$shell=new DownloadProductImg_Shell();
$shell->run();