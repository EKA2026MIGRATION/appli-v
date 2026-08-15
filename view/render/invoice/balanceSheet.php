<?php $title = "Bilan comptable"; ?>
<?php use_helper('dates,formTools, buttons');?>
<?php $resultArray = [];?>

<style>
    #contentTable {max-width: 95vw; overflow: auto; margin:auto; }
    #myTable {text-align: center; }
    #tableHead { background-color: darkblue; color: white; font-size: 10px; position: sticky; top: 80px; z-index: 99}
    #tableFoot { background-color: white; color: darkblue; font-size: 10px;}
    .colHide { color: white;}
    .tableRow { display: flex;}
    .tableRow div { text-align: center; word-wrap: break-word;justify-content: start; -webkit-hyphens: auto; hyphens: auto;}
    .colNum { width: 60px;}
    .colName { width: 120px}
    .colName2 { width: 200px}
    .colNameFusion { width: 320px}
    .colComp { width: 120px; word-wrap: break-word; }
    .colTT { width: 100px; border-left: 1px solid darkblue; border-right: 1px solid darkblue; }
    .colTT2 { width: 200px; border: 2px solid darkblue;}

    .tableRow:hover { background-color: lightgrey; color: darkred}

    #ui-datepicker-div {
        z-index: 999!important
    }
  </style>

<?php showFloatingActionButton($params->buttons); ?>



<h1>Bilan comptable</h1>

<div id="showInvoiceDetails" class="" style="z-index: 999">
</div>

<div id="invoicePage">

  <form action="<?= HOST."invoice/balance";?>" method="post" class="form-balance-sheet">
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
    <input type="submit" class="button" value="Afficher"/>
  </form>
    <div class="form-balance-sheet">
        <div class="medium-3 cell">
            <label for="viewByYear">Vue par année</label>
            <select id="viewByYear">
                <option/>
                <?php
                $currentYear = date('Y');
                for ($i = 0; $i < 5; $i++) {
                    $year = $currentYear - $i;
                    echo "<option value=\"$year\">$year</option>";
                }
                ?>
            </select>
        </div>
    </div>


    <div class="medium-3 cell">
        <label>Rechercher par nom
            <input type="text" id="searchByName" placeholder="Nom du client" onkeyup="handleSearch(this.value)">
        </label>
    </div>

    <div class="tableRow" id="tableHead">
        <div class="colNum">id</div>
        <div class="colNum">Num.</div>
        <div class="colName2">Client</div>
        <div class="colName">Date</div>
        <div class="colNum">M</div>
        <?php $nbComp = 0; foreach($params->components as $component):?>
            <?php $nbComp++;?>
            <div  class="colComp"><?php echo $component->nameFr ;?></div>
            <?php $totalCol[$component->nameFr] = 0;?>
            <?php $totalTtcByVat[$component->vat]    = 0;?>
        <?php endforeach;?>
        <div class="colTT">Total TTC</div>
        <?php $totalCol['totalTTC'] = 0;?>
        <div class="colTT">Total/j</div>
  </div>


  <div id="contentTable">
  
    <?php $totalJ = 0; $i = 0; $totalHtByVat['20'] = 0; $totalHtByVat['10'] = 0; $totalVatByVat['20'] = 0; $totalVatByVat['10'] = 0;?>

    <!--- Ensemble des lignes -->
    <?php foreach($params->invoices as $key => $invoice):?>


        <?php $lineArray = [];?>

      <?php $i = -$i; ($i == 1) ? $backcolor= "background-color: lightgrey" : $backcolor = "";?>

      <!-- check if line is the lastest invoice of the same day-->
      <?php $currentDay = date('d/m/y', strtotime($invoice->date));?>
     <?php $lineArray['date'] = $currentDay;?>
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
            <?php 
            if(isset($values[$component->nameFr])) {
                $values[$component->nameFr] += $component->priceTtc*$quantity ;
            } else {
                $values[$component->nameFr] = $component->priceTtc*$quantity ;
            };?>
                    
            <?php $totalHt  = $component->priceHt*$quantity;?> 
            <?php $totalTtc = $component->priceTtc*$quantity;?>
            <?php $vat      = $component->priceVat*$quantity;?>
            <?php $totalHtByVat[$component->vat] += $totalHt;?>
            <?php $totalVatByVat[$component->vat] += $vat;?>

        <?php endforeach;?>
      <?php endforeach;?>

      <?php ($latestInvoiceDay) ? $bottom = "border-bottom: 2px solid darkred" : $bottom = "";?>
      
      <div class="tableRow" style="<?= $bottom;?>; font-size: 12px; <?= $backcolor;?>">
          <div class="colNum"><?= $invoice->invoiceId;?></div>
          <?php $lineArray['id'] = $invoice->invoiceId;?>
          <div class="colNum"><?= $invoice->number;?></div>
          <div class="colName2">
            <a href='invoice/display/<?= $invoice->invoiceId;?>' title="Vue détaillée" class="displayInvoiceButton" id="full-<?= $invoice->invoiceId;?>">
              <?= $invoice->nameFr;?>
              <?php $lineArray['name'] = $invoice->nameFr;?>
            </a>
          </div>
          <div class="colName"><?= $currentDay?></div>
          <div class="colNum"><?= $invoice->paymentMethod;?></div>

          <?php $sum = 0;?>
          <?php foreach($params->components as $component):?>
            <div class="colComp">
              <?php if(isset($values)):?>
                  <?php if(array_key_exists($component->nameFr, $values)):;?>
                      <?php echo $values[$component->nameFr]?>
                      <?php $sum += $values[$component->nameFr]?>
                      <?php $totalCol[$component->nameFr] += $values[$component->nameFr];?>
                      <?php $totalTtcByVat[$component->vat] += $values[$component->nameFr];?>
                  <?php endif;?>
              <?php endif;?>
              <?php $sum = $sum; // use floor if we need to normalize value?>
            </div>
          <?php endforeach;?>
          <div  class="colTT"><?= $sum;?></div>
          <?php $lineArray['total'] = $sum;?>
          <?php $totalCol['totalTTC'] += $sum;?>

          <!-- show total/j-->
          <?php $totalJ += $sum;?>
          <?php if($latestInvoiceDay):?>
            <div  class="colTT">
              <?= $totalJ;?><br/>
              <span style="font-style: italic; font-size: 10px">
                <?= showDate($invoice->date, 'd/m');?>
              </span>
            </div>
            <?php $totalJ = 0;?>
          <?php else:?>
            <div  class="colTT">&nbsp;</div>
          <?php endif;?>
      </div>
      <?php unset($sum);unset($values);?>

        <?php $resultArray[] = $lineArray;?>
    <?php endforeach;?>


    <!-- tableau total --->

    <div class="tableRow" id="tableFoot">
      <div class="colNum colHide">id</div>
      <div class="colNum colHide">Num.</div>
      <div class="colName2 colHide">Client</div>
      <div class="colName colHide">Date</div>
      <div class="colNum colHide">M</div>
      <?php foreach($params->components as $component):?>
          <div  class="colComp"><?php echo $component->nameFr ;?></div>
      <?php endforeach;?>
      <div class="colTT2" colspan="2">Total TTC</div>
    </div>

    <div class="tableRow"  style="border: 2px solid darkred; background-color: lightgrey">
        <div class="colNum" style="color: lightgrey">id</div>
        <div class="colNum" style="color: lightgrey">Num.</div>
        <div class="colName2" style="font-size: 14px; font-weight: bold">TOTAL TTC</div>
        <div class="colName" style="color: lightgrey">Date</div>
        <div class="colNum" style="color: lightgrey">M</div>
        <?php foreach($params->components as $component):?>
          <div  class="colComp" style="font-size: 14px">
            <?= $totalCol[$component->nameFr] ;?>
          </div>
        <?php endforeach;?>
        <div class="colTT2" colspan="2"><b><?= $totalCol['totalTTC'];?></b></div>
    </div>

    <?php ksort($totalTtcByVat); ksort($totalHtByVat); ksort($totalVatByVat)?>

    <div style="border-left: 2px solid darkred; border-bottom: 2px solid darkred">
        <div class="tableRow">
            <div class="colNum">&nbsp;</div>
            <div class="colNum">&nbsp;</div>
            <div class="colName2"><b>TOTAL TTC</b></div>
            <div class="colName">&nbsp;</div>
            <div style="width: <?= 120*$nbComp;?>px; display: flex; justify-content: space-around">
                  <?php $coltt = 0;foreach($totalTtcByVat as $vat => $value):?>
                      <span>TVA <?=$vat;?>% : <?= number_format($value, 2, '.', ' ');?></span>
                      <?php $coltt += floatval($value);?>
                  <?php endforeach;?>
                  <?php unset($value);?>
            </div>
            <div class="colTT2">
                <?= $coltt;?>
            </div>
        </div>

        <div class="tableRow">
            <div class="colNum">&nbsp;</div>
            <div class="colNum">&nbsp;</div>
            <div class="colName2"><b>TOTAL HT</b></div>
            <div class="colName">&nbsp;</div>
            <div style="width: <?= 120*$nbComp;?>px; display: flex; justify-content: space-around">
                  <?php $coltt = 0; foreach($totalHtByVat as $vat => $value):?>
                      <span>TVA <?=$vat;?>% : <?= number_format($value, 2, '.', ' ');?></span>
                      <?php $coltt += floatval($value);?>
                  <?php endforeach;?>
                  <?php unset($value);?>
            </div>
            <div class="colTT2">
                <?= $coltt;?>
            </div>
        </div>
        
        <div class="tableRow">
            <div class="colNum">&nbsp;</div>
            <div class="colNum">&nbsp;</div>
            <div class="colName2"><b>TOTAL TVA</b></div>
            <div class="colName">&nbsp;</div>
            <div style="width: <?= 120*$nbComp;?>px; display: flex; justify-content: space-around">
                  <?php $coltt = 0; foreach($totalVatByVat as $vat => $value):?>
                      <span>TVA <?=$vat;?>% : <?= number_format($value, 2, '.', ' ');?></span>
                      <?php $coltt += floatval($value);?>
                  <?php endforeach;?>
                  <?php unset($value);?>
            </div>
            <div class="colTT2">
                <?= $coltt;?>
            </div>
        </div>
      </div>    

  </div>

    <?php if(in_array('ROLE_ADMIN', $_SESSION['ROLE'])):?>
            <div>
                <table>
                    <?php foreach($resultArray as $result):?>
                        <tr>
                            <td><?= $result['date'] ?></td>
                            <td><?= $result['id'];?></td>
                            <td><?= $result['name'];?></td>
                            <td><?= $result['total'];?></td>

                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
    <?php endif;?>
</div>
<script>
    function handleSearch(searchText) {
        // Convertit le texte de recherche en minuscules pour une recherche insensible à la casse
        searchText = searchText.toLowerCase();

        // Récupère toutes les lignes de la table (à l'exception de la première ligne d'en-tête)
        const tableRows = document.querySelectorAll("#contentTable .tableRow:not(#tableHead)");

        // Parcourt toutes les lignes et compare le texte de la colonne "Client"
        tableRows.forEach(row => {
            const clientName = row.querySelector(".colName2").textContent.toLowerCase();

            // Vérifie si le texte de recherche a au moins 2 caractères et s'il est présent dans le nom du client
            if (searchText.length >= 2 && clientName.includes(searchText)) {
                // Si le texte de recherche est présent, met en surbrillance la ligne
                row.style.backgroundColor = "yellow";
            } else {
                // Sinon, réinitialise la surbrillance
                row.style.backgroundColor = "";
            }
        });
    }

    const viewByYearSelect = document.getElementById("viewByYear");
    let baseurl = "<?php echo HOST.'invoice/stats/year/';?>";




    viewByYearSelect.addEventListener("change", function() {
        const selectedYear = viewByYearSelect.value;
        window.location.href = `${baseurl}${selectedYear}/`;
    });
</script>

