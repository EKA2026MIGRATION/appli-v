<?php use_helper('dates');?>
<?php $title = "Liste des inscrits "?>

<h1 class="text-center" style="font-size: 28px"><?= $params->product->nameFr; ?><br/><span style="font-size: 18px"><?= $params->product->priceTtc;?> €</span></h1>
<h2 class="text-center" style="font-size: 22px"><span id="nbRegistration"></span> enfants - <span id="showTotalSessions"></span> sessions - <span id="showTotalPriceTtc"></span> €</h2>


<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>

<section class="block-list">
    <ul>
    <?php $i = 0; $s = 0; foreach($params->childs as  $childname => $datas):?>
        <?php $i++;?>
        <li>
            <div>
                <p class="list-header">
                    <div style="color: darkblue"><?= $childname;?></div>
                    <div style="font-style: italic; color: grey; font-size: 14px">
                        <?php foreach($datas as $k => $data):?>
                            Inscription <?= $data->registrationId?> - créée le <?= showDate($data->updatedAt);?> - <?= $data->status;?> - 
                            <?php foreach($data->sessions as $session):?>
                                <?php $sessionsArray[$session->date] = showDate($session->date).' '.strtoupper(showMomentShort($session->start, $session->end));?>
                                <?php $s++;?>
                            <?php endforeach;?>
                            <span style="color: darkblue; font-style: italic; font-size: 14px"><?php echo implode(' | ', $sessionsArray);?></span>
                            <br/>
                            <?php unset($sessionsArray);?>
                        <?php endforeach;?>
                    <div>
                </p>
                <div class="with-icon">
                    <i class="material-icons">send</i>
                </div>
            </div>

        </li>

    <?php endforeach;?>
    <ul>
</section>
<input type="hidden" name="countRegistration" value="<?= $i;?>" id="countRegistration" />
<input type="hidden" name="nbTotalSessions" value="<?= $s;?>" id="nbTotalSessions" />
<input type="hidden" name="totalPriceProduct" value="<?= $params->product->priceTtc;?>" id="totalPriceProduct"/>

