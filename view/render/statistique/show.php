<?php
$type = $params->type;
if (!in_array($type, ['analyse', 'ca', 'repartition'], true)) {
    $type = 'ca';
}
?>
<style>
    ul { list-style: none}
    #listWeeks { margin-left: 20px}
    #listWeeks option { padding: 2px 5px; }
    .typestage { background-color: #FCF6E3;}
    .typeecole { background-color: #F0FEFE}
    .typeinter { background-color: #E2F3D2}

    .totalCaUl { background-color: lightblue}

    #showResult {
        display: flex; flex-wrap: wrap;
    }

    .ulResult {
        margin: 0px; padding: 0px; border: 1px solid darkblue;
    }

    .ulResult ul {
        margin: 0px; padding: 0px;
    }

    .dataRef {
        font-size: 14px;
        margin: 10px;
        border: 2px solid darkred;
        background-color: lavender;
        border-radius: 10px;
    }

    .arrow_upwardProgress, .arrow_downwardProgress {
        padding: 10px; color: white; font-weight: bold; text-align: center;
    }
   .arrow_downwardProgress {
        background-color: darkred; 
    }

    .arrow_upwardProgress {
        background-color: green;
    }

    .weekData {
        width: 100%;
        margin: auto;
        color: black;
    }
    .weekData tr, .weekData th, .weekData td {
        border: 1px solid black;
    }

    .currentWeek {
        background-color: lightcyan;
    }
</style>

<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>
<br/><br/><br/>
<?php include('_'.$type.'Form.php');?>