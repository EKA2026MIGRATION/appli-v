<?php 
  $title="Gestion des donages"; 
  require_once('_createReminder.php');
  require_once('_displayReminder.php');
  require_once('_generateCronFormat.php');
?>


<h1> Rappels </h1>


<div class="text-center">
  <button class="button" onclick="changeActionSurvey()" data-open="createReminder"> Créer un rappel </button>
</div>

<h3> Rappels reçus</h3>
<section class="block-list">
  <ul id="reminderList">
    <li>
      <a href="javascript:void(0)">
        <div>
          <p class="list-header">
            <img src="" class="width-30 height-30" />
            Véhicule Espace 356 - Date récurrente - Contrôle technique à faire
            <div class="with-icon">
              <i class="material-icons">check</i>
            </div>
          </p> 
        </div>
      </a>
    </li>
  </ul>
</section>
<div style="height: 50px;"></div>
<h3> Rappels programmés</h3>
<section class="block-list">
  <ul id="reminderList">
    <li>
      <a href="javascript:void(0)">
        <div>
          <p class="list-header">
            <img src="" class="width-30 height-30" />
            Véhicule Espace 356 - Date récurrente - Contrôle technique à faire - Prochain envoi le ...
            <div class="with-icon">
              <i class="material-icons">edit</i>
            </div>
          </p> 
        </div>
      </a>
    </li>
  </ul>
</section>

<input type="hidden" id="lastIdVehicle">