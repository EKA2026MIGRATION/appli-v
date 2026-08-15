<?php $title = 'Gestion des présences des enfants'; ?>
<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
	</div>

<div class="text-center">
  <h1>

    <a href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>child/presenceDay/date/<?php echo date('Y-m-d', strtotime('-1 day', strtotime($params->date))); ?>/')">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a> <?php echo date('d/m/Y', strtotime($params->date)); ?>

    <a href="javascript:void(0)" onclick="openDatePicker('Day')">
      <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>

    <a  href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>child/presenceDay/date/<?php echo date('Y-m-d', strtotime('+1 day', strtotime($params->date))); ?>/')">
      <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
    </a>

  </h1>

</div>


<div id="datePickerInline"></div>


<div class="grid-x grid-margin-x">
    <div class="cell medium-6 large-6 small-12" style="margin-top: 20px;">

        <div class="slider" style="margin-bottom: 0.5rem;" data-slider data-start="630" data-end="1830" data-step="5" data-initial-start="700" data-initial-end="1800">
            <span class="slider-handle" data-slider-handle role="slider" tabindex="1"></span>
            <span class="slider-fill" data-slider-fill></span>
            <span class="slider-handle" data-slider-handle role="slider" tabindex="1"></span>
            <input type="hidden"  id="hour1">
            <input type="hidden" id="hour2">
        </div>
        <center><strong> Filtre par heure : <span id="hourFilter">7h00 - 18h00</span> </strong></center>

    </div>
    <div class="cell medium-6 large-6 small-12" style="display: flex; margin-top: 20px; justify-content: center;" >
        <div>
            <select id="locationsFilters">
                <optgroup label="Lieux">
                    <?php foreach ($params->locations as $location):?>
                
                            <option value="<?php echo $location->locationId; ?>" data-selected><?php echo $location->name; ?></option>
               
                    <?php endforeach; ?>
                </optgroup>
            </select>
        </div>
        <button class="button" style="display: block" id="locationsFilterValidate"> OK </button>
        <input type="hidden" id="liveResult" />
    </div>
</div>

<div class="callout alert-callout-subtle" style="background-color: lightblue">
    <strong>Nombre d'enfants : </strong> <span id="nbChild"></span>  
</div>

<section class="block-list margin-top-20">
  <ul id="childPresenceList">
      <?php $nbChild = 0; foreach ($params->child_presence as $presence):?>

        <?php ++$nbChild; ?>
        <div class="reveal mobile-ios-modal" id="action-child<?= $presence->childPresenceId; ?>" data-reveal>

          <div class="mobile-ios-modal-options-stacked">
            <a href="<?= HOST; ?>child/display/id/<?php echo $presence->child->childId; ?>/"><button data-close class="button">Voir le profil</button></a>
            <a href="<?= HOST; ?>registration/display/id/<?php echo $presence->registration->registrationId; ?>/"><button data-close class="button">Voir l'inscription</button></a>
            <a href="<?= HOST; ?>childPresence/delete/id/<?php  echo $presence->childPresenceId ?>/"><button data-close class="button">Supprimer la présence</button></a>

            <button data-close class="button" style="color:red;">Fermer</button>
          </div>
        </div>
          <?php
            $hourStart = date('H:i', strtotime($presence->start));
            $hourEnd = date('H:i', strtotime($presence->end));
          ?>

          <li data-location="<?php echo $presence->location->locationId; ?>" data-start-hour="<?php echo str_replace(':', '', $hourStart); ?>" data-end-hour="<?php echo str_replace(':', '', $hourEnd); ?>">
            <a href="javascript:void(0)" data-open="action-child<?= $presence->childPresenceId; ?>" >
              <div>
                <p class="list-header">
                  <img src="<?php echo ($presence->child->photo != '') ? HOST.$presence->child->photo : IMG.'no_photo.jpg'; ?>" class="width-30 height-30" />
                  <?php echo $presence->child->lastname; ?>  <?php echo $presence->child->firstname; ?> - <?php echo $presence->location->name; ?> • (<?php echo $presence->start; ?> - <?php echo $presence->end; ?> )
                  <div class="with-icon">
                    <i class="material-icons">send</i>
                  </div>
                </p>
              </div>
            </a>
          </li>
      <?php endforeach; ?>
  </ul>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {

    let nbChild = "<?= $nbChild; ?>";
    $('#nbChild').html(nbChild);

});
</script>