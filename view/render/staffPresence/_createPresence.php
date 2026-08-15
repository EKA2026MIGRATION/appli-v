 <div class="reveal mobile-ios-modal" id="action-add-presence" data-reveal>
  <div class="mobile-ios-modal-inner">
    <p>Ajouter une présence</p>
    <input type="text" id="lastDatePresence">

    <p>Plage horaire</p>
    <input type="time" id="start" placeholder="Heure de début" value="<?= $hour_start_value;?>">

    <input type="time" id="end" placeholder="Heure de fin" value="<?= $hour_end_value;?>">


    <select name="type_name" id="type_name">
          <option value="PRESENCE">Présence</option>
          <option value="ABSENCE">Absence</option>
          <option value="CATCHING">Rattrapage</option>
          <option value="BONUS">Bonus</option>
          <option>---------</option>
          <option value="FORMATION">Formation</option>
         <option value="VACATION">Congés</option>
    </select>

    <ul style="width: 90%">
        <?php foreach($params->teams as $id => $team):?>
            <li style="display: flex">
                <div>
                    <input type="checkbox" value="<?= $id;?>" name="teams" class="checkboxTeams"/> 
                </div>
                <div style="margin-left: 10px">
                    <?= $team;?>
                </div>
            </li>
        <?php endforeach;?>
    </ul>
    <select name="location" id="location">
          <?php foreach($params->locations as $location):?>
            <option value="<?= $location->locationId;?>" <?php if($location->locationId == 6) echo ' selected="selected" ';?>><?= $location->name;?></option>
          <?php endforeach;?>
    </select>

  </div>

  <div class="mobile-ios-modal-options">
    <button data-close class="button">Fermer</button>
    <button class="button" id="createPresence">Ok</button>
  </div>
</div>
