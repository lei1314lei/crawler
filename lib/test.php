<?php
/**
 * Created by PhpStorm.
 * User: Joy
 * Date: 4/18/2016
 * Time: 2:30 PM
 */
$patter = "/asasas(Product description|产品描述|产品特点：)dddddd/";
preg_match($patter,"asasasProduct descriptiondddddd",$matches);
var_dump($matches);exit;

$string = " 31360000";
//$full_string = ",,,31360000";
var_dump(trim($string,""));
var_dump(str_replace("","",$string));
var_dump(mb_detect_encoding($full_string));
var_dump(mb_detect_encoding($string));exit;
var_dump(trim($string));exit;
function autoload2($class_name){

}
preg_match('@<meta[^>]+http-equiv\\s*=\\s*(["|\'])Content-Type\\1([^>]+?)>@i',
    $markup, $matches
);
$markup = '<meta charset="gbk">';
$patter="@<meta[^>]+(charset)\\s*=\\s*[\"'](.+)[\"']>@i";
preg_match($patter,
    $markup, $matches
);
var_dump($matches);
//class autoload {
//    public static function load($class ){
//
//        if(file_exists($class.'.php')) {
//            echo "autoload::load is evoking" .$class;
//            echo "</br>";
//            require_once $class . '.php';
//        }
//    }
//}
// function load($class ){
//    if(file_exists($class)) {
//        echo "autoload::load is evoking" .$class;
//        require_once $class . '.php';
//    }
//}
//function test($class){
//    echo " running to here now";
//    echo "</br>";
//}
//function __autoload($class_name) {
//
//    $path = str_replace('_', '/', $class_name);
//    echo "Default autoload is evoling ".$class_name;;
//    require_once $path . '.php';
//}
////spl_autoload_register(array('autoload','load' ));
//spl_autoload_extensions(".php");
//spl_autoload_register();
////spl_autoload_register("test");
////include("CallbackParam.php");
////$callback = new CallbackParam();
//
////var_dump($callback->tt);
////var_dump(CallbackParam->defaultDoctype);
////$callback = new CallbackParam();
////var_dump($callback::defaultDoctype)
//$file = "test.txt";
//$ft=fopen($file,"a+");
//fwrite($ft,"afafafafaf3535353afaf");
