<?php $title = "Gestion des présences"; ?>


<div class="text-center">
  <h1>

    <a href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>staffPresence/calendar/date/<?php echo date('Y-m-d', strtotime('-1 day', strtotime($params->date))) ?>/')">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a> <?php echo date('d/m/Y', strtotime($params->date)); ?>

    <a href="javascript:void(0)" onclick="openDatePicker()">
      <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>

    <a  href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>staffPresence/calendar/date/<?php echo date('Y-m-d', strtotime('+1 day', strtotime($params->date))) ?>/')">
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
        <option value="<?php echo $staff->staffId; ?>"><?php echo $staff->person->firstname; ?> <?php echo $staff->person->lastname; ?> (<?php if ('trainee' === $staff->kind): echo 'stagiaire'; else: echo $staff->kind; endif; ?>) - max enfants : <?= (null != $staff->maxChildren)? $staff->maxChildren: 'nc'; ?></option>
      <?php endforeach; ?>
    </select>
  </label>
</div>

<!--
<h1>Présent(s) du jour</h1>

<section class="block-list">
  <ul id="staffPresenceList">
      <?php foreach($params->staff_presence as $presence):?>
        <li class="type<?= $presence->typeName;?>">
          <a href="<?= HOST ?>staffPresence/display/id/<?= $presence->staff->staffId ;?>/" >
            <div>
              <p class="list-header">
                <img src="<?php echo ($presence->staff->person->photo != "") ? HOST.$presence->staff->person->photo : IMG.'no_photo.jpg';  ?>" class="width-30 height-30" />
                <?php echo $presence->staff->person->firstname; ?>  <?php echo $presence->staff->person->lastname; ?> (<?php if ('trainee' === $presence->staff->kind): echo 'stagiaire'; else: echo $presence->staff->kind; endif; ?>) - max enfants : <?= (null != $staff->maxChildren)? $staff->maxChildren: 'nc'; ?>
                <div class="with-icon">
                  <i class="material-icons">send</i>
                </div>
              </p>
            </div>
          </a>
        </li>
      <?php endforeach ?>
  </ul>
</section>
-->


<div id="containerCalendar">
  <div id="calendar"></div>
</div>

<input type="hidden" id="dateCalendar" value="<?= $params->date; ?>">
