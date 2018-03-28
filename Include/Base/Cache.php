<?php

interface Base_Cache 
{
    public function isCached($key);
    public function getCache($key);
    public function saveCache($key,$data);
}
