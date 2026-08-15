<?php
$title = "Détail du survey";
$surveySession = $params->surveySession;
?>


<div class="actionsPage">
  <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>

<h3 style="margin-top: 45px">
  <b><?= $surveySession->child->fullname;?></b> - 
  <?= $surveySession->survey->name; ?>
</h3>

<div>
  <ul>
    <li>Date de création : <?= $surveySession->createdAt->date;?></li>
    <li>Date concernée: <?= $surveySession->childPresence->date;?></li>
    <li>Produit concerné: <?= strip_tags($surveySession->product->nameFr);?></li>
    <li>Personne sondée: <?= $surveySession->person->firstname.' '.$surveySession->person->lastname;?></li>


  </ul>


    <hr/>
      <div style="display: flex; flew-wrap: wrap; justify-content: space-around">
        <div style="text-align:center">
            Status : <b><?= $surveySession->status ;?></b>
            <br/>
            <a href="<?= HOST; ?>survey/session/assigned/<?= encodeInt($surveySession->id); ?>/" target="_blank">__ voir le sondage __</a>
        </div>
        <?php if($surveySession->status == "assigned"):?>
            <button class="button" id="sendByEmail" onclick="sendSurvey('<?= $surveySession->id; ?>', '<?= $surveySession->person->email; ?>', '<?= HOST; ?>survey/session/assigned/<?= encodeInt($surveySession->id); ?>/', '<?= $surveySession->child->firstname; ?>', '<?php echo date('d/m/Y', strtotime($surveySession->childPresence->date)); ?>')">Envoyer par email</button>
        <?php endif;?>
        <?php if($surveySession->status == "send"):?>
            <button class="button" id="sendByEmail" onclick="sendSurvey('<?= $surveySession->id; ?>', '<?= $surveySession->person->email; ?>', '<?= HOST; ?>survey/session/assigned/<?= encodeInt($surveySession->id); ?>/', '<?= $surveySession->child->firstname; ?>', '<?php echo date('d/m/Y', strtotime($surveySession->childPresence->date)); ?>')">Renvoyer par email</button>
        <?php endif;?>
      </div>
    <hr/>
  <ul>  
    <li>
        Driver(s) associé(s) : 
          <?php if($surveySession->driverList != "" && $surveySession->driverList != "null"):?>
            <ul>
              <?php $check = []; foreach(explode(',',$surveySession->driverList) as $driverId):?>
                  <?php if(!in_array($driverId, $check)) echo '<li>'.$_SESSION['STAFFS'][$driverId]['fullname'].'</li>';?>
                  <?php $check[] = $driverId;?>
              <?php endforeach;?>
            </ul>
          <?php else:?>
            Aucun
          <?php endif;?>
    </li>
    <li>
        Coach(s) associé(s) : 
        <?php if($surveySession->coachList != "" && $surveySession->coachList != "null"):?>
            <ul>
              <?php $check = []; foreach(explode(',',$surveySession->coachList) as $coachId):?>
                  <?php if(!in_array($coachId, $check)) echo '<li>'.$_SESSION['STAFFS'][$coachId]['fullname'].'</li>';?>
                  <?php $check[] = $coachId;?>
              <?php endforeach;?>
            </ul>
          <?php else:?>
              Aucun
          <?php endif;?>
    </li>
  </ul>

</div>