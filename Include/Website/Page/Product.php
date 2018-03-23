<?php

abstract class Website_Page_Product extends Website_Page{
    abstract protected function _imgName();
    abstract protected function _imgSelector();
    public function getProdImgs($exceptedImgCount=null)
    {
        $srcs=$this->_getImgSRCs($exceptedImgCount);
        $name=$this->_imgName();
        if(count($srcs)>1)
        {
            $timer=0;
            foreach($srcs as $src)
            {
                $timer++;
                $info['src']=$src;
                $info['name']=$name.'_'.$timer;
            }
        }else{
            $info['src']=array_pop($srcs);
            $info['name']=$name;
        }
        $info[Website_Page::DATA_FROM]=$this->_pageUrl;
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
        $imgSelector=$this->_imgSelector();
        $imgSRCs=$this->getElesBySelector($imgSelector, $srcAttr);
        if(!is_null($exceptedImgCount)){
            if($imgSrcs->count()!==$exceptedImgCount)
            {
                throw new Exception("Unexcepted amount of img");
            }
        }
        return $imgSRCs;
    }
    
    
}
