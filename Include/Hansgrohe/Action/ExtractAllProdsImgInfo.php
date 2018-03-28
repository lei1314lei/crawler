<?php

class Hansgrohe_Action_ExtractAllProdsImgInfo
{
    protected $_hnsgrhImgInfoSuccessLogger;
    protected $_hnsgrhImgInfoFailLogger;
    protected $_exceptionLogger;
    public function execute($print=false)
    {
        $this->_initLogger();
        $allImgsInfo=$this->_getProdsImgInfo($print);
        return $allImgsInfo;
    }
    protected function _initLogger()
    {
        $this->_hnsgrhImgInfoSuccessLogger=new log("hansgrohe_imgInfo.log");
        $this->_hnsgrhImgInfoFailLogger=new log("hansgrohe_imgInfo_failed.log");
        $this->_exceptionLogger=new Base_ExceptionLogger('exception.log');
    }
    protected function _allProdUrlItems($print)
    {
        $action=new Hansgrohe_Action_ExtractAllProdsUrlInfo();
        $infoes=$action->execute($print);
        $prodUrls=array();
        foreach($infoes as $item)
        {
            $prodUrls[]=array("url"=>$item['value']);
        }
        return $prodUrls;
    }
    protected function _allProdPage($print)
    {
        
//        $prodsUrlItems=array(
//            array('url'=>"https://www.hansgrohe.de/articledetail-logis-einhebel-kuechenmischer-120-coolstart-71837000"),
//            array('url'=>"https://www.hansgrohe.de/articledetail-logis-classic-2-griff-kuechenmischer-wandmontage-highspout-71286000"),
//
//        );
        $prodsUrlItems=$this->_allProdUrlItems($print);
        $cachedProdPages=array();
        $unCachedProdPages=array();
        foreach($prodsUrlItems as $key=>$item)
        {
            $prodUrl=$item['url'];
            $prodPage=new Hansgrohe_Product($prodUrl);
            if($prodPage->isCached())
            {
                $cachedProdPages[$key]=$prodPage;
                unset($prodsUrlItems[$key]);
            }else{
                $unCachedProdPages[$prodUrl]=$prodPage;
            }
        }

        //multithread load uncached $prodsUrlItems
        $loader=new Base_MultiLoader();
        $loader->setItemsToLoad($prodsUrlItems)
                ->disableSSLVerify();
        $loader->execute();
        $items=$loader->getItemsLoaded();

        $prodPages=array();
        foreach($items as $item)
        {
            $prodPage=$unCachedProdPages[$item[Base_MultiLoader::KEY_URL]];
            $prodPage->setPageDoc($item[Base_MultiLoader::KEY_LOAD_CONTENT]);
            $prodPages[]=$prodPage;
        }
        
       return array_merge($prodPages,$cachedProdPages);
    }
    protected function _getProdsImgInfo($print)
   {
        $allProdPage=$this->_allProdPage($print);
        $allImgsInfo=array();
        var_dump(count($allProdPage));
        foreach($allProdPage as $prodPage)
        {
            try{
                $imgInfos=$prodPage->getProdImgs();
                $otherSmpImgsInfos=$prodPage->getProImgsFromOtherSmpProdPage();

                $allImgsInfo=array_merge($allImgsInfo,$imgInfos,$otherSmpImgsInfos);
                if($print)
                {
                    static $timer=0;
                    $timer++;
                    echo "Extract imgs from product($timer)\r\n";
                }
                $this->_hnsgrhImgInfoSuccessLogger->addRow(json_encode($imgInfos));
            } catch (Website_ElementException $ex) {
                $page=$ex->getObject();
                $msg="product page failed to get img urls.";
                $error=array("msg"=>$msg,"ElementException"=>$ex->getMessage(),"page-url"=>$page->getPageUrl());
                var_dump($page->getPageUrl(),Website_Page::cacheKey($page->getPageUrl()),$page->getPageDoc()->htmlOuter());exit;
                $this->_hnsgrhImgInfoFailLogger->addRow(json_encode($error));
                continue;
            }catch(Exception $ex)
            {
                $this->_exceptionLogger->record($ex);
            }
        }
        return $allImgsInfo;
    }
            
}
