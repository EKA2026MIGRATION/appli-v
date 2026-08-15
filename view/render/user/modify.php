<?php $title = "Modifier un utilisateur "; ?>

<h2 class="text-center  margin-top-20"> Modifier le mot de passe </h2>

<form action="<?= API;?>user/api/change-user-password/<?= $params->identifier ?>" method="PUT" id="changePassWord" novalidate="novalidate">

  <div class="grid-container">
      <div class="medium-12 cell">
        <label>Mot de passe
          <input type="password" name="new_password" id="passwordInput" placeholder="Nouveau mot de passe">
          <div id="showPasswordButton" style="display: flex; cursor: pointer; color: darkblue; text-align: left; font-style: italic;">
              <i class="material-icons">remove_red_eye</i>
              &nbsp;&nbsp;&nbsp;
              <span>Afficher le mot de passe</span>
          </div>
        </label>
      </div>
  </div>

      <div class="medium-12 cell">
        <center><input type="submit" class="button" value="Changer le mot de passe" /></center>
      </div>

</form>

<h2 class="text-center margin-top-20"> Modifier l'email </h2>

<form action="<?= API;?>user/api/modify/<?= $params->identifier ?>" method="PUT" id="changeEmail" novalidate="novalidate">

  <div class="grid-container">
      <div class="medium-12 cell">
        <label>Email
          <input type="email" id="newEmail" name="new_email"  placeholder="Nouvel e-mail">
        </label>
      </div>
  </div>

      <div class="medium-12 cell">
        <center><input type="submit" class="button" value="Changer l'email" /></center>
      </div>

</form>


<?php if(hasRole('ADMIN')):?>

  <h2 class="text-center  margin-top-20"> Modifier les rôles </h2>

  <style type="text/css">.zselect { width:100%; } </style>


  <?php $roles = explode(",", $params->roles); ?>
  <div class="cell medium-12 large-12 small-12" >
      <div>
          <label>Choix des rôles </label>
          <select id="rolesSelect">
              <optgroup label="Rôles">
                  <option value="ROLE_PARENT" <?= (in_array("ROLE_PARENT", $roles)) ?  'data-selected': '';  ?>>ROLE_PARENT</option>
                  <option value="ROLE_DRIVER" <?= (in_array("ROLE_DRIVER", $roles)) ?  'data-selected': '';  ?>>ROLE_DRIVER</option>
                  <option value="ROLE_COACH" <?= (in_array("ROLE_COACH", $roles)) ?  'data-selected': '';  ?>>ROLE_COACH</option>
                  <option value="ROLE_MANAGER" <?= (in_array("ROLE_MANAGER", $roles)) ?  'data-selected': '';  ?>>ROLE_MANAGER</option>
                  <option value="ROLE_ADMIN" <?= (in_array("ROLE_ADMIN", $roles)) ?  'data-selected': '';  ?>>ROLE_ADMIN</option>

              </optgroup>
          </select>
       </div>
       <input type="hidden" id="liveResult" />
  </div>

  <div class="medium-12 cell">
    <center><input type="submit" class="button" onclick="modifyRoles()" value="Envoyer" /></center>
  </div>


<?php endif;?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/js-sha1/0.6.0/sha1.js" type="text/javascript"></script>
<input id="user_identifier" value="<?= $params->identifier; ?>" type="hidden">
<input id="urlRoles" type="hidden" value="<?= API;?>user/api/modify-roles/<?= $params->identifier ?>" type="hidden">
<input id="urlApi" value="<?= API;?>" type="hidden">
<input id="listroles" value="<?= $params->roles;?>" type="hidden">


<script>
    let showPasswordButton = document.getElementById('showPasswordButton');
    let showPasswordInput = document.getElementById('passwordInput');
    
    showPasswordButton.addEventListener('click', function() {
        if (showPasswordInput.type === "password") { 
          showPasswordInput.type = "text"; 
        } 
        else
        { 
          showPasswordInput.type = "password"; 
        } 
    })

</script>