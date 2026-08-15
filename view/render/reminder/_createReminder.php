<div class="reveal" id="createReminder" data-reveal>
  <p class="lead">Créer un rappel </p>

 
  <form method="post" id="vehicleForm" action="vehicle/create">
    <input type="hidden" name="photo" id="photoUrl" value="" />
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
          <label>Message *
            <input type="text" name="title" placeholder="Message rappel" required>
          </label>
        </div>
        <div class="medium-12 cell">
          <label>Choisir une liason *
            <select name="liason">
              <option value="vehicle">Véhicules</option>
            </select>
          </label>
        </div>
        <div class="medium-12 cell">
          <label>Choisir la liason *
            <select name="id-liason">
              <option value="1">Espace 356</option>
            </select>
          </label>
        </div>
        <div class="medium-12 cell">
          <label>Date fixe 
            <input type="date" name="date_fixe" />
          </label>
        </div>
        <div class="medium-12 cell">
          <label>Date récurente - <a href="#" data-open="generateCronFormat">Générer format CRON</a>
              <input type="text" name="date_recur" id="date_recur" />
          </label>
        </div>
        <div class="medium-12 cell" style="margin-top: 20px;">
          <center><button type="submit" class="button">Envoyer </button></center>
        </div>
      </div>
    </div>
  </form>

  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
  <p>* champ obligatoire</p>
</div>



