
<style>
  .taskInfo { display: flex!important; justify-content: space-between!important;}
  .showDescription, .taskH5, .taskH6 { display: none!important;}


</style>


<br/><br/>
<h4 style="font-weight: bold">Tâches récurrentes</h4>
<hr/>

<div>
  <div>
    <h4>Matin</h4>
    <?php if(!ACTIVITY_AUTH_VALID):?>
      <div class="callout alert-callout-subtle alert">
        Vous devez être connecté au <strong>WIFI du Club</strong> pour pouvoir ajouter une activité
      </div>
      <?php else:?>
        <div style="display: flex;justify-content: space-between">

          <div style="width: 75%">
            <select id="selectTaskMorning">
              <?php foreach($params->tasks->morning as $id => $task):?>
                <option value="<?= $id;?>">
                  <?php echo $task;?>
                </option>
              <?php endforeach;?>
            </select>

          </div>

          <div style="width: 20%">
            <button id="selectTaskMorningButton" class="button primary">Valider</button>
          </div>
        </div>
      <?php endif;?>
    </div>
    <div>
      <h4>Après-midi</h4>

      <?php if(!ACTIVITY_AUTH_VALID):?>
        <div class="callout alert-callout-subtle alert">
          Vous devez être connecté au <strong>WIFI du Club</strong> pour pouvoir ajouter une activité
        </div>
        <?php else:?>
          <div style="display: flex;justify-content: space-between">
            <div style="width: 75%">
              <select id="selectTaskAfternoon">
                <?php foreach($params->tasks->afternoon as $id => $task):?>
                  <option value="<?= $id;?>">
                    <?php echo $task;?>
                  </option>
                <?php endforeach;?>
              </select>
            </div>

            <div style="width: 20%">
              <button id="selectTaskAfternoonButton" class="button primary">Valider</button>
            </div>
          </div>

        <?php endif;?>
      </div>
</div>


<br/><br/>
<h4 style="font-weight: bold" style="position: relative">
  <i class="material-icons" id="showAllTaskDayButton" style="float: left; font-size: 30px; color: darkblue; cursor: pointer">assignment_turned_in</i>
  Liste des tâches effectuées ce jour
</h4>

<div id="showAllTaskDay" style="display: none; position: absolute; border: 2px solid darkblue; width: 90%; z-index: 99; background-color: white; border-radius: 10px; padding: 10px">
  Hello
</div>
<hr/>
<div class="medium-12 cell" id="taskList">
  <?php include('_taskList.php');?>
</div>

<br/><br/>



<?php $hideSupervision = 1; $hideDone = 1; $myCallBack = "activity/display/date/".$params->date."/"?>
<h4>Taches à valider</h4>
<div>
    <?php $tasks = $params->tasks_aday; ?>
    <?php include VIEW.'render/task/_day.php'; ?>
    <?php unset($tasks); ?>
</div>




<br/><br/>
<h4 style="font-weight: bold">Ajouter une tâche faite ce jour</h4>
<hr/>
<div style="padding: 20px">
  <?php include(VIEW.'render/task/_addTaskForm.php');?>
</div>
<hr/>
