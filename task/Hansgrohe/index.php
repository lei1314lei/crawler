<?php
$include="../../EnvInit.php";
include_once $include;


//$eleExLogger=new Base_Logger_Crawler('test.log');
//$page=new Website_Page('http://test.com','test');
//$selector='#haha-';
//$message="this is a test program";
//$ex=new Website_ElementException($page, $selector, $message);
//$eleExLogger->logEx($ex);exit;


            $action=new Hansgrohe_Action_ExtractAllProductsImgInfo();
            $action->execute(true);exit;

$action=new Hansgrohe_Action_ExtractAllProductsImgInfo();
$action->execute();exit;


$timer=time();
//set_time_limit(60);
            $action=new Hansgrohe_Action_DownloadAllProductsPage1();
            $action->execute(true);
           var_dump((time()-$timer)/1000); 
            exit;


        $action=new Hansgrohe_Action_ExtractAllProdsImgInfo();
        $action->execute();
        exit;


$action=new Hansgrohe_Action_ExtractProdUrl();
$infoes=$action->execute();
var_dump($infoes);exit;

//$cateogryUrls=array(
//    'https://www.hansgrohe.de/kueche/produkte',
//    'https://www.hansgrohe.de/bad/produkte'
//    );
//$categoryUrl= 'https://www.hansgrohe.de/kueche/produkte';




//foreach($cateogryUrls as $categoryUrl)
//{
//    $prodsUrlInfo=getProdsUrlInfo($categoryUrl);
//    var_dump($prodsUrlInfo);
//}




exit;






var_dump(count($prodPages));

var_dump(count($cachedProdPages));

foreach($cachedProdPages as $prodPage)
{
    var_dump($prodPage->getProdImgsInfo());
}


echo 'breakpoint';exit;









$imgsInfo=array();
foreach($prodsUrl as $prodUrl)
{
    $prodPage=new Hansgrohe_Product($prodUrl);
    try{
        $imgInfos=$prodPage->getProdImgsInfo();
        $otherSmpImgsInfos=$prodPage->getProImgsInfoFromOtherSmpProdPage();
        
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
$downloader=new Base_MultiLoader();
$downloader->setItemsToLoad($img_2, 'src')
        ->disableSSLVerify();
$downloader->downloadTo("hansgrohe", "hansgrohe.log");exit;