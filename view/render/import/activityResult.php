<?php require_once(HELPER.'dates.php');?>

<?php foreach($params->messages as $type=>$content):?>

    <?php if($type == "info"):?>
        <h4>Information</h4>
        <div class="alert alert-success" style="padding: 20px; border-radius: 10px; background-color: lightskyblue; margin: 10px 0">
            <?= $content;?>
        </div>
        <hr/>
    <?php endif;?>

    <?php if($type == "imported"):?>
            <h4>Création de d'activités</h4>
            <table>
                <?php foreach($content as $data):?>
                                <tr>
                                    <td><b><?= $data->child->firstname.' '.$data->child->lastname;?></b></td>
                                    <td><?= $data->sport->name;?></td>
                                    <td><?= showDate($data->date, 'd/m');?></td>
                                    <td><?= $data->start;?></td>
                                    <td><?= $data->end?></td>


                                </tr>
                <?php endforeach;?>
            </table>
            <hr/>
    <?php endif;?>

<?php endforeach;?>
