<?php $title = "Bilan des appels"; ?>
<?php use_helper('dates,formTools, buttons');?>
<?php $i = 0;?>

<style>
    #mainContent { min-width: 400px; max-width: 900px; margin: auto; font-size: 16px};
    #contentTable {max-width: 95vw; overflow: auto; margin:auto; }
    #tableHead { background-color: darkblue; color: white; font-size: 16px; position: sticky; top: 80px; z-index: 99}
    .tableRow { display: flex;}
    .tableRow div { text-align: center; word-wrap: break-word;justify-content: start; -webkit-hyphens: auto; hyphens: auto;}
    .colNum { width: 60px;}
    .colName2 { width: 200px}


    .tableRow:hover { background-color: lightgrey; color: darkred}

    #ui-datepicker-div {
        z-index: 999!important
    }
</style>

<h1>Bilan des appels</h1>

<div id="mainContent">

    <form action="<?= HOST."standard/all";?>" method="post" class="form-balance-sheet">
        <div class="medium-3 cell">
            <label> Date de départ
                <input type="text" id="date_invoice1"  placeholder="Date de départ" required value="<?= showDate($params->from) ;?>">
            </label>
            <input type="hidden" id="datepicker1" name="from" value="<?= $params->from ;?>">
        </div>
        <div class="medium-3 cell">
            <label> Date de fin
                <input type="text" id="date_invoice2"  placeholder="Date de fin" required value="<?= showDate($params->to) ;?>">
            </label>
            <input type="hidden" id="datepicker2" name="to" value="<?= $params->to ;?>">
        </div>
        <input type="submit" class="button" value="Afficher"/>
    </form>

    <div class="tableRow" id="tableHead">
        <div class="colNum">id</div>
        <div class="colName2">Date</div>
        <div class="colNum">Heure</div>
        <div class="colName2">Num.</div>
        <div class="colName2">Personne</div>
        <div class="colNum">Durée</div>
    </div>


    <div id="contentTable">

        <?php $i = -$i; ($i == 1) ? $backcolor= "background-color: lightgrey" : $backcolor = "";?>

        <?php foreach($params->calls as $call):?>

            <?php $i = -$i; ($i == 1) ? $backcolor= "background-color: lightgrey" : $backcolor = "";?>

            <div class="tableRow" style="<?= $backcolor;?>">
                <div class="colNum"><?= $call->id?></div>
                <div class="colName2"><?= showDate($call->call_date);?></div>
                <div class="colNum"><?= showTime($call->call_time);?></div>
                <div class="colName2"><?= $call->number;?></div>
                <div class="colName2"><?= $call->from_person;?></div>
                <div class="colNum"><?= $call->duration;?> s.</div>
            </div>

        <?php endforeach;?>
    </div>

</div>
