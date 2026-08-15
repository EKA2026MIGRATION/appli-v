<div class="reveal mobile-ios-modal" id="action-plage-de-date" data-reveal>
  <div class="mobile-ios-modal-inner">
    <p>Ajouter une présence</p>
    <label>
      Date de début
      <input type="text" id="startDate">
    </label>

    <label>Date de fin
      <input type="text" id="endDate">
    </label>

    <p>Horaires pour la plage</p>
    <input type="time" id="start-hour-plage" placeholder="Heure de début" value="<?= $hour_start_value;?>">
    <input type="time" id="end-hour-plage" placeholder="Heure de fin" value="<?= $hour_end_value;?>">
  </div>

  <div class="mobile-ios-modal-options">
    <button data-close class="button">Fermer</button>
    <button class="button" id="createPresenceByPlage">Ok</button>
  </div>
</div>
