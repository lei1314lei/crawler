<?php

class Hansgrohe_Action_ExtractAllProdsUrlInfo
{
    protected $_hnsgrhProdUrlSuccessLogger;
    protected $_hnsgrhProdUrlFailLogger;
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
        return $prodsUrlInfo;
    }
    protected function _initLogger()
    {
        $this->_hnsgrhProdUrlSuccessLogger =new log("hansgrohe_prodUrl.log");
        $this->_hnsgrhProdUrlFailLogger=new log("hansgrohe_prodUrl_failed.log");
        $this->_exceptionLoger=new Base_ExceptionLogger('exception.log');
    }
    protected function _getProdsUrlInfo($categoryUrl,$print)
    {

        static $timer=0;
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
                $selector=$categoryPagination->prodLinkSelector();
                $attr=$categoryPagination->getHrefAttr();
                $infos=$categoryPagination->getProdsUrlInfo($selector,$attr);
                $timer++;
                if($print)
                {
                    echo "Success to extract product url from pagination($timer) \r\n";
                }
                $this->_hnsgrhProdUrlSuccessLogger->addRow(json_encode($infos)."\r\n");  
            } catch (Website_ElementException $ex) {
                $page=$ex->getObject();
                $msg="pagination failed to get product urls.";
                $error=array("msg"=>$msg,"page-url"=>$page->getPageUrl());
                $this->_hnsgrhProdUrlFailLogger->addRow($msg);
                continue;
            }catch(Exception $ex){
                $this->_exceptionLoger->record($ex);
            }
            $prodsUrlInfo=  array_merge($prodsUrlInfo,$infos);
        }
        
        
        
        return $prodsUrlInfo;
    }
}