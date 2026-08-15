<?php require_once(HELPER.'dates.php');?>

<?php foreach($params->messages as $type=>$content):?>

    <?php if($type == "info"):?>
        <h4>Information</h4>
        <div class="alert alert-success" style="padding: 20px; border-radius: 10px; background-color: lightskyblue; margin: 10px 0">
            <?= $content;?>
        </div>
        <hr/>
    <?php endif;?>

    <?php if($type == "sibling"):?>
        <h4>Liens entre enfants</h4>
        <?php foreach($content as $element):?>
                <?= ucfirst($element);?>
        <?php endforeach;?>
        <hr/>
    <?php endif;?>

    <?php if($type == "imported"):?>
            <h4>Création de pickup</h4>
            <table>
                <?php foreach($content as $elements):?>
                    <?php foreach($elements as $data):?>
                                <tr>
                                    <td><b><?= $data->child->firstname.' '.$data->child->lastname;?></b></td>
                                    <td><?= $data->kind;?></td>
                                    <td><?= $data->pickupId;?></td>
                                    <td><?= showDate($data->start, 'd/m H:i');?></td>
                                </tr>
                    <?php endforeach;?>
                <?php endforeach;?>
            </table>
            <hr/>
    <?php endif;?>
    
<?php endforeach;?>
