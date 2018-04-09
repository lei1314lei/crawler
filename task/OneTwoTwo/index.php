<?php
$include="../../EnvInit.php";
include_once $include;


$action=new OneTwoTwo_GD_Action_ExaminationRoom_NumbOfExamineeList(201802,OneTwoTwo_GD_Zone::CODE_GZ);
var_dump($action->execute());exit;

$action=new OneTwoTwo_GD_Action_DriverSchool_QualityList(201802,OneTwoTwo_GD_Zone::CODE_GZ);
var_dump($action->execute());exit;








            $action=new Hansgrohe_Action_DownloadAllProductsPage();
           // $action->execute(true);
            $action->tmp(true);
            exit;
            
            
            
            
            $cateogryUrls= array(
                'https://www.hansgrohe.de/bad/produkte',
                'https://www.hansgrohe.de/bad/produkte/duschen',
                'https://www.hansgrohe.de/bad/produkte/armaturen',
                'https://www.hansgrohe.de/bad/produkte/thermostate',
                'https://www.hansgrohe.de/bad/produkte/badaccessoires',
                'https://www.hansgrohe.de/bad/produkte/installationstechnik',
                'https://www.hansgrohe.de/bad/produkte/ablaufsysteme',
                'https://www.hansgrohe.de/bad/produkte/linien',
                'https://www.hansgrohe.de/kueche/produkte',
                'https://www.hansgrohe.de/kueche/produkte/spuelenkombinationen',
                'https://www.hansgrohe.de/kueche/produkte/kuechenarmaturen',
                'https://www.hansgrohe.de/kueche/produkte/kuechenspuelen',
                'https://www.hansgrohe.de/kueche/produkte/linien',
                );
            $action=new Hansgrohe_Action_ExtractProdUrlsInfo();
            $action->setToBeCmdMode();
            $prodUrls=$action->batchExtractFromCategories($cateogryUrls); 
            $action=new Hansgrohe_Action_ExtractProductImgsInfo();
            $action->setToBeCmdMode();
            $imgsInfo=$action->batchExtract($prodUrls);
            exit;
            
            
            $cateogryUrls= array(
                'https://www.hansgrohe.de/bad/produkte',
                'https://www.hansgrohe.de/bad/produkte/duschen',
                'https://www.hansgrohe.de/bad/produkte/armaturen',
                'https://www.hansgrohe.de/bad/produkte/thermostate',
                'https://www.hansgrohe.de/bad/produkte/badaccessoires',
                'https://www.hansgrohe.de/bad/produkte/installationstechnik',
                'https://www.hansgrohe.de/bad/produkte/ablaufsysteme',
                'https://www.hansgrohe.de/bad/produkte/linien',
                'https://www.hansgrohe.de/kueche/produkte',
                'https://www.hansgrohe.de/kueche/produkte/spuelenkombinationen',
                'https://www.hansgrohe.de/kueche/produkte/kuechenarmaturen',
                'https://www.hansgrohe.de/kueche/produkte/kuechenspuelen',
                'https://www.hansgrohe.de/kueche/produkte/linien',
                );
            $action=new Hansgrohe_Action_ExtractProdUrlsInfo();
            $action->setToBeCmdMode();
            $allPrudsUrlInfo=$action->batchExtractFromCategories($cateogryUrls); 
            exit;













$logger=new Base_Logger_Crawler(Hansgrohe_Action_ExtractProductImgsInfo::LOG_FILE_SUCCESS);
$imgsInfo=$logger->readAllRows();

$action=new Hansgrohe_Action_DownloadProdImgs();
$action->setToBeCmdMode();
$action->batchDownload($imgsInfo);
exit;









$prodUrl="https://www.hansgrohe.de/articledetail-raindance-s-kopfbrause-300-1jet-mit-brausearm-27493000";

$action=new Hansgrohe_Action_ExtractProductImgsInfo();
$action->extract($prodUrl);
exit;






$cateogryUrls=array(
    'https://www.hansgrohe.de/kueche/produkte',
    'https://www.hansgrohe.de/bad/produkte'
    );
$action=new Hansgrohe_Action_ExtractProdUrlsInfo();
$allPrudsUrlInfo=$action->batchExtractFromCategories($cateogryUrls); 
//exit;
$prodUrls=array();
foreach($allPrudsUrlInfo as $prodUrlsInfo)
{
    $prodUrls[]=$prodUrlsInfo['prodUrl'];
}
$action=new Hansgrohe_Action_ExtractProductImgsInfo();
$imgsInfo=$action->batchExtract($prodUrls); exit;



$prodUrl="https://www.hansgrohe.de/articledetail-logis-einhebel-waschtischmischer-70-coolstart-mit-zugstangen-ablaufgarnitur-71072000";
$print=true;
$action=new Hansgrohe_Action_ExtractProductImgsInfo();
$action->setToBeCmdMode();
$imgsInfo=$action->extract($prodUrl);
var_dump($imgsInfo);exit;

//$logger=new Base_Logger_Crawler('test.log');
//$row=array("haha",urlencode("Küch"));
//$logger->addRow("this is key3", $row);
//foreach($logger->readAllRows() as $row)
//{
//    var_dump(urldecode($row[1]));
//}
//exit;




            $action=new Hansgrohe_Action_ExtractAllProductsImgInfo();
            $action->execute(true);exit;
//
//
        $action=new Hansgrohe_Action_DownloadAllProImgs();
        $action->execute(true);
        echo 'ok';exit;






//$prodUrl="https://www.hansgrohe.de/articledetail-metris-select-einhebel-kuechenmischer-320-mit-ausziehauslauf-14884000";
//$prodPage=new Hansgrohe_Product($prodUrl);
//$prodPage->getPageDoc();
//exit;
//
//
//$data=$prodPage->getDataTrack();
//var_dump($data);exit;

$action=new Hansgrohe_Action_DownloadAllProImgs();
$action->execute(true);exit;


//$eleExLogger=new Base_Logger_Crawler('test.log');
//$page=new Website_Page('http://test.com','test');
//$selector='#haha-';
//$message="this is a test program";
//$ex=new Website_ElementException($page, $selector, $message);
//$eleExLogger->logEx($ex);exit;







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