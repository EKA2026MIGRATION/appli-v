<div class="reveal" id="revealCreateTrajet" data-reveal>
    <p class="lead">Créer/Modifier un trajet</p>

    <div class="containerLoader" id="loaderFormEditRide">
        <div class="lds-roller">
            <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
        </div>
    </div>

    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>

    <form method="post" id="rideForm" action="ride/create">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s', strtotime($params->date)); ?>">

                <div class="medium-12 cell">
                    <label>Nom du trajet
                        <input type="text" name="name" placeholder="Nom du trajet" required>
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Prise en charge/Dépose
                        <select name="kind" required>
                            <option value="dropin">Prise en charge</option>
                            <option value="dropoff">Dépose</option>
                        </select>
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Heure de départ
                        <input type="time" id="start_ride" value="08:00:00" placeholder="Heure de départ" required>
                        <input type="hidden" id="start_ride_2" name="start"  value="08:00:00" />
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Heure d'arrivée
                        <input type="time" id="arrival_ride"  value="08:00:00" placeholder="Heure d'arrivée" required>
                        <input type="hidden" id="arrival_ride_2" name="arrival"  value="08:00:00"/>
                    </label>
                </div>


                <div class="medium-12 cell">
                    <label>Nombre de places maximum
                        <input type="number" name="places" value="8" placeholder="Nombre de places maximum" required>
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Chauffeur

                        <select id="selectDriver" name="staff" required>
                            <option value="0">Choisir un chauffeur</option>
                        </select>
                    </label>
                </div>


                <div class="medium-12 cell">

                    <div class="containerLoader" id="loaderLoadAdressDriver">
                        <div class="lds-roller">
                            <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
                        </div>
                    </div>

                    <div id="resultAdressDriver" class="padding-top-5 padding-bottom-5"></div>

                </div>

                <div class="medium-12 cell">
                    <label>Point de départ
                        <input type="text" name="startPoint" id="autocomplete1"  placeholder="Adresse de départ" required>
                    </label>
                </div>

                <div class="medium-12 cell">
                    <label>Point d'arrivée
                        <input type="text" name="endPoint" id="autocomplete2"  placeholder="Adresse d'arrivée" required>
                    </label>
                </div>

                <div class="medium-12 cell">
                    <label>Véhicules
                        <select name="vehicle" id="vehiclesCreateRide" required></select>
                    </label>
                </div>

                <div class="medium-12 cell">
                    <label>Liaison de trajet

                        <select name="linkedRide" id="ridesCreateRide">
                            <option value="0">Choisir une liaison (optionnel)</option>
                        </select>

                    </label>
                </div>

                <div class="medium-12 cell">
                    <center><input type="submit" class="button" value="Envoyer" /></center>
                </div>
            </div>
        </div>
    </form>

</div>