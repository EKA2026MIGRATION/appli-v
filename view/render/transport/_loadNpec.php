<?php
$lastStatus = 'first';
use_helper('loader');
?>
<section class="block-list" data-id-ride="npec">

    <div class="text-center" style="margin-top: 16px;"><button class="button" onclick="loadNpec()">Recharger les pickups</button>
        <div class="reloadingPickup" style="display: none;">
            <?= loader('Les pickups sont en cours de chargement'); ?>
        </div>
    </div>

    <header>
        <i class="material-icons arrow">keyboard_arrow_up</i> NPEC
    </header>

    <ul id="pickUpListNPEC">
        <h3 class="text-center margin-top-10">

            <i class="material-icons orderPickups" id="button-Dropin-postal" style="cursor: pointer; color: lightgrey">home</i>
            <i class="material-icons orderPickups" id="button-Dropin-name" style="cursor: pointer; color: darkblue">person</i>
            Prise en charge
            <a href="javascript:void(0)" onclick="toogleDropIn(this);">
                <i class="material-icons">keyboard_arrow_up</i>
            </a>
        </h3>
        <hr>
        <aside class="dropin">
            <ul id="ulPickupsDropin">
                <?php foreach ($params->pickups_unaffected_dropin as $pickup) :  ?>
                    <?php include '_showPickupUnaffected.php'; ?>
                <?php endforeach; ?>
            </ul>
        </aside>

        <h3 class="text-center margin-top-10">
            <i class="material-icons orderPickups" id="button-Dropoff-postal" style="cursor: pointer; color: lightgrey">home</i>
            <i class="material-icons orderPickups" id="button-Dropoff-name" style="cursor: pointer; color: darkblue">person</i>

            Dépose <a href="javascript:void(0)" onclick="toogleDropOff(this);">
                <i class="material-icons">keyboard_arrow_up</i></a>
        </h3>
        <hr>
        <aside class="dropoff">
            <ul id="ulPickupsDropoff">
                <?php foreach ($params->pickups_unaffected_dropoff as $pickup) :  ?>
                    <?php include '_showPickupUnaffected.php'; ?>
                <?php endforeach; ?>
            </ul>
        </aside>
    </ul>
</section>