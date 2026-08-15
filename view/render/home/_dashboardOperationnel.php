<?php use_helper('dates'); ?>
<?php use_helper('team'); ?>
<?php $listCoachs = [];?>

<?php if ( hasCredential('menu::admin') || hasCredential('menu::manager') ) : ?>
  <div class="callout alert-callout-subtle" style="background-color: lightblue">
      <strong>Information de capacité</strong> <span class="msg"></span>
      <ul>
          <li>Encadrement : <span id="capacityCoachInformation"></span></li>
          <li>Transport : <span id="capacityDriverInformation"></span></li>
      </ul>
  </div>
<?php endif;?>

<div class="masonry-css">
        <div class="masonry-css-item" style="width: 95%">
          <section class="title bg-silver black">
            Staff : <span id="nbStaffPresent"></span> - 
            Capacité : <span id="capacityChildStaffed"></span>
          </section>
          <section class="block-list expandable">
            <ul>
                  <?php $nbStaffPresent = 0; $listDrivers = []; $capacityChildStaffed = 0; $capacityDrived = 0; ?>
                  <?php foreach ($params->staff_presence as $key => $presence):?>
                      <?php if ($presence->typeName != 'ABSENCE' && $presence->typeName != 'VACATION' ):?>
                          <?php ++$nbStaffPresent; ?>
                          <?php $capacityChildStaffed += $presence->staff->maxChildren; ?>
                      <?php endif; ?>

                      <?php ob_start(); ?>

                          <li class="type<?= $presence->typeName; ?>">
                          <?php if(hasCredential('dashboard::linkOperationnel')):?>
                              <a href="<?= HOST; ?>staff/planning/id/<?= $presence->staff->staffId; ?>/target/<?= $params->date;?>/" >
                          <?php endif;?>
                              <div>
                                <p class="list-header">
                                  <img src="<?php echo ($presence->staff->person->photo != '') ? HOST.$presence->staff->person->photo : IMG.'no_photo.jpg'; ?>" class="width-30 height-30" />
                                  <?php echo $presence->staff->person->firstname; ?>
                                    <span style="font-style: italic; font-size: 13px"><?php echo $presence->staff->person->lastname; ?></span>
                                    <br/>
                                    <span style="border-radius: github10px; font-size: 14px; background-color: <?= showColorMoment(showMoment($presence->start, $presence->end));?>">
                                      &nbsp;&nbsp;&nbsp;
                                      <?php echo $presence->location;?> -
                                      <span style="font-size: 12px">
                                        <?php echo showTime($presence->start).' '.showTime($presence->end);?>
                                      </span>
                                      &nbsp;&nbsp;&nbsp;
                                  </span>


                                  <span id="driver<?= $key; ?>"></span>
                                  <div class="with-icon">
                                    <i class="material-icons">send</i>
                                  </div>
                                </p>
                              </div>

                          <?php if(hasCredential('dashboard::linkOperationnel')):?>
                            </a>
                          <?php endif;?>  
                          
                          </li>
                      <?php $line = ob_get_clean(); ?>

                      <?= $line; ?>

                      <?php if (inTeam($presence->teamsIdList, 'coach') && $presence->typeName != 'ABSENCE' && $presence->typeName != 'VACATION'   ):?>
                          <?php $listCoachs[] = $line; ?>
                      <?php endif; ?>

                      <?php foreach (['maintenance', 'secrétariat', 'TIC'] as $teamName):?>
                        <?php if (inTeam($presence->teamsIdList, $teamName) && $presence->typeName != 'ABSENCE' && $presence->typeName != 'VACATION' ):?>
                            <?php $listPresences[$teamName][] = $line; ?>
                        <?php endif; ?>
                      <?php endforeach; ?>

                      <?php if (inTeam($presence->teamsIdList, 'driver') && $presence->typeName != 'ABSENCE' && $presence->typeName != 'VACATION' ):?>

                  
                          <?php if (isset($presence->staff->vehicle)):?>

                              <?php $vehicle = $presence->staff->vehicle; ?>
                              <?php $addLine = '<div style="background-color: black; font-size: 12px; color: white">'.$vehicle->name.' ('.$vehicle->places.')</div>'; ?>
                              <?php $line .= $addLine; ?>
                              <?php  $capacityDrived += $vehicle->places; ?>
                          <?php endif; ?>
                          <?php $listDrivers[] = $line; ?>
           
                      <?php endif; ?>
                      
                    <?php endforeach; ?>
                  <input type="hidden" name="nbStaffPresentInput" id="nbStaffPresentInput" value="<?= $nbStaffPresent; ?>"/>
                  <input type="hidden" name="capacityChildStaffedInput" id="capacityChildStaffedInput" value="<?= $capacityChildStaffed; ?>"/>
                  <input type="hidden" name="capacityDrived" id="capacityDrivedInput" value="<?= $capacityDrived; ?>"/>

            </ul>
          </section>

          <?php //$capacityDrived; ?>
        </div>

        <div class="masonry-css-item" style="width: 95%">
          <section class="title bg-silver black">
            Coach : <span id="nbCoachPresent"></span>
          </section>
          <section class="block-list expandable">
            <ul>
                  <?php $nbCoachPresent = 0; ?>
                  <?php foreach ($listCoachs as $lineCoach):?>
                      <?php ++$nbCoachPresent; ?>
                      <?= $lineCoach; ?>
                  <?php endforeach; ?>
                  <input type="hidden" name="nbCoachPresentInput" id="nbCoachPresentInput" value="<?= $nbCoachPresent; ?>"/>
            </ul>
          </section>
        </div>

        <div class="masonry-css-item" style="width: 95%">
          <section class="title bg-silver black">
            Driver : <span id="nbDriverPresent"></span> -
            Capacité : <span id="capacityDrived"></span>
          </section>
          <section class="block-list expandable">
            <ul>
                  <?php $nbDriverPresent = 0; ?>
                  <?php foreach ($listDrivers as $lineDriver):?>
                      <?php ++$nbDriverPresent; ?>
                      <?= $lineDriver; ?>
                  <?php endforeach; ?>
                  <input type="hidden" name="nbDriverPresentInput" id="nbDriverPresentInput" value="<?= $nbDriverPresent; ?>"/>
            </ul>
          </section>
        </div>

        <?php if(isset($listPresences)):?>
            <?php foreach ($listPresences as $teamName => $linesPresences):?>
              <div class="masonry-css-item" style="width: 95%">
                <section class="title bg-silver black">
                  <?= $teamName; ?>
                </section>
                <section class="block-list expandable">
                  <ul>
                        <?php foreach ($linesPresences as $linesPresence):?>
                            <?= $linesPresence; ?>
                        <?php endforeach; ?>
                  </ul>
                </section>
              </div>
            <?php endforeach; ?>
        <?php endif;?>

        <div class="masonry-css-item" style="width: 95%">
          <section class="title bg-silver black">
              Enfants : <span id="nbChildPresent"></span>
              <div id="injectSelect"></div>
              <br/>
          </section>
          <section class="block-list expandable" style="margin-top: 30px">
            <ul>
                <?php $nbChildPresent = 0; $allLocations = []; foreach ($params->child_presence as $presence):?>

                  <?php if(isset($presence->childId)):?>
                        <?php ++$nbChildPresent; ?>
                        <?php $moment = showMoment($presence->start, $presence->end);?>
                        <?php $location = $presence->location; $allLocations[$presence->locationId] = $location?>
                        <?php ob_start();?>
                          <li style="background-color: <?= showColorMoment(showMomentShort($moment)) ;?>" class="location-<?= $presence->locationId;?>">
                            <a href="<?= HOST; ?>child/display/id/<?= $presence->childId; ?>/" >
                              <div>
                                <p class="list-header">
                                  
                                  <img src="<?php echo ($presence->urlPhoto != '') ? HOST.$presence->urlPhoto : IMG.'no_photo.jpg'; ?>" class="width-30 height-30" />

                                  <?php echo $presence->lastname; ?> <?php echo $presence->firstname; ?>

                                  <?php if( itIsBirthdate($presence->birthdate, $params->date)):?>
                                    <img src="<?= IMG;?>icons/birthday-cake.svg" width="27px" style="position: relative"/>
                                      [<?= showDate($presence->birthdate, 'd/m') ;?>]
                                  <?php endif;?>

                                    <?php $diff = newDiffDate($presence->dateLatestMedia, date('Y-m-d')) ;?>

                                    <?php
                                     if($presence->dateLatestMedia == "") {
                                         echo '<i class="material-icons" style="color: darkred">camera</i>';
                                     } elseif( $diff > 30) {
                                         echo '<i class="material-icons" style="color: orangered">camera</i>';
                                     } else {
                                         echo '<i style="font-size:11px; color: darkblue">'.showDate($presence->dateLatestMedia, 'd/m').'</i>';
                                     };
                                     ?>

                                  <br/>
                                  <span style="font-style:italic; font-size: 13px; color: darkblue">
                                  <?php echo $moment?>
                                  <?php echo " - ".showTime($presence->start).' '.showTime($presence->end);?>
                                  </span>
                                  <br/>
                                    <span style="font-size: 12px; color: black"><?= $location;?></span>
                                  <div class="with-icon">
                                    <i class="material-icons">send</i>
                                  </div>
                                </p>
                              </div>
                            </a>
                          </li>
                        <?php $showChildPresence[$moment][] = ob_get_clean();?>
                  <?php else :?>
                      <span style="font-style:italic; color: gray">
                        Presence <?php if(isset($presence->childPresenceId)) echo $presence->childPresenceId;?> : child not found
                        <?php if(isset($presence->registration->registrationId)) echo ' - registration :'.$presence->registration->registrationId ;?>
                      </span>
                  <?php endif;?>
                <?php endforeach; ?>
                <input type="hidden" id="nbChildPresentInput" value="<?= $nbChildPresent; ?>"/>

                <?php if(isset($showChildPresence)):?>
                      <?php foreach($showChildPresence as $moment => $elements):?>
                            <br/>
                            <h6 style="text-align: center"><?= $moment;?></h6>
                            <?php foreach($elements as $liChildPresence):?>
                                <?= $liChildPresence;?>
                            <?php endforeach;?>
                      <?php endforeach;?>
                <?php endif;?>

            </ul>
          </section>
        </div>
</div>

<div class="masonry-css">
        <div class="masonry-css-item">
          <?php $hideSupervision = 1;?>
          <section class="title bg-silver black">Taches du jour</section>
          <section class="block-list expandable">
            <?php $tasks = $params->tasks_aday; ?>
            <?php include VIEW.'render/task/_day.php'; ?>
            <?php unset($tasks); ?>
          </section>
        </div>

        <div class="masonry-css-item">
            <section class="title bg-silver black">Tâches faites</section>
            <section class="block-list expandable">
              <?php $tasks = $params->tasks_done; ?>
              <?php include VIEW.'render/task/_day.php'; ?>
              <?php unset($tasks); ?>
            </section>
        </div>

        <?php if(isset($supervisions)):?>
            <div class="masonry-css-item">
                <section class="title bg-silver black">Supervisions</section>
                <section class="block-list expandable">
                    <div class="taskBlockDay"><ul class="taskUL">
                      <?php foreach($supervisions as $supervision):?>
                          <?= $supervision;?>
                      <?php endforeach;?>
                    </ul></div>
                </section>
            </div>
        <?php endif;?>
</div>


<script>
    let injectSelect = document.getElementById('injectSelect');
    let allLocations = <?= json_encode($allLocations); ?>;
    // Création de l'élément select
    let select = document.createElement('select');
    select.id = 'locationFilter';

    // Ajout d'une option vide pour "tous"
    let defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'Tous';
    select.appendChild(defaultOption);

    // Remplir le select avec les options du tableau allLocations
    Object.keys(allLocations).forEach(function(key) {
        var option = document.createElement('option');
        option.value = key;
        option.textContent = allLocations[key];
        select.appendChild(option);
    });

    // Ajouter le select à un élément du DOM, par exemple le body
    injectSelect.appendChild(select);

    select.addEventListener('change', function() {
        var selectedLocation = this.value;

        // Récupérer tous les éléments li
        var listItems = document.querySelectorAll('li');

        // Boucler sur chaque li et les afficher/masquer selon le filtre
        listItems.forEach(function(li) {
            if (selectedLocation === '' || li.classList.contains('location-' + selectedLocation)) {
                li.style.display = ''; // Afficher
            } else {
                li.style.display = 'none'; // Masquer
            }
        });
    });



</script>
