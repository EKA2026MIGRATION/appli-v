<style>
  .invoiceProduct { display : flex; justify-content: space-between; font-size: 1.6rem; color: darkblue;}
  .componentTable td { border : 1px solid lightgrey; text-align: center; color: black}
  .componentTable th { border : 1px solid lightgrey; text-align: center; color: black}
  .totalInfo { text-align: right; font-size: 1.2rem}
  .invoiceTotal {text-align: right;}
  .invoiceTotal div { margin: 0px 10px 0px 10px;}
  .masked { background-color: white; color: darkblue}
  #invoiceHead { color: black}
  .spanInvoiceComponent { color: darkred; font-weight: bold}
</style>

<?php use_helper('dates');?>
<?php $invoice = $params->invoice;?>
<div id="invoiceClose" onclick="closeInvoice()">X</div>

<br/><br/>

  <div style="float: left">
    <button class="button" id="showClient">Vue Client</button>
    <button class="button masked" id="showCompta">Vue Comptable</button>
  </div>
  <div style="float: right">
    <a href="<?= HOST.'download/i/v/'.encodeInt($invoice->invoiceId).'/i/c/';?>" target="_blank"><button class="button" id="">Export Client</button><a>
    <a href="<?= HOST.'download/i/v/'.encodeInt($invoice->invoiceId).'/i/full/';?>' target="_blank"><button class="button masket" id="">Export Comptable</button><a>
  </div>
<br style="clear: both"/>
<br/><br/>

<div id="invoiceHead" style="display: flex">
  <img src="<?= IMG.'logoInvoiceEKA.jpg';  ?>" alt="logo EKA invoice"/>
  <div>
    <b><?= $invoice->nameFr;?></b><br/>
    <?= $invoice->address;?>
    <br/>
    <?= $invoice->postal;?> <?= $invoice->town;?>
    <br/><br/>
    <div id="invoiceInfo">
      Facture n° <?= $invoice->number;?> <span style="font-weight: normal">du <?= showDate($invoice->date);?></span>
    </div>
  </div>
</div>

<?php if($invoice->descriptionFr != "") echo "<hr/><div style='color: black; font-size: 14px; font-style: italic'>".$invoice->descriptionFr.'</div>';?>
<?php if($invoice->descriptionEn != "") echo "<div style='color: black; font-size: 14px; font-style: italic'>".$invoice->descriptionEn.'</div>';?>

<hr/>

<div id="showProductList">
      <?php $totalVatValueInvoice = 0; $totalHtInvoice = 0;?>
      <?php $i = 0; foreach($invoice->invoiceProducts as $invoiceProductData):?>
                  <?php $invoiceProduct = $invoiceProductData['product'];?>
                  <?php $quantity       = $invoiceProductData['quantity'];?>
                  <?php foreach($invoiceProductData['description'] as $childname => $dates):?>
                      <?php $alldates = implode('-', $dates);?>
                      <?php $descriptionArr[]= $childname.': '.$alldates;?>
                  <?php endforeach;?>

                  <?php $description = implode(' | ', $descriptionArr);?>

                  <?php unset($descriptionArr);?>

                  <div class="invoiceProduct">
                      <div>
                          <b><?= strip_tags($invoiceProduct->nameFr);?></b><br/>
                          <span style="font-size:16px">
                              P.U. TTC: <span id="invoiceProductTtc2<?= $invoiceProduct->invoiceProductId;?>"><?= $invoiceProduct->priceTtc;?></span> € - Quantité : <?= $quantity;?> <br/>
                              <?php if(isset($invoiceProductData['description2'])):?>
                                    <?php $i++;?>
                                    <?= $invoiceProductData['description2'].'<sup>('.$i.')</sup>';?>
                                    <?php $details[$i] = $description;?>
                                <?php else :?>
                                    <?= $description ?>
                                <?php endif;?>
                          </span>
                      </div>
                      <div><span id="invoiceProductTtc<?= $invoiceProduct->invoiceProductId;?>"><?= number_format($invoiceProduct->priceTtc*$quantity, 2, '.', '');?></span> € TTC</div>
                  </div>

          

                  <table class="componentTable comptaTable">
                    <tr class="invoiceComponent"> 
                      <td/>
                      <th>P.U. HT</th>
                      <th>Quantité</th>
                      <th>Total HT normal</th>
                      <th>Total HT réduit</th>
                      <th>TVA 20%</th>
                      <th>TVA 10%</th>
                      <th>Total</th>
                      <td/>
                    </tr>
                    <?php $totalProductHt = 0; $totalVatValue = 0;?>
                    <tbody id="bodyInvoiceProduct<?= $invoiceProduct->invoiceProductId;?>">
                      <?php foreach($invoiceProduct->invoiceComponents as $invoiceComponent):?>
                          <tr id="trRow<?= $invoiceComponent->invoiceComponentId ;?>">
                                <?php $quantity2 = $invoiceComponent->quantity*$quantity;?>
                                <?php $totalHt = $invoiceComponent->totalHt*$quantity;?> 
                                <?php $totalTtc = $invoiceComponent->totalTtc*$quantity;?>
                                <?php $vat =  $totalTtc-$totalHt;?>
                                <td><?= $invoiceComponent->nameFr;?></td>
                                <td><?= $invoiceComponent->priceHt;?></td>
                                <td><?= $quantity2;?></td>
                                <td><?php if($invoiceComponent->vat >= "20.00") echo $totalHt?></td>
                                <td><?php if($invoiceComponent->vat  <= "10.00") echo $totalHt?></td>
                                <td><?php if($invoiceComponent->vat >= "20.00") echo $vat?></td>
                                <td><?php if($invoiceComponent->vat <= "10.00") echo $vat?></td>
                                <td><?= $totalTtc ;?></td>
                                <td>
                                    <div class="deleteComponent" data-invoiceproductid="<?= $invoiceProduct->invoiceProductId;?>" data-invoicecomponentid = "<?= $invoiceComponent->invoiceComponentId ;?>" style="cursor: pointer">
                                      <i class="material-icons" >delete</i>
                                    </div>
                                </td>
                          </tr>
                          <?php $totalProductHt += $totalHt;?> 
                          <?php $totalVatValue += $vat;?>
                      <?php endforeach;?>
                    </tbody>
                  
                    <form id="addComponentForm<?= $invoiceProduct->invoiceProductId;?>">
                        <input type="hidden" name="invoiceProductId" value="<?= $invoiceProduct->invoiceProductId;?>"/>
                        <tr class="addComponentTr">
                            <td colspan="2" style="color: darkblue">
                              Composant<br/>
                              <select name="componentId" class="selectComponent" id="selectComponent">
                                <option/>
                                <?php foreach($params->components as $component):?>
                                  <option value="<?= $invoiceProduct->invoiceProductId;?>-<?= $component->componentId;?>"><?= $component->nameFr;?></option>

                                  <?php $components[$component->componentId] = $component->vat;?>

                                <?php endforeach;?>
                              </select>
                            </td>
                            <td style="color: darkblue">
                                P.U. TTC<br/>
                                <input type="number" name="priceTtc" style="width: 100px" data-invoiceProductId = "<?= $invoiceProduct->invoiceProductId ;?>" class="inputPriceQuantity" id="inputPrice<?= $invoiceProduct->invoiceProductId ;?>"/>
                            </td>
                            <td style="color: darkblue">
                                Quantité<br/>
                                <input type="number" name="quantity" style="width: 100px" data-invoiceProductId = "<?= $invoiceProduct->invoiceProductId ;?>" class="inputPriceQuantity" id="inputQuantity<?= $invoiceProduct->invoiceProductId ;?>"/>
                            </td>
                            <td style="color: darkblue">
                                TVA<br/>
                                <span class="spanInvoiceComponent" id="componentVat<?= $invoiceProduct->invoiceProductId ;?>">&nbsp;</span><span style="color: darkred; font-weight: bold"> %</span>
                            </td>
                            <td style="color: darkblue">
                                P.U. HT<br/>
                                <span class="spanInvoiceComponent"  id="priceHt<?= $invoiceProduct->invoiceProductId ;?>">&nbsp;</span>
                            </td>
                            <td style="color: darkblue">
                                TOTAL HT<br/>
                                <span class="spanInvoiceComponent"  id="totalHt<?= $invoiceProduct->invoiceProductId ;?>">&nbsp;</span>
                            </td>
                            <td style="color: darkblue">
                                TOTAL TTC<br/>
                                <span class="spanInvoiceComponent"  id="totalTtc<?= $invoiceProduct->invoiceProductId ;?>">&nbsp;</span>
                            </td>
                            <td>
                              <button class="button" id="submitAddInvoiceProduct" data-invoiceProductId = "<?= $invoiceProduct->invoiceProductId ;?>" >Ajouter</button>
                            </td>
                        
                        </tr>
                    </form>

                  </table>
                  
                  

          <hr/>
          <?php $totalVatValueInvoice += $totalVatValue;?>
          <?php $totalHtInvoice += $totalProductHt;?>

      <?php endforeach;?>


      <div class="invoiceProduct" style="text-align : right">
            <div>&nbsp;</div>
            <div>
              <div class="invoiceTotal">
                <span>Montant TVA:</span>
                <span id="amountTVA"><?= number_format($totalVatValueInvoice, 2, '.', '');?></span>€
              </div>
              <div class="invoiceTotal">
                <span>Total HT:</span>
                <span id="invoiceTotalHt"><?= number_format($totalHtInvoice, 2, '.', '');?></span>€
              </div>
              <div class="invoiceTotal">
                <span>Total TTC:</span>
                <span id="invoiceTotalTtc"><?= number_format($invoice->priceTtc, 2, '.', '');?></span>€
              </div>
            </div>
      </div>

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


<script>
  showCompta = document.getElementById('showCompta');
  showClient = document.getElementById('showClient');
  comptaTables = document.getElementsByClassName('comptaTable');
  submitAddInvoiceProduct = document.getElementById('submitAddInvoiceProduct');
  deleteComponents = document.getElementsByClassName('deleteComponent');

  components = <?php echo json_encode($components); ?>;
  selectComponent = document.getElementById('selectComponent');
  inputPriceQuantitys   = document.getElementsByClassName('inputPriceQuantity');



 /*** show add event listener ****/
  showClient.addEventListener('click', function() {
    for(let i = 0; i< comptaTables.length; i++) {
      comptaTables[i].style.display = "none";
    }
  })

  showCompta.addEventListener('click', function() {
    for(let i = 0; i< comptaTables.length; i++) {
      comptaTables[i].style.display = "block";
    }
  })

  /** event listener on delete  **/
  for(let i = 0; i < deleteComponents.length; i++) {
    deleteComponents[i].addEventListener('click', function() {
      let invoicecomponentid = this.dataset.invoicecomponentid;
      let invoiceProductId = this.dataset.invoiceproductid;

        deleteRow(invoicecomponentid, invoiceProductId);
    })
  }


  /***  add event listener on update and add component */ 
  for(let i =0; i < inputPriceQuantitys.length; i++) {
    inputPriceQuantity = inputPriceQuantitys[i];

    inputPriceQuantity.addEventListener('change', function() {
        let invoiceProductId = this.dataset.invoiceproductid;
        calculPrice(invoiceProductId);
    })
  }

  selectComponent.addEventListener('change', function() {
      let elements = this.value;
      let invoiceProductId = elements.split('-')[0];
      let componentId      = elements.split('-')[1];
      let vat              = components[componentId];

      let targetSpanVat = document.getElementById("componentVat"+invoiceProductId);
      targetSpanVat.textContent = vat;
  })


/**** functions */

calculPrice = (invoiceProductId) => {

      priceTtc = parseFloat(document.getElementById('inputPrice'+invoiceProductId).value);
      quantity = parseFloat(document.getElementById('inputQuantity'+invoiceProductId).value);
      vat = parseFloat(document.getElementById('componentVat'+invoiceProductId).textContent);

      let test = document.getElementById('componentVat'+invoiceProductId);

      if(vat !== "" && priceTtc != "" && quantity != "") {
        priceHt = priceTtc*100/(100+vat);

        totalHt= priceHt*quantity;
        totalTtc = priceTtc*quantity;
        document.getElementById('priceHt'+invoiceProductId).textContent = parseFloat(priceHt).toFixed(2);
        document.getElementById('totalHt'+invoiceProductId).textContent = parseFloat(totalHt).toFixed(2);
        document.getElementById('totalTtc'+invoiceProductId).textContent = parseFloat(totalTtc).toFixed(2);
      }

  }


deleteRow = (invoiceComponentId, invoiceProductId) => {
  
  let myFormData = new FormData();

console.log(invoiceComponentId+' '+invoiceProductId);
  
  myFormData.append('invoiceComponentId', invoiceComponentId);

  let targetUrl = `${urlHost}invoice/delComp/invoiceProductId/${invoiceProductId}/`;
  let bodyData   = myFormData;
  
  fetchAjaxJson(targetUrl, bodyData, deleteComponentSuccess);
}


submitAddInvoiceProduct.addEventListener('click', function() {

  let invoiceProductId = this.dataset.invoiceproductid;
  
  let myFormData = new FormData();

  priceTtc = document.getElementById('inputPrice'+invoiceProductId).value;
  quantity = document.getElementById('inputQuantity'+invoiceProductId).value;
  selectComponent = document.getElementById('selectComponent').value.split('-')[1];

  myFormData.append('invoiceProductId', invoiceProductId);
  myFormData.append('price', priceTtc);
  myFormData.append('quantity', quantity); 
  myFormData.append('componentId', selectComponent);

  let targetUrl = `${urlHost}invoice/addComp/`;
  let bodyData   = myFormData;
  
  fetchAjaxJson(targetUrl, bodyData, addComponentSuccess);

});



/*** SHOW RESULT ****/

addComponentSuccess = (result) => {

  html = `<tr><td>${result.nameFr}</td><td>${result.priceTtc}</td><td>${result.quantity}</td>`;
  if(result.vat == 20) {
    html = html+`<td>${result.totalHt}</td><td></td>`;
  } else {
    html = html+`<td></td><td>${result.totalHt}</td>`;
  }
  if(result.vat == 20) {
    html = html+`<td>${result.totalVat}</td><td></td>`;
  } else {
    html = html+`<td></td><td>${result.totalVat}</td>`;
  }

  html = html+`<td>${result.totalTtc}</td><td><i class="material-icons" onclick="deleteRow('${result.invoiceComponentId}', '${result.invoiceProductId}')">delete</i></td></tr>`;

  $('#bodyInvoiceProduct'+result.invoiceProductId).append(html);

  updateAllNumbers(result, '+');
}

deleteComponentSuccess = (result) => {
  updateAllNumbers(result, '-');

  invoiceComponentRow = document.getElementById('trRow'+result.invoiceComponentId);
  invoiceComponentRow.style.display = "none";

}

updateAllNumbers = (result, sign) => {
  value = document.getElementById('amountTVA').textContent;
  if(sign == "+") { resultant = parseFloat(value) + result.totalVat; } else { resultant = parseFloat(value) - result.totalVat;}
  document.getElementById('amountTVA').textContent = parseFloat(resultant).toFixed(2);;

  value = document.getElementById('invoiceTotalHt').textContent;
  if(sign == "+") { resultant = parseFloat(value) + result.totalHt; } else { resultant = parseFloat(value) - result.totalHt;}
  document.getElementById('invoiceTotalHt').textContent = parseFloat(resultant).toFixed(2);;

  value = document.getElementById('invoiceTotalTtc').textContent;
  if(sign == "+") { resultant = parseFloat(value) + result.totalTtc; } else { resultant = parseFloat(value) - result.totalTtc;}
  document.getElementById('invoiceTotalTtc').textContent = parseFloat(resultant).toFixed(2);

  value = document.getElementById('invoiceProductTtc'+result.invoiceProductId).textContent;
  if(sign == "+") { resultant = parseFloat(value) + result.totalTtc; } else { resultant = parseFloat(value) - result.totalTtc;}
  document.getElementById('invoiceProductTtc'+result.invoiceProductId).textContent = parseFloat(resultant).toFixed(2);
  document.getElementById('invoiceProductTtc2'+result.invoiceProductId).textContent = parseFloat(resultant).toFixed(2);
}
</script>