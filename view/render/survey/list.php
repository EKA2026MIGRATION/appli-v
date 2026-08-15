<?php
$title = "Gestion des donages";
require_once('_createSurvey.php');
?>


<h1> Sondages </h1>

<div class="text-center">
  <a href="<?= HOST; ?>survey/create"> Créer un sondage </a>
</div>

<section class="block-list">
  <ul id="surveyList">


    <?php foreach ($params->surveys as $survey) : ?>
      <li>
        <a href="<?= HOST; ?>surveySession/result/id/<?= $survey->id; ?>/">
          <div>
            <p style="padding: 0; margin: 0;" class="list-header">
              <?= $survey->name; ?> - <?= $survey->description; ?> -
              <?php if ($survey->isActive == 1) : ?>
                <span style="color: green;">Actif</span>
              <?php else : ?>
                <span class="color: red;">Inactif</span>
              <?php endif; ?>
            <div class="with-icon">
              <i class="material-icons">send</i>
            </div>
            </p>
          </div>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>


<input type="hidden" id="lastIdVehicle">