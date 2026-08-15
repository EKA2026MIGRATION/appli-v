<?php include_once(HELPER.'dates.php');?>
<?php use_helper('buttons');?>
<?php showFloatingActionButton($params->buttons); ?>

<?php $title = "Profil ".$params->person->firstname." ".$params->person->lastname; ?>

<h1 class="text-center"><?= $params->person->firstname." ".$params->person->lastname; ?></h1>
<h6 class="text-center">#<?= $params->person->personId;?></h6>

<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>

<!--
<div class="reveal mobile-ios-modal" id="action-person" data-reveal>
  <div class="mobile-ios-modal-options-stacked">
    <button data-close class="button" onclick="changeActionAdress()" data-open="revealAddress">Ajouter une adresse</button>
    <button data-close class="button" onclick="changeActionPhone()" data-open="revealPhone">Ajouter un téléphone</button>
    <button data-close class="button" style="color:red;">Fermer</button>
  </div>
</div>-->

<div class="reveal" id="revealPhone" data-reveal>
  <p class="lead">Téléphone </small></p>

  <div class="containerLoader" id="loaderFormEditPhone" style="display: none;"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

  <form method="post" id="phoneForm" action="phone/create">
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="medium-12 cell">
        <label>Nom du numéro *
          <input type="text" name="name" placeholder="Nom du numéro" required>
        </label>
      </div>
      <div class="medium-12 cell">
        <label>Numéro de téléphone*
          <input type="tel" name="phone" placeholder="Numéro de téléphone" required>
        </label>
      </div>
      <div class="medium-12 cell">
        <center><button type="submit" class="button">Envoyer </button></center>
      </div>
    </div>
  </div>
</form>

  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
    <p>* champ obligatoire</p>
</div>

<?php include('_revealSearchAssociatedChild.php');?>


<div class="reveal" id="revealAddress" data-reveal>
  <p class="lead">Adresse </small></p>

  <div class="containerLoader" id="loaderFormEditAddress" style="display: none;"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

  <input type="hidden" value="<?= $params->person->personId ?>" id="idPersonInput" />
  <form method="post" id="adresseForm" action="address/create">
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="medium-12 cell">
        <label>Nom de l'adresse *
          <input type="text" name="name" placeholder="Nom de l'adresse" required>
        </label>
      </div>
      <div class="medium-12 cell">
        <label>Adresse *
          <input type="text" name="address" id="autocomplete" placeholder="Votre adresse" required>
        </label>
      </div>
      <div class="medium-12 cell">
        <label>Complément
          <input type="text" name="address2" placeholder="Complément d'adresse" >
        </label>
      </div>
      <div class="medium-6 cell">
        <label>Code postal *
          <input type="number" name="postal" id="postal_code"  placeholder="Code postal" required>
        </label>
      </div>
      <div class="medium-6 cell">
        <label>Ville *
          <input type="text" name="town"  placeholder="Ville" required>
        </label>
      </div>
      <div class="medium-6 cell">
        <label>Pays *
          <input type="text" name="country" placeholder="Pays" required>
        </label>
      </div>
      <div class="medium-12 cell">
       	<center><button type="submit" class="button">Envoyer </button></center>
      </div>
    </div>
  </div>
</form>

  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
    <p>* champ obligatoire</p>
</div>

<div class="page__profil" id="displayOverButtons">

    <div class="profile__picture">
        <img src="<?= ($params->person->photo != "") ? HOST.$params->person->photo : IMG.'no_photo.jpg';  ?>" />
    </div>

    <h6 class="text-center"><?= showDate($params->person->birthdate) ?></h6>

    <ul class="tabs margin-top-20" data-tabs id="child-tabs">
        <li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Tenant du compte</a></li>
        <li class="tabs-title"><a href="#panel2" >Téléphone</a></li>
        <li class="tabs-title"><a href="#panel3" >Adresse(s)</a></li>
        <li class="tabs-title"><a href="#panel4">Enfants associés</a></li>
        <li class="tabs-title"><a href="#panel6">Personnes associées</a></li>

        <?php if (null != $params->person->driver): ?> <li class="tabs-title"><a onclick="getPresence(<?= $params->person->driver->staffId; ?>)" href="#panel5">Présences</a></li> <?php  else: ''; endif; ?>
    </ul>

    <div class="tabs-content" data-tabs-content="child-tabs">

    <?php include('_owner.php');?>

    <?php include('_telephone.php');?>

    <?php include('_address.php');?>

    <?php include('_relations.php');?>

    <?php include('_children.php');?>

    <?php if (null != $params->person->driver): ?>

        <?php include('_presences.php');?>

    <?php endif; ?>
    </div>
</div>


<?php //include('_addUserForm.php');?>

<div id="showMessagePerson"></div>

<div class="space_actions_page_mobile"></div>
