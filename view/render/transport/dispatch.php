<?php
 $title = 'Dispatcher Transport';
 use_helper('photo, translation, loader');
 ?>

<?= showFloatingActionButton($params->buttons); ?>

<div class="flexForBarreScroll">
    <section class="dispatchPage">

        <?php showDatePickerNavigation('transport/dispatch/date', $params->date); ?>
        <?php include '_sendRideUber.php'; ?>
        <?php include '_createRideMultiple.php'; ?>
        <?php include '_createRide.php'; ?>
        <?php include '_actionPickUp.php'; ?>
        <?php include '_actionDispatch.php'; ?>
        <?php include '_createPickup.php'; ?>
        <?php include '_mapRide.php'; ?>
        <?php include '_changeRide.php'; ?>

        <div class="grid-x grid-margin-x">
            <div class="cell medium-6 large-6 small-12 margin-top-20">
                <div class="slider margin-bottom-9" data-slider data-start="630" data-end="1830" data-step="5"data-initial-start="700" data-initial-end="1800">
                    <span class="slider-handle"data-slider-handle role="slider"tabindex="1"></span>
                    <span class="slider-fill"data-slider-fill></span>
                    <span class="slider -handle"data-slider-handle role="slider"tabindex="1"></span>
                    <input type="hidden" id="hour1">
                    <input type="hidden"id="hour2">
                </div>
                <div class="text-center bold">
                    Filtre par heure : <span id="hourFilter">7h00 - 18h00</span>
                </div>
            </div>

            <div class="cell medium-6 large-6 small-12 margin-top-20 flexCenter">
                <div onclick="loadDrivers()">
                    <select id="driverFilter">
                        <optgroup label="Chauffeurs"></optgroup>
                    </select>
                </div>

                <button class="button displayBlock" id="driverFilterValidate" style="display: block"> OK </button>
                <input type="hidden" id="liveResult" />
            </div>
        </div>

        <div class="text-center margin-top-10">
            <button class="button" onclick="saveDispatch('button')">Valider le transport</button>
        </div>

        <!--
            <div class="validationInformation"><?= loader('Les informations de validation sont en cours de chargement '); ?></div>
        -->
        <div class="callout alert-callout-subtle" style="background-color: lightblue">
            <strong>Gestion des absences<br></strong> <span class="msg"></span>
            <ul>
                <li>Passer un enfant en absent le rend absent toute la journée (présences, activités)</li>
                <li>Pour enfant exceptionnellement sans transport, retirer le pickup du transport</li>
            </ul>
           
        </div>

        <div id="pickUpFull" data-closable class="callout alert-callout-subtle alert displayNone">
            <strong>Information !<br></strong> <span class="msg"></span>
            <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                <span aria-hidden="true">⊗</span>
            </button>
        </div>

        <div class="dragDispatch">
            <div class="column1">

                <section class="block-list" data-id-ride="npec">
                    <?= loader('Les pickups sont en cours de chargement '); ?>
                </section>

            </div>

            <hr/>

            <h3 class="dispatchTitle">Répartition par véhicule</h3>

            <div class="column2">
                <?= loader('Les rides sont en cours de chargement '); ?>
            </div>
            <?php //include '_createDropOff.php'; ?>
        </div>
        <input type="hidden" id="lastIdPickup">
        <input type="hidden" id="dateDispatch" value="<?= $params->date; ?>">
        <input type="hidden" id="person_connected" value="<?php echo PERSON_CONNECTED['firstname']; ?>">
        <div class="space_actions_page_mobile"></div>
    </section>
    <div class="barreScroll animateBackground displayBlock"></div>
</div>
