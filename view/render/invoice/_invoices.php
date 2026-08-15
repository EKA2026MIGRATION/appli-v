<style>
  .draft { background-color: lightgrey;}
  .draft2 { font-size: 40px;
            font-weight: bold;
            position: absolute;
            text-align: right;
            right: 40px;
            opacity: 0.5;
    }
</style>

<div id="showInvoiceDetails" class="">
</div>

<?php showFloatingActionButton($params->buttons); ?>

<?php if(!isset($hideForm)):?>

    <form action="<?= HOST."invoice/list";?>" method="post" class="form-balance-sheet">
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
        <input type="submit" class="button" value="Afficher"/>
    </form>

<?php endif;?>


<section class="block-list">
  <ul id="">    
    <?php foreach($params->invoices as $invoice):?>
      <?php ($invoice->status == "payed-draft") ? $class = "draft" : $class = "";?>
      <li class="<?= $class;?>" style="position:relative">
        <!-- view full -->
        <a href='invoice/display/<?= $invoice->invoiceId;?>' title="Vue détaillée" class="displayInvoiceButton" id="full-<?= $invoice->invoiceId;?>">
        <!-- view customer <a href='invoice/display/<?= $invoice->invoiceId;?>' title="Vue client"  class="displayInvoiceButton" id="customer-<?= $invoice->invoiceId;?>">-->
          <div id="invoiceList">
            <p class="list-header">
              <div>
                <span style="color: black">N° <?= $invoice->number;?></span> - <?= $invoice->nameFr;?>
              </div>
              <div>
                <span><?= $invoice->priceTtc;?> € </span>- 
                <?= $invoice->paymentMethod;?>
              </div>
              <div class="infoCreation">
                  #<?= $invoice->invoiceId;?> - 
                  <?= showDate($invoice->date, 'l j/m'). ' '.showTime($invoice->date);?><br/>
                  Créée par <?= ucfirst($invoice->createdByName);?>
              </div>

              <div class="with-icon">
                <i class="material-icons">send</i>
              </div>
            </p> 
          </div>
        </a>
        <div style="display: <?= ($class == "draft") ? "block" : "none" ;?>" class="draft2">
          BROUILLON
        </div>
      </li>
    <?php endforeach; ?>

  </ul>
</section>

<script>
  var showCompta;
  var showClient;
  var comptaTables;
  var components;
  var selectComponent;
  var deleteRow;
  var updateAllNumbers;
  var inputPriceQuantitys;
  var price, quantity, vat, total;
  var calculPrice;
  var submitAddInvoiceProduct, deleteComponents, deleteComponentSuccess, invoiceComponentRow;
  var html, row, cell;
  var amountTVA, invoiceTotalHt, invoiceTotalTtc, value, resultant;


  const fetchAjaxJson = (targetUrl, bodyData, callBack) => {
    const options = {
        method: 'POST',
        body: bodyData
      };
      fetch(targetUrl, options)
      .then(function(response) {
        return response.json();
      })
      .then(function(result) {
         callBack(result);
      });
  }
</script>