<?php
$title = "Activités par moniteur";
$currentStaffId = $params->active_staff->staffId;
?>
<input type="hidden" value="<?= $currentStaffId;?>" id="currentStaffId"/>
<?php showDatePickerNavigation('activity/display/date', $params->date); ?>

<?php if(hasRole(['ADMIN', 'MANAGER'])):?>
  <div class="displayNoneImpression" style="max-width: 300px; margin:auto">
    <label>Changer de coach
      <select id="selectCoach" name="person" required>
        <option value="0">Choisir un coach</option>
        <?php foreach($params->coachs as $coach):?>
          <option value="<?php echo $coach->staff->staffId; ?>"><?php if(isset($coach->staff->staffId)): ?> <?php echo $coach->staff->person->firstname; else: echo 'PAS DE COACH'; endif; ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>
<?php endif;?>

<h2 class="text-center"><?= $params->active_staff->person->firstname.' '.$params->active_staff->person->lastname; ?></h2>

<ul id="dashboardMenuLi">
  <li data-dash="Tasks" class="liButtonMenu" id="buttonTasks">
    <i class="material-icons">view_agenda</i>
      <span class="textButtonMenu">Tâches</span>
  </li>
  <li data-dash="Groups" class="liButtonMenu" id="buttonGroups" >
    <i class="material-icons">people</i>
    <span class="textButtonMenu">Groupes</span>
  </li>
</ul>

<div id="showActivityTasks">
  <?php include('_activityTasks.php');?>
</div>

<div id="showActivityGroups" style="display: none">
  <?php include('_activityGroups.php');?>
</div>


