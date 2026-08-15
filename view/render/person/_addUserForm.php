<div  id="showCreateUserForm"
      style = "position:absolute;
              z-index:999; border:4px solid darkblue;border-radius:10px; 
              width: 80%; background-color: white; top: 100px; min-height: 300px; padding: 30px;"

      >
        <h4 style="text-align: center">Transformer le profil en compte utilisateur</h4>

        <form  autocomplete="off" method="post" id="signUpForm" action="<?= API;?>user/api/create';  ?>">
          <div class="grid-container">
            <div class="medium-12 cell">
                <div class="callout alert small messageInscription" style="display: none;">
              </div>
            <div class="grid-x grid-padding-x">
              <div class="medium-12 cell">
                <label>E-mail
                  <input type="email" required name="username" placeholder="E-mail de l'utilisateur">
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


</div>