<?php use_helper('dates');?>
<?php $title = "Dupliquer le transport";?>
<input type="hidden" id="currentDate" value="<?= $params->date;?>"/>

<h1>Dupliquer le transport</h1>



<p>
  Vous allez dupliquer les transport du <?= showDate($params->date);?><br/>

  <ul id="duplicateTask">
      <li>
        <i class="material-icons" class="calendar_change_date" id="datePickerButton" style="cursor: pointer">date_range</i>
        <div id="datePicker" style="display: none; cursor: pointer"></div>
        <span id="infoCheckDate">
            Sélectionnez la date cible
        </span>
        <div class="with-icon" style="float: right; display: none" id="checkDate">
            <i class="material-icons" style="color: darkgreen; font-weight: bold">check</i>
        </div>

      </li>
      <li id="replicationLi" style="display: none">

          Vous allez lancer la duplication
          <ul>
              <li>Tous les trajets d'origine seront créés</li>
              <li>Si le driver n'est présent le jour cible, le trajet sera créé sans lui</li>
              <li>Seuls les pickups non affectés sur le jour cible sont pris en compte</li>
              <li>Tous les pickups cible prennent les réglages du jour d'origine</li>
              <li>Si un trajet existe en cible, il ne sera pas effacé</li>
              <li>Si un trajet identique existe en cible, il sera modifié</li>
          </ul>
          <br/>
          <button class="button" style="text-align: center; width: 100%" id="replicationButton">
                  LANCER LA REPLICATION
          </button>

      </li>

      <div id="duplicationResult"></div>




      <!-- forcer la mise à jour -->

      <!--- tableau de rapport -->





  </ul>







</p>
