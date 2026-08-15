<?php use_helper('dates');?>

<style>
    .stockList {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .categoryTd { background: darkblue; color: white; font-weight: bold; font-size: 16px; text-align: center}

    tr:nth-child(odd) {background: lightgrey}
    th {background: darkred; color: white}
    td, th { border-left: 1px solid grey; border-right: 1px solid grey}

    h3 { display: flex; justify-content: space-between}
    h3 a {
        margin: 0px!important; padding: 4px!important;
    }
</style>

<h3>
    Inventaire
    <a href="<?= HOST ?>stock/edit/" class="button"><i class="material-icons">edit</i> </a>
</h3>

<input type="hidden" value="inventory" name="inventory" id="currentPage"/>

<input id="date" value="<?= $params->date ?>" type="hidden">
<div class="text-center">
    <h3>
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
    </h3>
</div>
<div id="datePickerInline"></div>

<?php include('_list.php');

