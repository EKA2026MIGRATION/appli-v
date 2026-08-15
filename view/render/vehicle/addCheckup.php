<?php 
  $title="Ajouter un checkup"; 
?>


<p class="lead">Ajouter un checkup</p>


<div class="containerLoader displayNone" id="loaderFormCheckVehicle" ><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>


<form method="post" id="checkVehicleForm" action="vehicle/checkup/valid">
  <input type="hidden" name="photo" id="photoUrl" value="" />
  <input type="hidden" id="staff_id_checkup" name="staffId" value="<?= PERSON_CONNECTED['staff']['staffId']; ?>">
  
  <div class="grid-container">
    <div class="grid-x grid-padding-x" >
    <div class="medium-12 cell">
                <label>Véhicule*
                    <select name="vehicle_id" id="vehicule_id_checkup">
                        <?php if(isset($params->staff->vehicle->vehicleId)): ?>
                        <?php foreach($params->vehicleList as $vehicle):?>
                        <option value="<?= $vehicle->vehicleId; ?>"
                            <?php if($params->staff->vehicle->vehicleId == $vehicle->vehicleId) { echo 'selected'; } ?>>
                            <?= $vehicle->matriculation; ?> - <?= $vehicle->name; ?>
                        </option>
                        <?php endforeach; ?>

                        <?php else: ?>
                        <?php foreach($params->vehicleList as $vehicle):?>
                        <option value="<?= $vehicle->vehicleId; ?>">
                            <?= $vehicle->matriculation; ?> - <?= $vehicle->name; ?>
                        </option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </label>
            </div>
    <section class="block-list" id="list_checkup">
        <div>
          <ul>
            <?php foreach($params->checkup as $checkup):?>

               <li>
                  <a href="javascript:void(0)">
                      <div>
                          <p class="list-header second-row">
                              <?= $checkup->name; ?> (<?= $checkup->description; ?>) 
                              <aside class="subtitles"></aside>
                              <div class="with-icon">
                                 <div class="switch">
                                        <input class="switch-input"  id="<?= $checkup->constantKey; ?>" type="checkbox" >
                                        <label class="switch-paddle" for="<?= $checkup->constantKey; ?>"></label>
                                  </div>
                              </div>
                          </p>
                      </div>
                  </a>
              </li>
 
            <?php endforeach; ?>
          </ul>
        </div>
    </section>
      <div class="medium-12 cell">
        <label>Commentaire
          <input type="text" name="comment" id="comment_checkup" placeholder="Commentaire" >
        </label>
      </div>
      <div class="medium-12 cell">
        <label>Date du checkup 
          <input type="date" id="date_checkup_send" name="date_checkup" placeholder="Date" >
        </label>
      </div>

      <!--
      <div class="medium-12 cell">
        <div class="dropContainer" id="dropContainer">
          <div class="contentDropContainer">

            <div class="image-upload">

              <label class="labelFileInput" for="fileInput">
                <a class="button withIcon"><i class="material-icons">create_new_folder</i> Parcourir mes fichiers </a>
              </label>

              <input type="file" id="fileInput" onchange="previewOnDiv()"/>

            </div>
            Glisser et déposer une photo si besoin
          </div>
        </div>

      </div>
      <div class="medium-12 cell" style="margin-top: 10px;">
        <div class="photoContainer"><img src="<?= IMG ?>no_photo_2.jpg" id="photoRender"></div>
      </div>
      -->


      <div class="medium-12 cell" style="margin-top: 10px;">
        <center><button type="submit" class="button">Envoyer </button></center>
      </div>
    </div>
  </div>
</form>


<p>* champs obligatoire</p>