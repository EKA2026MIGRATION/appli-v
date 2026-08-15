<?php if(!isset($callBack)) $callBack = null ?>
<?php (!isset($params->callBack)) ? $callBack = null : $callBack = str_replace('/', '-', $params->callBack)?>

<h4>Affecter une tâche</h4>

<form action="<?= HOST;?>task/add" method="post">
  <input type="hidden" name="taskStaffId" />
  <input type="text" name="name" placeholder="Intitulé de la tâche" class="required" required/>
  <input type="text" name="type" placeholder="Type de la tâche"/>
  <input type="hidden" name="callBack" value="<?= $callBack;?>"/>
  <textarea placeholder="Description (optionnel)" name="description"></textarea>

  <?php if(isset($params->staffs)):?>
              <hr/>
              <h4>Equipe</h4>
              <div style="">
                  <div style="width: 49%; float: left">
                      Affectation
                      <select name="staffId" class="required" id="selectStaffId">
                        <option/>
                        <?php foreach($params->staffs as $staff):?>
                          <option value="<?= $staff->staffId;?>"><?= $staff->person->firstname.' '.$staff->person->lastname;?></option>
                        <?php endforeach;?>
                      </select>
                      <input type="hidden" name="listStaffId" id="listStaffId"/>
                      <div id="listaffectation">
                      </div>
                    </div>

                    <?php if(isset($params->supervisor)):?>
                        <div style="width: 49%; float: left; margin-left: 2%">
                            Superviseur
                            <select name="supervisorId">
                              <option/>
                              <?php foreach($params->supervisor as $supervisor):?>
                                <option value="<?= $supervisor->staffId;?>"><?= $supervisor->person->firstname.' '.$supervisor->person->lastname;?></option>
                              <?php endforeach;?>
                            </select>
                          </div>
                    <?php endif;?>
              </div>
  <?php else:?>
              <input type="hidden" name="staffId" value="<?= $params->staff->staffId;?>"?>
  <?php endif;?>

  <?php if(!hasRole(['ADMIN', 'MANAGER']) || $originalRequest->getRoute() == "activity/display"):?>
                  <input type="hidden" name="dateTodo" value="<?= date('Y-m-d');?>"/>
                  <input type="hidden" name="timeTodo" value="<?= date('H:i');?>"/>
  <?php else:?>
                  <hr/>
                  <h4>Date de la tâche</h4>
                  <div class="">
                          <div style="width: 49%; float: left">
                                <input type="text" id="dateTodo" placeholder="A faire le" class="required" required>
                                <input type="hidden" id="datepicker" name="dateTodo">
                          </div>
                          <div class="input-group" style="width: 49%; float: left; margin-left: 2%;">
                              <span class="input-group-label">
                                 <i class="large material-icons">access_time</i>
                              </span>
                              <input type="time" name="timeTodo" value="<?= date('H:i');?>" class="input-group-field required" required/>
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

                  <hr/>
                  <h4>Etat de la tâche</h4>

                  <div class="">
                          <div style="width: 49%; float: left">
                                  <select name="step">
                                      <option value="TODO" >TACHE A FAIRE</option>
                                      <option value="DONE" <?php if($callBack == 'activity-display') echo 'selected="selected"' ;?>>TACHE FAITE</option>
                                  </select>
                          </div>
                          <div style="width: 49%; float: left; margin-left: 2%">
                                    <input type="text" id="dateLimit" placeholder="Jour limite de réalisation">
                                    <input type="hidden" id="datepicker2" name="dateLimit">
                          </div>
                  </div>



  <?php endif;?>

  <input type="submit" value="AJOUTER" class="button large" style="text-align: center; margin: 0 auto; width: 100%"/>

</form>
