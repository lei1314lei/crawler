<?php
/**
 * Created by PhpStorm.
 * User: Joy
 * Date: 5/9/2016
 * Time: 1:40 PM
 */
class Export {
    public $test;
    // export to file
    static function doexport($file) {
        echo _LOG_DIR_ . DS . $file;exit;
        if(is_file($file)) {
            header('Content-Type: text/csv"');
            header('Content-Disposition: attachment; filename=' . $file);
            header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
            header('Expires:0');
            header('Pragma:public');

//            ob_start('ob_gzhandler');
            readfile(_LOG_DIR_ . DS . $file);
            //ob_end_flush();//结束压缩
        }
    }

    public function ob_gzip($content)
    {

        if (!headers_sent() && extension_loaded("zlib") && strstr($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")) {
           // $content = StringHelper::Encoding($content, 'utf-8', 'GBK');
            $content = gzencode($content, 9);
            header("Content-Encoding: gzip");
            header("Vary: Accept-Encoding");
            header("Content-Length: " . strlen($content));
        }
        return $content;
    }

}
?>