<?php $currentActivity = $params->currentActivity;?>
<?php $activities = $params->activities;?>

<?php use_helper('dates');?>
<div class="medium-12 cell">

    <h2>Modification des activités liées</h2>
    <br/>
    <div style="text-align: center">
    <h5><b><?= $currentActivity->child->firstname.' '.$currentActivity->child->lastname ;?></b></h5>
    <H5>Activité de référence <?= $currentActivity->pickupActivityId;?> du <?= showDate($currentActivity->date);?></h5>
    </div>
    <ul style="display: flex; justify-content: space-around; list-style-type: none;">
        <li style="border: 2px solid darkblue; padding: 10px 20px 10px 20px">Début : <?= showTime($currentActivity->start);?></li>
        <li style="border: 2px solid darkblue; padding: 10px 20px 10px 20px">Fin : <?= showTime($currentActivity->end);?></li>
        <li style="border: 2px solid darkblue; padding: 10px 20px 10px 20px">Sport : <?= $currentActivity->sport->name;?></li>
    </ul>
    <br/><br/>
    Sélectionnez les dates où appliquer les modifications :<br/>
    <br/>
    <input type="checkbox" name="checkAll" value = "0" id="chekckAllButton">&nbsp;&nbsp;Tout cocher
    <br/>
    <form action="<?= HOST;?>activity/doUpdateAllRegistration/" method="post">
        <input type="hidden" name="newSport" value="<?= $currentActivity->sport->sportId;?>">
        <input type="hidden" name="currentDate" value="<?= $currentActivity->date;?>"/>
        <?php foreach($activities as $activity):?>
            <?php if($activity->date != $currentActivity->date && $activity->sport->sportId != 10 && $activity->sport->sportId == $params->sportSelected):?>
                <ul style="display: flex; list-style-type: none;">
                    <li><input type="checkbox" name="activitysAssociated[]" class="activitysAssociated"  value="<?=$activity->pickupActivityId;?>"</li>
                    <li style="padding: 10px 20px 10px 20px">Date : <?= showDate($activity->date);?></li>
                    <li style="padding: 10px 20px 10px 20px">Début : <?= showTime($activity->start);?></li>
                    <li style="padding: 10px 20px 10px 20px">Fin : <?= showTime($activity->end);?></li>
                    <li style="padding: 10px 20px 10px 20px">Sport : <?= $activity->sport->name;?></li>
                </ul>
            <?php endif;?>
        <?php endforeach;?>

        <div class="medium-12 cell">
            <center><input type="submit" class="button large" id="" value="Envoyer" /></center>
        </div>

    </form>

</div>





