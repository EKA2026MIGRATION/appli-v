<div class="tabs-panel is-active" id="panel1">

    <div class="card-wrap horizontal">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">date_range</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Date de naissance</p>
                    <p><?= date('d/m/Y', strtotime($params->child->birthdate)); ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">phone</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Téléphone</p>
                    <p><?= (null !==$params->child->phone)? $params->child->phone: '-' ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">run_circle</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Profil sportif</p>
                    <p><?= $params->child->sportifProfil ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">emoji_people</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Coach Référent</p>
                    <?php if($params->child->staff != ''):?>
                        <p><?= $params->child->staff->fullname ?></p>
                    <?php else:?>
                        /
                    <?php endif;?>
                </figure>
            </div>
        </div>
    </div>



    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">local_hospital</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Informations médicales</p>
                    <p><?= $params->child->medical ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">directions_cars</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Commentaire sur le transport</p>
                    <p><?= $params->child->comment ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">directions_cars</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Informations de transport</p>
                    <p><?= $params->child->pickupInstruction ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">location_on</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Résident français</p>
                    <p><?php if($params->child->franceResident == 1) { echo 'Oui'; } else { echo 'Non'; } ?></p>
                </figure>
            </div>
        </div>
    </div>


    <?php if(isset($params->child->school->schoolId)): ?>
        <div class="card-wrap horizontal hight">
            <div class="card-img-container">
                <figure>
                    <img style="top:10px; left:15px; max-height: 100px; max-width: 100px;" src="<?= ($params->child->school->photo != "") ? $params->child->school->photo : IMG.'no_photo.jpg';  ?>" />
                </figure>
            </div>
            <div class="card-info">
                <div class="card-primary">
                    <figure>
                        <p class="card-title">École : <?= $params->child->school->name; ?></p>
                        <p><?= $params->child->school->address ?> <?= $params->child->school->town ?>, <?= $params->child->school->postal ?>, <?= $params->child->school->country ?></p>
                    </figure>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
