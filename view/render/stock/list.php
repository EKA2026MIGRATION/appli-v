<?php use_helper('dates, buttons');?>

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
<?php showFloatingActionButton($params->buttons); ?>

<h3>
    Etats du stock - dernier inventaire : <?= showDate($params->latestDate);?>
</h3>
<?php include('_list.php');

