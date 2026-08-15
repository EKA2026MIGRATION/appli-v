<div class="grid-x grid-margin-x">
    <div class="cell medium-6 large-6 small-12"style="margin-top: 20px;">

        <div class="slider" style="margin-bottom: 0.5rem;" data-slider data-start="630" data-end="1830" data-step="5" data-initial-start="700"data-initial-end="1800">
            <span class="slider-handle"data-slider-handle role="slider"tabindex="1"></span>
            <span class="slider-fill"data-slider-fill></span>
            <span class="slider-handle"data-slider-handle role="slider"tabindex="1"></span>
            <input type="hidden" id="hour1">
            <input type="hidden"id="hour2">
        </div>
        <center><strong> Filtre par heure : <span id="hourFilter">7h00 - 18h00</span> </strong></center>
        <p><label style="line-height:5px; margin-top: 30px;"><input type="checkbox" id="daily" value="ok" onclick="allFilter()"/> Se servir uniquement du premier curseur<br/><small> (si curseur = 10h, toutes les activités/groups ayant 10h compris dans leur plage seront affichés </small></label></p>
    </div>
    <div class="cell medium-6 large-6 small-12"style="margin-top: 20px;">

        <div class="slider"id="slider2"style="margin-bottom: 0.5rem;"data-slider data-start="1"data-end="18"data-step="1"data-initial-start="1"data-initial-end="18">
            <span class="slider-handle"data-slider-handle role="slider"tabindex="1"></span>
            <span class="slider-fill"data-slider-fill></span>
            <span class="slider-handle"data-slider-handle role="slider"tabindex="1"></span>
            <input type="hidden" id="age1">
            <input type="hidden"id="age2">
        </div>
        <center><strong> Filtre par âge : <span id="ageFilter">1 - 18 </span> </strong></center>

    </div>
    <div class="cell medium-6 large-6 small-12 "style="display: flex; margin-top: 20px; justify-content: center;">
        <div >
            <select id="locationFilter">
                 <?php foreach($params->locations as $location): ?>
                    <?php if(     hasCredential('location::showAll') || hasCredential('location::show-'.$location->locationId)   ):?>
                        <option data-id-location="<?php echo $location->locationId; ?>"data-location-name="<?php echo $location->name; ?>"value="<?php echo $location->locationId; ?>"><?php echo $location->name; ?></option>
                    <?php endif;?>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="button"style="display: block"  id="locationFilterValidate" onclick="allFilter()"> OK </button>
        <input type="hidden"id="liveResultLocation"/>
    </div>

    <div class="cell medium-6 large-6 small-12 "style="display: flex; margin-top: 20px; justify-content: center;">
        <div>
            <select id="monitorFilter">
                <optgroup label="Moniteurs">
                        <option value="nothing">Sans moniteur</option>
                    <?php foreach($params->coaches as $coach):
                        if(isset($coach->staff->person)):?>
                           <option value="<?= $coach->staff->staffId; ?>"><?= $coach->staff->person->firstname; ?> <?= $coach->staff->person->lastname; ?></option>
                        <?php else:?>
                           <option>
                                ATTENTION LA PRESENCE <?= $coach->staffPresenceId;?> N'A PAS DE MONITEUR</option>-->
                        <?php endif;?>
                    <?php endforeach; ?>
                    <?php foreach($params->drivers as $driver):
                        if(isset($driver->staff->person)):?>
                            <option value="<?= $driver->staff->staffId; ?>"><?= $driver->staff->person->firstname; ?> <?= $driver->staff->person->lastname; ?></option>
                        <?php else:?>
                            <option>
                                ATTENTION LA PRESENCE <?= $driver->staffPresenceId;?> N'A PAS DE MONITEUR</option>-->
                        <?php endif;?>
                    <?php endforeach; ?>
                    <?php foreach($params->trainees as $trainee):
                        if(isset($trainee->staff->person)):?>
                            <option value="<?= $trainee->staff->staffId; ?>"><?= $trainee->staff->person->firstname; ?> <?= $trainee->staff->person->lastname; ?></option>
                        <?php else:?>
                            <option>
                                ATTENTION LA PRESENCE <?= $trainee->staffPresenceId;?> N'A PAS DE MONITEUR</option>-->
                        <?php endif;?>
                    <?php endforeach; ?>
                </optgroup>
            </select>
        </div>
        <button class="button" style="display: block" id="monitorFilterValidate"  onclick="allFilter()"> OK </button>
        <input type="hidden"id="liveResultMonitorBis"/>
    </div>
</div>