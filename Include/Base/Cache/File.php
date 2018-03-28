<?php

class Base_Cache_File implements Base_Cache
{
    const FILE_TYPE_HTML='html';
    const FILE_TYPE_TEXT='text';
    protected $_path;
    protected $_fullPath;
    protected $_fileExtension;
    protected $_fileType;
    public function __construct($path,$fileType) {
        if($path)
        {
            $this->_path=$path;
        }
        if($fileType)
        {
            $this->_fileType=$fileType;
        }else{
            throw new Exception("unexcepted file type:$fileType");
        }
    }
    public function isCached($key)
    {
        $filename=$this->_filename($key);
        return file_exists($filename)?true:false;
    }
    public function getCache($key){
        $filename=$this->_filename($key);
        $data=@file_get_contents($filename);
        return $data?$data:'';
    }
    public function saveCache($key,$data){
        $filename=$this->_filename($key);
        $result= @file_put_contents($filename, $data);
        return $result?true:false;
    }
    protected function _filename($key)
    {
        $filename=$this->_fullPath($this->_path).DS.$key.".".$this->_fileExtension($this->_fileType);
        return $filename;
    }
    static protected function _fileExtension($fileType)
    {
        if($fileType===self::FILE_TYPE_HTML)
        {
            return "html";
        }else{
            return 'txt';
        }
    }
    protected function _fullPath($dataPath)
    {
        if(!isset($this->_fullPath))
        {
            $fullPath=_CACHE_DIR_;
            if($dataPath)
            {
                $fullPath.=DS.$dataPath;
            }
            if(!is_dir($fullPath))
            {
                if(false===@mkdir($fullPath,0777,true))
                {
                    throw new Exception("Faild to create direction:$fullPath");
                }
            }
            $this->_fullPath=$fullPath;
        }
        return  $this->_fullPath;
    }
}
