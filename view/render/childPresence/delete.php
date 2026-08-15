<?php $presence = $params->childPresence;?>
<?php use_helper('dates');?>
<?php $title = "Présence ".showDate($presence->date)." - de ".showTime($presence->start)." à ".showTime($presence->end).' à '.$presence->location->name; ?>

<h1 class="text-center"><?= $presence->child->firstname.' '.$presence->child->lastname;?></h1>
<h5 class="text-center"><?= $title;?></h5>


<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>


<div class="page__profil">

    <h4>Suppression de la présence du <?= showDate($presence->date);?></h4>
    <br/>
    En cliquant sur <button>Valider</button>, la présence va être supprimée, mais aussi:
    <ul>
        <li>les transports liés</li>
        <li>les activités de la journée</li>
        <li>les repas associés</li>
    </ul>
    <br/>
    Pour retrouver cette présence, il faut repasser par la fiche de l'enfant.
    <br/><br/>

    <form action="<?= HOST ?>childPresence/confirmDelete/" method="POST">
        <input type="hidden" name="backUrl" value="child/presence/date/<?= $presence->date;?>/"/>
        <input type="hidden" name="childPresenceId" value="<?= $presence->childPresenceId ?>/"/>
        <input type="submit" class="button" value="Valider la suppression de la présence"/>
    </form>

   
</div>


<div class="space_actions_page_mobile"></div>