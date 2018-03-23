<?php


define("_BASE_DIR_",dirname(dirname(dirname(__FILE__))));
require_once (_BASE_DIR_."/setting.php");

$include_path[]= realpath(dirname(dirname(__FILE__)));
set_include_path(implode(PS,$include_path) .PS.get_include_path());

define("_DATA_DIR_",dirname(__FILE__).DS."data");
define("DATA_DOWNLOAD_DIR",dirname(__FILE__).DS."download");
define("CURRENT_DIR",dirname(__FILE__));




$listPageUrls=array(
    'https://www.hansgrohe.de/kueche/produkte',
    'https://www.hansgrohe.de/bad/produkte');

$categoryUrl='https://www.hansgrohe.de/kueche/produkte?page=1';

$categoryPagination=new Hansgrohe_CategoryPagination($categoryUrl);
$HansgrohePaginationSet=new Hansgrohe_Category($categoryPagination);
$urls=$HansgrohePaginationSet->getAllProdsUrlInfo();
var_dump($urls); exit;