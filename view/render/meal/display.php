<?php if ( null !== $params->child): $title = "Repas - " . $params->child->firstname . " " . $params->child->lastname; elseif (null !== $params->person): $title = "Repas - " . $params->person->firstname . " " . $params->person->lastname; else: $title = "Repas - " . $params->freeName; endif ?>

<h1 class="text-center">
    <?php if ( null != $params->child):
        echo  $params->child->firstname . " " . $params->child->lastname . " - repas du " . date('d/m/Y', strtotime($params->date));
    elseif (null != $params->person):
        echo $params->person->firstname . " " . $params->person->lastname . " - repas du " . date('d/m/Y', strtotime($params->date));
    else: echo  $params->freeName . " - repas du " . date('d/m/Y', strtotime($params->date));
    endif ?>

</h1>

<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
    <button id="deleteMeal" data-id-meal="<?= $params->mealId ?>" class="button"><i class="material-icons">delete</i> </button>
    <a href="<?= HOST ?>meal/add/id/<?= $params->mealId ?>/"> <button class="button"><i class="material-icons">edit</i> </button></a> </div>


<div class="page__profil">
    <h2>Informations</h2>
    <div class="card-wrap horizontal">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">date_range</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Date du repas</p>
                    <p><?= date('d/m/Y', strtotime($params->date)); ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">access_time</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Heure du repas</p>
                    <p>11h45</p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">group</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Groupe</p>
                    <p>...</p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">sentiment_satisfied_alt</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Responsable Groupe</p>
                    <p>Sandy</p>
                </figure>
            </div>
        </div>
    </div>
</div>

<h2 class="margin-top-20"> Aliments associés </h2>
<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <?php foreach($params->foods as $food):?>
            <div class="cell small-6 medium-4 large-2">
               <div class="food__profil">
                    <img  src="<?= ("" !== $food->photo) ? HOST.$food->photo : IMG.'no_photo_2.jpg';  ?>" />
                    <a  href="<?= HOST ?>food/display/id/<?= $food->foodId; ?>/"><button style="display: block;
            position:absolute;
            bottom:-8px;
            left:0;
            width:100%;" class="button"> Voir l'aliment </button></a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<div class="space_actions_page_mobile"></div>