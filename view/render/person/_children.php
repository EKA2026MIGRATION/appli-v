
<div class="tabs-panel" id="panel4">
    <div class="flex space-arround">
        <?php foreach($params->person->children as $child):?>
            <div class="card-ea-profil">

                <div class="card-banner">
                    <div class="card-profile" style="background-image: url('<?= ($child->photo != "") ? $child->photo : IMG.'no_photo.jpg';  ?>');">
                    </div>
                    <h3><?= $child->firstname.' '.$child->lastname; ?> </h3>
                    <aside>
                        <a href="<?= HOST ?>child/display/id/<?= $child->childId; ?>/">Afficher le profil</a>
                    </aside>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
