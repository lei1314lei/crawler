<?php

abstract class Website_Page_Product extends Website_Page{
    const DATA_ADDITION_IMG_NAME="imgName";
    const DATA_PROD_IMG="src";
   // const IMG_NAME_SEPARATOR="_";
    abstract protected function _imgName($i);
    abstract public function imgSelector();
    public function getProdImgsInfo($exceptedImgCount=null)
    {
        $srcs=$this->_getImgSRCs($exceptedImgCount);
        $timer=0;
        foreach($srcs as $i=>$src)
        {
            $timer++;
            $info[self::DATA_PROD_IMG]=$src;
            $info[self::DATA_ADDITION_IMG_NAME]=$this->_imgName($i);
        }
        
//        $prodId=$this->prodId();
//        $srcs=$this->_getImgSRCs($exceptedImgCount);
//        $name=$this->_imgName();
//        $timer=0;
//        foreach($srcs as $src)
//        {
//            $timer++;
//            $info[self::DATA_PROD_IMG]=$src;
//            $info[self::DATA_ADDITION_IMG_NAME]="$prodId-$timer--".SELF::IMG_NAME_SEPARATOR.$name;
//        }
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
