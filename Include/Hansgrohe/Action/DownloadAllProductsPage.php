<?php

class Hansgrohe_Action_DownloadAllProductsPage
{
    public function execute($print=false)
    {
        $action=new Hansgrohe_Action_ExtractAllProdsUrlInfo();
        $allPrudsUrlInfo=$action->execute($print);
        
        //$origItems[]=array_shift($allPrudurlInfo);
        $origItems=$allPrudsUrlInfo;
        $loader=new Base_MultiLoader();
        $loader->setItemsToLoad($origItems,'value')
                ->disableSSLVerify();
        $loader->execute();
        
        $items=$loader->getItemsLoaded();
        foreach($items as $key=>$item)
        {
            $error=isset($item[Base_MultiLoader::KEY_ERROR]);
            $url=$item[Base_MultiLoader::KEY_URL];
            if($error)
            {
                $loadRst="MultiLoader Fail To Load Product Page:$url \r\n";
            }else{
                $prodPage=new Hansgrohe_Product($url);
                $prodPage->setPageDoc($item[Base_MultiLoader::KEY_LOAD_CONTENT]);
                $loadRst="MultiLoader Success To Load Product Page:$url \r\n";
            }
            if($print)
            {
                echo $loadRst;
            }
        }
    }
}