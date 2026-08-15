<?php 
  $title="Ajouter du fuel"; 
?>


<p class="lead">Ajouter de l'essence</p>

<form method="post" id="addEssence" action="vehicle/add/fuel">
    <input type="hidden" name="" />
    <input type="hidden" name="staff_id" value="<?= PERSON_CONNECTED['staff']['staffId']; ?>" />

    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <label>Véhicule*
                    <select name="vehicle_id">
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
            <div class="medium-12 cell">
                <label>Kilométrage du véhicule*
                    <input type="number" inputmode="decimal" id="mileage" name="mileage" placeholder="Kilométrage du véhicule" required>
                </label>
            </div>
            <div class="medium-12 cell">
                <label>Quantité en litres
                    <input type="number" inputmode="decimal" id="quantity" name="quantity" step="any" placeholder="Quantité">
                </label>
            </div>
            <div class="medium-12 cell">
                <label>Prix*
                    <input type="number" inputmode="decimal" id="amount" name="amount" step="any" placeholder="Prix" required>
                </label>
            </div>

            <div class="medium-12 cell">
                <label>Date*
                    <input type="date" id="date_fuel" name="date_action" value="<?= $params->date; ?>"
                        placeholder="Date" required>
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
              Photo du reçu
            </div>
          </div>

        </div>
        <div class="medium-12 cell" style="margin-top: 10px;">
          <div class="photoContainer"><img src="<?= IMG ?>no_photo_2.jpg" id="photoRender"></div>
        </div
        -->

            <div class="medium-12 cell" style="margin-top: 10px;">
                <center><button type="submit" class="button">Envoyer </button></center>
            </div>
        </div>
    </div>
</form>

<p>* champs obligatoire</p>