<?php $title="Drivers"; ?>


<h1> Drivers </h1>

<div data-closable class="callout alert-callout-subtle info">
  <strong>Information !<br></strong> Vous pouvez changer l'ordre des drivers en glissant déposant chaque driver et en cliquant sur sauvegarder. L'ordre de la liste correspond à l'ordre utilisé pour l'auto dispatch.
  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
    <span aria-hidden="true">⊗</span>
  </button>
</div>

<div class="reveal mobile-ios-modal" id="action-driver" data-reveal>

  <div class="mobile-ios-modal-options-stacked">
    <button data-close class="button" onclick="editDriver();openRevealJS('createDriver')">Modifier</button>
    <button data-close class="button" onclick="deleteDriver()">Supprimer</button>
    <button data-close class="button" style="color:red;">Fermer</button>
  </div>
</div>

<div class="reveal" id="createDriver" data-reveal>
  <p class="lead" id="titleReveal" >Drivers </small></p>
  <div class="text-center editAdress displayNone"><a href="javascript:void(0)" onclick="iframePerson()" class="button editAdress">Ajouter/Modifier une adresse</a></div> 
  <div class="containerLoader displayNone" id="loaderFormEditDriver" <!--style="display: none;-->"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

  <form method="post" id="driverForm" action="staff/create">
    <input type="hidden" name="kind" value="driver">
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
            <input type="hidden" name="person" required>
        </div>

        <div class="medium-12 cell" id="listPerson" >
          <label>Associer une personne
            <input type="search" id="searchListPerson" placeholder="Rechercher une personne ">
          </label>
          <section class="block-list">
            <ul id="personList"></ul>
          </section>

          <div class="text-center" style="margin-top: 12px;"><button class="button" style="display: none;" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListPerson"> Afficher plus </button></div>
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

          <section class="block-list" id="vehiclesList">
              <label>
                  <i class="material-icons arrow" style="vertical-align: text-bottom;">keyboard_arrow_down</i>
                  Associer un véhicule
              </label>
            <ul id="vehicleList">
            <li data-id-vehicle="0" style="height: 4.025rem; display: none;">
                      <div>
                        <p class="list-header">
                          <img src="<?= IMG.'no_photo_2.jpg';  ?>" class="width-30 height-30" />
                          Aucun véhicule
                          <aside class="subtitles"></aside>
                          <div class="with-icon">
                            <div class="switch">
                              <input class="switch-input" value="" id="vehiclesnon" type="radio" name="vehicle">
                              <label class="switch-paddle" for="vehiclesnon"></label>
                            </div>
                          </div>
                        </p> 
                      </div>
                  </li>
                <?php foreach($params->vehicles as $vehicle):?>
                  <li data-id-vehicle="<?= $vehicle->vehicleId; ?>" style="height: 4.025rem; display: none;">
                      <div>
                        <p class="list-header">
                          <img src="<?= ("" != $vehicle->photo) ? HOST.$vehicle->photo : IMG.'no_photo_2.jpg';  ?>" class="width-30 height-30" />
                          <?= $vehicle->name; ?> - <?= $vehicle->matriculation; ?>
                          <aside class="subtitles"></aside>
                          <div class="with-icon">
                            <div class="switch">
                              <input class="switch-input" value="<?= $vehicle->vehicleId; ?>" id="vehicles<?= $vehicle->vehicleId; ?>" type="radio" name="vehicle">
                              <label class="switch-paddle" for="vehicles<?= $vehicle->vehicleId; ?>"></label>
                            </div>
                          </div>
                        </p> 
                      </div>
                  </li>
                <?php endforeach ?>
            </ul>
          </section>
        </div>


        <p class="lead">Zones </p>
        <div class="medium-12 cell">

          <div id="resultZone" style="margin-top: 15px; margin-bottom: 15px;"></div>
          <div class="grid-x grid-padding-x">
            <div class="medium-6 cell">
            <input id="postal" type="number" placeholder="CP">
            </div>
            <div class="medium-6 cell">
              <input id="priority" type="number" placeholder="Priorité">
            </div>
          </div>
          <div class="text-center">
             <a href="javascript:void(0)" onclick="addZone()" class="button">Ajouter une zone </a>
          </div>
        </div>
        <div class="medium-12 cell" style="margin-top: 20px;">
          <center><button type="submit" class="button large">Envoyer </button></center>
        </div>
      </div>
    </div>
  </form>

  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="text-center"><button class="button margin-right-10" onclick="changerActionDriver();openRevealJS('createDriver')"> Ajouter un driver</button><button class="button" id="saveOrder"> Sauvegarder  l'ordre </button></div>

<section class="block-list">
  <ul id="driverList">


      <?php foreach($params->drivers as $driver):?>

        <li data-id-driver="<?php echo $driver->staffId; ?>" data-id-person="<?php echo $driver->person->personId; ?>">
          <a href="javascript:void(0)" onclick="getIdDriver('<?php echo $driver->staffId; ?>');openRevealJS('action-driver')" >
            <div>
              <p class="list-header">
                <img src="<?php echo ($driver->person->photo != "") ? HOST.$driver->person->photo : IMG.'no_photo.jpg';  ?>" class="width-30 height-30" />
                <?php echo $driver->person->firstname; ?>  <?php echo $driver->person->lastname; ?>
                <aside class="subtitles">
                  Zone(s) associée(s) :<?php foreach($driver->driverZones as $zone):?>
                    <?php echo $zone->postal; ?> <strong class="red" style="margin-right: 10px;"> (<?php echo $zone->priority; ?>)</strong> 
                  <?php endforeach ?>
                  <?php if($driver->vehicle != null): ?>
                  <br/> Véhicule associé :  <?php echo $driver->vehicle->name; ?>  - <?php echo $driver->vehicle->matriculation; ?>
                  <?php endif; ?> 
                  <?php if($driver->address != null): ?>
                  <br/>Adresse principale : <?php echo $driver->address->name; ?> - <?php echo $driver->address->address; ?> (<?php echo $driver->address->address2; ?>) - <?php echo $driver->address->postal; ?> - <?php echo $driver->address->country; ?>
                  <?php endif; ?>
                </aside>
                <div class="with-icon">
                  <i class="material-icons">send</i>
                </div>
              </p>
            </div>
          </a>
        </li>
      <?php endforeach ?>
  </ul>
</section>

<div class="text-center margin-top-12" >
  <button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreDriver"> Afficher plus </button>
</div>


<input type="hidden" id="pageSearch">
<input type="hidden" id="lastIdDriver">
