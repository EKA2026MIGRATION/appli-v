<?php use_helper('dates, buttons');?>
<?php $title = "Liste des courses"; ?>

<button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>

<h3>
    <b>Date des dernières courses des courses</b>
    <br/>
    <i style="font-size: 16px">dernier inventaire : <?= showDate($params->latestDate);?></i>
</h3>


<section class="block-list">
    <ul>
        <?php foreach($params->stockOrders as $stockOrder):?>
            <li style="position:relative">
                <a href='<?= HOST;?>stock/order/date/<?= showDate($stockOrder->dateOrder->date, 'Y-m-d');?>/' title="Voir le détail">
                    <div id="invoiceList">
                        <p class="list-header">
                        <div>
                            <span>id. <?= $stockOrder->id;;?></span> - <?= showDate($stockOrder->dateOrder->date);?>
                        </div>
                        <div class="with-icon">
                            <i class="material-icons">send</i>
                        </div>
                        </p>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
