<div class="tabs-panel" id="panel5">
    <div class="flex space-arround">

        <?php foreach($params->child->siblings as $child):?>
            <div  class="card-ea-profil"  style="height: 370px;">
                <div class="card-banner">
                    <div class="card-profile" style="background-image: url('<?= ($child->photo != "") ? HOST.$child->photo : IMG.'no_photo.jpg';  ?>');"></div>

                    <h3> <?= $child->firstname.' '.$child->lastname; ?> </h3>
                    <p> <?= showAge($child->birthdate)?> </p>
                    <aside >
                        <a href="<?= HOST ?>child/display/id/<?= $child->childId; ?>/">Afficher le profil</a>
                    </aside>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
