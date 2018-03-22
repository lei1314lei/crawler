<?php

class Hansgrohe_Page_Category extends Page_Category{
    public function prePage() {
        try{
            $page= $this->pagination('[rel=prev]');
            return $page;
        } catch (Page_NoElementException $ex) {
            //暂时不处理
        }
        
    }
    public function nextPage() {
        try{
            $page = $this->pagination('[rel=next]');
            return $page;
        } catch (Page_NoElementException $ex) {
            //暂时不处理
        }
        
    }

}
