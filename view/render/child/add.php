<?php $title = "Ajouter / Modifier un enfant"; ?>

<?php $update = 0; if(isset($params->child->firstname)):  $update = 1; endif ?>

<h1 class="text-center"><?= (1 === $update) ? 'Modifier' : 'Ajouter';  ?> un enfant </h1>

<div class="actionsPage">
    <a href="<?= HOST ?>child/display/id/<?= $params->child->childId;?>/"> <button class="button"><i class="material-icons">arrow_back</i> </button> </a>
</div>


<form method="post" id="childForm" action="child/<?= (1 === $update) ? 'modify/'.$params->child->childId : 'create';  ?>">

  <input type="hidden" name="photo" id="photoUrl" value="<?= (1 === $update) ?  $params->child->photo: '';  ?>">


  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="medium-6 cell">
        <label>Nom de l'enfant *
          <input type="text" name="lastname" placeholder="Nom de l'enfant" value="<?= (1 === $update) ?  $params->child->lastname: '';  ?>" required>
        </label>
      </div>
      <div class="medium-6 cell">
        <label>Prénom de l'enfant *
          <input type="text" name="firstname" placeholder="Prénom de l'enfant" value="<?= (1 === $update) ?  $params->child->firstname: '';  ?>" required>
        </label>
      </div>
      <div class="medium-6 cell">
        <label> Date de naissance *
          <input type="text" id="birthdate"  placeholder="Date de naissance" value="<?= (1 === $update) ? date('d/m/Y', strtotime($params->child->birthdate)): '';  ?>" required>
        </label>
          <input type="hidden" id="datepicker" name="birthdate" value="<?= (1 === $update) ? date('d/m/Y', strtotime($params->child->birthdate)): '';  ?>">
      </div>
      <div class="medium-6 cell">
        <label> Téléphone personnel de l'enfant
          <input type="tel" name="phone"  placeholder="Numéro de téléphone" value="<?= (1 === $update) ?  $params->child->phone: '';  ?>" >
        </label>
      </div>
      <div class="medium-6 cell">
        <label> Sexe
          <select name="gender">
            <option value="h" <?php if(1 === $update): echo ($params->child->gender == "h") ? 'selected':''; endif ?>>Garçon</option>
            <option value="f" <?php if(1 === $update): echo ($params->child->gender == "f") ? 'selected':''; endif ?>>Fille</option>
          </select>
        </label>
      </div>
      <div class="medium-6 cell">
        <label> Main
          <select name="childHand">
          <option/>
            <option value="left" <?php if(1 === $update): echo ($params->child->childHand == "left") ? 'selected':''; endif ?>>Gauche</option>
            <option value="right" <?php if(1 === $update): echo ($params->child->childHand == "right") ? 'selected':''; endif ?>>Droite</option>
          </select>
        </label>
      </div>

      <div class="medium-6 cell">
        <label> Profil sportif
            <input type="text" name="sportifProfil" placeholder="Profil sportif" value="<?= (1 === $update) ?  $params->child->sportifProfil: '';  ?>">
        </label>
      </div>

      <div class="medium-6 cell">
        <label> Coach référent
          <select name="staff">trainee
              <option value=null ></option>
              <?php foreach($params->staffs as $staff):?>
                <option value="<?= $staff->staffId ;?>" 
                    <?php if(1 === $update && ($params->child->staff != null) ): echo ($params->child->staff->staffId == $staff->staffId) ? 'selected':''; endif ?>>
                    <?= $staff->fullname;?>
                </option>
              <?php endforeach;?>
          </select>
        </label>
      </div>

      <div class="medium-6 cell">
        <label> Résident français
          <select name="france_resident">
            <option value="1" <?php if(1 === $update): echo ($params->child->franceResident == "1") ? 'selected':''; endif ?>>Oui</option>
            <option value="0" <?php if(1 === $update): echo ($params->child->franceResident == "0") ? 'selected':''; endif ?>>Non </option>
          </select>
        </label>
      </div>
      <div class="medium-6 cell">
        <label> Préférence de transport
          <select name="pickup_instruction">
            <option value="Le coach téléphone et j’accompagne mon enfant au minivan" <?php if(1 === $update): echo ($params->child->pickupInstruction == "Le coach téléphone et j’accompagne mon enfant au minivan") ? 'selected':''; endif ?>> Le coach téléphone et j’accompagne mon enfant au minivan </option>
            <option value="Le coach téléphone et mon enfant rentre seul du minivan" <?php if(1 === $update): echo ($params->child->pickupInstruction == "Le coach téléphone et mon enfant rentre seul du minivan") ? 'selected':''; endif ?>> Le coach téléphone et mon enfant rentre seul du minivan </option>
            <option value="Le coach ne téléphone pas et mon enfant rentre seul du minivan" <?php if(1 === $update): echo ($params->child->pickupInstruction == "Le coach ne téléphone pas et mon enfant rentre seul du minivan") ? 'selected':''; endif ?>> Le coach ne téléphone pas et mon enfant rentre seul du minivan</option>
          </select>
        </label>
      </div>
      <div class="medium-6 cell">
        <label> Informations médicales
          <input type="text"  name="medical" value="<?= (1 === $update) ?  $params->child->medical: '';  ?>">
        </label>
      </div>
      <div class="medium-12 cell">
        <label> Commentaire sur le transport
          <textarea name="comment"><?= (1 === $update) ?  $params->child->comment: '';  ?></textarea>
        </label>
      </div>
        <div class="medium-12 cell">
            <label for="school">École <sup style="color: darkred">*</sup></label>
            <?php if($update == 1 AND isset($params->child->school->schoolId)): ?>
                <input id="autocomplete" placeholder="Rechercher une école"  class="form-input-text" type="text" value="<?= (1 === $update) ?  $params->child->school->name: '';  ?>">
                <input type="hidden" id="school" name="school" value="<?= (1 === $update) ?  $params->child->school->schoolId: '';  ?>">
            <?php else: ?>
                <input id="autocomplete" placeholder="Rechercher une école"  class="form-input-text" type="text">
                <input type="hidden" id="school" name="school">
            <?php endif; ?>
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
        <div class="photoContainer"><img src="<?php if(1 === $update): echo ("" != $params->child->photo) ? HOST.$params->child->photo : IMG.'no_photo.jpg'; else:  IMG.'no_photo.jpg'; endif ?>" id="photoRender"></div>
        <?php if($update == 1): ?>
          <center>
            <p>
              <a href="javascript:void(0)" class="button rotate" style="margin-top: 12px;" onclick="rotatePhoto('<?= $params->child->photo; ?>')">
                Rotation de l'image 
              </a>
            </p>
          </center>
        <?php endif; ?>
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
            Glisser et déposer le certificat médical
          </div>
        </div>

      </div>
      <div class="medium-6 cell">
        <div class="photoContainer">
            // certificat médical
        </div>
      </div>






      <div class="medium-12 cell">

        <h2 class="margin-top-20"> Utilisateurs associés </h2>
        <div class="flex space-arround user__associated" >

            <?php if($update == 1):  ?>

              <?php foreach($params->child->persons as $person):?>

                <div  class="card-ea-profil" data-relation="test" data-id-person="<?= $person->personId; ?>">
                    <div class="card-banner">
                        <div class="card-profile" style="background-image: url('<?= ($person->photo != "") ? HOST.$person->photo : IMG.'no_photo.jpg';  ?>');"></div>
                        <h3><?= $person->firstname.' '.$person->lastname; ?></h3>
                        <h4><?= $person->relation; ?></h4>
                        <aside>
                            <a href="javascript:void(0)" data-id="<?= $person->personId; ?>" onclick="deletePerson(this)"> Supprimer </a>
                        </aside>
                    </div>
                </div>

              <?php endforeach ?>

            <?php endif ?>

        </div>

        <p class="lead"> Ajouter une personne liée </p>

        <input type="search"  id="searchListPerson" placeholder="Recherche dynamique">

        </section>
        <section class="block-list">
          <ul id="personList"> </ul>
        </section>

        <div class="text-center" style="margin-top: 12px;"><a href="javascript:void(0)" class="button bg-white black border--black" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListPerson"> Afficher plus </a></div>

      </div>
      <div class="medium-12 cell">
       	<center><input type="submit" class="button large" id="displayOverButtons" value="Envoyer" /></center>
      </div>
    </div>
  </div>
</form>
<p>* champ obligatoire</p>

<div class="reveal mobile-ios-modal" id="relationPerson" data-reveal>
  <div class="mobile-ios-modal-inner">
    <p>Indiquez la relation</p>
    <input type="hidden" id="idPerson">
    <input type="hidden" id="nomPerson">
    <input type="hidden" id="photoPerson">
    <input type="text" id="relationInput">
  </div>

  <div class="mobile-ios-modal-options">
    <button data-close class="button">Fermer</button>
    <button class="button" data-close onclick="addPersonStep2()">Ok</button>
  </div>
</div>

<input type="hidden" id="pageSearch">
<div class="space_actions_page_mobile"></div>
