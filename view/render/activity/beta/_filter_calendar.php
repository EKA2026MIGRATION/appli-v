<input id="date" value="<?= $params->date ?>" type="hidden">
<div class="text-center">
    <h1>
        <a href="#" id="previousDay" class="jumpToDayButton">
            <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
        </a>

        <span id="showCurrentDate">
      <?php echo date('d/m/Y', strtotime($params->date)); ?>
    </span>

        <a href="javascript:void(0)" onclick="openDatePicker()">
            <i class="material-icons" class="calendar_change_date">date_range</i>
        </a>

        <a href="#" id="nextDay" class="jumpToDayButton">
            <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
        </a>
    </h1>
</div>
<div id="datePickerInline"></div>