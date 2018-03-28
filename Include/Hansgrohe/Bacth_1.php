<?php



define("_BASE_DIR_",dirname(dirname(dirname(__FILE__))));
require_once (_BASE_DIR_."/setting.php");

$include_path[]= realpath(dirname(dirname(__FILE__)));
set_include_path(implode(PS,$include_path) .PS.get_include_path());

define("_DATA_DIR_",dirname(__FILE__).DS."data");
define("DATA_DOWNLOAD_DIR",dirname(__FILE__).DS."download");
define("CURRENT_DIR",dirname(__FILE__));


 

 function multiCurl($res, $options=""){

         if(count($res)<=0) return False;

         $handles = array();

         if(!$options) // add default options
             $options = array(
                 CURLOPT_HEADER=>0,
                 CURLOPT_RETURNTRANSFER=>1,
             );

         // add curl options to each handle
         foreach($res as $k=>$row){
             $ch{$k} = curl_init();
             $options[CURLOPT_URL] = $row['url'];
             $opt = curl_setopt_array($ch{$k}, $options);
             var_dump($opt);
             $handles[$k] = $ch{$k};
         }

         $mh = curl_multi_init();

         // add handles
         foreach($handles as $k => $handle){
             $err = curl_multi_add_handle($mh, $handle);            
         }

         $running_handles = null;

         do {
           curl_multi_exec($mh, $running_handles);
           curl_multi_select($mh);
         } while ($running_handles > 0);
        
         foreach($res as $k=>$row){
             $res[$k]['error'] = curl_error($handles[$k]);
             if(!empty($res[$k]['error']))
                 $res[$k]['data']  = '';
             else
             {
                 $res[$k]['data']  = curl_multi_getcontent( $handles[$k] );  // get results
                 file_put_contents('haha.png', $res[$k]['data']);
             }
                 

             // close current handler
             curl_multi_remove_handle($mh, $handles[$k] );
         }
         curl_multi_close($mh);
         return $res; // return response
 } 

$img_2=array(
   array('url'=>"http://assets.hansgrohe.com/mam/celum/celum_assets/154__hpa01862_TIF.png") ,
   array('url'=>"assets.hansgrohe.com/mam/celum/celum_assets/154__hpa01678_tif.png")
    
);
var_dump(multiCurl($img_2));exit;

$curl_mul=new curl_multi(); 
$curl_mul->setUrlList($img_2); 
$a=$curl_mul->execute(); 
$i=1; 
foreach($a as $v){ 
    $filename=$i.'.png'; 
    $fp2=@fopen($filename,'a'); 
    fwrite($fp2,$v); 
    var_dump($filename);
    fclose($fp2); 
    $i++; 
} 
?>　