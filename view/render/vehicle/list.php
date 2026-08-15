<?php
$title = "Gestion de la flotte de véhicules";
?>


<style type="text/css">
  .mfb-component--br {
    position: absolute;
  }
</style>

<?php include('_createVehicle.php');?>


<h1 class="text-center"> Véhicules </h1>

<div class="text-center">
  <button class="button" onclick="changeActionVehicle()" data-open="createVehicle"> Ajouter un véhicule </button>
</div>

<div class="vehicle flexEvenly">
  <section>
    Du <br />
    <input type="date" id="reportStart" value="<?= $params->vehicleDateStart; ?>">
  </section>

  <section>
    Au <br />
    <input type="date" id="reportEnd" value="<?= $params->vehicleDateEnd; ?>">
  </section>

  <section>
    <button class="button" style="margin-top: 20px;" onclick="viewRapportDate()">Afficher le rapport </button>
  </section>
</div>


<div>
    
    <div class="with-icon" style="display: flex; justify-content: center">
        <div class="switch">
              <input class="switch-input"  id="showAllVehicleButton" type="checkbox" >
              <label class="switch-paddle" for="showAllVehicleButton"></label>
        </div>
        <div style="line-height: 30px">
          &nbsp;&nbsp;Voir tous les véhicules
        </div>

    </div>
</div>

<center>
  <button class="button" onclick="extractFuel()"> Fuel </button>
  <button class="button" onclick="extractWash()"> Lavages </button>
  <button class="button" onclick="extractAction()"> Actions </button>
  <button class="button" onclick="extractCheckup()"> Checkups </button>
</center>

<div id="fuelTableExtract" style="display: none;">

  <table class="margin-top-20">
    <thead>
      <tr>
        <th width="200">Véhicule</a></th>
        <th width="200">Quantité (litres)</a></th>
        <th width="200">Prix (euros)</a></th>
        <th width="150">Kilométrage (km)</a></th>
        <th width="150">Date </a></th>
        <th width="150">Ajouté par </a></th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

</div>


<div id="washTableExtract" style="display: none;">

  <table class="margin-top-20">
    <thead>
      <tr>
        <th width="200">Véhicule</a></th>
        <th width="200">Quantité (litres)</a></th>
        <th width="200">Prix (euros)</a></th>
        <th width="150">Kilométrage (km)</a></th>
        <th width="150">Date </a></th>
        <th width="150">Ajouté par </a></th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

</div>

<div id="actionTableExtract" style="display: none;">

  <table class="margin-top-20">
    <thead>
      <tr>
        <th width="200">Véhicule</a></th>
        <th width="200">Quantité (litres)</a></th>
        <th width="200">Prix (euros)</a></th>
        <th width="150">Kilométrage (km)</a></th>
        <th width="150">Date </a></th>
        <th width="150">Ajouté par </a></th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

</div>

<div id="checkupTableExtract" style="display: none;">

  <table class="margin-top-20">
    <thead>
      <tr>
        <th width="200">Véhicule</a></th>
        <th width="200">Quantité (litres)</a></th>
        <th width="200">Prix (euros)</a></th>
        <th width="150">Kilométrage (km)</a></th>
        <th width="150">Date </a></th>
        <th width="150">Ajouté par </a></th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

</div>


<table class="margin-top-20 table-expand vehicleTable">
  <thead>
    <tr class="table-expand-row">
      <th width="200">Photo</th>
      <th width="200">Nom</th>
      <th width="150">Immatriculation</th>
      <th width="150">Driver(s)</th>
      <th width="150">Conso au 100 </th>
      <th width="150">Coût <img src="<?= IMG . 'icons/fuel.png' ?>" style="width: 15px;" /></th>
      <th width="150">Coût <img src="<?= IMG . 'icons/wash.png' ?>" style="width: 15px;" /></th>
      <th width="150">Coût <img src="<?= IMG . 'icons/car-action.png' ?>" style="width: 15px;" /></th>
      <th width="150">Coût total</th>
      <th width="150">Action </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($params->vehicleListBetween as $vehicle) : ?>

      <?php
      $quantityFuel = 0;
      $conso = 0;
      $amountFuel = 0;
      $amountAction = 0;
      $amountWash = 0;
      $litresConso = 1;
      $i = 0;
      $iTotal = count((array) $vehicle->fuels) - 1;
      $kmStart = 0;
      $kmEnd = 0;

      if($vehicle->vehicle->matriculation == "nc" || $vehicle->vehicle->matriculation == "NC" || $vehicle->vehicle->matriculation == "") {
        $busMatriculationClass = "busNC";
      } else {
        $busMatriculationClass = "";
      }

      foreach ($vehicle->fuels as $fuel) :

        if ($i == 0) {
          $kmStart = $fuel->mileage;
        } else {
          $litresConso += $fuel->quantity;
        }

        if ($i == $iTotal) {
          $kmEnd = $fuel->mileage;
        }

        $quantityFuel += $fuel->quantity;
        $amountFuel += $fuel->amount;
        $i++;

      endforeach;

      foreach ($vehicle->washings as $wash) :
        $amountWash += $wash->amount;
        $i++;
      endforeach;

      $amountAction = 0;

      foreach ($vehicle->actions as $action) :
        $amountAction += $action->amount;
      endforeach;

      $totalCost = round($amountAction + $amountFuel + $amountWash, 2);

      $conso = ($kmStart - $kmEnd) / $litresConso;
      ?>

      
      <tr data-id-vehicle="<?= $vehicle->vehicle->vehicleId; ?>"
          class="table-expand-row search <?= $busMatriculationClass;?>"
          <?php if($busMatriculationClass == "busNC") echo ' style = "display:none;" ';?>
        >
        <td><img src="<?php echo showPhoto('other', $vehicle->vehicle->photo); ?>" class="width-30 height-30" /></td>
        <td><?= $vehicle->vehicle->name; ?></td>
        <td><?= $vehicle->vehicle->matriculation; ?></td>
        <td>
        <?php foreach($params->staff as $staff):?>
          <?php if(isset($staff->vehicle->vehicleId)): ?>
            <?php if($staff->vehicle->vehicleId == $vehicle->vehicle->vehicleId): ?>
                <?= $staff->person->firstname; ?><br/>
              <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        </td>
        <td><?= round($conso, 2); ?>l/100km</td>
        <td><?= round($amountFuel, 2); ?></td>
        <td><?= round($amountWash, 2); ?></td>
        <td><?= round($amountAction, 2); ?></td>
        <td><?= $totalCost; ?></td>
        <td><a href="<?= HOST; ?>vehicle/display/id/<?= $vehicle->vehicle->vehicleId; ?>/">Ouvrir </a></td>
      </tr>
      <?php require('_vehicleExpandTableForCalcul.php'); ?>

    <?php endforeach ?>
  </tbody>
</table>


<input type="hidden" id="pageSearch">
<input type="hidden" id="lastIdVehicle">
<input type="hidden" id="lastNameVehicle">