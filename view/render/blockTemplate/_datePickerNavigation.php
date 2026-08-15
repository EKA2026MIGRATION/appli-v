<input id="date" value="<?= $date; ?>" type="hidden">
<div class="text-center">
  <h1> 
    <a href="javascript:void(0)" onclick="locationRedirect('<?= $prevLeftLink;?>')">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a> <?= showDate($date); ?>

    <a href="javascript:void(0)" onclick="openDatePicker()">
      <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>

    <a href="javascript:void(0)" onclick="locationRedirect('<?= $nextRightLink;?>')">
      <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
    </a>
</div>
<div id="datePickerInline"></div>