<div class="tabs-panel" id="panel3">
    <div class="person_adresses">
        <?php foreach($params->person->addresses as $addresse):?>
        <div class="card-wrap horizontal" id="blockAdress<?= $addresse->addressId; ?>">

            <div class="card-img-container">
                <figure>
                  <i class="material-icons">location_on</i>
                </figure>
            </div>

            <div class="card-info">
                <div class="card-primary with-second">
                    <figure>
                        <p class="card-title"> <?= $addresse->name; ?></p>
                        <?= $addresse->address; ?>
                        <?= $addresse->address2; ?>
                        <br/> <?= $addresse->postal; ?> - <?= $addresse->town; ?>
                    </figure>
                </div>

                <div class="card-secondary">
                    <a href="javascript:void(0)" onclick="openRevealJS('revealAddress');editAddress('<?= $addresse->addressId; ?>')" ><span><i class="material-icons">mode_edit</i></span> Modifier</a>
                    <a href="javascript:void(0)" onclick="deleteAddress('<?= $addresse->addressId; ?>')"  ><span><i class="material-icons">delete</i></span> Supprimer</a>
                </div>

            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
