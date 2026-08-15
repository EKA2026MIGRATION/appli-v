<?php use_helper('invoice');?>
<?php $arr = ['Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa', 'Di'];?>

<style>
    .flexWeekView { margin-top : 20px}
    .flexColumn ul { 
        list-style-type: none;
        margin: 0px;
        padding: 0px;
    }
    .flexColumn li {
        border-bottom: 2px solid darkred;
        padding: 4px;
        text-align: center;
        
    }
    #totalBar {
        border: 4px solid darkred;
        text-align: center;
        color: darkblue;
        font-size: 16px;
        width: 95%;
        margin: 0 auto;
        padding: 6px;
        font-weight: bold;
    }
    .detailsLineInfo {font-size: 11px; font-style: italic; padding-left: 4px!important}
    .detailsLineInfo li { border-bottom: 0px solid red; font-weight: 100; text-align: left; padding: 0px; }
    .detailslineInfoWeek { display: flex; flex-wrap: wrap; justify-content: space-around; font-weight: 100; font-size: 14px}
</style>

<div id="calendarDayBar">
    <div class="showDateColButtonInvoice">Lu</div>
    <div class="showDateColButtonInvoice">Ma</div>
    <div class="showDateColButtonInvoice">Me</div>
    <div class="showDateColButtonInvoice">Je</div>
    <div class="showDateColButtonInvoice">Ve</div>
    <div class="showDateColButtonInvoice">Sa</div>
    <div class="showDateColButtonInvoice">Di</div>
</div>

<div id="totalBar">
    <div>TOTAL SEMAINE : <span id="showTotalWeek"></span></div>
    <div style="border-top: 1px solid darkblue;">
        <b>TOTAL MOIS : <?= $params->totalMonth['Total TTC'];?> €</b>
        <div class="detailslineInfoWeek">
            <?php foreach($params->totalMonth as $key => $totalMonth):?>
                <?php if ($key == "Total TTC") continue;?>
                <div><?= $key;?>: <?= $totalMonth;?> €</div>
            <?php endforeach;?>
        </div>
    </div>
</div>


<div class="flexWeekView">

      <?php $totalWeek = 0; $totalWeekVat10 = 0; $totalWeekVat20 = 0; $totalWeekHt = 0; $totalWeekTva = 0;?>

     

      <?php $i = 0; foreach ($params->invoicesWeek as $date => $invoiceByDay):?>



          <div class="flexColumn">
                    <div id="showDateColButtonInvoices<?=$arr[$i];?>" class="flexDate" style="background-color: darkblue; color: white;">
                            <?= showDate($date, 'l');?>
                            <?= showDate($date);?>
                    </div>
                    <div style="background-color: lightblue; color: black; font-weight: bold; text-align: center" id="price<?=$date;?>">
                    </div>

                              
                    <?php if($invoiceByDay):?>
                            <?php ksort($invoiceByDay);?>
                            <ul>
                                <?php $totalDay = 0; $totalVat10 = 0; $totalVat20 = 0; $totalHt = 0; $totalTva = 0;?>
                                <?php foreach($invoiceByDay as $invoice):?>

                                    <li>
                                        <div style="text-align: center; font-weight: bold; color: darkblue">
                                            <?= showDate($invoice->date, 'H:i:s');?>
                                        </div>
                                        <span style="font-style: italic; font-size: 12px">#<?= $invoice->invoiceId;?></span>
                                        <?= $invoice->nameFr;?><br/>
                                        <span style="font-weight: bold; color: black"><?= $invoice->priceTtc;?> € TTC</span>
                                        <?php $totalDay += $invoice->priceTtc;?>
                                        <br/>
                                        <?php if($transaction = $invoice->transaction):?>
                                            <span style="font-style: italic; font-size: 12px">
                                                Transaction: #<?= $transaction->transactionId.' '.$transaction->amount.' €';?>
                                            </span>
                                        <?php endif;?>

                                        <?php $datas = extractTva($invoice);?>

                                        <?php if($datas == "no products"):?>

                                            <div style="font-style: italic; color: red; font-size: 12px">Pb sur la facture <?= $invoice->invoiceId;?></div>

                                        <?php else:;?>

                                            <?php if(isset($datas['vat10'])) $totalVat10 += $datas['vat10'];?>
                                            <?php if(isset($datas['vat20'])) $totalVat20 += $datas['vat20'];?>
                                            <?php $totalHt += $datas['totalHt']; $totalTva += $datas['totalTva'] ;?>   
                                        
                                        <?php endif;?>
                                    </li>
                                <?php endforeach;?>
                            <ul>
                            <?php $totalWeek += $totalDay;?>

                            <?php if(isset($totalVat10)) $totalWeekVat10 += $totalVat10;?>
                            <?php if(isset($totalVat20)) $totalWeekVat20 += $totalVat20;?>
                            <?php $totalWeekHt += $totalHt; $totalWeekTva += $totalTva; ;?>   

                            <script>
                                totalInvoiceDay   = "<?php echo $totalDay;?>"; 
                                totalInvoiceHt    = "<?php echo $totalHt;?>";
                                totalInvoiceVat10 = "<?php echo $totalVat10;?>";
                                totalInvoiceVat20 = "<?php echo $totalVat20;?>";
                                totalInvoiceTva   = "<?php echo $totalTva;?>";

                                detailsInvoiceLineTva = `<ul class="detailsLineInfo"><li>Total HT: ${totalInvoiceHt}</li><li>Total TVA: ${totalInvoiceTva}</li><li>TVA 10%: ${totalInvoiceVat10}</li><li>TVA 20%: ${totalInvoiceVat20}</li></ul>`;
                                
                                myPriceDate = "<?php echo $date;?>";
                                document.getElementById('price'+myPriceDate).innerHTML = ''+totalInvoiceDay+' € TTC<br/>'+detailsInvoiceLineTva;
                            </script>
                    <?php endif;?>
          </div>
          <?php $i++;?>
      <?php endforeach; ?>
      <script>
            totalInvoiceWeek = "<?php echo $totalWeek;?>"; 

            totalWeekHt    = "<?php echo $totalWeekHt;?>";
            totalWeekVat10 = "<?php echo $totalWeekVat10;?>";
            totalWeekVat20 = "<?php echo $totalWeekVat20;?>";
            totalWeekTva   = "<?php echo $totalWeekTva;?>";

            detailsInvoiceLineTvaWeek = `<div class="detailslineInfoWeek"><div>Total HT: ${totalWeekHt} €</div><div>Total TVA: ${totalWeekTva} €</div><div>TVA 10%: ${totalWeekVat10} €</div><div>TVA 20%: ${totalWeekVat20} €</div></div>`;

            document.getElementById('showTotalWeek').innerHTML = totalInvoiceWeek+" € TTC<br/>"+detailsInvoiceLineTvaWeek;
      </script>
</div>

<script>
     showDateColButtonInvoices = document.getElementsByClassName('showDateColButtonInvoice');

    for(z= 0; z < showDateColButtonInvoices.length; z++) {

        showDateColButtonInvoices[z].addEventListener('click', function() {
        let target = document.getElementById('showDateColButtonInvoices'+this.textContent);

        target.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    })
    }
</script>