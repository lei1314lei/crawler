<?php

class Hansgrohe_Action_ExtractProductImgsInfo extends Hansgrohe_AbstractAction
{
    const LOG_FILE_FAILED="test_hansgrohe_imgInfo_failed.log";
    const LOG_FILE_SUCCESS="test_hansgrohe_imgInfo.log";
    protected function _initLogger()
    {
        $this->_successLogger=new Base_Logger_Crawler(SELF::LOG_FILE_SUCCESS);
        $this->_failLogger=new Base_Logger_Crawler(self::LOG_FILE_FAILED);
        $this->_exceptionLogger=new Base_ExceptionLogger('exception.log');
    }

    
    public function batchExtract($prodUrls)
    {
        $imgsInfo=array();
        foreach($prodUrls as $prodUrl)
        {
            if($this->_cmdMode)
            {
                static $timer=0;
                $timer++;
                $msg="\r\n Extract imgs info from Product($timer)";
                echo $msg;
            }
            $result=$this->extract($prodUrl);
            if(false!==$result)
            {
                $imgsInfo=array_merge($imgsInfo,$result);
            }
        }
        return $imgsInfo;
    }
    
    
    /*
     * returning Array 'imgsInfo' if there are, or else return false
     */
    public function extract($prodUrl)
    {
        $prodPage=new Hansgrohe_Product($prodUrl);

        try{
            $imgsInfo=$prodPage->getProdImgsInfo();
            $this->_logSuccessItems($imgsInfo);
 
            if($prodPage->hasOtherSimpleProds())
            {
                $otherSmpImgsInfos=$prodPage->getProImgsInfoFromOtherSmpProdPage();
                $this->_logSuccessItems($otherSmpImgsInfos);
                $imgsInfo=array_merge($imgsInfo,$otherSmpImgsInfos);
            }
            if($this->_cmdMode)
            {
                $msg="Success to extract imgs from product(ID:{$prodPage->getProductId()}):";
                echo $msg."\r\n";
            }
            return $imgsInfo;
        } catch (Website_ElementException $ex) {
            $this->_failLogger->logEx($ex);
        }catch(Exception $ex)
        {
            $this->_exceptionLogger->record($ex);
        }
        if($this->_cmdMode)
        {
            $msg="Failed to extract imgs from product";
            echo $msg."\r\n";
        }
        return false;
    }
    protected function _logSuccessItems($imgsInfo)
    {
        foreach($imgsInfo as $imgInfo)
        {
            $imgUrl=$imgInfo[Website_Page_Product::DATA_PROD_IMG];
            $this->_successLogger->addRow(Base_Logger_Crawler::key($imgUrl),$imgInfo);
        }
    }
}

