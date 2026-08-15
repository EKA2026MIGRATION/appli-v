<tr class="table-expand-row-content not-search">
          <td colspan="8" class="table-expand-row-nested">

            <?php if(isset($vehicle->fuels)): ?>
              <?php if(!isset($vehicle->fuels->message)): ?>
                <div class="text-center">
                  <img src="<?= IMG.'icons/fuel.png' ?>" class="iconVehicle" />
                </div>
                <?php 
                  $quantityFuel = 0;
                  $conso = 0;
                  $amountFuel = 0;
                  $litresConso = 1;
                  $i = 0;
                  $iTotal = count((array) $vehicle->fuels)-1;
                  $kmStart = 0;
                  $kmEnd = 0;
                  $amountWash = 0;
                  $amountAction = 0;

                  foreach($vehicle->fuels as $fuel):

                    if($i == 0) {
                      $kmStart = $fuel->mileage;
                    } else {
                      $litresConso += $fuel->quantity;
                    }

                    if($i == $iTotal) {
                      $kmEnd = $fuel->mileage; 
                    }

                    $quantityFuel += $fuel->quantity;
                    $amountFuel += $fuel->amount;
                    $i++;

                  endforeach; 

                  $conso = ($kmStart-$kmEnd)/$litresConso;
                  ?>

                  <div class="flexEvenly">
                    <section style="width: 30%;" >
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


                <table class="margin-top-20 fuelTable" >
                  <thead>
                    <tr>
                      <th width="200">Véhicule</th>
                      <th width="200">Quantité (litres)</th>
                      <th width="200">Prix (euros</th>
                      <th width="150">Kilométrage (km)</th>
                      <th width="150">Date</th>
                      <th width="150">Ajouté par</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php foreach($vehicle->fuels as $fuel):?>
                        <tr>
                          <td><?= $vehicle->vehicle->name; ?> (<?= $vehicle->vehicle->matriculation; ?>)</td>
                          <td><?= $fuel->quantity; ?></td>
                          <td><?= $fuel->amount; ?></td>
                          <td><?= $fuel->mileage; ?></td>
                          <td><?= date('d/m/Y', strtotime($fuel->dateAction->date)); ?></td>
                          <td><?= $fuel->staff->person->firstname; ?> <?= $fuel->staff->person->lastname; ?></td>
                        </tr>
                      <?php endforeach ?>
                  </tbody>
                </table>
              <?php endif; ?>

              <?php if(!isset($vehicle->washings->message)): ?>
                <div class="vehicleSeparator"></div>
                
                <div class="text-center">
                  <img src="<?= IMG.'icons/wash.png' ?>" class="iconVehicle" />
                </div>
                <?php  
                  $amountWash = 0;

                  foreach($vehicle->washings as $wash):

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
                      <th width="200">Véhicule</th>
                      <th width="200">Description </th>
                      <th width="200">Prix (euros)</th>
                      <th width="150">Kilométrage (km)</th>
                      <th width="150">Date </th>
                      <th width="150">Ajouté par </th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php foreach($vehicle->washings as $wash):?>
                        <tr>
                          <td><?= $vehicle->vehicle->name; ?> (<?= $vehicle->vehicle->matriculation; ?>)</td>
                          <td><?= $wash->description; ?></td>
                          <td><?= $wash->amount; ?></td>
                          <td><?= $wash->mileage; ?></td>
                          <td><?= date('d/m/Y', strtotime($wash->dateAction->date)); ?></td>
                          <td><?= $wash->staff->person->firstname; ?> <?= $wash->staff->person->lastname; ?></td>
                        </tr>
                      <?php endforeach ?>
                  </tbody>
                </table>
              <?php endif; ?>


              <?php if(!isset($vehicle->actions->message)): ?>
                <div class="vehicleSeparator"></div>
                
                <div class="text-center">
                  <img src="<?= IMG.'icons/car-action.png' ?>" class="iconVehicle" />
                </div>
                <?php  
                  $amountAction = 0;

                  foreach($vehicle->actions as $action):

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
                      <th width="200">Véhicule</th>
                      <th width="200">Action</th>
                      <th width="200">Prix (euros)</th>
                      <th width="150">Kilométrage (km)</th>
                      <th width="150">Date </th>
                      <th width="150">Ajouté par </th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php foreach($vehicle->actions as $action):?>
                        <tr>
                          <td><?= $vehicle->vehicle->name; ?> (<?= $vehicle->vehicle->matriculation; ?>)</td>                          
                          <td><?= $action->actionType; ?> : <?= $action->actionName; ?></td>
                          <td><?= $action->amount; ?></td>
                          <td><?= $action->mileage; ?></td>
                          <td><?= date('d/m/Y', strtotime($action->dateAction->date)); ?></td>
                          <td><?= $action->staff->person->firstname; ?> <?= $action->staff->person->lastname; ?></td>
                        </tr>
                      <?php endforeach ?>
                  </tbody>
                </table>
              <?php endif; ?>
         
              <?php if(1 == 0): if(count((array) $vehicle->checkup->checkups)  > 0): ?>
                <div class="vehicleSeparator"></div>
                
                <div class="text-center">
                  <img src="<?= IMG.'icons/check-vehicle.png' ?>" class="iconVehicle" />
                </div>
                <?php  
                  $amountAction = 0;

                  foreach($vehicle->checkup as $action):

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
                      <th width="200">Véhicule</th>
                      <th width="200">Action</th>
                      <th width="200">Prix (euros)</th>
                      <th width="150">Kilométrage (km)</th>
                      <th width="150">Date </th>
                      <th width="150">Ajouté par</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php foreach($params->actionList as $action):?>
                        <tr>
                          <td><?= $vehicle->name; ?> (<?= $vehicle->matriculation; ?>)</td>                          
                          <td><?= $action->actionType; ?> : <?= $action->actionName; ?></td>
                          <td><?= $action->amount; ?></td>
                          <td><?= $action->mileage; ?></td>
                          <td><?= date('d/m/Y', strtotime($action->dateAction->date)); ?></td>
                          <td><?= $action->staff->person->firstname; ?> <?= $action->staff->person->lastname; ?></td>
                        </tr>
                      <?php endforeach ?>
                  </tbody>
                </table>
              <?php endif; endif; ?>
            <?php endif; ?>
          </td>
        </tr>