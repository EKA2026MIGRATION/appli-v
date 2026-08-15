<?php $groups = $params->groups; $groupChild = []?>
<?php if($groups):?>
    <?php foreach($groups as $group):?>

      <div class="groupActivity" style="margin-bottom: 30px">
          <h5><?= $group->start.' '.$group->name.' '.$group->area?></h5>
          <?php if($group->staffs):?>
            <section class="block-list" style="background-color: lightgrey">
                  <ul>
                      <?php foreach($group->staffs as $staff):?>
                          <?php if(isset($mealPerson)):?>
                            <?php if(key_exists($staff->personId, $mealPerson)):?>
                                <?= $mealPerson[$staff->personId];?>
                                <?php $groupPerson[$staff->personId] = $staff->personId;?>
                            <?php else:?>
                                <?=  liWithoutMeal($params->date, $staff->fullname, $staff->personId, 'personId')?>
                            <?php endif;?>
                          <?php endif;?>
                      <?php endforeach;?>
                  </ul>
              </section>
          <?php endif;?>

          <?php if($group->childs):?>
            <section class="block-list">
                <ul>
                    <?php foreach($group->childs as $child):?>
                        <?php if(isset($mealChild)):?>
                            <?php if(key_exists($child->id, $mealChild)):?>
                                <?= $mealChild[$child->id];?>
                                <?php $groupChild[$child->id] = $child->id;?>
                            <?php else:?>
                                <?=  liWithoutMeal($params->date, $child->firstname.' '.$child->lastname, $child->id, 'childId')?>
                            <?php endif;?>

                        <?php endif;?>
                    <?php endforeach;?>
                </ul>
              </section>
          <?php endif;?>
      </div>
    <?php endforeach;?>
<?php else:?>
    Aucun groupe
<?php endif;?>
<?php unset($arr);?>


<?php if(!empty($groupChild)):?>
    <h5 style="font-weight: bold">Enfants sans groupe</h5>


    <section class="block-list">
        <ul>
        <?php foreach($presences as $presence):?>

                <!-- check if is not in group child -->
                <?php if(!key_exists($presence->childId, $groupChild)):?>

                    <!-- chek if has  meal --->
                    <?php if(key_exists($presence->childId, $mealChild)):?>
                        <?= $mealChild[$presence->childId];?>
                    <?php else:?>
                        <?php if(!isset($arr[$presence->firstname.' '.$presence->lastname])):?>
                            <?php echo liWithoutMeal($params->date, $presence->firstname.' '.$presence->lastname, $presence->childId, 'childId');?>
                        <?php endif;?>
                        <?php $arr[$presence->firstname.' '.$presence->lastname] = $presence->firstname.' '.$presence->lastname;?>
                    <?php endif;?>

                <?php endif;?>
        <?php endforeach;?>
        </ul>
    </section>
<?php endif;?>


<?php if(isset($groupPerson)):?>

  <h5 style="font-weight: bold">Coachs sans groupe</h5>

  <?php unset($arr);?>
  <section class="block-list">
      <ul>
        <?php foreach($presenceCoachs as $presenceCoach):?>
              <?php $person = $presenceCoach->staff->person;?>

              <!-- check if is not in group child -->
              <?php if(!key_exists($person->personId, $groupPerson)):?>

                  <!-- chek if has  meal --->
                  <?php if(key_exists($person->personId, $mealPerson)):?>
                      <?= $mealPerson[$person->personId];?>
                  <?php else:?>
                      <?php if(!isset($arr[$person->firstname.' '.$person->lastname])):?>
                          <?php echo liWithoutMeal($params->date, $person->firstname.' '.$person->lastname, $person->personId, 'personId');?>
                      <?php endif;?>
                      <?php $arr[$person->firstname.' '.$person->lastname] = $person->firstname.' '.$person->lastname;?>
                  <?php endif;?>
              <?php endif;?>
        <?php endforeach;?>
      </ul>
  </section>

<?php endif;?>
