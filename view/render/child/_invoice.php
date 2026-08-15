<style>
  #invoiceList p { display: flex; justify-content: space-between}
  #invoiceList div { color: darkblue!important}
  .infoCreation { font-size: 0.7rem; font-style: italic; color: black!important}
  #invoiceList div > span { font-weight: bold}
</style>
<?php use_helper('dates');?>
<div class="tabs-panel" id="panel8">

    <div class="text-center">
        
        
        <a class="button" style="display: inline" href="<?= HOST; ?>child/display/id/<?= $params->child->childId;;?>/year/<?= $params->year-1; ?>/"><</a>
        <h5  style="display: inline">
            &nbsp;&nbsp;&nbsp;
            Facture sur l'année <?= $params->year;?>
            &nbsp;&nbsp;&nbsp;
        </h5>
        <a class="button" style="display: inline"  href="<?= HOST; ?>child/display/id/<?= $params->child->childId;?>/year/<?= $params->year+1; ?>/">></a>

    </div>

    <section class="block-list">
        <ul id="">
            <?php foreach($params->invoices as $invoice):?>
                <?php ($invoice->status == "payed-draft") ? $class = "draft" : $class = "";?>
                <li class="<?= $class;?>" style="position:relative">
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
                                <a href="https://appli-v.net/download/i/v/<?= encodeInt($invoice->invoiceId);?>/i/c/" target="_blank" title="vue détaillée">
                                    <i class="material-icons">print</i>
                                </a>
                                <a href="https://appli-v.net/download/i/v/<?= encodeInt($invoice->invoiceId);?>/i/full/" target="_blank" title="vue client">
                                    <i class="material-icons">send</i>
                                </a>
                            </div>
                        </p>
                    </div>

                    <div style="display: <?= ($class == "draft") ? "block" : "none" ;?>" class="draft2">
                        BROUILLON
                    </div>
                </li>
            <?php endforeach; ?>

        </ul>
    </section>


</div>