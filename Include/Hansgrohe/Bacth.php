<?php

define("_BASE_DIR_",dirname(dirname(dirname(__FILE__))));
require_once (_BASE_DIR_."/setting.php");

$include_path[]= realpath(dirname(dirname(__FILE__)));
set_include_path(implode(PS,$include_path) .PS.get_include_path());

define("_DATA_DIR_",dirname(__FILE__).DS."data");
define("DATA_DOWNLOAD_DIR",dirname(__FILE__).DS."download");
define("CURRENT_DIR",dirname(__FILE__));


//
//$prodUrl="https://www.hansgrohe.de/articledetail-metris-select-einhebel-kuechenmischer-320-mit-ausziehauslauf-14884800";
//$prodPage=new Hansgrohe_Product($prodUrl);
//
//
//
//$imgs_1=$prodPage->getProdImgs();
//$imgs_2=array_merge($imgs_1,$prodPage->getProImgsFromOtherSmpProdPage());
//var_dump($imgs_1,$imgs_2);



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

//foreach($imgs_2 as $item)
//{
//    $urls[]=$item['src'];
//}


$urls[]="https://www.hansgrohe.de/service/badausstellung-aquademie";
$urls[]="https://www.hansgrohe.de/service/garantie";

//$urls =array(  
// 'http://m.111cn.net/',  
// 'http://www.111cn.net/',  
// 'http://www.163.com/' 
//);  

?>　