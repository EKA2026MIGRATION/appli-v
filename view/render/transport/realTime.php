<meta http-equiv="refresh" content="10">
<?php
 $lastStatus = "first";
 $title = "Dispatcher Transport"; ?>


<div class="dragDispatch">


    <div class="column2">
        <?php foreach($params->rides as $ride): $hour = date('H:i', strtotime($ride->start)); ?>
            <?php foreach($ride->pickups as $pickup):

                if($pickup->validated != "VALIDATED"):

                    $class = "noValidateRide";

                else:

                    $class = "";

                endif;

             endforeach; ?>
            <section id="ride<?= $ride->rideId; ?>" style="width:33%;" class="block-list" data-startPoint="<?php echo $ride->startPoint; ?>" data-endPoint="<?php echo $ride->endPoint; ?>"  data-id-ride="<?php echo $ride->rideId; ?>" data-start="<?php echo $params->date; ?> <?php echo $ride->start; ?>" data-hour="<?php echo str_replace(":", '',  $hour); ?>" data-driver="<?php echo $ride->staff->staffId; ?>">

                <header><?php echo $ride->name; ?> -
                    <?php if(isset($ride->staff->staffId)): ?> <?php echo $ride->staff->person->firstname; else: echo 'PAS DE DRIVER'; endif; ?>  - <?php echo $ride->start; ?> - <span class="nbPlaces">0</span>/<span class="nbPlacesMax"><?php echo ($ride->places == null) ? '8' : $ride->places;  ?></span></header>
                <ul>

                    <?php foreach($ride->pickups as $pickup):?>
                        <?php $hour = date('H:i', strtotime($pickup->start)); ?>
                        <li class="<?php echo ($pickup->status != null) ? $pickup->status:'npec';  ?>"  data-id-pickup="<?php echo $pickup->pickupId; ?>" data-address="<?php echo $pickup->address; ?>">
                            <a target="_blank" href="<?= HOST ?>child/display/id/<?= $pickup->child->childId; ?>/" data-hour="<?php echo str_replace(":", '',  $hour); ?>" >
                                <div class="<?php echo ($pickup->status != null) ? $pickup->status:'npec';  ?>">
                                    <p class="list-header">
                                        <?php if($pickup->child->photo == '') { $photo = IMG."no_photo.jpg"; } else { $photo = $pickup->child->firstname; } ?>
                                        <img src="<?= $photo ?>" class="width-30 height-30" data-id-child="<?php echo $pickup->child->childId; ?>" alt="">
                                        <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?> - <?php echo $pickup->kind; ?>
                                        <aside class="subtitles">
                                            <?php echo $pickup->address; ?> -  <?php echo date('H:i', strtotime($pickup->start)); ?>
                                        </aside>

                                    </p>
                                </div>
                            </a>
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

                                  if($lastStatus != null)
                                  {
                                    echo '<i class="material-icons status orange">directions_car</i>';
                                  }
                                  else
                                  {
                                    echo '<i class="material-icons status blue">access_time</i>';
                                  }

                                }

                                $lastStatus = $pickup->status;

                                ?>

                            </div>


                        </li>

                    <?php endforeach; ?>

                </ul>
                <button onclick="unLockRide(this)" class="unlock button withIcon <?= (true === $ride->locked) ? '' : 'displayNone';  ?>"><i class="material-icons">lock_key</i> Débloquer ce trajet </button>
            </section>

        <?php endforeach; ?>

    </div>
</div>

<input type="hidden" id="lastIdPickup">
<input type="hidden" id="person_connected" value="<?php echo PERSON_CONNECTED['firstname']; ?>">

<div class="space_actions_page_mobile"></div>
