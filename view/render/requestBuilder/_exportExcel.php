<?php use_helper('dates, translation, buttons');?>
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
                <?php if( $child_id != $results->child_id ) { $nbChild++; $child_id = $results->child_id ;} ;?>
                <td><?= $result;?></td>
            <?php endforeach;?>
        </tr>
        <?php $altColor = $altColor * -1;?>
    <?php endforeach;?>

</table>