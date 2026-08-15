<?php $title = "Mot de passe oublié ?"; ?>

<form action="<?= API;?>user/api/reset-password" method="PUT" id="lostPassWordForm" style="max-width: 400px; margin:auto;" novalidate="novalidate">

        <h3 class="picto-list-title main-content-title"><span>Réintialiser le mot de passe</span></h3>
        <p class="form-item">
            <label for="firstEmail"><strong>Votre</strong>  adresse e-mail</label>
            <input id="firstEmail" name="email" class="form-input-text" required="" type="email" title="Format incorrect" aria-required="true" >
        </p>

    <p>
        <input type="submit" style="display: block; width:100%" class="button" value="Réintialiser mon mot de passe">
        <br><br><br><br>
    </p>
</form>