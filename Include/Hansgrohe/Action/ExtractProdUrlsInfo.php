<?php

class Hansgrohe_Action_ExtractProdUrlsInfo extends Hansgrohe_AbstractAction
{
    const LOG_FILE_FAILED="test_hansgrohe_prodUrl_failed.log";
    const LOG_FILE_SUCCESS="test_hansgrohe_prodUrl.log";
    protected function _initLogger()
    {
        $this->_successLogger =new Base_Logger_Crawler(self::LOG_FILE_SUCCESS);
        $this->_failLogger=new Base_Logger_Crawler(self::LOG_FILE_FAILED);
        $this->_exceptionLoger=new Base_ExceptionLogger('exception.log');
    }
    /*
     * we expect URLs come from diffrient cateogry 
     */
    public function batchExtractFromCategories($cateogryUrls)
    {
        $prodUrlsInfo=array();
        $allPaginations=array();
        $timer=0;
        $totalNumOfCats=count($cateogryUrls);
        foreach($cateogryUrls as $key=>$categoryUrl)
        {
            $timer=$key+1;
            $categoryPagination=new Hansgrohe_CategoryPagination($categoryUrl);
            $HansgrohePaginationSet=new Hansgrohe_Category($categoryPagination);
            $allPaginations =  array_merge($allPaginations,$HansgrohePaginationSet->getAllPaginations());
            if($this->_cmdMode)
            {
                echo "Successs to get all pagination from category($timer/$totalNumOfCats) \r\n";
            }
        }
        $timer=0;
        $totalNumOfPgntions=count($allPaginations);
        foreach($allPaginations as $key=>$pagination)
        {
            $timer++;
            $prodUrlsInfo=array_merge($prodUrlsInfo,$pagination->getProdsUrlInfo());
            if($this->_cmdMode)
            {
                echo "Successs to extract product Url from category pagination($timer/$totalNumOfPgntions) \r\n";
            }
        }
        $uniProds=$this->_group($prodUrlsInfo);
        $this->_logSuccessItems($uniProds);
        
        if($this->_cmdMode)
        {
            $totalNumOfProdUrls=count($uniProds);
            echo "-----The total number of extracted product URLs info  is  $totalNumOfProdUrls---------\r\n";
        }
        $prodUrls=array();
        foreach($uniProds as $prodUrl=>$onPages)
        {
            $prodUrls[]=$prodUrl;
        }
        return $prodUrls;
    }
    protected function _logSuccessItems($uniProds)
    {
        foreach($uniProds as $prodUrl=>$onPages)
        {
            $this->_successLogger->addRow(Base_Logger_Crawler::key($prodUrl),$onPages);
        }
    }
    protected function _group($prodUrlsInfo)
    {
        $uniProds=array();
        foreach($prodUrlsInfo as $prodUrlInfo)
        {
            $prodUrl=$prodUrlInfo['prodUrl'];
            if(!isset($uniProds[$prodUrl]))
            {
                $uniProds[$prodUrl]['prodUrl']=$prodUrl;
            }
            $uniProds[$prodUrl]['onPages'][]=$prodUrlInfo;

        }
        return $uniProds;
    }
}