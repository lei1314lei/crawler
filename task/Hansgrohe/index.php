<?php
$include="../../EnvInit.php";
include_once $include;



$prodsUrlItems=array(
    array('url'=>"https://www.hansgrohe.de/articledetail-logis-einhebel-kuechenmischer-120-coolstart-71837000"),
   // array('url'=>"https://www.hansgrohe.de/articledetail-logis-classic-2-griff-kuechenmischer-wandmontage-highspout-71286000"),
    
);
$cachedProdPages=array();
foreach($prodsUrlItems as $key=>$item)
{
    $prodPage=new Hansgrohe_Product($item['url']);
    if($prodPage->isCached())
    {
        $cachedProdPages[$key]=$prodPage;
        unset($prodsUrlItems[$key]);
    }
}

$downloader=new Base_MultiDownloader();
$downloader->setTargetItems($prodsUrlItems)
        ->disableSSLVerify();
$downloader->execute();
$items=$downloader->getTargetItems();

$prodPages=array();
foreach($items as $item)
{
    $prodPage=new Hansgrohe_Product($item[Base_MultiDownloader::KEY_URL]);
    $prodPage->setPageDoc($item[Base_MultiDownloader::KEY_LOAD_CONTENT]);
    $prodPages[]=$prodPage;
}
var_dump(count($prodPages));

var_dump(count($cachedProdPages));

foreach($cachedProdPages as $prodPage)
{
    var_dump($prodPage->getProdImgs());
}


echo 'breakpoint';exit;









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




$img_2=array(
    array(
        'src'=>'https://assets.hansgrohe.com/mam/celum/celum_assets/154__hpa01862_TIF.png',
        'name' =>  'Metris-',
    ),
    array(
        'src'=>'https://assets.hansgrohe.com/mam/celum/celum_assets/154__hpa01678_tif.png',
        'name' =>  'Metris--_2',
        ),
);
$downloader=new Base_MultiDownloader();
$downloader->setTargetItems($img_2, 'src')
        ->disableSSLVerify();
$downloader->downloadTo("hansgrohe", "hansgrohe.log");exit;