<?php

class Hansgrohe_Action_DownloadAllProductsPage1
{
    public function execute($print=false)
    {
        $action=new Hansgrohe_Action_ExtractAllProdsUrlInfo();
        $allPrudsUrlInfo=$action->execute($print);
        
        //$origItems[]=array_shift($allPrudurlInfo);
        $origItems=$allPrudsUrlInfo;
        $origItems=  array_slice($origItems, 0,100);
        
        $loader=new Base_MultiLoader();
        $loader->setItemsToLoad($origItems,'value')
                ->disableSSLVerify();
        $loader->execute();
        
        $items=$loader->getItemsLoaded();
        
        foreach($items as $key=>$item)
        {
            
            $url=$item[Base_MultiLoader::KEY_URL];
            if(Base_MultiLoader::isItemLoadedSucess($item))
            {
                $prodPage=new Hansgrohe_Product($url);
                $prodPage->setPageCode('test');
                $prodPage->setPageDoc($item[Base_MultiLoader::KEY_LOADED_CONTENT]);
                $loadRst="MultiLoader Success To Load Product Page($key): \r\n Page URL:$url \r\n For for page cahce".website_page::cacheKey($url);
            }else{
                $error=$item[Base_MultiLoader::KEY_ERROR];
                var_dump($error);
                $loadRst="MultiLoader Fail To Load Product Page:$url \r\n";
            }
            if($print)
            {
                echo $loadRst;
            }
        }
    }
}