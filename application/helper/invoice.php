<?php

/**
 * return 
 * totalVat10
 * totalVat20
 * totalVat
 * totalPriceHt
 * totalPriceTtc
 */
function extractTva($invoice) {


    if(!$invoice->invoiceProducts) return "no products";

    foreach($invoice->invoiceProducts as $products) {

        foreach($products->invoiceComponents as $component) {

            if(!isset($datas['vat'.$component->vat])) $datas['vat'.$component->vat] = 0;
            if(!isset($datas['totalHt']))             $datas['totalHt'] = 0;
            if(!isset($datas['totalTtc']))            $datas['totalTtc'] = 0;
            if(!isset($datas['totalTva']))            $datas['totalTva'] = 0;



            $datas['vat'.$component->vat] += $component->priceVat*$component->quantity;
            $datas['totalHt']             += $component->priceHt*$component->quantity; 
            $datas['totalTtc']            += $component->priceTtc*$component->quantity;
            $datas['totalTva']            += $component->priceVat*$component->quantity;
        }
    }

    return $datas;


}