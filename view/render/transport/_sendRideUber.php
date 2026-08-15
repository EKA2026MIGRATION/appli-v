<div id="showUberRide">
    <span id="closeShowUberRide" style="color: red; font-weight: bold; float: right">X</span>
    <h6><?= date('d/m/Y', strtotime($params->date)) ?></h6>
    Envoi du parcours <h7 style="font-weight: bold; color: darkblue"></h7>
    <br />
    <input type="email" name="customEmail" id="customEmail" placeholder="Entrez un email" />
    ou
    <select name="prestEmail" id="prestEmail">
        <option value="" selected=selected>Sélectionnez un prestataire</option>
        <?php foreach ($params->prestas as $presta) : ?>
            <option value="<?= $presta['email']; ?>"> <?= $presta['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <br />
    <button class="button" id="sendUberRide" style="width: 100%">Envoyez</button>
    <br />
    <div id="uberRideContent"></div>
    <div id="uberRideResult"></div>
    <br /><br /><br /><br /><br />
</div>