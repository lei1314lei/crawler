<?php

class Hansgrohe_Action_DownloadAllProductsPage
{
    public function tmp($print)
    {
//        $action=new Hansgrohe_Action_ExtractAllProdsUrlInfo();
//        $allPrudsUrlInfo=$action->execute($print);
        new Base_Logger_Crawler();
        foreach($allPrudsUrlInfo as $key=>$info )
        {
            $url=$info['value'];
            $prodPage=new Hansgrohe_Product($url);
            //$prodPage->setPageDoc($item[Base_MultiLoader::KEY_LOADED_CONTENT]);
            $prodPage->getPageDoc();
            if($print)
            {
                $loadRst="MultiLoader Success To Load Product Page($key):$url \r\n";
                echo $loadRst;
            }
        }
    }
    public function execute($print=false)
    {
        $action=new Hansgrohe_Action_ExtractAllProdsUrlInfo();
        $allPrudsUrlInfo=$action->execute($print);
        
        //$origItems[]=array_shift($allPrudurlInfo);
        $origItems=$allPrudsUrlInfo;
        $origItems=  array_slice($origItems, 0,2);
        
        $loader=new Base_MultiLoader();
        $loader->setItemsToLoad($origItems,'value')
                ->disableSSLVerify();
        $loader->execute();
        
        $items=$loader->getItemsLoaded();
        
        foreach($items as $key=>$item)
        {
            
            $url=$item[Base_MultiLoader::KEY_URL];
            if(isset($item[Base_MultiLoader::KEY_ERROR]))
            {
                $error=$item[Base_MultiLoader::KEY_ERROR];
                var_dump($error);
                $loadRst="MultiLoader Fail To Load Product Page:$url \r\n";
            }else{
                $prodPage=new Hansgrohe_Product($url);
                $prodPage->setPageDoc($item[Base_MultiLoader::KEY_LOADED_CONTENT]);
                $loadRst="MultiLoader Success To Load Product Page:$url \r\n";
            }
            if($print)
            {
                echo $loadRst;
            }
        }
    }
}