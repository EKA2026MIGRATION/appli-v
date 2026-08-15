<?php use_helper('dates,pickupStatis, pickupStatus');?>
<?php $day = null; $classColor = ""; $taskStaffId = null?>
<?php (!isset($params->callBack)) ? $myCallback = null : $myCallback = str_replace('/', '-', $params->callBack)?>
<?php if(isset($params->config)) { $pagination = true; $taskStaffId = $params->config['staffId'];};?>
<?php if(isset($params->config)) { $pagination = true; $taskStaffId = $params->config['staffId'];};?>
<?php if(!isset($hideSupervision))  $hideSupervision = 0;?> 
<?php if(!isset($hideDone))  $hideDone = 0;?> 

    <?php if($tasks):?>
                        <div class="taskBlockDay"><ul class="taskUL"> <!-- open a div to be closed at first loop -->
                        <?php foreach($tasks as $task):?>

                            <?php if(!is_object($task)) continue;?>

                            <?php if($task->step == "DONE" && $hideDone == 1) continue;?>

                            <?php ob_start();?>

                                      <?php if($day != showDate($task->dateTask->date)):?>
                                          <?php echo "</ul></div>";?>
                                          <?php $day = showDate($task->dateTask->date);?>
                                          <div class="taskBlockDay">
                                            <h5 class="taskH5" id="titleTask-<?= showDate($task->dateTask->date, 'Y-m-d');?>"><?= showDate($task->dateTask->date, 'l d F');?></h5>
                                            <ul class="taskUL" style="list-style: none">
                                      <?php endif;?>
                                      <?php if($task->staff):?>
                                          <?php if($taskStaffId != $task->staff->staffId):?>
                                              <h6 class="taskH6" style="text-align: center">
                                                  <?php if($task->staff):?>
                                                          <?php $taskStaffId = $task->staff->staffId;?>
                                                          <?php if($task->staff->person):?>
                                                              <a href="<?=HOST;?>staff/resume/id/<?= $taskStaffId;?>/" style="color: darkblue">
                                                                <?= $task->staff->person->firstname.' '.$task->staff->person->lastname;?>
                                                              </a>
                                                          <?php else:?>
                                                              staff sans person !!!
                                                          <?php endif;?>
                                                  <?php endif;?>
                                              </h6>
                                          <?php endif;?>
                                      <?php else:?>
                                          <h6 class="taskH6" style="font-style: italic; font-weight: normal">Non affectée</h6>
                                          <?php $taskStaffId = null?>
                                      <?php endif;?>

                                      <li class="taskLI" style="justify-content: space-between">
                
                                            <?php if(diffDate(date('Y-m-d'), showDate($task->dateLimit->date, 'Y-m-d')) <= 0) $classColor = "color: darkred";?>
                                            <?php if($task->step == "DONE") $classColor = "color: mediumseagreen";?>
                                            <div class="taskInfo" style="<?= $classColor;?>; cursor: pointer" title="<?= ($task->task) ? $task->task->name : $task->name;?>">
                                                
                                      
                                                <div class="taskLineItem taskTime"> 

                                                    <?php if(isset($task->criticity)):?>
                                                        <?= showCriticity($task->criticity);?>
                                                    <?php endif;?>

                                                    <?= showTime($task->dateTask->date);?>
                                                </div>
                                                <div class="taskLineItem taskName" id="taskName-<?= $task->id;?>">
                                                  <?php if($task->type != "") echo '{'.$task->type.'} ';?>
                                                  <?= $task->name ;?>
                                                </div>
                                                <div style="display: flex">
                                                  <?php if($task->step == "TODO"):?>
                                                              <a href="<?= HOST;?>task/modifyStep?id=<?= $task->id;?>&callBack=<?= $myCallback;?>">
                                                                    <i class="material-icons" style="">
                                                                      done
                                                                    </i>
                                                              </a>
                                                              <?php if(hasRole(['ADMIN', 'MANAGER']) && $myCallback != "app-home"):?>
                                                                  <a href="<?= HOST;?>task/deleteTask/id/<?= $task->id;?>/callBack/<?= $myCallback ?>/">
                                                                        <i class="material-icons" style="">
                                                                          delete
                                                                        </i>
                                                                  </a>
                                                                  <a href="<?= HOST;?>task/editTaskStaff/id/<?= $task->id;?>/callBack/<?= $myCallback ?>/">
                                                                        <i class="material-icons" style="">
                                                                          edit
                                                                        </i>
                                                                  </a>
                                                              <?php endif;?>
                                                    <?php else:?>
                                                            <i class="material-icons" style="color: mediumseagreen; font-size: 10px">
                                                              check_circle
                                                            </i>
                                                    <?php endif;?>
                                                  </div>
                                                <br style="clear: both"/>
                                            </div>
                                            <div class="showDescription" id="taskDescription-<?= $task->id;?>" style="min-width: 300px">
                                                <ul>
                                                    <li>Date limite de validation <?= showDate($task->dateLimit->date, 'd/m/Y H:i');?></li>
                                                    <?php if($task->duration):?>
                                                        <li>Durée prévue <?= showDuration($task->duration);?></li>
                                                    <?php endif;?>
                                                    <?php if($task->dateTaskDone):?>
                                                          <li>Tâche validée le <?= showDate($task->dateTaskDone->date, 'd/m/Y H:i');?></li>
                                                    <?php endif;?>
                                                    <?php if($task->description != null || $task->description != ""):?>
                                                        <b><?= $task->name ;?></b>
                                                        <div class="taskDescription">
                                                          <?= $task->description;?>
                                                        </div>
                                                    <?php endif;?>
                                                    <?php if($task->supervisor != null || $task->supervisor != ""):?>
                                                          <div>
                                                            <i>Supervision : <?= ($staff = $task->supervisor) ? $staff->person->firstname.' '.$staff->person->lastname : null;?></i>
                                                          </div>
                                                    <?php endif;?>
                                                </ul>
                                              </div>

                                      </li>
                            <?php $theTaskLine = ob_get_clean();?>

                            <?php if($hideSupervision == 1 && preg_match('/SUPERVISION/', $task->name)):?>

                                  <?php $supervisions[] = $theTaskLine;?>

                            <?php else :?>

                                <?= $theTaskLine;?>

                            <?php endif;?>

                            <?php unset($theTaskLine);?>

                        <?php endforeach;?>

                        <?php echo "</ul></div>";?> <!--- close the current div open -->


    <?php else:?>
                        <?php if(isset($currentDate)):?>
                          <div class="taskBlockDay">
                                <h5 class="taskH5"><?= showDate($currentDate, 'l d F');?></h5>
                                <br/><br/>
                                <i>aucune tâche trouvée</i>
                                <br/><br/>
                                <br/><br/>
                          </div>

                        <?php endif;?>
    <?php endif;?>




  <div class="taskPaginationBar"></div>
