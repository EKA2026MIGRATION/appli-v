<input type="hidden" id="childParam" value="<?= $params->child; ?>">
<p class="lead">Créer / Modifier un pickup</p>

<div class="containerLoader" id="loaderFormEditPickUp" style="display: none;"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

<form method="post" id="pickUpForm" action="pickup/create">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">

                <?php $date = date('Y-m-d'); ?>
                <input type="hidden" name="child" value="<?= $params->child; ?>">

                <input type="hidden" name="sortOrder" value="12">
                <label>Prise en charge/Dépose
                    <select name="kind" id="kindPickup" required>
                        <option value="dropin">Prise en charge</option>
                        <option value="dropoff">Dépose</option>
                    </select>
                </label>
                <div class="medium-12 cell">
                    <label>Heure de prise en charge
                        <input type="time"  onkeyup="changeDateStart()" onchange="changeDateStart()" id="start_not" value="08:00" placeholder="Heure de prise en charge">
                    </label>
                </div>


                <label>Adresse
                    <input type="text" name="address" id="autocomplete3" placeholder="Adresse de prise en charge">
                </label>
                <label>Code postal (auto-dispatch)
                    <input type="text" id="postal_pickup" name="postal" value="">
                </label>
                <label>Montant à faire payer
                    <input type="number" id="amount" value="">
                </label>

                <div class="containerLoader" id="loaderLoadAdress" style="display: none;"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

                <div id="resultAdress" style="padding-top: 5px; padding-bottom: 5px;"></div>

            </div>
            <input type="hidden" id="start_note_2" name="start" value="<?php echo $params->date; ?> 08:00">
            <div class="medium-12 cell">
                <label>Commentaire (facultatif)
                    <input type="text" name="comment" placeholder="Commentaire" value="">
                </label>
            </div>


            <input type="hidden" id="pageSearch">


            <div class="medium-12 cell">
                <center><input type="submit" class="button" value="Envoyer" />
            </div>
        </div>
    </div>
</form>


