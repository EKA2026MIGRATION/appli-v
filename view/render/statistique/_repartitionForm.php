<?php use_helper('dates,formTools');?>
<style>

</style>

 <form action="#" method="post" class="form-balance-sheet" style="max-width: 100%">
    <div style="max-width: 500px; margin: 0 auto">
        <input type="submit" class="submitButtonForm button" value="Afficher"/>

        <div class="medium-3 cell"> 
            <label> Date de départ
                <input type="text" id="date_invoice1"  placeholder="Date de départ" required value="<?= showDate($params->dateStart) ;?>">
            </label>
            <input type="hidden" id="datepicker1" name="dateStart" value="<?= $params->dateStart ;?>">
        </div>
        <div class="medium-3 cell">
            <label> Date de fin
                <input type="text" id="date_invoice2"  placeholder="Date de fin" required value="<?= showDate($params->dateEnd) ;?>">
            </label>
            <input type="hidden" id="datepicker2" name="dateEnd" value="<?= $params->dateEnd ;?>">
        </div>
        <div class="medium-3 cell">
            <label> Mode de paiement
                <select name="modePayement" id="modePayment">
                <option value="all" <?= getSelected($params->modePayement, 'all');?>>Tout</option>
                <option value="CB" <?= getSelected(strtoupper($params->modePayement), 'CB');?>>CB</option>
                <option value="CHEQUE" <?= getSelected(strtoupper($params->modePayement), 'CHEQUE');?>>Chèque</option>
                <option value="VIREMENT" <?= getSelected(strtoupper($params->modePayement), 'VIREMENT');?>>Virement</option>
                </select>
            </label>
        </div>
    </div>
     <br/>
     <span id="showListProductButton" style="cursor: pointer; padding: 10px; border: 2px solid darkblue; border-radius: 10px">
         voir la liste par défaut des méta groupes de produits
     </span>
     <br/><br/>
     <div id="showListProduct" style="display: none;">
         <?php foreach($params->products as $metaGroup => $products):?>
                <b><?= $metaGroup;?></b>
                <?php foreach($products as $productId => $product):?>
                    <li><?= $product;?></li>
                <?php endforeach;?>
         <?php endforeach;?>
         <input type="hidden" name="metaGroups" id="metaGroups" value="<?= json_encode($params->products);?>"/>
     </div>

    <input type="submit" class="submitButtonForm button" value="Afficher"/>
  </form>

  <div id="showResultRepartition"></div>
  <br/><br/>
  <canvas id="pie-chart" width="800" height="450"></canvas>
