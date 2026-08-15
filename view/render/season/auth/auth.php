<?php $title = "Authentification"; ?>
<h1>Authentification </h1>
<div class="signInDiv">
  <form method="post" id="signInForm" action="<?= API;?>user/api/authenticate">
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
          <div class="callout alert small messageConnexion" style="display: none;">
          </div>
        </div>
        <div class="medium-12 cell">
          <label>Email de connexion
            <input type="text" name="username" placeholder="Votre nom d'utilisateur" data-message="test" required>
          </label>
        </div>
        <div class="medium-12 cell">
          <label>Mot de passe
            <input type="password" name="password" placeholder="Votre mot de passe" required>
          </label>
        </div>
        <div class="medium-12 cell">
         	<center><input type="submit" class="button" value="Envoyer" /></center>
        </div>
      </div>
    </div>
  </form>
  <center><a href="<?= HOST ;?>auth/lost-password">Mot de passe oublié ? </a></center>
  <div id="signature" style="font-size: 10px; margin-top:10px; text-align: center; font-style: italic;">
    version V413N71N3 - 2016-171125-903
    - <a href="disclaimer" style="color: black">Mentions légales développement</a>
  </div>
</div>
