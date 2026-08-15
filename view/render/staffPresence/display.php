<?php $title = "Présences du personnel"; ?>

<?php ($params->member->kind == "driver") ? $hour_start_value = "08:30" : $hour_start_value = "09:00";?>
<?php ($params->member->kind == "driver") ? $hour_end_value = "18:30": $hour_end_value = "17:00";?>

<?php
include('_createPresence.php');
include('_createPresenceBySeason.php');
include('_createPresenceByProduct.php');
include('_createPresenceByPlage.php');
?>

<style type="text/css">
  .fc-time
  {
    display: none;
  }
  .zselect
  {
    position: absolute;
    top:25px;
    right:100px;
  }

  .ui-datepicker-calendar
  {
    display: none;
  }
  .ui-datepicker-next, .ui-datepicker-prev
  {
    display: none;
  }

</style>

<div class="text-center">
  <h1>
    <a href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>staffPresence/display/id/<?= $params->member->staffId; ?>/date/<?php echo date('Y-m', strtotime('-1 month', strtotime($params->date))) ?>/')">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a> <?php echo date('m/Y', strtotime($params->date)); ?>
    <a href="javascript:void(0)" onclick="openDatePicker()">
      <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>
    <a href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>staffPresence/display/id/<?= $params->member->staffId; ?>/date/<?php echo date('Y-m', strtotime('+1 month', strtotime($params->date))) ?>/')">
      <i class="material-icons" class="chevron_right_calendar">chevron_right</i>

    </a>
  </h1>
</div>
<div id="datePickerInline"></div>


<div class="text-center">
  <h1>  Présence de <?= $params->member->person->firstname; ?> -  <?= $params->member->person->lastname; ?>  (<?php if ('trainee' === $params->member->kind): echo 'stagiaire'; else: echo $params->member->kind; endif; ?>) </h1>

  <p class="lead">
    Nombre d'enfants : <?= (null != $params->member->maxChildren)? $params->member->maxChildren: 'nc'; ?>
  </p>
</div>

<div class="reveal mobile-ios-modal" id="action-presence" data-reveal>
  <div class="mobile-ios-modal-options-stacked">
    <button data-close class="button" id="deletePresence">Supprimer la présence</button>
    <button data-close class="button red">Fermer</button>
  </div>
</div>

<div class="reveal mobile-ios-modal" id="action-presence-2" data-reveal>
  <div class="mobile-ios-modal-options-stacked">
    <button data-close class="button" data-close data-open="action-plage-de-date">Plage de date</button>
    <button data-close class="button" data-close data-open="reveal-product" onclick="initMultiSelect()">Un produit</button>
    <button data-close class="button" data-close data-open="reveal-season">Par saison</button>
    <button data-close class="button red">Fermer</button>
  </div>
</div>

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

<div class="text-center">
  <button class="button" data-open="action-presence-2">Créer les présences </button>
</div>

<div id="containerCalendar">
  <div id="calendar"></div>
</div>

<input type="hidden" id="staffId" value="<?= $params->member->staffId; ?>" >
<input type="hidden" id="lastIdPresence">
<input type="hidden" id="dateCalendar" value="<?= $params->date; ?>">