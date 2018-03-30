<?php

class Hansgrohe_Action_ExtractAllProdsUrlInfo
{
    const LOG_FILE_FAILED="hansgrohe_prodUrl_failed.log";
    const LOG_FILE_SUCCESS="hansgrohe_prodUrl.log";

    protected $_successLogger;
    protected $_failLogger;
    protected $_exceptionLoger;
    public function execute($print=false)
    {
        $this->_initLogger();
        $cateogryUrls=array(
                'https://www.hansgrohe.de/kueche/produkte',
                'https://www.hansgrohe.de/bad/produkte'
                );
        $prodsUrlInfo=array();
        foreach($cateogryUrls as $categoryUrl)
        {
            $prodsUrlInfo=array_merge($prodsUrlInfo,$this->_getProdsUrlInfo($categoryUrl,$print));
        }
        $this->_unsetLogger();
        return $prodsUrlInfo;
    }
    protected function _initLogger()
    {
        $this->_successLogger =new Base_Logger_Crawler(self::LOG_FILE_SUCCESS);
        $this->_failLogger=new Base_Logger_Crawler(self::LOG_FILE_FAILED);
        $this->_exceptionLoger=new Base_ExceptionLogger('exception.log');
    }
    protected function _unsetLogger()
    {
        $this->_successLogger=null;
        $this->_failLogger=null;
        $this->_exceptionLoger;
        
    }
    protected function _getProdsUrlInfo($categoryUrl,$print)
    {

        
        $hnsgrhImgInfoSuccessLogger=new log("hansgrohe_imgInfo.log");
        $hnsgrhImgInfoFailLogger=new log("hansgrohe_imgInfo_failed.log");


        $prodUrls=array();
        $categoryPagination=new Hansgrohe_CategoryPagination($categoryUrl);
        $HansgrohePaginationSet=new Hansgrohe_Category($categoryPagination);

        $paginations=$HansgrohePaginationSet->getAllPaginations();
        $prodsUrlInfo=array();
        foreach($paginations as $categoryPagination)
        {
            try{
//                $selector=$categoryPagination->prodLinkSelector();
//                $attr=$categoryPagination->getHrefAttr();
//                $infos=$categoryPagination->getProdsUrlInfo($selector,$attr);
                $infos=$categoryPagination->getProdsUrlInfo();
                $this->_logSuccessItems($infos);
                
                $prodsUrlInfo=  array_merge($prodsUrlInfo,$infos);
                static $timer=0;
                $timer++;
                $msg= "Success to extract product url from pagination($timer)";
                if($print)
                {
                    echo $msg."\r\n";
                }
            } catch (Website_ElementException $ex) {
                $this->_failLogger->logEx($ex);
                continue;
            }catch(Exception $ex){
                $this->_exceptionLoger->record($ex);
            }
            
            
        }
        return $prodsUrlInfo;
    }
    
    protected function _logSuccessItems($prodsUrlInfo)
    {
        foreach($prodsUrlInfo as $prodUrlInfo)
        {
            $prodUrl=$prodUrlInfo[Website_Page_Pagination_Category::DATA_PROD_URL];
            $this->_successLogger->addRow(Base_Logger_Crawler::key($prodUrl),$prodUrlInfo);
        }
    }
}