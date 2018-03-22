<?php

require_once ('local.php');

class test {
    protected $_manufucturers;
    public function __construct($manufucture)
    {
        $this->_manufucturers = $manufucture;
    }
    public function fetchProductImgs($manufacturer)
    {
        // check manufacuturer first
//        if(!in_array(strtolower($manufacturer),$this->_manufucturers)) {
//            die ("Valid " .$manufacturer . "\n");
//
//        }
        $file = $this->recordAllProductUrl($manufacturer);

        $urls = csvToarray($file);
        $urls = array_column($urls,0);
        $class = uc_words($manufacturer)."_ProductPage";
        $productpage = new $class(NULL,$urls);
        unset($urls);
        $productpage->_data_download_dir = DATA_DOWNLOAD_DIR . DS . $manufacturer;
        $productpage->loadAllProductImgs();
        echo "get {$manufacturer} product information done" . "\n";
        return;
    }
    public function recordAllProductUrl($manufacturer) {
        $fileName = $manufacturer."products.csv";
        $dir = DATA_DOWNLOAD_DIR . DS . $manufacturer;
        if(is_file($dir .DS.$fileName)) {
            echo $dir .DS.$fileName . " Already exsit, not need to fetch again!";
            return $dir .DS.$fileName;
        }
        $class = uc_words($manufacturer)."_CategoryPage";
        $category = new $class($dir);
        // $duravit_category->product_urls_log_dir = ;
        $category->recordAllProductUrl($fileName);
        echo "get {$manufacturer} product urls done" . "\n";
        return $dir .DS.$fileName;

    }
}

$base_path = dirname(__FILE__).'/photo';

$download_config = array(
    array('https://assets.hansgrohe.com/mam/celum/celum_assets/154__hpa00192_tif.png', $base_path.'/p1.png'),
    array('https://assets.hansgrohe.com/mam/celum/celum_assets/154__hpr01348_tif.png', $base_path.'/p2.png'),
    array('https://assets.hansgrohe.com/mam/celum/celum_assets/154__hpa01434_TIF.png', $base_path.'/p3.png'),
);

//$obj = new Base_BatchDownLoad($download_config, 2, 10);
//$handle_num = $obj->download();
//
//echo 'download num:'.$handle_num.PHP_EOL;

$listPageurl='https://www.hansgrohe.de/kueche/produkte';
function getProdUrls($listPageUrl)
{
    $listPage=new Page($listPageurl);
    $selector=".product-mini__link";

    $hrefs=$listPage->getItemsBySelector($selector,'href');
    $prodUrls=Link::paddingRelativeUrl($listPage, $hrefs);
    var_dump($hrefs,$prodUrls);
    return $prodUrls;
}






$imgs=array();
$logger=new log('LogFile-ProductPage-loadFailed.log');

$imgs=array();
$prodUrl="https://www.hansgrohe.de/articledetail-metris-select-einhebel-kuechenmischer-320-mit-ausziehauslauf-14884800";
$prodPage=new Websitepage_Hansgrohe_Product($prodUrl);
$imgs=$prodPage->getProdImgs();
if($prodPage->hasOtherSimpleProds())
{
    $prodUrls=$prodPage->getOtherSmpProdUrls();
    foreach($prodUrls as $prodUrl)
    {
        $prodPage=new Websitepage_Hansgrohe_Product($prodUrl);
        $imgs=  array_merge($imgs,$prodPage->getProdImgs());
    }
}
var_dump($imgs);exit;




//function prodImg($prodUrl)
//{
//    $prodPage=new Page($prodUrl);
//    
//
//    
//    $selector='.product-images__image img';
//    try{
//       // $src=$prodPage->getItemsBySelector($selector,'data-src');
//        $eles=$prodPage->getItemsBySelector($selector);
//        
//        //
//        $title=strip_tags(pq($ele)->attr('page-title'))
//        if($eles->count()>1)
//        {
//            throw new Exception("there are more than one pic selected by '{$selector}'");
//        }
//        foreach($eles as $ele)
//        {
//            $src=pq($ele)->attr('data-src');
//            
//            $imgs[$src]=
//        }
//    } catch (Page_LoadException $ex) {
//        $logger->addRow($prodUrl);
//    }
//    //is multi product
//    
//    var_dump($src);
//}
//prodImg($prodUrl);
//exit;


foreach($prodUrls as $prodUrl)
{
    $prodPage=new Page($prodUrl);
    $selector='.product-images__image img';
    try{
        $src=$prodPage->getItemsBySelector($selector,'src');
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


