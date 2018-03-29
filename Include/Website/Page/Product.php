<?php

abstract class Website_Page_Product extends Website_Page{
    const DATA_ADDITION_IMG_NAME="imgName";
    const DATA_PROD_IMG="src";
    
    abstract protected function _imgName();
    abstract public function imgSelector();
    public function getProdImgsInfo($exceptedImgCount=null)
    {
        $srcs=$this->_getImgSRCs($exceptedImgCount);
        $name=$this->_imgName();
        if(count($srcs)>1)
        {
            $timer=0;
            foreach($srcs as $src)
            {
                $timer++;
                $info[self::DATA_PROD_IMG]=$src;
                $info[self::DATA_ADDITION_IMG_NAME]=$name.'_'.$timer;
            }
        }else{
            $info[self::DATA_PROD_IMG]=array_pop($srcs);
            $info[self::DATA_ADDITION_IMG_NAME]=$name;
            
        }
        $info[self::DATA_ADDITION_SELECTOR]=$this->imgSelector();
        $info[self::DATA_ADDITION_FROM_PAGE]=$this->_pageUrl;
        $infos[]=$info;
        return $infos;
    }
    protected function _getAttrSrcName()
    {
        return "src";
    }
    protected function _getImgSRCs($exceptedImgCount)
    {
        $srcAttr=$this->_getAttrSrcName();
        $imgSelector=$this->imgSelector();
        $imgSRCs=$this->getElesBySelector($imgSelector, $srcAttr);
        if(!is_null($exceptedImgCount)){
            if($imgSrcs->count()!==$exceptedImgCount)
            {
                throw new Website_ElementException($this,$imgSelector,"Unexcepted amount of img");
            }
        }
        return $imgSRCs;
    }
    
    
}
