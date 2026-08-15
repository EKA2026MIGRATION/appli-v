<?php use_helper('dates');?>
<?php $invoice = $params->invoice;?>
<table>
    <tr>
        <td>
            <img src="<?= IMG.'logoInvoiceEKA.jpg';  ?>" alt="logo EKA invoice"/>
        </td>
        <td><br/><br/><br/><br/><br/><br/><br/>
        <?= $invoice->nameFr;?>
        <br/><br/>
        <?= $invoice->address;?>
        <br/>
        <?= $invoice->postal;?> <?= $invoice->town;?>
        <br/><br/>
        Facture n° <?= $invoice->number;?> <span style="font-weight: normal">du <?= showDate($invoice->date);?></span>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <?php if($invoice->descriptionFr != "") echo "<hr/><div style='color: black; font-size: 14px; font-style: italic'><br/>".$invoice->descriptionFr.'</div>';?>
            <?php if($invoice->descriptionEn != "") echo "<div style='color: black; font-size: 14px; font-style: italic'>".$invoice->descriptionEn.'</div>';?>
            <hr/>
        </td>
    </tr>
 </table>

<div id="showProductList">
        <?php $totalVatValueInvoice = 0; $totalHtInvoice = 0;?>


            <?php $i = 0; ;?>
            
            <?php foreach($invoice->invoiceProducts as $invoiceProductData):?>


                <table id="invoice" style="width: 600px;">

                        <?php $invoiceProduct = $invoiceProductData['product'];?>
                        <?php $quantity       = $invoiceProductData['quantity'];?>
                    
                        <?php if(isset($invoiceProductData['description'])):?>
							<?php foreach($invoiceProductData['description'] as $childname => $dates):?>
								<?php $alldates = implode('-', $dates);?>
								<?php $descriptionArr[]= $childname.': '.$alldates;?>
							<?php endforeach;?>
							<?php $description = implode(' | ', $descriptionArr);?>
							<?php unset($descriptionArr);?>
						<?php endif;?>

                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="color: darkblue; width: 300px"><?= strip_tags($invoiceProduct->nameFr);?>
                            </td>
                            <td style="color: darkblue; text-align: right; width: 200px;">
                                P.U. TTC: <?= $invoiceProduct->priceTtc;?> € - Quantité : <?= $quantity;?>
                            </td>
                            <td style="color: darkblue; text-align: right; width: 100px;">
                                <?= $invoiceProduct->priceTtc*$quantity;?> € TTC
                            </td>
                        </tr>
                        <tr>    
                            <td colspan="3">
                                <i style="font-size: 12px">
                                    <?php if(isset($invoiceProductData['description2'])):?>
                                        <?php $i++;?>
                                        <?= $invoiceProductData['description2'].'<sup>('.$i.')</sup>';?>
                                        <?php $details[$i] = $description;?>
                                    <?php else :?>
                                        <?= $description ?>
                                    <?php endif;?>
                                </i>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <hr style="width: 50%"/>
                            </td>
                        </tr>
                </table>


                <?php if($params->view == 'full'):?>

                        <table cellpadding="4">
                            <tr class="invoiceComponent" style="font-size:10px"> 
                                <td></td>
                                <th border="1" style="font-weight: bold; text-align: center">P.U. HT</th>
                                <th border="1" style="font-weight: bold; text-align: center">Quantité</th>
                                <th border="1" style="font-weight: bold; text-align: center">Total HT normal</th>
                                <th border="1" style="font-weight: bold; text-align: center">Total HT réduit</th>
                                <th border="1" style="font-weight: bold; text-align: center">TVA 20%</th>
                                <th border="1" style="font-weight: bold; text-align: center">TVA 10%</th>
                                <th border="1" style="font-weight: bold; text-align: center">Total</th>
                            </tr>
                            <?php $totalProductHt = 0; $totalVatValue = 0;?>
                            <tbody id="bodyInvoiceProduct<?= $invoiceProduct->invoiceProductId;?>">
                                <?php foreach($invoiceProduct->invoiceComponents as $invoiceComponent):?>
                                    <tr id="trRow<?= $invoiceComponent->invoiceComponentId ;?>" style="font-size: 12px; text-align: right; padding-right: 4px">
                                            <?php $quantity2 = $invoiceComponent->quantity*$quantity;?>
                                            <?php $totalHt = $invoiceComponent->totalHt*$quantity;?> 
                                            <?php $totalTtc = $invoiceComponent->totalTtc*$quantity;?>
                                            <?php $vat =  $totalTtc-$totalHt;?>
                                            <td border="1"><?= $invoiceComponent->nameFr;?></td>
                                            <td border="1"><?= $invoiceComponent->priceHt;?></td>
                                            <td border="1"><?= $quantity2;?></td>
                                            <td border="1"><?php if($invoiceComponent->vat >= "20.00") echo number_format($totalHt, 2, '.', ' ') ;?></td>
                                            <td border="1"><?php if($invoiceComponent->vat  <= "10.00") echo number_format($totalHt, 2, '.', ' ') ;?></td>
                                            <td border="1"><?php if($invoiceComponent->vat >= "20.00") echo number_format($vat, 2, '.', ' ')?></td>
                                            <td border="1"><?php if($invoiceComponent->vat <= "10.00") echo number_format($vat, 2, '.', ' ') ?></td>
                                            <td border="1"><?= $totalTtc ;?></td>
                                    </tr>
                                    <?php $totalProductHt += $totalHt;?> 
                                    <?php $totalVatValue += $vat;?>
                                <?php endforeach;?>
                            </tbody>
                        </table>

                <?php endif;?>
      
                <?php $totalProductHt = 0; $totalVatValue = 0;?>
                <?php foreach($invoiceProduct->invoiceComponents as $invoiceComponent):?>
                            <?php $quantity2 = $invoiceComponent->quantity*$quantity;?>
                            <?php $totalHt = $invoiceComponent->totalHt*$quantity;?> 
                            <?php $totalTtc = $invoiceComponent->totalTtc*$quantity;?>
                            <?php $vat =  $totalTtc-$totalHt;?>
                        
                        <?php $totalProductHt += $totalHt;?> 
                        <?php $totalVatValue += $vat;?>
                <?php endforeach;?>

                <?php $totalVatValueInvoice += $totalVatValue;?>
                <?php $totalHtInvoice += $totalProductHt;?>

            <?php endforeach;?>

        <table style="width: 600px">

            <tr>
                <td>&nbsp;</td>
                <td colspan="2" style="text-align:right; color: darkblue; font-weight: bold;">
                    Montant TVA:&nbsp;&nbsp;
                    <?= number_format($totalVatValueInvoice, 2, '.', ' ');?> €
                </td>
            </tr>


            <tr>
                <td>&nbsp;</td>
                <td colspan="2" style="text-align:right; color: darkblue; font-weight: bold;">
                    Total HT:&nbsp;&nbsp;
                    <?= number_format($totalHtInvoice, 2, '.', ' ');?> €
                </td>
            </tr>


            <tr>
                <td>&nbsp;</td>
                <td colspan="2" style="text-align:right; color: darkblue; font-weight: bold;">
                    Total TTC:&nbsp;&nbsp;
                    <?= number_format($invoice->priceTtc, 2, '.', ' ');;?> €
                </td>
            </tr>

        </table>

        <br/>
        <br/>

        <?php if(isset($details) && count((array) $details) > 0):?>
          <div style="font-size: 10px; color: darkblue">
              Toutes les dates par personne
              <ul>
              <?php foreach($details as $k => $det):?>
                  <li style="word-wrap: break-word;">
                      <sup><?= $k ;?></sup>&nbsp;&nbsp;
                      <?= $det;?>
                  </li>
              <?php endforeach;?>
              </ul>
          </div>
      <?php endif;?>
</div>