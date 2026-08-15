
<div class="tabs-panel" id="panel6">
    <div class="flex space-arround">
        <?php foreach($params->person->related as $pers):?>
            <div class="card-ea-profil">
                <div class="card-banner">
                    <div class="card-profile" style="background-image: url('<?= ($pers->photo != "") ? $person->photo : IMG.'no_photo.jpg';  ?>');">
                    </div>
                    <h3><?= $pers->firstname.' '.$pers->lastname; ?> </h3>
                    <aside>
                        <a href="<?= HOST ?>person/display/id/<?= $pers->personId; ?>/">Afficher le profil</a>
                    </aside>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
