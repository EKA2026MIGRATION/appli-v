<?php use_helper('dates, buttons');?>
<?php
    $mode = "";
    if( isset($params->orderProducts)) {
        $orderProducts = (array)$params->orderProducts;
    } else {
        $orderProducts = [];
    }
    $stockProducts = [];
    // usual case
    if(isset($params->stockProducts)) {
        $stockProducts = (array)$params->stockProducts;
    }
    // home page case
    if( isset($params->stockAlert)) {
        $stockProducts = $params->stockAlert;
        $mode = "homepage";
    }
;?>
<?php (isset($params->status)) ? $status = $params->status : $status = "create";?>
<style>
    .stockList {
        width: 100%;
        border-collapse: collapse;
        font-size: 16px;
    }

    .categoryTd { background: darkblue; color: white; font-weight: bold; font-size: 16px; text-align: center}

    tr:nth-child(odd) {background: lightgrey}
    th {background: darkred; color: white}
    td, th { border-left: 1px solid grey; border-right: 1px solid grey}

    h3 { display: flex; justify-content: space-between}
    h3 a {
        margin: 0px!important; padding: 4px!important;
    }

    .chevron { cursor: pointer; font-weight: bold}
    .chevron:hover { color: darkred;}

    .saved {
        background-color: lightgreen!important;
        color: darkblue!important;
    }

    .microButton {
        text-align: center;
        padding: 10px;
        border-radius: 10px;
        background-color: grey;
        color: white;
        font-size: 18px;
        padding-top: 20px;
    }

</style>
<?php if($mode != "homepage"):?>
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>

    <h3>
        <?php ($status == "create") ? $text = "FAIRE LES COURSES" : $text = "COURSE DU ".showDate($params->date);?>
        <b><?= $text;?></b>
        <br/>
        <?php if(isset($params->latestDate)):?>
            <i style="font-size: 16px">dernier inventaire : <?= showDate($params->latestDate);?></i>
        <?php endif;?>
    </h3>
<?php endif;?>

    <table class="stockList">

        <tr>
            <th>
                Intitulé
            </th>
            <th>
                Besoin
            </th>
            <?php if($mode != "homepage") echo "<th/>";?>
        </tr>



        <?php foreach($stockProducts as $category => $elements):?>
            <?php ($mode == "homepage") ? $nbcol = "3" : $nbcol = "4";?>
            <tr><td colspan="<?= $nbcol ;?>" class="categoryTd"><?= $category;?></td></tr>

            <?php foreach($elements as $stockProduct):?>

                <?php $quantityTarget = $stockProduct->restockLevel - $stockProduct->currentStock ;?>

                <?php if($stockProduct->restockLevel - $stockProduct->currentStock<0 || $stockProduct->restockLevel == 0) continue;?>
                <?php ($stockProduct->restockLevel == null) ? $restock = 0 : $restock = $stockProduct->restockLevel ;?>

                <?php if($restock == 0) continue;?>
                <?php if($quantityTarget == 0) continue;?>


                <?php if($status == "show") {
                    if(!key_exists($stockProduct->id, $orderProducts)) continue;
                };?>

                <tr>
                    <td>
                        <?= $stockProduct->name;?>
                        <?php if($stockProduct->conditioning != ""):?>
                            <br/>
                            <i style="font-size: 12px; color: darkblue"><?= $stockProduct->conditioning;?></i>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if ($mode != "homepage"):?>
                            <input type="number"
                                   id="quantityProduct-<?= $stockProduct->id;?>"
                                   name="product-<?= $stockProduct->id;?>"
                                   <?php if($status=="show") echo ' disabled ';?>
                                   value="<?php echo (key_exists($stockProduct->id, $orderProducts)) ?  $orderProducts[$stockProduct->id]->quantity : $quantityTarget;?>"
                                   style="width: 80px; display: inline"/>
                            &nbsp;&nbsp;
                            <input type="hidden" id="quantityTarget-<?= $stockProduct->id;?>" value="<?= $quantityTarget;?>"/>
                            <?= $stockProduct->unity;?><?php if( ($stockProduct->unity == "pièce" || $stockProduct->unity == "paquet" || $stockProduct->unity == "litre") && $restock > 1) echo 's';?>
                            <br/>
                        <?php endif;?>
                        <i style="font-size: 12px; color: darkblue">
                            Etat actuel: <?= $stockProduct->currentStock;?>
                            <?= $stockProduct->unity;?><?php if( ($stockProduct->unity == "pièce" || $stockProduct->unity == "paquet" || $stockProduct->unity == "litre") && $restock > 1) echo 's';?>
                            &nbsp;-&nbsp;
                            Seuil d'alerte: <?= $stockProduct->minimumStock;?>
                            <?= $stockProduct->unity;?><?php if( ($stockProduct->unity == "pièce" || $stockProduct->unity == "paquet" || $stockProduct->unity == "litre") && $restock > 1) echo 's';?>
                            &nbsp;-&nbsp;
                            Quantité cible: <?= $stockProduct->restockLevel;?>
                            <?= $stockProduct->unity;?><?php if( ($stockProduct->unity == "pièce" || $stockProduct->unity == "paquet" || $stockProduct->unity == "litre") && $restock > 1) echo 's';?>
                            &nbsp;-&nbsp;
                            Besoin idéal d'achat: <?= $quantityTarget?>
                        </i>
                    </td>
                    <?php if ($mode != "homepage"):?>
                        <td>
                            <a href="<?= HOST ?>stock/order/"
                               id="validButton<?= $stockProduct->id;?>"
                               class="microButton <?php if(key_exists($stockProduct->id, $orderProducts)) echo 'saved';?>"
                               data-id="<?= $stockProduct->id;?>">
                                <i class="material-icons">check</i>
                            </a>
                        </td>
                    <?php endif;?>
                </tr>

            <?php endforeach;?>

        <?php endforeach;?>

    </table>

<br/><br/>
