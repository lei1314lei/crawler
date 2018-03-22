<?php

require_once ('../../app.php');

$base_path = dirname(__FILE__).'/photo';

$download_config = array(
    array('https://assets.hansgrohe.com/mam/celum/celum_assets/154__hpa00192_tif.png', $base_path.'/p1.png'),
    array('https://assets.hansgrohe.com/mam/celum/celum_assets/154__hpr01348_tif.png', $base_path.'/p2.png'),
    array('https://assets.hansgrohe.com/mam/celum/celum_assets/154__hpa01434_TIF.png', $base_path.'/p3.png'),
);


$listPageUrls=array(
    'https://www.hansgrohe.de/kueche/produkte',
    'https://www.hansgrohe.de/bad/produkte');

//$listPageurl='';
//function getProdUrls($listPageUrl)
//{
//    $listPage=new Page($listPageurl);
//    $selector=".product-mini__link";
//
//    $hrefs=$listPage->getElesBySelector($selector,'href');
//    $prodUrls=Link::paddingRelativeUrl($listPage, $hrefs);
//    return $prodUrls;
//}

//$categoryPage->getAllProducts($selector,$attrName);
//
//
//
//$hrefs=array();
//foreach($listPageUrls as $listPageUrl)
//{
//    $listPage=new Page($listPageUrl);
////    $selector=".product-mini__link";
////    $hrefs=array_merge($hrefs,$listPage->getElesBySelector($selector,'href'));
//      $hrefs=$listPage->getAllItems($itemSelector,$attrName);
//}
//$prodUrls=Link::paddingRelativeUrl($listPage, $hrefs);
//var_dump($prodUrls);

$categoryUrl='https://www.hansgrohe.de/kueche/produkte?page=1';
$categoryPage=new Hansgrohe_Page_Category($categoryUrl);
$hrefs=$categoryPage->getAllItemsOfCategory(".product-mini__link", 'href'); 
var_dump('haha',$hrefs);
exit;






$prodUrl="https://www.hansgrohe.de/articledetail-metris-select-einhebel-kuechenmischer-320-mit-ausziehauslauf-14884800";
$prodPage=new Hansgrohe_Page_Product($prodUrl);

//$selector=".product-surface.js-surface-selector [href]";
//$ele=$prodPage->getElesBySelector($selector); 
//var_dump($ele->is($selector),$ele->length(),$ele->size(),get_class($ele));
//foreach(get_class_methods($ele) as $m)
//{
//    var_dump($m);
//}
//echo 'breakpoint';exit;


$imgs=$prodPage->getProdImgs();
$imgs=array_merge($imgs,$prodPage->getProImgsFromOtherSmpProdPage());
var_dump($imgs);








$imgs=array();
$logger=new log('LogFile-ProductPage-loadFailed.log');


var_dump($imgs);exit;



foreach($prodUrls as $prodUrl)
{
    $prodPage=new Page($prodUrl);
    $selector='.product-images__image img';
    try{
        $src=$prodPage->getUniqeEleBySelector($selector,'src');
        $imgs[]=$src;
    } catch (Page_LoadException $ex) {
        $logger->addRow($prodUrl);
    }
    var_dump($src);
}
echo '<hr>';
var_dump($imgs);
exit;

$eles=$productPage->getElements($selector);
var_dump($eles->count(),$eles->htmlOuter());exit;






$manufucturer="hansgrohe";
$action=new test($manufucturer);
$action->fetchProductImgs($manufucturer);

//$infos like array('imgUrl'=>$imgUrl,'loaded'=>bool)
$logInfo=array($categoryUrl=array($productUrl=>$infos));
//$category   $product    $img   $loaded

$listPageUrlArray=array(
    $listPageUrl_1,
    $listPageUrl_2,
);

$listPage=new Page($url);
$attrName='href';
$prodUrls=$listPage->getItems($itemsSelector,$attrName);





function getProdPages($prodListPageUrl,$imgSelector)
{
    
}
        
function loadProductImg($prodPageUrl,$imgSelector)
{
    $page=new Page($prodPageUrl);
    $ele=$page->getEle($imgSelector);
    $uri=$ele->getAttr('src');
    $downloader=new Downloader($uri);
    $fileFullPath=$downloader->load();
}



function BatchDownloadProdImgs($imgURIs)
{
    $downloader=new Downloader($imgURIs);
    $fileFullPath=$downloader->load();
}


