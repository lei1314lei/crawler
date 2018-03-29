<?php 
class Base_MultiLoader{ 
   // private $url_list=array(); 
   const  KEY_LOADED_CONTENT='load_content';
   const  KEY_URL='url';
   //const  KEY_FILE_NAME='name';
   const  KEY_ERROR='error';
   protected $_targetItems;
   protected $_logger;
    private $_curl_setopt=array( 
        CURLOPT_RETURNTRANSFER => 1,//结果返回给变量 
        CURLOPT_HEADER => 0,//是否需要返回HTTP头 
        CURLOPT_NOBODY => 0,//是否需要返回的内容 
        CURLOPT_FOLLOWLOCATION => 0,//自动跟踪 
        //CURLOPT_TIMEOUT => 1,//超时时间(s) 
    ); 
    function __construct($seconds=null){ 
        //set_time_limit($seconds); 
        if($seconds)
        {
            $this->_curl_setopt[CURLOPT_TIMEOUT]=$seconds;
            set_time_limit($seconds+10); 
        }
    } 
    public function disableSSLVerify()
    {
        $this->_curl_setopt[CURLOPT_SSL_VERIFYHOST]=0;
        $this->_curl_setopt[CURLOPT_SSL_VERIFYPEER]=0;
    }
    /* 
     * 
     */ 
    public function setItemsToLoad(Array $items,$urlAs=self::KEY_URL){ 
        foreach($items as $i=>$item)
        {
            if(!isset($item[$urlAs])) throw new Exception("Invalid parameter:Lack of Key 'url'");
            if(self::KEY_URL!==$urlAs)
            {
                $item[self::KEY_URL]=$item[$urlAs];
                unset($item[$urlAs]);
                $items[$i]=$item;
            }
        }
        $this->_targetItems=$items;
        //$this->url_list=$list; 
        return $this;
    }
    public function getItemsLoaded()
    {
        return $this->_targetItems;
    }
    /* 
     * 设置参数 
     * @cutPot array 
     */ 
    protected function _setOpt($cutPot){ 
        $this->_curl_setopt=$cutPot+$this->_curl_setopt; 
    } 
    static public function isItemLoadedSucess(Array $item)
    {
        return isset($item[self::KEY_LOADED_CONTENT])?true:false;
    }
    /* 
     * @return array 
     */ 
    public function execute($options=""){

            if(count($this->_targetItems)<=0) return False;

            $handles = array();

            if(!$options) // add default options
   //             $options = array(
   //                 CURLOPT_HEADER=>0,
   //                 CURLOPT_RETURNTRANSFER=>1,
   //                 
   //             );
                $options=$this->_curl_setopt;

            // add curl options to each handle
            foreach($this->_targetItems as $k=>$row){
                $ch{$k} = curl_init();
                $options[CURLOPT_URL] = $row[self::KEY_URL];
                $opt = curl_setopt_array($ch{$k}, $options);
                //var_dump($opt);
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

            foreach($this->_targetItems as $k=>$row){
                $this->_targetItems[$k][self::KEY_ERROR] = curl_error($handles[$k]);
                if(!empty($this->_targetItems[$k][self::KEY_ERROR]))
                {
                   // $this->_targetItems[$k][self::KEY_LOADED_CONTENT]  = '';
                }else{
                    // get results
                    $this->_targetItems[$k][self::KEY_LOADED_CONTENT]  = curl_multi_getcontent( $handles[$k] );  
                }


                // close current handler
                curl_multi_remove_handle($mh, $handles[$k] );
            }
            curl_multi_close($mh);
            return $this->_targetItems; // return response
    } 

//    public function downloadTo($path,$logFile)
//    {
//        $this->_logger = new log($logFile);
//        $this->execute();
//        $this->_writeFile($path);
//    }
//    protected function _writeFile($path)
//    {
//       
//        foreach($this->_targetItems as $i=>$item)
//        {
//            $fileName=$this->_fileName($i);
//            $fullPath=_DOWNLOAD_.DS.$path.DS.$fileName;
//            $content=$this->_targetItems[$i][self::KEY_LOADED_CONTENT];
//            var_dump($content);
//            if(false===file_put_contents($fullPath, $content))
//            {
//                $data="Fail to Save: {$this->_targetItems[$i][self::KEY_URL]}";
//                
//            }else{
//                $data="Success to Save: {$this->_targetItems[$i][self::KEY_URL]}";
//            }
//            $this->_logger->addRow($data);
//        }
//    }
//    protected function _fileName($i)
//    {
//        $data=$this->_targetItems[$i];
//        $url=$data[self::KEY_URL];
//        $parts=pathinfo($url);
//        $extension=$parts['extension'];
//        if(isset($data[self::KEY_FILE_NAME])  ) 
//        {
//            $filename=$data[self::KEY_FILE_NAME];
//            $pathParts=pathinfo($filename);
//            $filename=$pathParts['filename'].".";
//            return $filename.=isset($pathParts['extension'])?$pathParts['extension']:$extension;
//        }else{
//
//            return $parts['basename'];
//        }
//    }
} 