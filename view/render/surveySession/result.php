<?php
use_helper('dates, translation, buttons');
showFloatingActionButton($params->buttons);
$title = "Gestion des sondages";
$survey = $params->results->survey;
$sessions = $params->results->sessions;
$staffNotations = $params->results->staffNotations;
$sessionData = $params->results->sessionData;
?>
<style>
.notationRow  {
    box-sizing: border-box;
  }
  .notationRow:nth-child(even) {
      background-color: lightgrey;
  }
  .notationRow div {
    box-sizing: border-box;
    padding: 4px;
    text-align: center;
  }
  .notationRow div:first-child {
      width: 200px; 
      text-align: left;

  }
  .notationRow div:nth-child(2) {
      width: 50px;
  }

  .notationRow div:nth-child(3) {
      width: 110px;
  }

  .notationRow div:nth-child(4) {
      width: 150px;
      text-align: right;
      padding-right: 8px;
  }

  .title {
    background-color: darkblue!important; color: white; font-weight: bold;
  }

  .title div {
    text-align: center!important; cursor: pointer;
  }
</style>


<div class="actionsPage">
  <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>

<h1 style="margin-top: 45px; text-align: center"><?= $survey->name; ?></h1>


<p>
  <?= $survey->description;?>
</p>

<div>
  <ul>
      <li>Date de création : <?= showDate($survey->createdAt->date);?></li>
      <li>Description: <?= $survey->description;?></li>
      <li style="list-style: none">
        <h6 style="text-align: center; font-weight: bold;">Chapitres</h6>   
        <ul class="flexAround">
          <?php foreach($survey->chapters as $chapter):?>
          <?php $types[] = $chapter->type;?>
          <li style="list-style: none">
              <b><?= $chapter->name;?></b>
              <ul>
                <?php foreach($chapter->questions as $question):?>
                    <li><?= $question->name;?></li>
                <?php endforeach;?>
              </ul>
          </li>
          <?php endforeach;?>
        </ul>
      </li>
  </ul>
</div>

<hr/>


<div class="flexAround">
  <?php foreach($types as $type):?>
    <div>
      <b><?= ucfirst($type);?></b>

      <div class="flexAround">
          <div>Moy: <?= $params->results->total->$type->average;?></div>
          <div>Nb notes: <?= $params->results->total->$type->nbResult;?></div>
      </div>

      <div class="flexBetween notationRow title">
        <div data-col="name" data-type="<?= $type;?>" class="titleResult">Nom</div>
        <div data-col="notation" data-type="<?= $type;?>" class="titleResult">Note</div>
        <div data-col="date" data-type="<?= $type;?>" class="titleResult">Date</div>
        <div data-col="childname" data-type="<?= $type;?>" class="titleResult">Enfant</div>
      </div>
        
      <div id="containerResult<?= $type;?>">
        <?php foreach($staffNotations->$type as $staffNotation):?>
            <?php $sessionId = $staffNotation->sessionId;?>

            <?php $staffColor = "";?>
            <?php if($staffNotation->notation >= 4) $staffColor = "color: green; font-weight: bold";?>
            <?php if($staffNotation->notation < 3) $staffColor = "color: red; font-weight: bold";?>

            <div  data-name="<?= $staffNotation->staffName;?>" 
                  data-notation="<?= $staffNotation->notation;?>"
                  data-date="<?= showDate($staffNotation->createdAt, 'Y-m-d');?>" 
                  data-childname="<?= $sessionData->$sessionId->childName;?>" 
                  class="flexBetween notationRow notationRow<?= $type;?>" style="<?= $staffColor;?>">
                    <div><?= $staffNotation->staffName;?></div>
                    <div><?= $staffNotation->notation;?></div>
                    <div><?= showDate($staffNotation->createdAt);?></div>
                    <div><?= $sessionData->$sessionId->childName;?></div>
            </div>

            <?php
              if( !isset($staffAverages[$type][$staffNotation->staffName]) ) {
                $staffAverages[$type][$staffNotation->staffName] = 0;
                $staffAveragesNb[$type][$staffNotation->staffName] = 0;

              }   
              $staffAverages[$type][$staffNotation->staffName] += $staffNotation->notation;
              $staffAveragesNb[$type][$staffNotation->staffName]++;
            ?>

        <?php endforeach;?>
      </div>
      
    </div>
  <?php endforeach;?>
</div>
<br/><br/>
<div class="flexAround">
  <?php foreach($types as $type):?>
    <div>
      <b><?= ucfirst($type);?> - moyennes individuelles</b>

      <div class="flexBetween notationRow title">
        <div data-col="name" data-type="<?= $type;?>" class="titleResult" data-table="averageStaff">Nom</div>
        <div data-col="notation" data-type="<?= $type;?>" class="titleResult" data-table="averageStaff">Note</div>
        <div data-col="nbEvaluation" data-type="<?= $type;?>" class="titleResult">Evaluations</div>
      </div>


      <div id="containerResult<?= $type;?>averageStaff">

        <?php foreach($staffAverages[$type] as $staffName => $staffAverage):?>

          <?php $note = number_format($staffAverage / $staffAveragesNb[$type][$staffName], 2);?>


          <?php $staffColor = "";?>
          <?php if($note >= 4) $staffColor = "color: green; font-weight: bold";?>
          <?php if($note < 3) $staffColor = "color: red; font-weight: bold";?>




          <div data-name="<?= $staffName;?>" data-notation="<?= $note;?>" class="flexAround notationRow notationRow<?= $type;?>averageStaff" style="<?= $staffColor;?>">
              <div><?= $staffName;?></div>
              <div><?= $note;?></div>
              <div><?= $staffAveragesNb[$type][$staffName];?></div>
          </div>
            
        <?php endforeach;?>

      </div>

    </div>
<?php endforeach;?>

</div>

