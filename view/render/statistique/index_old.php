<?php $type = $params->type;?>
<style>
    ul { list-style: none}
    #listWeeks { margin-left: 20px}
    #listWeeks option { padding: 2px 5px; }
    .typestage { background-color: #FCF6E3;}
    .typeecole { background-color: #F0FEFE}
    .typeinter { background-color: #E2F3D2}


    #showResult {
        display: flex; flex-wrap: wrap;
    }

    .ulResult {
        margin: 0px; padding: 0px; border: 1px solid darkblue;
    }

    .ulResult ul {
        margin: 0px; padding: 0px;
    }
</style>

<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>
<br/><br/><br/>
<?php include('_caForm.php');?>