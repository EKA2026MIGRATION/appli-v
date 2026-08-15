<?php if(isset($params->messages->imported)):?>
    <h4>Enfants importés ou mis à jour</h4>
    <ul>
    <?php foreach($params->messages->imported as $name):?>
            <li><?= $name;?></li>
    <?php endforeach;?>
    </ul>
<?php endif;?>

<?php if(isset($params->messages->not_imported)):?>
    <h4>Enfants non importés (mis à jour sur myclub)</h4>
    <ul>
    <?php foreach($params->messages->not_imported as $name):?>
            <li><?= $name;?></li>
    <?php endforeach;?>
    </ul>
<?php endif;?>


<?php if(isset($params->messages->info)):?>
    <h4><?= $params->messages->info;?></h4>
<?php endif;?>
