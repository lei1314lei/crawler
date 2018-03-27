<?php
// autoload
define("DS",DIRECTORY_SEPARATOR);
define("PS",PATH_SEPARATOR);
define("_LIB_DIR_",dirname(__FILE__).DS."lib".DS);
define("_PLUGINS_",dirname(__FILE__).DS."plugins".DS);
define("_INCLUDE_DIR_",dirname(__FILE__)."/include");
define("_LOG_DIR_",dirname(__FILE__)."/log");
define("_DOWNLOAD_",dirname(__FILE__)."/download");
define("DEBUG",true);
// get current page url

// TODO differiate browser and terminal access
//$document_root = str_replace(array("\\","/"),DS,$_SERVER['DOCUMENT_ROOT']);
//$current_file_root = str_replace(array("\\","/"),DS,dirname(__FILE__));
//if($document_root != $current_file_root) { // project document root is not website document root
//    $baseUrl = $_SERVER['SERVER_NAME'].substr($current_file_root,strlen($document_root));
//} else {
//    $baseUrl = $_SERVER['SERVER_NAME'];
//}
//define("_BASE_URL_",$baseUrl);
$include_path[] = _PLUGINS_;
$include_path[] = _LIB_DIR_;
$include_path[] = _INCLUDE_DIR_;
set_include_path(implode(PS,$include_path) .PS.get_include_path());
include_once('functions.php');
include('joy.php');
joy::register();
include_once("lib/index.php");
?>