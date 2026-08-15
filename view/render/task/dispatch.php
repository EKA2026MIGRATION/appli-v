<?php use_helper('date');?>
<?php $title = "Dispatcher des tâches";?>

<div class="text-center">
  <h1>

    <a  href="<?= HOST; ?>task/dispatch/date_ref/<?= prevDay($params->date_ref);?>/">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a> <?= showDate($params->date_ref)?>

    <a href="javascript:void(0)" onclick="openDatePicker()">
      <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>

    <a  href="<?= HOST; ?>task/dispatch/date_ref/<?= nextDay($params->date_ref);?>/">
      <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
    </a>

  </h1>

</div>

<div style="position: relative">
    <div id="listStaff">
        <i class="material-icons" id="closeListStaff">clear</i>
        <br style="clear: both"/>
        <div>
            <div class="criticity" data-criticity="1" style="background-color: red; width: 20px; border-radius: 10px; height: 10px; width: 50px; float: left; cursor: pointer; margin-right: 10px">&nbsp;</div>
            <div class="criticity "data-criticity="2"  style="background-color: orange; width: 20px; border-radius: 10px; height: 10px; width: 50px; float: left; cursor: pointer; margin-right: 10px">&nbsp;</div>
            <div class="criticity" data-criticity="3" style="background-color: green; width: 20px; border-radius: 10px; height: 10px; width: 50px; float: left; cursor: pointer; margin-right: 10px">&nbsp;</div>

        </div>
        <br style="clear: both"/>

        <div id="listStaffTitle" style="font-weight: bold; padding: 4px;"></div>
        <ul id="showListStaff" style="display: none">
            <?php foreach($params->staffs as $presencestaff):?>
                <?php $staff = $presencestaff->staff;?>
                <li class="staffName" data-id="<?= $staff->staffId;?>">
                    <?= $staff->person->firstname.' '.$staff->person->lastname;?>
                </li>
            <?php endforeach;?>
        </ul>

    </div>

    <section class="block-list">

      <h3 style="text-align: center">Matinée</h3>
      <ul id="basicList_morning">
        <?php foreach($params->basicTasks->morning as $id => $task):?>
            <?php $task = trim($task);?>
            <?php if($task != "Arrivée"):?>
                <li>
                  <?php $color = ""; $staffName = ""; $colorStaff = "color: darkblue"?>

                  <!-- if task affected-->
                  <?php if(array_key_exists($task, $params->tasksAffected)):?>
                          <?php $staffName = implode(', ', $params->tasksAffected[$task]);?>
                          <?php $color = "color: darkblue";?>
                          <!-- if taskdone -->
                          <?php if(array_key_exists($task, $params->tasksDone)):?>
                              <?php $color = "color: darkgreen";?>
                              <?php $colorStaff = "color: darkgreen" ;?>
                          <?php else:?>
                              <?php $color = "color: darkblue";?>
                          <?php endif;?>
                  <?php endif;?>
                  <a style="<?= $color;?>">
                    <div>
                      <p class="list-header">

                        <span class="affectTaskButton" data-id="<?= $id;?>" data-name="<?= $task;?>" id="taskName-<?= $id;?>">
                          <?php echo $task;?>
                        </span>
                        &nbsp;&nbsp;
                        
                        <span id="staffNameTask-<?= $id;?>" style="<?= $colorStaff;?>"><?= $staffName;?></span>

                      </p>
                    </div>
                  </a>
                </li>
            <?php endif;?>
        <?php endforeach; ?>

      </ul>
    </section>

    <br/><br/>

    <section class="block-list">

<h3 style="text-align: center">Après-midi</h3>
<ul id="basicList_morning">
  <?php foreach($params->basicTasks->afternoon as $id => $task):?>
      <?php $task = trim($task);?>
      <?php if($task != "DEPART"):?>
          <li>
            <?php $color = ""; $staffName = ""; $colorStaff = "color: darkblue"?>

            <!-- if task affected-->
            <?php if(array_key_exists($task, $params->tasksAffected)):?>
                    <?php $staffName = implode(', ', $params->tasksAffected[$task]);?>
                    <?php $color = "color: darkblue";?>
                    <!-- if taskdone -->
                    <?php if(array_key_exists($task, $params->tasksDone)):?>
                        <?php $color = "color: darkgreen";?>
                        <?php $colorStaff = "color: darkgreen" ;?>
                    <?php else:?>
                        <?php $color = "color: darkblue";?>
                    <?php endif;?>
            <?php endif;?>
            <a style="<?= $color;?>">
              <div>
                <p class="list-header">

                  <span class="affectTaskButton" data-id="<?= $id;?>" data-name="<?= $task;?>" id="taskName-<?= $id;?>">
                    <?php echo $task;?>
                  </span>
                  &nbsp;&nbsp;
                  
                  <span id="staffNameTask-<?= $id;?>" style="<?= $colorStaff;?>"><?= $staffName;?></span>

                </p>
              </div>
            </a>
          </li>
      <?php endif;?>
  <?php endforeach; ?>

</ul>
</section>


   
</div>


<div id="taskStaffAjaxDiv"></div>
<input type="hidden" name="taskId" id="taskIdInput"/>
<input type="hidden" id="dateRef" value="<?= $params->date_ref;?>"/>