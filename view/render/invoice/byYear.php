<style>
    #contentTable {max-width: 95vw; overflow: auto; margin:auto; }
    #myTable {text-align: center; }
    #tableHead { background-color: darkblue; color: white; font-size: 10px; position: sticky; top: 80px; z-index: 99}
    #tableFoot { background-color: white; color: darkblue; font-size: 10px;}
    .colHide { color: white;}
    .tableRow { display: flex;}
    .tableRow div { text-align: center; word-wrap: break-word;justify-content: start; -webkit-hyphens: auto; hyphens: auto;}
    .colNum { width: 60px;}
    .colName { width: 120px}
    .colName2 { width: 200px}
    .colNameFusion { width: 320px}
    .colComp { width: 120px; word-wrap: break-word; }
    .colTT { width: 100px; border-left: 1px solid darkblue; border-right: 1px solid darkblue; }
    .colTT2 { width: 200px; border: 2px solid darkblue;}

    .tableRow:hover { background-color: lightgrey; color: darkred}

    #ui-datepicker-div {
        z-index: 999!important
    }
</style>

<input type="hidden" id="currentYear" value="<?= $params->year;?>">
<input type="hidden" id="updateUrl" value="<?= HOST.'invoice/extract/';?>"

       <br/><br/><br/>


<div id="curentContentBlock">
</div>

