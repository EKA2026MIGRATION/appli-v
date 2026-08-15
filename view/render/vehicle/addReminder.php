<?php
$title = "Ajouter du fuel";
?>


<p class="lead">Ajouter un rappel</p>

<form method="post" id="addReminder" action="reminder/create">
    <input type="hidden" name="" />
    <input type="hidden" name="staff_id" value="<?= PERSON_CONNECTED['staff']['staffId']; ?>" />

    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <label>Véhicule*
                    <select name="vehicle">
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
                <label>Type de rappel
                    <select name="name" id="name" required>
                        <option value="Changement des pneus" selected>Changement des pneus</option>
                        <option value="Effectuer le contrôle technique">Effectuer le contrôle technique</option>
                        <option value="Effectuer une révision">Effectuer une révision</option>
                    </select>
                </label>
            </div>
            <div class="medium-12 cell">
                <label>Description*
                    <textarea id="description" name="description"></textarea>
                </label>
            </div>
            <div class="medium-12 cell">
                <label>Critère du rappel*
                    <select name="criteria" id="criteria" onchange="" required>
                        <option value="km" selected>Kilométrage</option>
                        <option value="date">Date</option>
                    </select> </label>
            </div>
            <div class="medium-12 cell">
                <label><span id="labelCriteriaValue">Kilométrage du rappel</span> *
                    <input type="number" id="criteriaValue" name="criteriaValue" placeholder="" required>
                </label>
            </div>
            
            <div class="medium-12 cell">
                <label>Critère de déclenchement*
                    <select name="criteriaComparison" id="criteriaComparison" required>
                        <!--<option value="=">= au kilomètrage/date de rappel</option>-->
                        <option value=">">supérieur au kilométrage/date de rappel</option>
                        <option value="<">inférieur au kilométrage/date de rappel</option>
                    </select>
                </label>
            </div>

            <input type="hidden" name="url" value="https://appli-v.net/vehicle/list" id="url" />

            <div class="medium-12 cell" style="margin-top: 10px;">
                <center><button type="submit" class="button">Envoyer </button></center>
            </div>
        </div>
    </div>
</form>

<p>* champs obligatoire</p>