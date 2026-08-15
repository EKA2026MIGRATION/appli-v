<style>
    .rowWeek { display: flex; justify-content: center; flex-wrap: wrap; margin-bottom: 3px;} 
    .celDay { border: 1px solid lightgrey; width: 12%; min-width: 100px; font-size: 0.9rem;}
    .center {text-align: center; font-weight: bold}
    .celDay ul { list-style: none; margin: 0px; padding: 0px}
    .rowWeek, .devContent { padding-left: 10px; padding-top: 10px; min-height: 90px;}
    .dayName { color: darkblue; background-color: #f2f2f2; padding-top: 4px; padding-bottom: 4px; font-weight: normal}
    .celContentPresence { cursor: pointer}
    .targetDay { background-color: darkred; color: white; font-weight: white}

    @media only screen and (max-width: 600px) {
      .celDay { min-width: 200px; width: 100%;} 
    } 
</style>


<input type="hidden" value="<?= $params->currentStaff->staffId;?>" id="currentStaffId"/>
<input type="hidden" value="<?= $params->target;?>" id="targetDate"/>

<?php ($params->currentStaff->kind == "driver") ? $hour_start_value = "08:30" : $hour_start_value = "09:00";?>
<?php ($params->currentStaff->kind == "driver") ? $hour_end_value = "18:30": $hour_end_value = "17:00";?>

<?php is_array($params->presences->presences) ? $presences = [] : $presences = get_object_vars($params->presences->presences);?>


<?php include VIEW.'render/staffPresence/_createPresence.php'; ?>

<div id="showStaffPresenceForm">
    <i class="material-icons" style="color: darkred; float: right; cursor: pointer" id="closeStaffPresence">close</i>

    <h6>Modifier le statut</h6>

    <button class="typeABSENCE editButton" id="update-ABSENCE">ABSENCE</button>
    <button class="typeCATCHING editButton" id="update-CATCHING">RATTRAPAGE</button>
    <button class="typeBONUS editButton" id="update-BONUS">BONUS</button>
    <button class="editButton" id="update-PRESENCE">PRESENCE</button>
    <br/><br/>
    <button class="typeVACATION editButton" id="update-VACATION">CONGES</button>
    <button class="typeFORMATION editButton" id="update-FORMATION">FORMATION</button>

    <br/>

    <br/><br/>

    <button class="editButton" id="update-DELETE" style="background-color: darkred; color: white">SUPPRIMER</button>

    <input type="hidden" id="staffPresenceIdToUpdate" name="staffPresenceId"/>

</div>

<?php $currentMonth = "";?>

<?php  
        $total_TYPE = [];
        $total_GROUPNAME = [];
        $total_GROUPNAMEDAY = [];
        $total_KIND = [];
        $total_KIND_HOURS = [];
        $total_presences = 0;
        $presence_months = null;
        $totalTime = 0;
        $total_day = [];
;?>
<?php foreach($params->season->weeks as $week):?>

        <?php if( $currentMonth != getMonth($week->dateStart)):?>
            <br/>
            <h5 class="center" style="color: darkred"><?= getMonth($week->dateStart);?> <?= showDate($week->dateStart, 'Y');?></h5>
            <?php $currentMonth = getMonth($week->dateStart);?>
        <?php endif;?>
        <div class="rowWeek">
            <div class="celDay headCol type<?=$week->kind;?>">
                <ul>
                    <li class="center dayName"><?= $week->code;?></li>
                    <div class="devContent">
                        <li><?= $week->name;?></li>
                        <li><?= $week->groupName;?></li>
                    </div>
                </ul>
            </div>
            <?php $currentDate =  $week->dateStart;?>
            <?php for($i = 0; $i<7; $i++):?>
                <div class="celDay type<?=$week->kind;?>"> 
                        <div id="celDay-<?= $currentDate;?>" class="center dayName <?php if($currentDate == $params->target) echo 'targetDay';?>">
                            <?= showDate($currentDate, 'l j/m') ?>
                        </div>

                        <?php if(key_exists($currentDate, $presences)):?>
                            <?php $typeName = $presences[$currentDate]->typeName;?>
                            <div class="devContent type<?= $typeName;?> celContentPresence" id="presence-<?= $presences[$currentDate]->staffPresenceId;?>">
                                <ul>
                                    <li id="typeName-<?= $presences[$currentDate]->staffPresenceId;?>"><?= maj(trans($typeName));?></li>
                                    <?PHP if($typeName != 'VACATION'):?>
                                        <li>Durée: <?= $duration = timeSpend($presences[$currentDate]->start, $presences[$currentDate]->end);?></li>
                                        <li><?= $presences[$currentDate]->location;?></li>
                                    <?php endif;?>
                                </ul>
                            </div>
                            <!-- increment total by type -->      
                            <?php if(!isset($total_TYPE[$typeName])) $total_TYPE[$typeName] = 0;?>
                            <?php $total_TYPE[$typeName]++;?>

                            <!-- increment kind -->
                            <?php if(!isset($total_KIND[$week->kind][$typeName])) $total_KIND[$week->kind][$typeName] = 0;?>
                            <?php $total_KIND[$week->kind][$typeName]++;?>

                            <!-- increment kind hours -->
                            <?php if($typeName != "VACATION"):?>
                                <?php if(!isset($total_KIND_HOURS[$week->kind][$typeName])) $total_KIND_HOURS[$week->kind][$typeName] = '00:00';?>
                                <?php $total_KIND_HOURS[$week->kind][$typeName] = incrementTime($total_KIND_HOURS[$week->kind][$typeName], $duration);?>
                            <?PHP endif;?>

                            <!-- increment groupName -->
                            <?php if(!isset($total_GROUPNAME[$week->groupName][$typeName])) $total_GROUPNAME[$week->groupName][$typeName] = 0;?>
                            <?php $total_GROUPNAME[$week->groupName][$typeName]++;?>

                            <!--- increment by day and group ---->
                            <?php //if($typeName != "VACATION" || $typeName != "ABSENCE"):?>
                            <?php  if($typeName == "PRESENCE"):;?>
                                <?php if(!isset($total_GROUPNAMEDAY[$week->groupName][showDate($currentDate, 'l')])) $total_GROUPNAMEDAY[$week->groupName][showDate($currentDate, 'l')] = 0;?>
                                <?php $total_GROUPNAMEDAY[$week->groupName][showDate($currentDate, 'l')]++;?>
                            <?php endif;?>


                        <?php else:?>
                            <div class="addStaffPresence" id="addPresence_<?= $currentDate;?>_<?= $params->currentStaff->staffId;?>" style="cursor: pointer; height: 80%">
                                &nbsp;
                            </div>

                        <?php endif;?>
                </div>
                <?php $currentDate = nextDay($currentDate);?>
            <?php endfor;?>
        </div>
<?php endforeach;?>