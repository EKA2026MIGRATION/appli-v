<?php $title = "Gestion des transports"; ?>


<div class="text-center">
  <h1>

    <a href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>transport/calendar/date/<?php echo date('Y-m-d', strtotime('-1 day', strtotime($params->date))) ?>/')">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a> <?php echo date('d/m/Y', strtotime($params->date)); ?>

    <a href="javascript:void(0)" onclick="openDatePicker()">
      <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>

    <a  href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>transport/calendar/date/<?php echo date('Y-m-d', strtotime('+1 day', strtotime($params->date))) ?>/')">
      <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
    </a>

  </h1>

</div>

<div id="datePickerInline"></div>

<div class="reveal" id="revealNPEC" data-reveal>
  <p class="lead">Non pris en charge</p>

    <section class="block-list">
      <header>NPEC </header>
      <ul id="pickUpListNPEC">  
        <li>DropIn</li>  
        <?php foreach($params->pickups_unaffected_dropin as $pickup):?>
          <li data-id-pickup="<?php echo $pickup->pickupId; ?>">
            <a href="<?= HOST ?>child/id/<?php echo $pickup->child->childId; ?>" target="_blank" data-open="action-pickup">
              <div>
                <p class="list-header">
                  <?php if($pickup->child->photo == '') { $photo = IMG."no_photo.jpg"; } else { $photo = $pickup->child->firstname; } ?>
                  <img src="<?= $photo ?>" class="width-30 height-30" alt=""> 
                  <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?>
                  <aside class="subtitles">
                  <?php echo $pickup->address; ?>
                  </aside>
                  <div class="with-icon">
                    Voir le profil
                  </div>
                </p> 
              </div>
            </a>
          </li>  
        <?php endforeach; ?>       
        <li>DropOff</li>
        <?php foreach($params->pickups_unaffected_dropoff as $pickup):?>
          <li data-id-pickup="<?php echo $pickup->pickupId; ?>">
            <a href="<?= HOST ?>child/id/<?php echo $pickup->child->childId; ?>" target="_blank" data-open="action-pickup">
              <div>
                <p class="list-header">
                  <?php if($pickup->child->photo == '') { $photo = IMG."no_photo.jpg"; } else { $photo = $pickup->child->firstname; } ?>
                  <img src="<?= $photo ?>" class="width-30 height-30" alt=""> 
                  <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?>
                  <aside class="subtitles">
                  <?php echo $pickup->address; ?>
                  </aside>
                  <div class="with-icon">
                    Voir le profil
                  </div>
                </p> 
              </div>
            </a>
          </li>  
        <?php endforeach; ?>    
      </ul>
    </section>

  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<?php foreach($params->rides as $ride): ?>

  <div class="reveal" id="revealTrajet<?php echo $ride->rideId; ?>" data-reveal>
    <section class="block-list" >
      <header> <?php echo $ride->name; ?> - <?php echo $ride->staff->person->firstname; ?> <?php echo $ride->staff->person->lastname; ?>  - <?php echo $ride->start; ?></header>
      <ul>    
          <?php foreach($ride->pickups as $pickup):?>
          <li data-id-pickup="<?php echo $pickup->pickupId; ?>" class="<?php echo ($pickup->status != null) ? $pickup->status:'NPEC';  ?>">
            <a href="<?= HOST ?>child/id/<?php echo $pickup->child->childId; ?>" target="_blank">
              <div>
                <p class="list-header">
                  <?php if($pickup->child->photo == '') { $photo = IMG."no_photo.jpg"; } else { $photo = $pickup->child->firstname; } ?>
                  <img src="<?= $photo ?>" class="width-30 height-30" data-id-child="<?php echo $pickup->child->childId; ?>" alt=""> 
                  <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?>
                  
                  <aside class="subtitles">
                  <?php echo $pickup->address; ?>
                  </aside>
                  <div class="with-icon">
                    <?php 
                      if($pickup->status == "pec")
                      {
                        echo '<i class="material-icons status green" style="font-size:1rem;">check</i>';
                      }
                      elseif($pickup->status == "npec")
                      {
                        echo '<i class="material-icons status red" style="font-size:1rem;">close</i>';
                      }
                      else // Status = null
                      {
                        echo '<i class="material-icons status blue" style="font-size:1rem;">access_time</i>';   
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

    <button class="close-button" data-close aria-label="Close modal" type="button">
      <span aria-hidden="true">&times;</span>
    </button>

  </div>

<?php endforeach; ?>  



<p><center><a href="<?= HOST ?>transport/dispatch/date/<?php echo $params->date;?>/"><button class='button'>Ouvrir le dispatcher <?php echo date('d/m/Y', strtotime($params->date)); ?> </button></a></center></p>


<?php 
  $totalNPEC = count((array)$params->pickups_unaffected_dropin) + count((array)$params->pickups_unaffected_dropoff); 
  $x = 0;
  foreach($params->rides as $ride): 
    foreach($ride->pickups as $pickup):
    

      if($pickup->validated != "VALIDATED")
      {
        $x++;
      }

    endforeach;
  endforeach;

  if($totalNPEC == 0 AND $x == 0)
  {
    ?>
      <div data-closable class="callout alert-callout-subtle success">
        <strong>Information !<br></strong> Journée validée
        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
          <span aria-hidden="true">⊗</span>
        </button>
      </div>
    <?php
  }
  else
  {
  ?>
    <div data-closable class="callout alert-callout-subtle alert">
      <strong>Information !<br></strong> <?php echo ($totalNPEC != 0) ? $totalNPEC.' pickup(s) non pris en charge.':'';  ?>
      <span id="noValidatedPickUp"> <br/> <?php echo ($x != 0) ? $x.' pickup(s) non validé(s).':'';  ?> </span>
      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
        <span aria-hidden="true">⊗</span>
      </button>
    </div>
  <?php
  }
?>




  <div id="containerCalendar">
    <div id='calendar'></div>
  </div>


    <div id="listChild1" style="display: none;">
      <div style="margin-top: 15px; padding:5px; font-size:12px;" >
      <p><strong>DropIn</strong></p>
    <?php 
    $nbEnfants = 0;
    foreach($params->pickups_unaffected_dropin as $pickup): 
    $nbEnfants++;
    ?>
      ○  <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?> - <?php echo date('H:i', strtotime($pickup->start)); ?> <br/>
    <?php
    endforeach;
    ?>
    <p><strong>DropOff</strong></p>
    <?php
    foreach($params->pickups_unaffected_dropoff as $pickup): 
    $nbEnfants++;
    ?>
      ○  <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?> - <?php echo date('H:i', strtotime($pickup->start)); ?> <br/>
    <?php
    endforeach;
    $events = "[{ id: '1', resourceId: 'a', start: '2018-10-17T00:01:00', end: '2018-10-17T23:59:00', title: 'NPEC : ".$nbEnfants." enfant(s)',  type: 'npec' }";
    $ressources = "[{ id: 'a', title: 'NPEC' }";

        foreach($params->rides as $ride): 


        $events = $events.",{ id: '".$ride->rideId."', resourceId: '".$ride->staff->staffId."', start: '".$ride->start."', title: '".$ride->name."', type: 'trajet'}";

        $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        $ressources = $ressources.",{ id: '".$ride->staff->staffId."', title: '".$ride->staff->person->firstname."', eventColor: '#3D9970'}";        
            ?>
            <div id="listChild<?php echo $ride->rideId; ?>" style="display: none;">
              <div style="margin-top: 15px; padding:5px; font-size:12px;" >
              <?php
              foreach($ride->pickups as $pickup):
              ?>
              
                ○  <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?> - <?php echo date('H:i', strtotime($pickup->start)); ?>
                 <?php 

                    if($pickup->status == "pec")
                    {
                      echo '<i class="material-icons white" style="font-size:1rem;">check</i>';
                    }
                    elseif($pickup->status == "npec")
                    {
                      echo '<i class="material-icons white" style="font-size:1rem;">close</i>';
                    }
                    else // Status = null
                    {
                      echo '<i class="material-icons white" style="font-size:1rem;">access_time</i>';   
                    }


                    ?>
                    <br />
              
              <?php
              endforeach;
              ?>
              </div>
            </div>
            <?php


         endforeach;

         $events = $events."]";
         $ressources = $ressources."]";


    ?>
      </div>
    </div>


<script type="text/javascript">
  
var generateRessources = <?php echo $ressources; ?>;
var generateEvents = <?php echo $events; ?>;

</script>