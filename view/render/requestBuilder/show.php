<?php use_helper('dates, translation, buttons');?>

<style>
    #resultData { display: flex; justify-content: space-around; border: 3px solid darkblue; border-radius: 10px; padding: 10px; margin: 20px}
</style>

<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>

<h3 class="text-center">
    <span style="font-size: 16px; font-weight: bold">#<?= $params->extractList->id;?></span>&nbsp;
    <?= $params->extractList->title;?>
</h3>

<div id="resultData">
    <div>Nombre d'enfants : <span id="nbChild"></span></div>
    <div>Nombre de ligne : <span id="nbRows"></span></div>
    <a href="<?= HOST; ?>requestBuilder/exportExcel/id/<?= $params->extractList->id;?>/" target="_blank">Export XLS</a>

</div>

<?php $nbRows = 0; $nbChild = 0;?>

<table id="listChild">
    <tr>
        <?php foreach($params->extractList->elements->selectRequest as $headTitle):?>
            <th><?= showSelectSql($headTitle);?></th>
        <?php endforeach;?>
        <th>keyfilter</th>
    </tr>

    <?php $child_id = null; $altColor = 1?>
    <?php foreach($params->content as $results):?>
        <?php $nbRows++; ($altColor == 1) ? $backStyle = "" : $backStyle="background-color: lightblue"?>
        <tr style="<?= $backStyle;?>">
            <?php foreach($results as $result):?>
                <?php
                if(isset($results->childId)) {
                    if ( $child_id != $results->child_id ) { $nbChild++; $child_id = $results->child_id ;} ;
                }
                ;?>

                <td><?= $result;?></td>
            <?php endforeach;?>
        </tr>
        <?php $altColor = $altColor * -1;?>
    <?php endforeach;?>

</table>


<script>

    let nbChild = "<?= $nbChild;?>";
    let nbRows  = "<?= $nbRows;?>";

    document.getElementById('nbChild').innerHTML = nbChild;
    document.getElementById('nbRows').innerHTML = nbRows;

</script>