<?php



require_once (_BASE_DIR_."/setting.php");

$include_path[]= realpath(dirname(dirname(__FILE__)));
set_include_path(implode(PS,$include_path) .PS.get_include_path());



//$filename=_LOG_DIR_.DS."hansgrohe_prodUrl.log";
//$handle = @fopen($filename, "r");
//if ($handle) {
//    while (($row = fgets($handle, 4096)) !== false) {
//        $info=json_decode($row);
//        $prodsUrl[]=$info->value;
//    }
//    if (!feof($handle)) {
//        echo "Error: unexpected fgets() fail\n";
//    }
//    fclose($handle);
//}

//return;



$EXCEPTIONLOGGER=new Base_ExceptionLogger('exception.log');
$hnsgrhProdUrlSuccessLogger=new log("hansgrohe_prodUrl.log");
$hnsgrhProdUrlFailLogger=new log("hansgrohe_prodUrl_failed.log");
$hnsgrhImgInfoSuccessLogger=new log("hansgrohe_imgInfo.log");
$hnsgrhImgInfoFailLogger=new log("hansgrohe_imgInfo_failed.log");


$prodUrl="https://www.hansgrohe.de/articledetail-logis-einhebel-kuechenmischer-120-coolstart-71837000";
$prodPage=new Hansgrohe_Product($prodUrl);
$prodPage->sitecode="Hansgrohe";
$prodPage->getPageDoc(); exit;
//$prodPage->setPageDoc($html);



//
//$cateogryUrls=array(
//    'https://www.hansgrohe.de/kueche/produkte',
//   // 'https://www.hansgrohe.de/bad/produkte'
//    );
//$categoryUrl= 'https://www.hansgrohe.de/kueche/produkte';
//$prodUrls=array();
//$categoryPagination=new Hansgrohe_CategoryPagination($categoryUrl);
//$HansgrohePaginationSet=new Hansgrohe_Category($categoryPagination);
//
//$paginations=$HansgrohePaginationSet->getAllPaginations();
//$prodUrlInfos=array();
//foreach($paginations as $categoryPagination)
//{
//    try{
//        $selector=$categoryPagination->prodLinkSelector();
//        $attr=$categoryPagination->getHrefAttr();
//        $infos=$categoryPagination->getProdsUrlInfo($selector,$attr);
//        var_dump($infos);exit;
//        $hnsgrhProdUrlSuccessLogger->addRow(json_encode($infos)."\r\n");  
//    } catch (Website_ElementException $ex) {
//        $page=$ex->getObject();
//        $msg="pagination failed to get product urls.";
//        $error=array("msg"=>$msg,"page-url"=>$page->getPageUrl());
//        $hnsgrhProdUrlFailLogger->addRow($msg);
//        continue;
//    }catch(Exception $ex){
//        $EXCEPTIONLOGGER->record($ex);
//    }
//    $prodUrlInfos=  array_merge($prodUrlInfos,$infos);
//}
//var_dump($prodUrlInfos);exit;


$prodsUrl=array(
    "https://www.hansgrohe.de/articledetail-logis-einhebel-kuechenmischer-120-coolstart-71837000",
    "https://www.hansgrohe.de/articledetail-logis-classic-2-griff-kuechenmischer-wandmontage-highspout-71286000"
);
$imgsInfo=array();
foreach($prodsUrl as $prodUrl)
{
    $prodPage=new Hansgrohe_Product($prodUrl);
    $prodPage->siteCode="Hansgrohe";
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



echo 'ok';exit;









