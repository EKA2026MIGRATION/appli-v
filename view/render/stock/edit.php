<?php use_helper('dates');?>

<style>
    .stockList {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        margin-top: 80px;
    }

    .categoryTd { background: darkblue; color: white; font-weight: bold; font-size: 16px; text-align: center}

    tr { border-bottom: 1px solid black!important;}
    th {background: darkred; color: white}
    td, th { border-left: 1px solid grey; border-right: 1px solid grey}

    .center { text-align: center; }

    h3, .flex { display: flex; justify-content: space-around}
    h3 button {
        margin: 0px!important; padding: 4px!important;
    }
    .chevron { cursor: pointer; font-weight: bold}
    .chevron:hover { color: darkred;}

    .microButton {
        text-align: center;
        padding: 10px;
        border-radius: 10px;
        background-color: darkblue;
        color: white;
    }


    .microButton {
        background-color: darkblue;
        color: white!important;
        font-size: 18px;
    }
    .needToSave {
        background-color: darkred;
        color: white!important;
    }

    #editStockProduct {
        background-color: seashell;
        padding: 20px;
        width: 90%;
        margin: 0 auto;
        border: 2px solid darkblue;
        border-radius: 10px;
        z-index: 99;
    }

    #editStockProduct input::placeholder ,  #editStockProduct textarea::placeholder{
        color: grey;
    }

    .openEditStockProduct {
        text-align: center; display: block; font-size: 14px;
    }

    #closeEditStockProduct {
        float: right;
        color: darkred;
        font-weight: bold;
    }

    #submitStockProductForm {
        margin: 0 auto;
        width: 100%;
        text-align: center;
    }

    .inputNumber {
        width: 100px;
    }

    .flex {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

</style>

<div style="position: fixed; background-color: white; width: 100%; padding-top: 10px; z-index: 999">
    <h3 style="center">
        <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
        Mise à jour - <?= showDate(date('Y-m-d'));?>
        <button class="button" id="addNewStockProduct" style="height: 50px; width: 50px">
            <i class="material-icons">add</i>
        </button>
    </h3>
</div>


<div style="position: relative; ">


    <table class="stockList">

        <?php foreach($params->stockProducts as $category => $elements):?>

            <tr><td colspan="7" class="categoryTd"><?= $category;?></td></tr>

            <?php foreach($elements as $stockProduct):?>
                <tr id="stockProductRow-<?=  $stockProduct->id;;?>">

                    <td>
                        <ul>
                            <li><b style="font-size: 18px" id="stockProductInfo_name_<?= $stockProduct->id;?>"><?= $stockProduct->name;?></b></li>
                            <li><i id="stockProductInfo_conditioning_<?= $stockProduct->id;?>"><?= $stockProduct->conditioning;?></i></li>
                        </ul>
                        <a href="#"
                           id="stockProductInfo_modifier_<?= $stockProduct->id;?>"
                           class="openEditStockProduct"
                           data-id="<?= $stockProduct->id;?>"
                           data-name="<?= $stockProduct->name;?>"
                           data-unity="<?= $stockProduct->unity;?>"
                           data-currentstock="<?= $stockProduct->currentStock;?>"
                           data-minimumstock="<?= $stockProduct->minimumStock;?>"
                           data-conditioning="<?= $stockProduct->conditioning;?>"
                           data-price="<?= $stockProduct->price;?>"
                           data-categoryid="<?= $stockProduct->category_id;?>"
                           data-restocklevel = "<?= $stockProduct->restockLevel;?>"

                        >
                            <i class="material-icons" style="font-size: 16px">edit</i>
                            MODIFIER
                        </a>


                        <a href="#"
                           id="stockProductInfo_delete_<?= $stockProduct->id;?>"
                           class="openDeleteStockProduct"
                           data-id="<?= $stockProduct->id;?>"
                           data-name="<?= $stockProduct->name;?>"
                           data-unity="<?= $stockProduct->unity;?>"
                           data-currentstock="<?= $stockProduct->currentStock;?>"
                           data-minimumstock="<?= $stockProduct->minimumStock;?>"
                           data-conditioning="<?= $stockProduct->conditioning;?>"
                           data-price="<?= $stockProduct->price;?>"
                           data-categoryid="<?= $stockProduct->category_id;?>"
                           data-restocklevel = "<?= $stockProduct->restockLevel;?>"
                           style="float: right"
                        >
                            <i class="material-icons" style="font-size: 16px">delete</i>
                        </a>

                        <?php $categoryArray[$stockProduct->category_id] = $stockProduct->category;?>

                    </td>
                    <td style="font-size: 18px;">
                        <?php ($stockProduct->currentStock == "") ? $current = 0 : $current = $stockProduct->currentStock;?>
                        <div class="flex" >
                            <i class="material-icons chevron" data-id="<?= $stockProduct->id;?>" data-direction="less">chevron_left</i>
                            <div id="currentStock<?= $stockProduct->id;?>" id="stockProductInfo_currentStock_<?= $stockProduct->id;?>"><?= $current;?></div>
                            <i class="material-icons chevron" data-id="<?= $stockProduct->id;;?>" data-direction="more">chevron_right</i>
                        </div>
                       <div style="text-align: center" id="stockProductInfo_unity_<?= $stockProduct->id;?>">
                           <?= $stockProduct->unity;?><?php if( ($stockProduct->unity == "pièce" || $stockProduct->unity == "paquet" || $stockProduct->unity == "litre") && $current > 1) echo 's';?>

                       </div>
                    </td>
                    <td style="text-align: center">
                        <a href="<?= HOST ?>stock/edit/" id="validButton<?= $stockProduct->id;?>" class="microButton" data-id="<?= $stockProduct->id;?>">
                            <i class="material-icons">check</i>
                        </a>
                    </td>
                </tr>

            <?php endforeach;?>

        <?php endforeach;?>
    </table>

    <?php include('_productForm.php');?>

</div>