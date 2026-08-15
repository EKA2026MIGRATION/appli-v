<?php $title = "Ajouter / Modifier un utilisateur "; ?>

<style type="text/css">.zselect { width:100%; } </style>
<?php $update = 0; if(isset($params->email)): $update = 1; endif ?>


<h1><?= (1 === $update) ? 'Modifiez' : 'Créez';  ?> le compte user de la personne </h1>

<form  autocomplete="off" method="post" id="signUpForm" action="<?= API;?>user/api/<?= (1 === $update) ? 'modify/'.$params->identifier : 'create';  ?>">
  <div class="grid-container">
     <div class="medium-12 cell">
        <div class="callout alert small messageInscription" style="display: none;">
      </div>
    <div class="grid-x grid-padding-x">
      <div class="medium-12 cell">
        <label>E-mail
          <input type="email" required name="username" value="<?= (1 === $update) ?  $params->email: '';  ?>"  placeholder="E-mail de l'utilisateur">
        </label>
      </div>

        <div class="medium-12 cell">
          <label>Mot de passe
            <input type="password" required name="plainPassword" placeholder="Mot de passe de l'utilisateur">
          </label>
        </div>
      <div class="medium-12 cell">
        <center><input type="submit" class="button" value="Envoyer" /></center>
      </div>
    </div>
  </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-sha1/0.6.0/sha1.js" type="text/javascript"></script>
