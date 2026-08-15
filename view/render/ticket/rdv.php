<?php $title = "Liste des rendez-vous"; ?>

<h1>Liste des rendez-vous</h1>  

<div class="text-center">
  <h1>
    <a href="<?= HOST; ?>ticket/rdv/date/<?php echo date('Y-m', strtotime('-1 month', strtotime($params->date))) ?>/">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a> <?php echo date('m/Y', strtotime($params->date)); ?>
    <a href="javascript:void(0)" onclick="openDatePicker()">
      <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>
    <a href="<?= HOST; ?>ticket/rdv/date/<?php echo date('Y-m', strtotime('+1 month', strtotime($params->date))) ?>/">
      <i class="material-icons" class="chevron_right_calendar">chevron_right</i>

    </a>
  </h1>
</div>
<div id="datePickerInline"></div>
<section class="block-list">
  <ul id="childList">    
    <?php foreach($params->rdv as $rdv):?>
      <li>
        <a href="<?= HOST ?>child/display/id/<?= $child->childId; ?>/">
          <div>
            <p class="list-header">             
              <?= $rdv->name; ?> - <?= $rdv->description; ?> - <?= date('d/m/Y h:i:s', strtotime($rdv->dateRdv)); ?>
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
<style type="text/css">
  
.ui-datepicker-calendar
{
  display: none;
}
.ui-datepicker-next, .ui-datepicker-prev
{
  display: none;
}
   
</style>