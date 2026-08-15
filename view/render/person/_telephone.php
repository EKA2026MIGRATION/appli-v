<div class="tabs-panel" id="panel2">

    <div id="person_phone">
        <?php foreach($params->person->phones as $phone):?>
            <div class="card-wrap horizontal" id="blockPhone<?= $phone->phoneId; ?>">
                <div class="card-img-container">
                    <figure>
                        <i class="material-icons">phone</i>
                    </figure>
                </div>

                <div class="card-info">
                    <div class="card-primary with-second">
                        <figure>
                            <p class="card-title"><?= $phone->name; ?></p>
                            <p><?= $phone->phone; ?> </p>
                        </figure>
                    </div>

                    <div class="card-secondary">
                        <a href="javascript:void(0)" onclick="openRevealJS('revealPhone');editPhone('<?= $phone->phoneId; ?>')"><span><i class="material-icons">mode_edit</i></span> Modifier</a>
                        <a href="javascript:void(0)" onclick="deletePhone('<?= $phone->phoneId; ?>')"><span><i class="material-icons">delete</i></span> Supprimer</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
