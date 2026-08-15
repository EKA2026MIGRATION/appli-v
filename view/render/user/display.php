<?php $title = "Profil ".$params->user->email; ?>


<h1 class="text-center"><?= $params->user->email ?></h1>

<div class="actionsPage">

    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>

    <a href="<?= HOST ?>user/modify/id/<?= $params->user->identifier ?>/"> <button class="button"><i class="material-icons">edit</i> </button></a>
    <button id="deleteUser" data-id-user="<?= $params->user->identifier ?>" class="button"><i class="material-icons">delete</i> </button>
    <?php if(isset($params->persons->personId)): ?>
        <a href="<?= HOST ?>person/add/person/<?= $params->persons->personId; ?>/" class="button"><i class="material-icons">add</i> </a>
    <?php else: ?>
        <a href="<?= HOST ?>person/add/identifier/<?= $params->user->identifier ?>/email/<?= $params->user->email ?>/" class="button"><i class="material-icons">add</i> </a>
    <?php endif; ?>
</div>

<div data-closable class="callout alert-callout-subtle info">
  <strong>Information !<br></strong> Cliquez sur le crayon pour éditer l'user ou lui attribuer des rôles spécifiques. Pour ajouter un profil "personne", cliquez sur le +.
  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
    <span aria-hidden="true">⊗</span>
  </button>
</div>

<div class="page__profil" id="displayOverButtons">
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
                    <p class="card-title">Compte crée le</p>
                    <p><?= date('d/m/Y', strtotime($params->user->creation->date)); ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">people</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Rôles</p>
                    <p> <?= $params->user->roles; ?> </p>
                </figure>
            </div>
        </div>
    </div>
</div>



<?php //echo '<pre>'; var_dump($params); echo '</pre>'; ?>
<p><h2 class="margin-top-20 text-center"> "Personnes" associés </h2></p>
<div class="flex space-arround">
    <div  class="card-ea-profil">
        <div class="card-banner">
            <div class="card-profile" style="background-image: url('<?= ("" != $params->persons->photo) ? HOST.$params->persons->photo : IMG.'no_photo.jpg';  ?>');"></div>
			<h3> <?= $params->persons->firstname.' '.$params->persons->lastname; ?> </h3>
            <p><?=$params->persons->email; ?></p>
			<aside>
			    <a href="<?= HOST ?>person/display/id/<?= $params->persons->personId; ?>/">Afficher le profil</a>
            </aside>
		</div>
    </div>

<?php foreach($params->persons->related as $related): ?>

    <div  class="card-ea-profil">
        <div class="card-banner">
            <div class="card-profile" style="background-image: url('<?= ("" != $related->photo) ? HOST.$related->photo : IMG.'no_photo.jpg';  ?>');"></div>
            <h3> <?= $related->firstname.' '.$related->lastname; ?> </h3>
            <p> <?=$related->email; ?></p>
            <aside>
                <a href="<?= HOST ?>person/display/id/<?= $related->personId; ?>/">Afficher le profil</a>
            </aside>
        </div>
    </div>


<?php endforeach; ?>

</div>
<div class="space_actions_page_mobile"></div>
