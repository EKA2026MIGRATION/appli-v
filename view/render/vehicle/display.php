<?php
use_helper('dates');
$title = "Véhicule";
?>

<style>
  .deleteElementButton { cursor: pointer; color: darkred}
</style>

<div class="actionsPage">
  <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>
<div>
    <!-- icon delete -->
    <button style="float: right;">
        <i class="material-icons deleteVehicleButton" data-vehicleid="<?= $params->id;?>" data-type="vehicle" style="font-size: 50px; color: darkred; cursor: pointer">delete</i>
    </button>
</div>

<?php foreach ($params->vehicleListBetween as $vehicle) : ?>

  <?php if ($vehicle->vehicle->vehicleId == $params->id) : ?>

    <h1 style="margin-top: 60px;">Véhicule "<?php echo $vehicle->vehicle->name; ?>"</h1>

    <div class="text-center">
      <?= $vehicle->vehicle->matriculation; ?> <br />
      <?= $vehicle->vehicle->places; ?> places <br />
      <?= $vehicle->vehicle->mileage; ?> km
    </div>
    </p>
    <div class="text-center">
      <img src="<?php echo showPhoto('other', $vehicle->vehicle->photo); ?>" style="max-width:150px;">
    </div>

    <p>Liste des drivers :
      <?php foreach ($params->staff as $staff) : ?>
        <?php if (isset($staff->vehicle->vehicleId)) : ?>
          <?php if ($staff->vehicle->vehicleId == $vehicle->vehicle->vehicleId) : ?>
            <?= $staff->person->firstname; ?> -
          <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?>
    </p>


    <?php if ($params->reminders != null && count((array) $params->reminders) > 0) : ?>
      <p class="lead">Tous les rappels</p>
      <?php include(VIEW.'render/home/_reminder.php');?>
    <?php endif;?>


    <hr />


    <?php if (isset($vehicle->fuels)) : ?>
      <?php if (!isset($vehicle->fuels->message)) : ?>
        <div class="text-center">
          <img src="<?= IMG . 'icons/fuel.png' ?>" class="iconVehicle" />
        </div>
        <?php
        $quantityFuel = 0;
        $conso = 0;
        $amountFuel = 0;
        $litresConso = 1;
        $i = 0;
        $iTotal = count((array) $vehicle->fuels) - 1;
        $kmStart = 0;
        $kmEnd = 0;
        $amountWash = 0;
        $amountAction = 0;

        foreach ($vehicle->fuels as $fuel) {

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

        };

        $conso = ($kmStart - $kmEnd) / $litresConso;
        ?>

        <div class="flexEvenly">
          <section style="width: 30%;">
            <h4>Litres ajoutés </h4>
            <?= $quantityFuel; ?>
          </section>
          <section style="width: 30%;">
            <h4>Consommation au 100 </h4>
            <?= $conso; ?> litres
          </section>

          <section style="width: 30%;">
            <h4>Prix total </h4>
            <?= $amountFuel; ?> euros
          </section>

        </div>


        <table class="margin-top-20 fuelTable">
          <thead>
            <tr>
              <th width="200">Quantité (litres)</th>
              <th width="200">Prix (euros)</th>
              <th width="150">Kilométrage (km)</th>
              <th width="150">Date</th>
              <th width="150">Ajouté par</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($vehicle->fuels as $fuel) : ?>
              <tr>
                <td><?= $fuel->quantity; ?></td>
                <td><?= $fuel->amount; ?></td>
                <td><?= $fuel->mileage; ?></td>
                <td><?= showDate($fuel->dateAction->date); ?></td>
                <td><?= $fuel->staff->person->firstname; ?> <?= $fuel->staff->person->lastname; ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php endif; ?>

      <?php if (!isset($vehicle->washings->message)) : ?>
        <div class="vehicleSeparator"></div>

        <div class="text-center">
          <img src="<?= IMG . 'icons/wash.png' ?>" class="iconVehicle" />
        </div>
        <?php
        $amountWash = 0;

        foreach ($vehicle->washings as $wash) :

          $amountWash += $wash->amount;
          $i++;

        endforeach;

        ?>

        <div class="flexEvenly">

          <section style="width: 30%;">
            <h4>Prix total </h4>
            <?= $amountWash; ?> euros
          </section>
        </div>
        <table class="margin-top-20 washTable">
          <thead>
            <tr>
              <th width="200">Description </th>
              <th width="200">Prix (euros)</th>
              <th width="150">Kilométrage (km)</th>
              <th width="150">Date </th>
              <th width="150">Ajouté par </th>
              <td width="15"></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($vehicle->washings as $wash) : ?>
              <tr id="wash-<?= $wash->id;?>">
                <td>
                  <?= $wash->description; ?>
                </td>
                <td><?= $wash->amount; ?></td>
                <td><?= $wash->mileage; ?></td>
                <td><?= date('d/m/Y', strtotime($wash->dateAction->date)); ?></td>
                <td><?= $wash->staff->person->firstname; ?> <?= $wash->staff->person->lastname; ?></td>
                <td>
                  <i class="material-icons deleteElementButton" data-elementid="<?= $wash->id;?>" data-type="wash">delete</i> 
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php endif; ?>


      <?php if (!isset($vehicle->actions->message)) : ?>
        <div class="vehicleSeparator"></div>

        <div class="text-center">
          <img src="<?= IMG . 'icons/car-action.png' ?>" class="iconVehicle" />
        </div>
        <?php
        $amountAction = 0;

        foreach ($vehicle->actions as $action) :

          $amountAction += $action->amount;


        endforeach;

        ?>

        <div class="flexEvenly">

          <section style="width: 30%;">
            <h4>Prix total </h4>
            <?= $amountAction; ?> euros
          </section>

        </div>


        <table class="margin-top-20 actionTable">
          <thead>
            <tr>
              <th width="200">Action</th>
              <th width="200">Prix (euros)</th>
              <th width="150">Kilométrage (km)</th>
              <th width="150">Date </th>
              <th width="150">Ajouté par </th>
              <td width="15"></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($vehicle->actions as $action) : ?>
              <tr id="action-<?= $action->id;?>">
                <td>
                  <?= $action->actionType; ?> : <?= $action->actionName; ?>
                </td>
                <td><?= $action->amount; ?></td>
                <td><?= $action->mileage; ?></td>
                <td><?= date('d/m/Y', strtotime($action->dateAction->date)); ?></td>
                <td><?= $action->staff->person->firstname; ?> <?= $action->staff->person->lastname; ?></td>
                <td>
                  <i class="material-icons deleteElementButton" data-elementid="<?= $action->id;?>" data-type="action">delete</i> 
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php endif; ?>

      <?php if (1 == 0) : if (count((array) $vehicle->checkup->checkups)  > 0) : ?>
          <div class="vehicleSeparator"></div>

          <div class="text-center">
            <img src="<?= IMG . 'icons/check-vehicle.png' ?>" class="iconVehicle" />
          </div>
          <?php
          $amountAction = 0;

          foreach ($vehicle->checkup as $action) :

            $amountAction += $action->amount;
            $i++;

          endforeach;

          ?>

          <div class="flexEvenly">

            <section style="width: 30%;">
              <h4> Checkup du véhicule </h4>
            </section>

          </div>


          <table class="margin-top-20 checkupTable">
            <thead>
              <tr>
                <th width="200">Action</th>
                <th width="200">Prix (euros)</th>
                <th width="150">Kilométrage (km)</th>
                <th width="150">Date </th>
                <th width="150">Ajouté par</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($params->actionList as $action) : ?>
                <tr>
                  <td><?= $action->actionType; ?> : <?= $action->actionName; ?></td>
                  <td><?= $action->amount; ?></td>
                  <td><?= $action->mileage; ?></td>
                  <td><?= date('d/m/Y', strtotime($action->dateAction->date)); ?></td>
                  <td><?= $action->staff->person->firstname; ?> <?= $action->staff->person->lastname; ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
      <?php endif;
      endif; ?>
    <?php endif; ?>

  <?php endif; ?>
<?php endforeach; ?>