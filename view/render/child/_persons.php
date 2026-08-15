<div class="tabs-panel" id="panel2">
    <div class="flex space-arround">

        <?php foreach($params->child->persons as $person):?>
            <div  class="card-ea-profil"  style="height: 370px;">
                <div class="card-banner">
                    <div class="card-profile" style="background-image: url('<?= ($person->photo != "") ? HOST.$person->photo : IMG.'no_photo.jpg';  ?>');"></div>

                    <h3> <?= $person->firstname.' '.$person->lastname; ?> </h3>
                    <h4> <?= $person->relation; ?> </h4>
                    <p> <?php echo ($person->email == "") ? 'Pas d\'email': $person->email;  ?> </p>
                    <aside >
                        <a href="<?= HOST ?>person/display/id/<?= $person->personId; ?>/">Afficher le profil</a>
                    </aside>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
