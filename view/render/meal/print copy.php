<?php use_helper('dates');?>
<?php use_helper('lunch');?>
<?php $mealList = $params->mealList;?>
<?php $presences = $params->child_presence;?>
<?php $presenceCoachs = $params->staff_presence;?>
<?php $presencePersons = $params->person_presence;?>
<?php $presenceChildArray = $params->child_presence_array;?>
<?php $totalMeals = ['total' => 0, 'child' => 0, 'adult' => 0, 'other' => 0];?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
      img { width: 50px; height: 50px; }
      table, thead, tr, td, th { border: 1px solid black; border-collapse: collapse; text-align: center}
      table { width: 100%}
      body { width: 95%; margin: 0 auto; font-size: 10px!important}
      #groupListPrint { display: flex; flex-wrap: wrap; justify-content: space-between;}
      .item { width: 160px; border: 1px solid black; padding: 5px 10px 0px 5px; border-radius: 10px; margin-top: 2px}
      .lunchLine { color: darkblue; }
      .lunchLine i { color: red}
      #withoutGroup {display: flex; flex-wrap: wrap; justify-content: space-between; }
      #withoutGroup li { width: 200px}
      ul { list-style-type: none; margin-left:0;padding-left:0;}
    </style>
  </head>
  <body>

    <h2 style="text-align: center">Repas du <?= showDate($params->date);?></h2>

    <?php include('_recapTable.php');?>

    <br/><br/>


    <?php $groups = $params->groups;?>


    <div id="groupListPrint">

          <?php if($groups):?>
              <?php foreach($groups as $group):?>
                <div class="item">
                    <b><?= $group->start.' '.$group->name.' '.$group->area?></b>
                    <?php if($group->staffs):?>
                            <ul>
                                <?php foreach($group->staffs as $staff):?>
                                    <li>
                                        <?= $staff->fullname;?>
                                        <?php $groupPerson[$staff->personId] = $staff->personId;?>

                                        <div class="lunchLine">
                                            <?php if(key_exists($staff->personId, $mealPerson)):?>
                                                  <?= $mealList['person'][$staff->fullname];?>
                                            <?php else:?>
                                                  <i>Pas de repas</i>
                                            <?php endif;?>
                                        </div>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                    <?php endif;?>

                    <hr/>

                    <?php if($group->childs):?>
                          <ul>
                              <?php foreach($group->childs as $child):?>
                                <li>
                                    <?= $child->firstname.' '.$child->lastname?>
                                    <?php $groupChild[$child->id] = $child->id;?>
                                    <div class="lunchLine">
                                        <?php if(key_exists($child->id, $mealChild)):?>
                                            <?= $mealList['child'][$child->firstname.' '.$child->lastname];?>
                                        <?php else:?>
                                            <i>Pas de repas</i>
                                        <?php endif;?>
                                    </div>
                                </li>
                              <?php endforeach;?>
                          </ul>
                    <?php endif;?>
                </div>
              <?php endforeach;?>
          <?php else:?>
              Aucun groupe
          <?php endif;?>

    </div>

    <h5 style="font-weight: bold">Enfants sans groupe mangeant à midi</h5>

    <?php unset($arr);?>
    <div>
        <ul id="withoutGroup">
          <?php foreach($presences as $presence):?>

                <!-- check if is not in group child -->
                <?php if(!key_exists($presence->child->childId, $groupChild) && !isset($arr[$presence->child->firstname.' '.$presence->child->lastname])):?>
                    
                    <!-- check time --->
                    <?php if(str_replace(':', '', $presence->start) < '120000' && str_replace(':', '', $presence->end) > "120000"):?>
                        <li>
                            <?= $presence->child->firstname.' '.$presence->child->lastname;?>
                            <!-- chek if has  meal --->
                            <div class="lunchLine">
                                <?php if(key_exists($presence->child->childId, $mealChild)):?>
                                  <?= $mealList['child'][$presence->child->firstname.' '.$presence->child->lastname];?>
                                <?php else:?>
                                      <i>Pas de repas</i>
                                <?php endif;?>
                            </div>
                            <?php $arr[$presence->child->firstname.' '.$presence->child->lastname] = $presence->child->firstname.' '.$presence->child->lastname;?>
                        </li>
                    <?php endif;?>
                <?php endif;?>
          <?php endforeach;?>
        </ul>
    </div>


    <?php if(isset($groupPerson)):?>

      <h5 style="font-weight: bold">Coachs sans groupe à Bièvres</h5>

      <?php unset($arr);?>
      <section class="block-list">
          <ul id="withoutGroup">
            <?php foreach($presenceCoachs as $presenceCoach):?>
                  <?php $person = $presenceCoach->staff->person;?>
                  
                  <!-- check if is not in group child -->
                  <?php if(!key_exists($person->personId, $groupPerson) && !isset($arr[$person->firstname.' '.$person->lastname])):?>
                      <li>
                          <?= $person->firstname.' '.$person->lastname;?>
                          <!-- chek if has  meal --->
                          <div class="lunchLine">
                              <?php if(key_exists($person->personId, $mealPerson)):?>
                                  <?= $mealList['person'][$person->firstname.' '.$person->lastname];?>
                              <?php else:?>
                                    <i>Pas de repas</i>
                              <?php endif;?>
                          </div>
                          <?php $arr[$person->firstname.' '.$person->lastname] = $person->firstname.' '.$person->lastname;?>
                      </li>
                  <?php endif;?>
            <?php endforeach;?>
          </ul>
      </section>

    <?php endif;?>

    <script type="text/javascript">
    javascript:window.print();
    </script>

  </body>
</html>
