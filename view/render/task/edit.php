<?php use_helper('date');?>
<?php $task = $params->task;?>
<?php $title = "Modification des tâches";?>
<?php (!isset($params->callBack)) ? $callBack = null : $callBack = str_replace('/', '-', $params->callBack)?>

<h1>Modifier une tâche</h1>

<form action="<?= HOST;?>task/updateTask" method="post">
  <input type="hidden" name="callBack" value="<?= $callBack;?>"/>
  <input type="hidden" name="taskStaffId" value="<?= $task->id;?>" />
  <input type="text" name="name" placeholder="Intitulé de la tâche" value="<?= $task->name;?>"/>
  <input type="text" name="type" placeholder="Type de la tâche" value="<?= $task->type;?>"/>
  <textarea placeholder="Description (optionnel)" name="description"><?= $task->description;?></textarea>

  <hr/>
  <h4>Equipe</h4>
  <div>
      <div style="width: 49%; float: left;">
          Affectation
          <select name="staffId">
            <option/>
            <?php foreach($params->staffs as $staff):?>
              <option value="<?= $staff->staffId;?>" <?php if($staff->staffId == $task->staff->staffId) echo 'selected="selected"';?> >
                  <?= $staff->person->firstname.' '.$staff->person->lastname;?>
              </option>
            <?php endforeach;?>
          </select>
      </div>
      <div style="width: 49%; float: left; margin-left: 2%">
          Superviseur
          <select name="supervisorId">
            <option/>
            <?php foreach($params->supervisor as $supervisor):?>
                <option value="<?= $supervisor->staffId;?>"  <?php if($task->supervisor) {if($task->supervisor->staffId == $supervisor->staffId) echo 'selected="selected"';}?>>
                    <?= $supervisor->person->firstname.' '.$supervisor->person->lastname;?>
                </option>
            <?php endforeach;?>
          </select>
      </div>
  </div>

  <hr/>
  <h4>Date de la tache</h4>
  <div>
      <div style="width: 49%; float: left;">
          <input type="text" id="dateTodo" placeholder="A faire pour le" value="<?= showDate($task->dateTask->date, 'd/m/Y');?>">
          <input type="hidden" id="datepicker" name="dateTodo" value="<?= showDate($task->dateTask->date, 'Y-m-d');?>">
      </div>

      <div style="width: 49%; float: left; margin-left: 2%">
        <div class="input-group">
          <span class="input-group-label">
             <i class="large material-icons">access_time</i>
          </span>
          <input type="time" name="timeTodo" value="<?= showDate($task->dateTask->date, 'H:i');?>" class="input-group-field"/>
        </div>
      </div>
  </div>

  <hr/>
  <h4>Durée de la tâche</h4>
  <div class="input-group">
          <label style="width: 30%; margin-right: 5%; float: left">
              Jour(s)
              <select name="durationDay">
                  <?php for($i = 0; $i < 20; $i++):?>
                      <option value="<?= sprintf("%02d", $i);?>"><?= sprintf("%02d", $i);?></option>
                  <?php endfor;?>
              </select>
          </label>

          <label style="width: 30%; margin-right: 5%; float: left">
              Heure(s)
              <select name="durationHour">
                <?php for($i = 0; $i < 10; $i++):?>
                    <?php ($i == 1) ? $selected = "selected" : $selected = "";?>
                    <option value="<?= sprintf("%02d", $i);?>" <?= $selected;?>>
                      <?= sprintf("%02d", $i);?>
                    </option>
                <?php endfor;?>
              </select>
          </label>

          <label style="width: 30%; float: left">
              Minute(s)
              <select name="durationMinute">
                <?php for($i = 0; $i < 60; $i++):?>
                    <option value="<?= sprintf("%02d", $i);?>"><?= sprintf("%02d", $i);?></option>
                <?php endfor;?>
               </select>
          </label>

  </div>

  <div>
    <div style="width: 49%; float: left;">
        Statut de la tâche
        <select name="step">
            <option value="TODO" <?php if($task->step == "TODO") echo 'selected="selected"';?>>TACHE A FAIRE</option>
            <option value="DONE" <?php if($task->step == "DONE") echo 'selected="selected"';?>>TACHE FAITE</option>
        </select>
    </div>
    <div style="width: 49%; float: left; margin-left: 2%">
        Date limite
        <input type="text" id="dateLimit" placeholder="Jour limite de réalisation" value="<?= showDate($task->dateLimit->date, 'd/m/Y');?>">
        <input type="hidden" id="datepicker2" name="dateLimit" value="<?= showDate($task->dateLimit->date, 'Y-m-d');?>">
    </div>
  </div>

  <input type="submit" value="MODIFIER" class="button large" style="text-align: center; margin: 0 auto"/>

</form>
