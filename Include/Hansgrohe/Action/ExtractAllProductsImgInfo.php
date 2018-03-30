<?php

class Hansgrohe_Action_ExtractAllProductsImgInfo
{
    protected $_failedItems;

    const LOG_FILE_FAILED="hansgrohe_imgInfo_failed.log";
    const LOG_FILE_SUCCESS="hansgrohe_imgInfo.log";
    protected $_successLogger;
    protected $_failLogger;
    protected $_exceptionLogger;
    
    protected function _initLogger()
    {
        $this->_successLogger=new Base_Logger_Crawler(SELF::LOG_FILE_SUCCESS);
        $this->_failLogger=new Base_Logger_Crawler(self::LOG_FILE_FAILED);
        $this->_exceptionLogger=new Base_ExceptionLogger('exception.log');
    }
    protected function _unsetLogger()
    {
        $this->_successLogger=null;
        $this->_failLogger=null;
        $this->_exceptionLoger=null;
    }
    public function execute($print)
    {
        $this->_initLogger();
       // set_time_limit(120); 
        $action=new Hansgrohe_Action_ExtractAllProdsUrlInfo();
        $allPrudsUrlInfo=$action->execute($print);
        $allImgsInfo=array();
        foreach($allPrudsUrlInfo as $key=>$info)
        {
            $prodUrl=$info[Website_Page_Pagination_Category::DATA_PROD_URL];
            $prodPage=new Hansgrohe_Product($prodUrl);

            try{
                $imgsInfo=$prodPage->getProdImgsInfo();
                $this->_logSuccessItems($imgsInfo); 
                $allImgsInfo=array_merge($allImgsInfo,$imgsInfo);
                
                
                $otherSmpImgsInfos=$prodPage->getProImgsInfoFromOtherSmpProdPage();
                $this->_logSuccessItems($otherSmpImgsInfos);
                $allImgsInfo=array_merge($allImgsInfo,$otherSmpImgsInfos);
                
                
                static $timer=0;
                $timer++;
                $msg="Success to extract imgs from product($timer)";
                if($print)
                {
                     echo $msg."\r\n";
                }

            } catch (Website_ElementException $ex) {
                $this->_failLogger->logEx($ex);
                continue;
            }catch(Exception $ex)
            {
                $this->_exceptionLogger->record($ex);
            }
        }
        $this->_unsetLogger();
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

