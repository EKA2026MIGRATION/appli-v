<?php $title = "Optimiser un trajet"; ?>

<h1>Optimiser un trajet </h1>

  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="medium-6 cell">
        <label>Point de départ
          <input type="text" id="autocomplete1" placeholder="Adresse"  required>
        </label>
      </div>
      <div class="medium-6 cell">
        <label>Point d'arrivée
          <input type="text" id="autocomplete2" placeholder="Adresse" required>
        </label>
      </div>
      <div class="medium-12 cell">
        <div class="grid-x ">
          <fieldset>
            <legend>Moyen de transport</legend>
            <input type="radio" name="transport" value="DRIVING" id="driving" checked><label for="driving">Voiture</label>
            <input type="radio" name="transport" value="BICYCLING" id="bicycling"><label for="bicycling">Vélo</label>
            <input type="radio" name="transport" value="WALKING" id="walking"><label for="walking">Marcher</label>
            <input type="radio" name="transport" value="TRANSIT" id="transit"><label for="transit">Transport en commun</label>
          </fieldset>

        </div>
      </div>

      <div class="medium-12 cell">

        <h2 class="margin-top-20"> Étapes </h2>

        <div class="input-group">
          <input class="input-group-field" id="autocomplete3" placeholder="Ajouter une étape" type="text">
          <div class="input-group-button">
            <input type="button" class="button" value="Ok" onclick="addStep()">
          </div>
        </div>

        <section class="block-list">
          <ul id="stepList"></ul>
        </section>

      </div>
      <div class="medium-12 cell">
       	<center><input type="submit" class="button large" class="button" style="margin-top: 8px;" onclick="launchIa()" value="Calculer" /></center>
      </div>
    </div>
  </div>


<div id="result" style="margin:20px; text-align: center;"></div>
<div id="map" style="min-width: 300px; min-height: 300px; margin:10px; margin:auto;  max-width: 1000px; max-height: 1000px;"></div>
