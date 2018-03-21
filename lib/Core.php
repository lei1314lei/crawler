<?php
/**
 * Created by PhpStorm.
 * User: Joy
 * Date: 5/6/2016
 * Time: 3:40 PM
 */

class Core {
    public $processing;
    public $error;

    static function showProcessing($message) {
        if(DEBUG){
            // use output buffering to show proceessing
            echo str_pad("", 5000) . "\n";
            echo $message;
            echo "</br>";
            flush();
            ob_flush();
        }
//        sleep(2);
        return ;
    }

    //http://www.local.com/download/log/taobao/product_info20160506092729.csv
    // get file url
    /*
     * @param $type. eg:log or skin
     * @param $filename , with relative path
     */
    static function getFileUrl($type,$file) {
        return _BASE_URL_ . DS . "log" .DS. $file;
    }
    /*
     * add css file
     */
    static function addCss($cssfile) {
        $cssFile = self::getFileUrl("skin",$cssfile);
        $string = <<<end
        <link rel="stylesheet" type="text/css" href="{$cssFile}" media="all">
end;
        return $string;
    }
    static function getUrl($type) {
        return _BASE_URL_ .DS .strtolow($type);
    }

    static function Mapping(array $data) {

    }
}
?>