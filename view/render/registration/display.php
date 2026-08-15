<?php $title = "Inscription ".$params->registration." ".$params->child->firstname." ".$params->child->lastname; ?>

<h1 class="text-center"><?= "Inscription ".$params->child->firstname." ".$params->child->lastname . " - " .date('d/m/Y', strtotime($params->registration)); ?></h1>


<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
    <a href="<?= HOST ?>registration/add/id/<?= $params->registrationId ?>/"> <button class="button"><i class="material-icons">edit</i> </button></a>
<button onclick="deleleteRegistration('<?= $params->registrationId; ?>')" class="button"><i class="material-icons">delete</i> </button>
</div>


<div class="page__profil" id="displayOverButtons">

    <ul class="tabs margin-top-20" data-tabs id="registration-tabs">
        <li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Pour / Par</a></li>
        <li class="tabs-title"><a href="#panel2" >Dates</a></li>
        <li class="tabs-title"><a href="#panel3">Infos facture</a></li>
        <li class="tabs-title"><a href="#panel4">Lieu</a></li>
        <li class="tabs-title"><a href="#panel5">Produit</a></li>
    </ul>

    <div class="tabs-content" data-tabs-content="registration-tabs">
        <div class="tabs-panel is-active" id="panel1">

            <div class="card-wrap horizontal">
                <div class="card-img-container">
                    <figure>
                        <i class="material-icons">child_care</i>
                    </figure>
                </div>
                <div class="card-info">
                    <div class="card-primary">
                        <figure>
                            <p class="card-title">Enfant inscrit</p>
                            <p><?=  $params->child->firstname." ".$params->child->lastname; ?></p>
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
                            <p class="card-title">Inscrit par </p>
                            <p><?= $params->person->firstname. " " . $params->person->lastname; ?></p>
                        </figure>
                    </div>
                </div>
            </div>

        </div>

        <div class="tabs-panel" id="panel2">
            <div class="card-wrap horizontal hight">
                <div class="card-img-container">
                    <figure>
                        <i class="material-icons">event</i>
                    </figure>
                </div>
                <div class="card-info">
                    <div class="card-primary">
                        <figure>
                            <p class="card-title">Inscription pour le(s) </p>
                            <?php foreach ($params->sessions as $session): ?>
                                 <p><?= date('d/m/Y', strtotime($session->date)); ?> - <?= date('H:i', strtotime($session->start)); ?> / <?= date('H:i', strtotime($session->end)); ?></p>
                            <?php endforeach; ?>
                        </figure>
                    </div>
                </div>
            </div>

            <div class="card-wrap horizontal hight">
                <div class="card-img-container">
                    <figure>
                        <i class="material-icons">date_range</i>
                    </figure>
                </div>
                <div class="card-info">
                    <div class="card-primary">
                        <figure>
                            <?php //echo '<pre>'; var_dump($params->session); echo '</pre>'; ?>
                            <p class="card-title">Date de la commande</p>
                            <p><?= date('d/m/Y', strtotime($params->registration)); ?></p>
                        </figure>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabs-panel" id="panel3">
            <div class="card-wrap horizontal hight">
                <div class="card-img-container">
                    <figure>
                        <i class="material-icons">receipt</i>
                    </figure>
                </div>
                <div class="card-info">
                    <div class="card-primary">
                        <figure>
                            <p class="card-title">Numéro de facture </p>
                            <p> <?= $params->invoice; ?>EA3598</p>
                        </figure>
                    </div>
                </div>
            </div>

            <div class="card-wrap horizontal hight">
                <div class="card-img-container">
                    <figure>
                        <i class="material-icons">info</i>
                    </figure>
                </div>
                <div class="card-info">
                    <div class="card-primary">
                        <figure>
                            <p class="card-title">Statut </p>
                            <p><?= $params->status; ?></p>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="card-wrap horizontal hight">
                <div class="card-img-container">
                    <figure>
                        <i class="material-icons">payment</i>
                    </figure>
                </div>
                <div class="card-info">
                    <div class="card-primary">
                        <figure>
                            <p class="card-title">Paiement </p>
                            <p>Montant déjà payé : <?= $params->payed; ?>€</p>
                        </figure>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabs-panel" id="panel4">
            <div class="card-wrap horizontal">
                <div class="card-img-container">
                    <figure>
                        <i class="material-icons">place</i>
                    </figure>
                </div>
                <div class="card-info">
                    <div class="card-primary">
                        <figure>
                            <p class="card-title">Lieu </p>
                            <p><?= $params->location->name; ?></p>

                        </figure>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabs-panel" id="panel5">

            <div class="flex space-arround">

                <div  class="card-ea-profil"  style="height: 370px;">
                    <div class="card-banner">
                        <div class="card-profile" style="background-image: url('<?= ($params->product->photo != "") ? HOST.$params->product->photo : IMG.'no_photo_2.jpg';  ?>');"></div>

                        <h3> <?= $params->product->nameFr; ?> </h3>
                        <p> <?=($params->product->priceTtc == "") ? '': number_format($params->product->priceTtc, 2, ',', ' ') ?>€</p>
                        <aside >
                            <a href="<?= HOST ?>product/display/id/<?= $params->product->productId; ?>/">Afficher le produit</a>
                        </aside>
                    </div>
                </div>
            </div>

        </div>
</div>


<div class="space_actions_page_mobile"></div>