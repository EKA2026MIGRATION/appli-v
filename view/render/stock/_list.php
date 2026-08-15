<table class="stockList">

    <tr>
        <th>
            id
        </th>
        <th>
            Intitulé
        </th>
        <th>
            Minima
        </th>
        <th>
            Max attendu
        </th>
        <th>
            Actuel
        </th>
        <th>
            Prix
        </th>
    </tr>


    <?php foreach($params->stockProducts as $category => $elements):?>

        <tr><td colspan="7" class="categoryTd"><?= $category;?></td></tr>

        <?php foreach($elements as $stockProduct):?>

            <tr>
                <td>
                    <?= $stockProduct->id;?>
                </td>
                <td>
                    <?= $stockProduct->name;?>
                    <?php if($stockProduct->conditioning != ""):?>
                        <br/>
                        <i style="font-size: 10px; color: darkblue"><?= $stockProduct->conditioning;?></i>
                    <?php endif;?>
                </td>
                <td>
                    <?= $stockProduct->minimumStock;?>&nbsp;
                    <?= $stockProduct->unity;?><?php if( ($stockProduct->unity == "pièce" || $stockProduct->unity == "paquet" || $stockProduct->unity == "litre") && $stockProduct->minimumStock > 1) echo 's';?>
                </td>
                <td>
                    <?php ($stockProduct->restockLevel == null) ? $restock = 0 : $restock = $stockProduct->restockLevel ;?>
                    <?= $restock;?>&nbsp;
                    <?= $stockProduct->unity;?><?php if( ($stockProduct->unity == "pièce" || $stockProduct->unity == "paquet" || $stockProduct->unity == "litre") && $restock > 1) echo 's';?>
                </td>
                <td><?= $stockProduct->currentStock;?>&nbsp;
                    <?= $stockProduct->unity;?><?php if( ($stockProduct->unity == "pièce" || $stockProduct->unity == "paquet" || $stockProduct->unity == "litre") && $stockProduct->currentStock > 1) echo 's';?>
                </td>
                <td><?= $stockProduct->price;?></td>
            </tr>

        <?php endforeach;?>

    <?php endforeach;?>
</table>