<?php use_helper('dates');?>
<?php $title = "Dupliquer les activités";?>
<input type="hidden" id="currentDate" value="<?= $params->date;?>"/>

<h1>Dupliquer les activités</h1>



<p>
  Vous allez dupliquer les activités du <?= showDate($params->date);?><br/>

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
              <li>Tous les groupes d'origine seront créés</li>
              <li>Si les coachs ne sont pas présents le jour cible, les groupes seront sera créés sans lui</li>
              <li>Si un groupe existe en cible, il ne sera pas effacé</li>
              <li>Si un groupe identique existe en cible, il sera modifié</li>
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
