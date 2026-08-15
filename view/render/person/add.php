<?php use_helper('photo');?>
<?php $title = "Ajouter / Modifier une personne "; ?>

<?php $update = 0; if(isset($params->firstname)): $update = 1; endif ?>
<?php $createFromUser = 0; if(isset($params->identifier)): $createFromUser = 1; endif ?>
<?php $createFromPerson = 0; if(isset($params->personId)): $createFromPerson = 1; endif ?>


<h1><?= (1 === $update) ? 'Modifiez' : 'Complétez';  ?> le profil de la personne </h1>

<div class="actionsPage">
  <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>

<form method="post" id="personForm" action="person/<?= (1 === $update) ? 'modify/'.$params->personId : 'create';  ?>">
  <input type="hidden" name="photo" id="photoUrl" value="<?= (1 === $update) ?  $params->photo: '';  ?>">

  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <?php if($update != 1 AND $createFromUser == 1): ?>
      <div class="medium-12 cell">
        <label>Associer à un compte (laissez vide si user connecté)
          <input type="text" id="autocompleteUser" value="<?= (1 === $createFromUser) ?  $params->email: '';  ?>" placeholder="Recherchez un utilisateur par l'email" >
          <input type="hidden" name="identifier" value="<?= (1 === $createFromUser) ?  $params->identifier: '';  ?>">
        </label>
      </div>
      <?php endif; ?>
      <?php if($update != 1 AND $createFromPerson == 1): ?>
      <input type="hidden" id="personLink" value="<?= $params->personId; ?>">
      <div class="medium-12 cell">
        <label>Lien par rapport à la personne principale *
          <input type="text" id="relation" placeholder="Relation" required>
        </label>
      </div>
      <?php endif; ?>
      <div class="medium-6 cell">
        <label>Nom *
          <input type="text" name="lastname" placeholder="Nom" value="<?= (1 === $update) ?  $params->lastname: '';  ?>" required>
        </label>
      </div>
      <div class="medium-6 cell">
        <label>Prénom *
          <input type="text" name="firstname" placeholder="Prénom" value="<?= (1 === $update) ?  $params->firstname: '';  ?>" required>
        </label>
      </div>
      <div class="medium-6 cell">
        <label>Date de naissance
          <input type="date" name="birthdate" placeholder="Date de naissance" value="<?= (1 === $update) ?  $params->birthdate: '';  ?>">
        </label>
      </div>
      <div class="medium-6 cell margin-bottom-16">
        <div class="dropContainer" id="dropContainer">
          <div class="contentDropContainer">

            <div class="image-upload">

              <label class="labelFileInput" for="fileInput">
                <a class="button withIcon"><i class="material-icons">create_new_folder</i> Parcourir mes fichiers </a>
              </label>

              <input type="file" id="fileInput" onchange="previewOnDiv()"/>

            </div>
            Glisser et déposer votre photo ici
          </div>
        </div>

      </div>
      <div class="medium-6 cell">
        <div class="photoContainer"><img src="<?php if(1 === $update): echo ("" != $params->photo) ? HOST.$params->photo.randomValueCache() : IMG.'no_photo.jpg'; else: echo IMG.'no_photo.jpg'; endif ?>" id="photoRender"></div>
        <?php if($update == 1): ?>
          <center>
            <p>
              <a href="javascript:void(0)" class="button rotate" style="margin-top: 12px;" onclick="rotatePhoto('<?= $params->photo; ?>')">
                Rotation de l'image 
              </a>
            </p>
          </center>
        <?php endif; ?>
      </div>
      <div class="medium-12 cell" style="margin-top: 20px;">
       	<center><input type="submit" class="button" id="displayOverButtons" value="Envoyer" /></center>
      </div>
    </div>
  </div>
</form>

<p>* champ obligatoire</p>
<div class="space_actions_page_mobile"></div>
