<?php $title = "Planification individuelle"; ?>
<?php use_helper('dates, translation, buttons');?>


<div style="max-width: 300px; margin:auto">
  <label>
    <select id="selectSeason" name="seasonId" required>
      <option disabled>Choisir une saison</option>
      <optgroup label = "Active">
        <?php foreach($params->seasons_actives as $activeSeason):?>
          <option
            value="<?php echo $activeSeason->seasonId; ?>" 
            <?php if(isset($params->season)) {
               if($params->season->seasonId == $activeSeason->seasonId) { echo ' selected ';}
            } else {
              echo ' selected ';
            };?>
          >
            <?php echo $activeSeason->name; ?>
          </option>
        <?php endforeach; ?>
      </optgroup>

      <optgroup label = "En préparation">
        <?php foreach($params->seasons_drafts as $draftSeason):?>
          <option 
            value="<?php echo $draftSeason->seasonId; ?>" 
            <?php if(isset($params->season)) {
              if($params->season->seasonId == $draftSeason->seasonId) { echo ' selected ';};
            }?>
          >
            <?php echo $draftSeason->name; ?>
          </option>
        <?php endforeach; ?>
      </optgroup>
    </select>
  </label>
</div>

<div style="max-width: 300px; margin:auto">
  <label>
    <select id="selectMember" name="person" required>
      <option selected disabled>Choisir un membre du personnel</option>
      <?php foreach($params->staff as $staff):?>
        <option value="<?php echo $staff->staffId; ?>"><?php echo $staff->person->firstname; ?> <?php echo $staff->person->lastname; ?></option>
      <?php endforeach; ?>
    </select>
  </label>
</div>


<?php if(isset($params->currentStaff)):?>
  <?php showFloatingActionButton($params->buttons); ?>


    <h2 class="center"><?= $params->currentStaff->fullname;?></h2>
    <h4 class="center" style="font-weight: normal">Planification - <?= $params->season->name ;?></h4>


    <ul class="tabs margin-top-20" data-tabs id="child-tabs">
        <li class="tabs-title is-active"><a href="#panel1" aria-selected="true" class="tab-href">Planning</a></li>
        <li class="tabs-title"><a href="#panel2"  class="tab-href">Statistiques</a></li>
        <li class="tabs-title"><a href="#panel3"  class="tab-href">Tâches</a></li>

    </ul>

    <div class="tabs-content" data-tabs-content="child-tabs">

        <div class="tabs-panel is-active" id="panel1">
            <?php include('_planning.php');?>
        </div>

        <div class="tabs-panel" id="panel2">
            <?php include('_statistiques.php');?>
        </div>

        <div class="tabs-panel" id="panel3">
          <div>
              <section class="title bg-silver black">Tâches à faire</section>
              <section class="block-list expandable" id="todoTask">
                <?php $tasks = $params->tasks_todo; ?>
                <?php include VIEW.'render/task/_day.php'; ?>
                <?php unset($tasks); ?>
              </section>
          </div>

          <div>
              <section class="title bg-silver black">Tâches faites</section>
              <section class="block-list expandable"  id="doneTask">
                <?php $tasks = $params->tasks_done; ?>
                <?php include VIEW.'render/task/_day.php'; ?>
                <?php unset($tasks); ?>
              </section>
          </div>
        </div>
      

    </div>


<?php endif;?>