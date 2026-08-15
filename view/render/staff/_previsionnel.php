<div style="max-width: 350px">
    <div id="showStaffPresenceForm">
        <i class="material-icons" style="color: darkred; float: right; cursor: pointer" id="closeStaffPresence">close</i>



        <h6>Modifier le statut</h6>

        <button class="typeABSENCE editButton" id="update-ABSENCE">ABSENCE</button>
        <button class="typeCATCHING editButton" id="update-CATCHING">RATTRAPAGE</button>
        <button class="typeBONUS editButton" id="update-BONUS">BONUS</button>
        <button class="editButton" id="update-PRESENCE">PRESENCE</button>


        <br/><br/>

        <button class="editButton" id="update-DELETE" style="background-color: darkred; color: white">SUPPRIMER</button>

        <input type="hidden" id="staffPresenceIdToUpdate" name="staffPresenceId"/>

    </div>

    <?php $weeks = $params->weeks; ?>

    <section class="title bg-silver black">Prévisionnel <?= $params->season->name; ?></section>
    <section class="block-list expandable">
      <ul>
          <?php $month = ''; $week = '';
                $total_PRESENCE = 0;
                $total_ABSENCE = 0;
                $total_CATCHING = 0;
                $total_BONUS = 0;
                $total_presences = 0;
                $presence_months = null;
                $totalTime = 0;
                $total_day = [];
                ?>
          <?php foreach ($params->presences->presences as $presence):?>

              <?php $typeName = $presence->typeName; ?>
              <?php if ($month != getMonth($presence->date)):?>
                <?php if ($presence_months != null):?>
                        <div class="presenceTotalRow">
                          Présence : <?= $presence_months; ?> J
                          <?php $presence_months = 0; ?>

                        </div>
                    </div> <!-- close div content --->
                <?php endif; ?>
                <div class="monthNameBar">
                  <?= $month = getMonth($presence->date); ?>
                  <?= getYear($presence->date); ?>
                </div>
                <?php ($month == getMonth(date('Y-m-d'))) ? $show = "style='display: block'" : $show = ''; ?>
                <div class="monthContent" <?= $show; ?>> <!-- ipen div content-->
              <?php endif; ?>
              <!--- break week row -->
              <?php $border = ''; ?>
              <?php if ($week != getWeek($presence->date)):?>
                <?php $border = 'border-top: 2px solid darkblue'; $week = getWeek($presence->date); ?>
              <?php endif; ?>
              <!--- background color of current day -->
              <?php $backcolor = ''; ?>
              <?php if ($presence->date == date('Y-m-d')):?>
                  <?php $backcolor = 'background-color: lightyellow'; ?>
              <?php endif; ?>
              <li class="dateRow type<?= $presence->typeName; ?>" style="<?=$border; ?>; <?=$backcolor; ?>; cursor: pointer" id="presence-<?= $presence->staffPresenceId; ?>">
                <?php if ($typeName == 'PRESENCE') {
                    ++$total_PRESENCE;
                } ?>
                <?php if ($typeName == 'ABSCENCE') {
                    ++$total_ABSENCE;
                } ?>
                <?php if ($typeName == 'CATCHING') {
                    ++$total_CATCHING;
                } ?>
                <?php if ($typeName == 'BONUS') {
                    ++$total_BONUS;
                } ?>

                <?php if ($typeName != 'ABSENCE') {
                    ++$presence_months;
                    ++$total_presences;
                    if (isset($total_day[showDate($presence->date, 'l')])) {
                        $total_day[showDate($presence->date, 'l')] = $total_day[showDate($presence->date, 'l')] + 1;
                    } else {
                        $total_day[showDate($presence->date, 'l')] = 1;
                    }
                }?>
                <div style="width: 40%">
                  <?= showDate($presence->date, 'd - l'); ?>
                </div>

                <div style="width: 30%;">
                  <?= showTime($presence->start).' - '.showTime($presence->end); ?>
                </div>

                <div style="width: 30%; text-align: right">
                  <?= $timeSpend = timeSpend($presence->start, $presence->end); ?>
                  <?php //$totalTime += convertInSecond($timeSpend);?>
                </div>
              </li>
          <?php endforeach; ?>
              <div style="font-style: italic; font-size: 12px; padding-left: 12px">
                Présence : <?= $presence_months; ?> J
              </div>
          </div> <!-- close div content --->
          <div style="background-color: lightblue; color: black; ; border: 2px solid darkblue; text-align: center; padding: 20px;">
            <ul>
                <li>TOTAL PRÉSENCES : <?= $total_presences; ?> Jours</li>
                <li>dont <?= trans('CATCHING'); ?> : <?= $total_CATCHING; ?> et  <?= trans('BONUS'); ?> : <?= $total_BONUS; ?></li>
                <?php foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $tt_day_name):?>
                    <?php if (isset($total_day[$tt_day_name])):?>
                      <li><?= $tt_day_name.' : '.$total_day[$tt_day_name]; ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <hr/>
                <li>Total  <?= trans('ABSENCE'); ?> : <?= $total_CATCHING; ?></li>


            </ul>
          </div>

      </ul>
    </section>
  </div>