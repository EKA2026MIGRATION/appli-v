<?php
$lastStatus = 'first';
$title = 'Transport';
use_helper('photo');
?>

<style>
  #checkReportTransport {
    background-color: lightcyan;
    position: fixed;
    height: 100%;
    width: 100%;
    margin: 0 auto;
    z-index: 9999;
    border-radius: 10px;
    box-sizing: border-box;
    padding-top: 20px;
    display: none;
    top: -10px;
    left: -5px;
    overflow: auto;
  }

  #checkReportTransport #contentReportTransport {
    padding: 20px;
  }

  #checkReportTransport h3,
  #checkReportTransport #validReportTransport,
  #checkReportTransport #nextReportTransport {
    background-color: black;
    color: white;
    width: 100%;
    padding: 6px;
    font-variant: small-caps slashed-zero;
    font-size: 2rem;
    text-align: center;
    font-weight: normal;
    margin-top: 30px;
    font-family: Arial;
  }

  #checkReportTransport #validReportTransport,
  #checkReportTransport #nextReportTransport {
    cursor: pointer;
  }

  #checkReportTransport #validReportTransport:hover,
  ,
  #checkReportTransport #nextReportTransport:hover {
    background-color: darkblue;
  }

  #checkReportTransport ul {
    list-style-type: none;
    margin: 0px;
    padding: 0px;
  }

  #checkReportTransport ul li {
    margin: 0px auto;
    padding: 0px;
    font-weight: normal;
    width: 80%;
    text-align: center;
    font-size: 24px;
    margin-bottom: 50px;
  }

  #checkReportTransport .divMood {
    display: flex;
    justify-content: space-evenly;
    font-weight: normal;
  }

  #checkReportTransport .divMood i {
    font-size: 60px;
    cursor: pointer;
  }

  #checkReportTransport .neutral {
    color: grey;
  }

  #checkReportTransport .noanswer {
    color: orange;
  }

  #checkReportTransport .good {
    color: green;
  }

  #checkReportTransport .bad {
    color: darkred;
  }


  #checkReportTransport #uberQuestions,
  #nextReportTransport {
    display: none;
  }

  .startStopRow {
    padding-top: 10px;
    display: flex;
    justify-content: space-around;
  }

  .startStopRow div {
    width: 50px;
    height: 50px;
    border: 1px solid black;
    line-height: 4;
    text-align: center;
    border-radius: 50px;
    margin-right: 20px;
    box-shadow: 2px 2px 2px darkred;
    cursor: pointer;
  }

   .startStopRow .screenLed {
    min-width: 250px;
    border-radius: 10px;
    width: auto;
    font-size: 16px;
    line-height: 48px;
    font-variant: small-caps;
    background-color: linen;
    cursor: normal;
  }

  .startStopRow .check {
    background-color: lightgreen;
  }
</style>

<script>
  let rides = new Object();
  let nbChilds = new Object();
  let nbStops = new Object();
  let lastPickUp = new Object();
</script>

<?php $grpDin = $params->group['dropin']; ?>
<?php $grpDoff = $params->group['dropoff']; ?>

<?php showFloatingActionButton($params->buttons); ?>

<?php if (count((array) $params->rides) > 0) : ?>
  <?php $showCheckTransport = true; ?>
  <div id="checkReportTransport">
    <?php include '_checkReportTransport.php'; ?>
  </div>
<?php endif; ?>

<div class="flexForBarreScroll">

  <section class="ridePage">

    <?php showDatePickerNavigation('transport/ride/date', $params->date, $params->active_driver->staffId); ?>

    <?php if (hasRole(['ADMIN', 'MANAGER'])) : ?>
      <div class="displayNoneImpression selectDriverContainer">
        Changer de chauffeur
        <select id="selectDriver" name="person" required>
          <option value="0">Choisir un chauffeur</option>
          <?php foreach ($params->drivers as $driver) : ?>
            <option value="<?php echo $driver->staff->staffId; ?>"><?php if (isset($driver->staff->staffId)) : ?> <?php echo $driver->staff->person->firstname;
                                                                                                                else : echo 'PAS DE DRIVER';
                                                                                                                endif; ?></option>
          <?php endforeach; ?>
        </select>

      </div>
    <?php endif; ?>



    <div id="ride">

      <h2 class="text-center">
        <?= $params->active_driver->person->firstname; ?>
      </h2>




      <?php foreach ($params->rides as $ride) : ?>

        <?php (strpos(strtoupper($ride->vehicle->name), "UBER") !== false) ?  $isUber = 1 : $isUber = 0; ?>

        <?php (isset($ride->staff->person->phones->phone)) ? $staffTel = $ride->staff->person->phones->phone : $staffTel = null; ?>

        <section data-id-ride="<?= $ride->rideId; ?>" class="block-list dragDrop <?= $ride->kind; ?> rideDriver">
          <header>
            <?php echo $ride->name; ?>
            <div class="nbStop">
              <span id="headerRide<?= $ride->rideId; ?>NbStop"></span> stop(s) -
              <span id="headerRide<?= $ride->rideId; ?>NbChild"></span> enfant(s)
            </div>
          </header>


          <?php if($isUber):?>
            <div>
                <div class="startStopRow">
                  <div>
                      <i id="startTransportChrono-<?= $ride->rideId; ?>" class="material-icons startTransportChrono">play_arrow</i>
                  </div>
                  <div>
                      <i  id="stopTransportChrono-<?= $ride->rideId; ?>" id="no" class="material-icons stopTransportChrono">stop</i>
                  </div>

                  <div class="screenLed" data-status = "ready" data-rideid = "<?= $ride->rideId; ?>" id="screenChrono-<?= $ride->rideId; ?>">
                    Démarrer le transport
                  </div>
                </div>
            </div>
          <?php endif;?>



          <ul>
            <li style="height: auto; padding-left: 0; padding-top: 10px; padding-bottom: 10px;">
              <div>
                <p class="list-header" style="text-align: left; padding-left:0; margin-left: 0;">
                  <strong> Départ </strong> : <?php echo date('H:i', strtotime($ride->start)); ?> - <?php echo $ride->startPoint; ?> <br /> <strong> Arrivée </strong> : <?php echo date('H:i', strtotime($ride->arrival)); ?> - <?php echo $ride->endPoint; ?> <br />
                <div class="cadreMaps">
                  <!--<button class="button displayNoneImpression"> Google Maps </button> <button class="button displayNoneImpression"> Waze </button>-->
                </div>
                </p>
              </div>
            </li>

            <?php $nbStop = 0;
            $nbChild = 0;
            $currentAdd = ''; ?>

            <?php foreach ($ride->pickups as $pickup) : ?>

              <?php if ($pickup->status != 'npec') : ?>
                <?php ++$nbChild;
                if ($currentAdd != $pickup->address) {
                  ++$nbStop;
                } ?>
                <?php $currentAdd = $pickup->address; ?>
                <?php $pickupPresents[$pickup->kind][$pickup->child->childId] = $ride->name; ?>
              <?php endif; ?>

              <?php ($pickup->kind == 'dropin') ? $kindText = 'Prise en charge' : $kindText = 'Dépose'; ?>

              <?php include '_revealChildView.php'; ?>

              <?php ($pickup->status == 'npec') ? $backcolor = 'background-color: lightpink' : $backcolor = ''; ?>

              <li id="pickupChildList<?php echo $pickup->pickupId; ?>" data-id-pickup="<?php echo $pickup->pickupId; ?>" class="<?php echo ($pickup->status != null) ? $pickup->status : 'nopec'; ?>" data-address="<?php echo $pickup->address; ?>" style="<?php echo $backcolor; ?>">

                <a href="#" style="padding-top: 0px; padding-bottom: 0px" onclick="openDialog('<?= $pickup->pickupId; ?>');updateLastPickup('<?= $pickup->pickupId; ?>');">
                  <div>
                    <p class="list-header childRide">
                      <span class="numberOrder ride-<?= $ride->rideId; ?> <?php echo showNewCustomerColor($pickup->child->createdAt); ?>" id="pickupOrder-<?php echo $pickup->pickupId; ?>"> <?= $nbStop; ?></span>

                      <img src="<?php echo showPhoto('profil', $pickup->child->photo); ?>" class="width-20 height-20" data-id-child="<?php echo $pickup->child->childId; ?>" alt="">
                      <span style="font-size: 16px">
                        <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?>
                        - <?= showAge($pickup->child->birthdate); ?> <?= showGender($pickup->child->gender);?>
                        <?php if (strlen($pickup->child->medical) > 0) : ?>
                          <i class="material-icons" style="color: darkblue" title="<?php echo $pickup->child->medical; ?>">local_hospital</i>
                        <?php endif; ?>
                        <?php if ($pickup->lastDayOfWeek ==  date('Y-m-d', strtotime($pickup->start))) : ?>
                          <span class="material-icons" style="font-size:18px">contactless</span>
                        <?php endif; ?>
                        <br />
                        <span style="font-size: 12px; font-style: italic">
                          <?= date('H:i', strtotime($pickup->start)); ?>
                        </span>
                        <?php if ($pickup->paymentDue != '') : ?>
                          <?php $backPayementColor = 'lightsalmon'; ?>
                          <?php if ($pickup->paymentDone == '') {
                            $backPayementColor = 'lightpink';
                          } ?>
                          <?php if ($pickup->paymentDone == $pickup->paymentDue) {
                            $backPayementColor = 'lightblue';
                          } ?>

                          <span style="font-size: 12px; padding: 6px; border-radius: 6px; font-style: italic; color: darkblue; background-color: <?= $backPayementColor; ?>">
                            <?php if ($pickup->paymentDone != '') : ?>
                              <span class="paymentDone"><?= $pickup->paymentDone; ?></span>
                            <?php else : ?>
                              <span class="paymentDone">0</span>
                            <?php endif; ?>
                            /
                            <?= $pickup->paymentDue; ?>
                            <i class="material-icons" style="font-size: 12px">euro</i>
                          </span>
                        <?php endif; ?>
                      </span>

                      <?php if (isset($pickup->category)) {
                        echo showIcon($pickup->category);
                      } ?>
                      <?php if (isset($pickup->registrationData)) : ?>
                        <?php if ($pickup->registrationData->hasLunch && $pickup->kind == 'dropin' && date('Hi', strtotime($pickup->start)) < '1245') : ?>
                          <?php $mealChild = 'meal-child' . $pickup->child->childId; ?>
                          <?php (isset($params->$mealChild)) ? $colorLunch = 'green' : $colorLunch = 'darkred'; ?>
                          <i class="material-icons" id="lunchIconRide<?= $pickup->pickupId; ?>" style="color: <?= $colorLunch; ?>">fastfood</i>
                        <?php endif; ?>
                      <?php else : ?>
                        <i style="font-size:10px">pas d'informations sur le repas et le produit</i>
                      <?php endif; ?>

                    <aside class="subtitles">

                      <i class="comment-child-transport"><?= $pickup->child->comment; ?></i>

                      <div class="displayNone displayShowImpression">
                        <div style="font-weight: bold;
    width: 80%;
    text-align: center;
    font-size: 20px;height:10px;"></div>
                        <strong><u>Parents</u></strong><br>
                        <?php foreach ($params->$child->persons as $person) : ?>
                          <div style="height:5px;"></div>
                          <strong style="color:red;"> <?php echo $person->firstname . ' ' . $person->lastname . ' | ' . $person->relation; ?><br /></strong>
                          <div style="height:5px;"></div>
                          <font style="color:blue;"><strong> Téléphones : </strong></font>

                          <?php foreach ($person->phones as $phone) : ?>
                            <br /> • <?= $phone->name; ?> (<?= $phone->phone; ?>)
                          <?php endforeach; ?>
                          <div style="height:5px;"></div>
                          <font style="color:blue;"><strong> Adresses : </strong></font>
                          <?php foreach ($person->addresses as $address) : ?>
                            <br /> • <?= $address->name; ?> (<?= $address->address; ?> <?= $address->address2; ?> <?= $address->postal; ?> <?= $address->town; ?>)
                          <?php endforeach; ?>
                        <?php endforeach; ?>
                      </div>
                    </aside>
                    <div class="with-icon">
                      <?php
                      showIconStatus($pickup->status, $lastStatus);
                      $lastStatus = $pickup->status;
                      ?>
                    </div>
                    </p>
                  </div>
                </a>
              </li>


            <?php endforeach; ?>

            <script>
              rides[<?= $ride->rideId; ?>] = <?= $ride->rideId; ?>;
              nbStops[<?= $ride->rideId; ?>] = <?= $nbStop; ?>;
              nbChilds[<?= $ride->rideId; ?>] = <?= $nbChild; ?>;
            </script>
          </ul>
        </section>




      <?php endforeach; ?>

      <?php if (isset($showCheckTransport)) : ?>
        <?php $lastRideId = $ride->rideId; ?>
        <input type="hidden" name="isUber" value="<?= $isUber; ?>" id="isUberInput" />
      <?php endif; ?>

    </div>

    <?php if (isset($smsList)) {
      include '_showSmsSendList.php';
    } ?>

  </section>

  <div class="barreScroll animateBackground"></div>
</div>

<?php if (isset($showCheckTransport)) : ?>
  <hr />
  <div class="button" id="reportTransport" data-lastrideid="<?= $lastRideId; ?>" style="width: 100%; background-color: lightskyblue; color: black;">VALIDER FIN DE TRANSPORT</div>
<?php endif; ?>

<hr />


<?php if (isset($pickupPresents)) : ?>
  <?php $showride = ''; ?>
  <?php foreach ($pickupPresents as $kind => $list) : ?>

    <?php if ($kind == 'dropin') {
      echo "<h5>1er groupe d'arrivée</h5>";
      $childsStdObj = $grpDin;
    } ?>
    <?php if ($kind == 'dropoff') {
      echo '<h5>Groupe de départ</h5>';
      $childsStdObj = $grpDoff;
    } ?>

    <?php $childsArr = json_decode(json_encode($childsStdObj), true); ?>

    <?php foreach ($list as $childId => $rideName) : ?>
      <?php if (key_exists($childId, $childsArr)) : ?>
        <div style="background-color: lightblue; padding: 8px; margin: 0px; list-style: none;">
          <?php if ($rideName != $showride) {
            echo '<br/><h6 style="color: darkblue; font-weight: bold">' . $rideName . '</h6>';
          } ?>
          <div>
            <?= $childsArr[$childId]['child_name']; ?>&nbsp;>&nbsp;<b><?= $childsArr[$childId]['staff_name']; ?></b>
            &nbsp;<i>(<?= $childsArr[$childId]['sport'] . ' ' . $childsArr[$childId]['time_start']; ?>)</i>
          </div>
          <?php $showride = $rideName; ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endforeach; ?>
<?php endif; ?>

<br />


<?php $update = 0;
if (isset($params->meal->mealId)) :  $update = 1;
endif; ?>




<?php if ($params->active_driver->staffId != null) : ?>
  <h2 class="text-center" style="margin-top: 10px; margin-bottom: 10px;">
    Ajouter un repas (staff)
  </h2>

  <strong class="alertCustom redAlert repasPrempli" <?php if (isset($params->active_driver->latestMeal->mealId) and $update == 0) : ?> style="display:block;" <?php endif; ?>> Pré-remplissage avec le dernier repas.</strong>
  <strong class="alertCustom redAlert repasNok" <?php if (!isset($params->active_driver->latestMeal->mealId) and $update == 0) : ?> style="display:block;" <?php endif; ?>>Aucun repas a été ajouté.</strong>


  <form method="post" id="mealFormStaff" action="meal/<?= (1 === $update) ? 'modify/' . $params->meal->mealId : 'create'; ?>">
    <div class="grid-container">
      <div class="grid-x grid-padding-x food_associated_staff">

        <input type="hidden" id="personId" name="person" value="<?= $params->active_driver->person->personId; ?>">


        <div class="medium-6 cell">
          <label>
            <input type="hidden" id="datepicker" placeholder="Choisir une date" value="<?= (1 === $update) ? date('d/m/Y', strtotime($params->meal->date)) : date('d/m/Y', strtotime($params->date)); ?>" required">
          </label>
          <input type="hidden" id="date" name="date" value="<?= (1 === $update) ? $params->meal->date : $params->date; ?>">
        </div>



        <div class="medium-6 medium-offset-3 cell">
          <?php foreach ($params->foodCategories as $categorie => $value) : ?>
            <fieldset class="fieldset">
              <legend><?= $value; ?> </legend>
              <div class="radioImg">
                <?php foreach ($params->foods as $food) :
                  if ($categorie === $food->kind && 'active' === $food->status) : ?>
                    <label>
                      <input <?php if (1 === $update) :
                                foreach ($params->meal->foods as $foodAsso) :
                                  if ($foodAsso->foodId === $food->foodId) :
                                    echo "class='asso-food'";
                                    echo "checked=''";
                                  else :
                                    echo '';
                                  endif;
                                endforeach;
                              else :
                                if (isset($params->active_driver->latestMeal->mealId)) :

                                  foreach ($params->active_driver->latestMeal->allfoods as $foodAsso) :
                                    if ($foodAsso->foodId === $food->foodId) :
                                      echo "class='asso-food'";
                                      echo "checked=''";
                                    else :
                                      echo '';
                                    endif;
                                  endforeach;

                                endif;

                              endif ?> type="checkbox" value="<?= $food->foodId; ?>" onclick="addClass(this)"> <!-- TODO enlever le onClick -->
                      <img src=<?= ($food->photo != '') ? HOST . $food->photo : IMG . 'no_photo.jpg'; ?>>
                    </label>
                <?php endif;
                endforeach; ?>
              </div>
            </fieldset>
          <?php endforeach; ?>
        </div>
        <div class="medium-12 cell">
          <center><input type="submit" class="button large" value="Envoyer" /></center>
        </div>
      </div>
    </div>
  </form>
  <p>* champ obligatoire</p>
  <br /><br /><br /><br />
<?php endif; ?>

<?php if ($params->needCheckup) : ?>
  <?php include('_needCheckup.php'); ?>
<?php else : ?>
  <input type="hidden" id="needCheckup" value="0">
    <div id="checkVehicleForm"></div>
<?php endif; ?>

<input type="hidden" id="lastPickup">