<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Duravit_ProductPage extends ProductPage
{

    protected function _getTitle()
    {
        return format_data(pq(".section h2")->text(),"&nbsp;");
        //  return ;
    }


    protected function _getReference()
    {
        return pq(".section-heading a.active")->text();
    }

    protected function _getDescription()
    {
        return format_data(pq("#prodrequest-form .function-list li:first")->text());
    }

    public function loadProductInfo($limit = null)
    {
        $this->prepareLog();
        $this->_productlist->addRow("sku,title,description");

        foreach ($this->_allProductUrls as $productUrl) {
            $this->_loadPage($productUrl);
            $reference = $this->_getReference(); //product partno
            if ($reference) {
                $this->_log->addRow($reference . ' download at ' . date('Y-m-d H:i:s'));
                $this->_productlist->addRow($reference . ",\"" .
                    $this->_getTitle() . "\",\"" .
                    $this->_getDescription() . "\",");
            } else {
                $this->_nofoundlog->addRow($productUrl);

            }

        }

        return $this->_data;
    }
}