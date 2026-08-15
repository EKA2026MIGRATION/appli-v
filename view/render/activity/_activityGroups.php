

<br/><br/>
<h4 style="font-weight: bold">Groupes de la journée</h4>
<hr/>

<?php foreach($params->groups as $group):?>
  <section class="block-list dragDrop">
    <header><?php echo $group->name; ?> - <?php echo date('H:i', strtotime($group->start)); ?>  à <?php echo date('H:i', strtotime($group->end )); ?> • <?= $group->sport->name; ?>
      <?php foreach ($params->group as $groupIndi):
          if($groupIndi->groupActivityId == $group->groupActivityId): ?>
      <?php foreach($groupIndi->staff as $staff): ?>
         • <?= $staff->person->firstname; ?> 
       <?php endforeach; ?>        
      <?php
         endif;
       endforeach; ?>
       </header>
    <ul>

        <?php foreach($group->pickupActivities as $pickup):?>

          <li style="background-color: <?= showColorMoment(showMomentShort(showMoment($pickup->start, $pickup->end))) ;?>" data-id-pickup="<?php echo $pickup->pickupActivityId; ?>" class="<?php echo ($pickup->status != null) ? $pickup->status:'nopec';  ?>">
            <a href="#" data-open="revealPEC<?php echo $pickup->pickupActivityId; ?>">
              <div>
                <p class="list-header">
                  <?php if($pickup->child->photo == '') { $photo = IMG."no_photo.jpg"; } else { $photo = HOST.$pickup->child->photo; } ?>
                  <img src="<?= $photo ?>" class="width-30 height-30" data-id-child="<?php echo $pickup->child->childId; ?>" alt="">
                  <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?>
                  <?php echo '<span style="font-size: 12px ; font-style: italic"> - '.showAge($pickup->child->birthdate).'</span>';?>
                    <?php echo showNewCustomer($pickup->child->createdAt, '20'); ?>
                  <br/>

                  <?php if ($pickup->child->medical != '') { echo '<span style="font-style: italic; color: black; font-weight: bold; font-size:13px">Informations médicales :' . $pickup->child->medical.'</span><br/>';} ?>

                  <span style="font-size: 12px; color: darkblue">
                    <?= str_replace(',', ', ', $pickup->listSports);?>
                  </span>

                  <?php if(isset($param->child)):?>
                    <aside class="subtitles">
                          <div class="displayNone displayShowImpression">
                            <div style="height:10px;"></div>
                            <strong ><u>Parents</u></strong><br>
                            <?php foreach($params->$child->persons as $person):?>
                              <div style="height:5px;">

                              </div>
                              <strong style="color:red;"> <?php echo $person->firstname.' '.$person->lastname.' | '.$person->relation; ?><br/></strong>
                              <div style="height:5px;"></div>
                              <font style="color:blue;"><strong> Téléphones : </strong></font>
                              <?php foreach($person->phones as $phone):?>
                              <br />  • <?= $phone->name; ?>  (<?= $phone->phone; ?>)
                              <?php endforeach; ?>
                              <div style="height:5px;"></div>
                              <font style="color:blue;"><strong> Adresses : </strong></font>
                              <?php foreach($person->addresses as $address):?>
                              <br/> • <?= $address->name; ?>  (<?= $address->address; ?> <?= $address->address2; ?> <?= $address->postal; ?> <?= $address->town; ?>)
                              <?php endforeach; ?>

                            <?php endforeach; ?>
                          </div>
                    </aside>

                  <?php endif;?>

                  <div class="with-icon">
                    <?php

                    if($pickup->status == "pec")
                    {
                      echo '<i class="material-icons status olive">check</i>';
                    }
                    elseif($pickup->status == "npec")
                    {
                      echo '<i class="material-icons status red">close</i>';
                    }
                    else // Status = null
                    {
                      echo '<i class="material-icons status blue">access_time</i>';
                    }


                    ?>


                  </div>
                </p>
              </div>
            </a>
          </li>

        <?php endforeach; ?>

    </ul>
  </section>
<?php endforeach; ?>
