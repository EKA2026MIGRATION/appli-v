<?php require_once(HELPER.'dates.php');?>
<?php use_helper('buttons');?>
<?php $title = "Calendrier des tâches" ?>
<?php showFloatingActionButton($params->buttons); ?>
<input type="hidden" value="<?= date('Y-m-d');?>" id="dateToday"/>

<div class="text-center">
  <h1>

    <a  href="<?= HOST; ?>task/view/date_ref/<?= prevDay($params->date_ref, 7);?>/">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a> <?= showDate($params->date_ref)?>

    <a href="javascript:void(0)" onclick="openDatePicker()">
      <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>

    <a  href="<?= HOST; ?>task/view/date_ref/<?= nextDay($params->date_ref, 7);?>/">
      <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
    </a>

  </h1>

</div>


<div id="datePickerInline"></div>


<div style="max-width: 300px; margin:auto">
  <label>
    <select id="selectMember" name="person" required>
      <option value="0">Choisir un membre du personnel</option>
      <?php foreach($params->staff as $staff):?>
        <option value="<?=  $staff->staffId; ?>"><?php echo $staff->person->firstname; ?> <?php echo $staff->person->lastname; ?></option>
      <?php endforeach; ?>
    </select>
  </label>
</div>

<br/><br/>
<div style="position: relative">
      <div style="display: none; position: absolute; z-index: 99; width: 90%; border: 3px solid darkblue; border-radius: 10px; box-shadow: 5px 5px 5px black; padding: 20px; background-color: white" id="showAddTaskForm">
        <i class="material-icons" style="color: darkred; float: right; cursor: pointer" id="closeAddTask">close</i>
        <?php include(VIEW.'render/task/_addTaskForm.php');?>
      </div>

      <br/><br/>

      <div style="display: none; position: absolute; z-index: 99; width: 90%; border: 3px solid darkblue; border-radius: 10px; box-shadow: 5px 5px 5px black; padding: 20px; background-color: white" id="showFormManageTask">
        <i class="material-icons" style="color: darkred; float: right; cursor: pointer" id="closeManageTask">close</i>
        <?php include(VIEW.'render/task/_manageTask.php');?>
      </div>

      <h2>Tâches de la semaine</h2>

      <div id="calendarViewWeek">
        <?php foreach($params->tasks as $currentDate => $tasks):?>
            <div class="divDay">
              <?php include(VIEW.'render/task/_day.php');?>
            </div>
        <?php endforeach;?>
      </div>
</div>
