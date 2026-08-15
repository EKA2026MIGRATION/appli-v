<?php $title = "Mot de passe oublié ?"; ?>

<form action="<?= API;?>user/api/reset-password-confirm/<?= $params->token; ?>" method="PUT" id="lostPassWordFormConfirm" style="max-width: 400px; margin:auto;" novalidate="novalidate">
		<input type="hidden" id="token" value="<?= $params->token; ?>">
        <h3 class="picto-list-title main-content-title"><span>Changer le mot de passe</span></h3>
        <p class="form-item">
            <label for="newPassWord"><strong>Nouveau</strong> mot de passe</label>
            <input id="newPassWord" name="new_password" class="form-input-text" required="" type="password" >
        </p>

    <p>
        <input type="submit" style="display: block; width:100%" class="button" value="Changer mon mot de passe">
        <br><br><br><br>
    </p>
    <p style="text-align: center">
        <a href="<?= HOST;?>" style="font-style: italic;">Revenir à l'accueil</a>
        <br><br><br><br>
    </p>
</form>
