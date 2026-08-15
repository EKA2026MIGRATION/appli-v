<?php use_helper('dates');?>

    <tr>
        <td style="border: 1px solid lightgrey;">Num</td>
        <td style="border: 1px solid lightgrey;">Client</td>
        <td style="border: 1px solid lightgrey;">Date de facture</td>
        <td style="border: 1px solid lightgrey;">Mode</td>
        <?php $nbComp = 0;?>
        <?php foreach($params->components as $component):?>
            <?php $nbComp++;?>
            <td style="border: 1px solid lightgrey;"><?php echo $component->nameFr ;?></td>
            <?php $totalCol[$component->nameFr] = 0;?>
            <?php $totalTtcByVat[$component->vat]    = 0;?>
        <?php endforeach;?>
        <td style="border: 1px solid lightgrey;">Total TTC</td>
        <?php $totalCol['totalTTC'] = 0;?>
    </tr>

    <?php $totalJ = 0; $i = 0; $totalHtByVat['20'] = 0; $totalHtByVat['10'] = 0; $totalVatByVat['20'] = 0; $totalVatByVat['10'] = 0;?>

    <!--- Ensemble des lignes -->
    <?php foreach($params->invoices as $key => $invoice):?>

        <!-- check if line is the lastest invoice of the same day-->
        <?php $currentDay = date('d/m/y', strtotime($invoice->date));?>
        <?php if(isset($params->invoices[$key+1])):?>
            <?php $nextInvoiceDay = date('d/m/y', strtotime($params->invoices[$key+1]->date));?>
        <?php else:?>
            <?php $nextInvoiceDay = null;?>
        <?php endif;?>
        <?php ($currentDay != $nextInvoiceDay) ? $latestInvoiceDay = true : $latestInvoiceDay = false;?>

        <!-- calcul price total * product quantity by component and create a values table of price --->
        <?php foreach($invoice->invoiceProducts as $product):?>
            <?php foreach($product->invoiceComponents as $component):?>
                <?php $quantity = $component->quantity*$product->quantity;?>

                <?php (isset($values[$component->nameFr])) ? $values[$component->nameFr] += $component->priceTtc*$quantity : $values[$component->nameFr] = $component->priceTtc*$quantity ;?>


                <?php $totalHt  = $component->priceHt*$quantity;?>
                <?php $totalTtc = $component->priceTtc*$quantity;?>
                <?php $vat      = $component->priceVat*$quantity;?>
                <?php $totalHtByVat[$component->vat] += $totalHt;?>
                <?php $totalVatByVat[$component->vat] += $vat;?>

            <?php endforeach;?>
        <?php endforeach;?>

        <?php ($latestInvoiceDay) ? $bottom = "border-bottom: 2px solid darkred" : $bottom = "";?>
        <tr style="border: 1px solid lightgrey;">
            <td style="border: 1px solid lightgrey;"><?= $invoice->number;?></td>
            <td style="border: 1px solid lightgrey;"><?= $invoice->nameFr;?></td>
            <td style="border: 1px solid lightgrey;"><?= $currentDay?></td>
            <td style="border: 1px solid lightgrey;"><?= $invoice->paymentMethod;?></td>

            <?php $sum = 0;?>
            <?php foreach($params->components as $component):?>
                <td style="border: 1px solid lightgrey;">
                    <?php if(isset($values)):?>
                        <?php if(array_key_exists($component->nameFr, $values)):;?>
                            <?php echo $values[$component->nameFr]?>
                            <?php $sum += $values[$component->nameFr]?>
                            <?php $totalCol[$component->nameFr] += $values[$component->nameFr];?>
                            <?php $totalTtcByVat[$component->vat] += $values[$component->nameFr];?>
                        <?php endif;?>
                    <?php endif;?>
                </td>
            <?php endforeach;?>
            <?php $sum = floor($sum);?>

            <td style="border: 1px solid lightgrey;"><?= $sum;?></td>
            <?php $totalCol['totalTTC'] += $sum;?>
        </tr>
        <?php unset($sum);unset($values);?>
    <?php endforeach;?>
