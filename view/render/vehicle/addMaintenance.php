<?php
$title = "Ajouter une maintenance";
?>


<p class="lead">Ajouter une maintenance</p>

<form method="post" id="addMaintenanceForm" action="vehicle/add/action">
    <input type="hidden" id="staff_id_maintenance" name="staffId" value="<?= PERSON_CONNECTED['staff']['staffId']; ?>">

    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <label>Véhicule*
                    <select name="vehicle_id" id="vehicule_id_maintenance" required>
                        <?php if (isset($params->staff->vehicle->vehicleId)) : ?>
                            <?php foreach ($params->vehicleList as $vehicle) : ?>
                                <option value="<?= $vehicle->vehicleId; ?>" <?php if ($params->staff->vehicle->vehicleId == $vehicle->vehicleId) {
                                                                                echo 'selected';
                                                                            } ?>>
                                    <?= $vehicle->matriculation; ?> - <?= $vehicle->name; ?>
                                </option>
                            <?php endforeach; ?>

                        <?php else : ?>
                            <?php foreach ($params->vehicleList as $vehicle) : ?>
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
                    <input type="number" id="km_maintenance" name="km" placeholder="Kilométrage du véhicule" required>
                </label>
            </div>
            <div class="medium-12 cell">
                <label>Date*
                    <input type="date" id="date_maintenance" name="date_maintenance" placeholder="Date" required>
                </label>
            </div>
            <p class="lead">Actions effectuées* </p>
            <div class="medium-12 cell">

                <div id="resultActionMaintenance" style="margin-top: 15px; margin-bottom: 15px;"></div>
                <div class="grid-x grid-padding-x">
                    <div class="medium-6 cell">
                        <input id="action_qty" type="text" placeholder="Quantité de l'action">
                    </div>
                    <div class="medium-6 cell">
                        <select id="action_type" type="text">
                            <?php foreach ($params->vehicle_action_type as $action_type) : ?>
                                <option value="<?= $action_type['name']; ?>"><?= $action_type['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="medium-6 cell">
                        <input id="action" type="text" placeholder="Quelle action ? (ex : Pneu avant)">
                    </div>
                    <div class="medium-6 cell">
                        <input id="prix_m" type="number" placeholder="Prix de l'action">
                    </div>
                </div>
                <div class="text-center">
                    <a href="javascript:void(0)" onclick="addActionMaintenance()" class="button">Ajouter une action </a>
                </div>
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
              Photo de la facture
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