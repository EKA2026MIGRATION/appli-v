<?php $title = 'Transport de la semaine'; ?>
<?php use_helper('translation');?>
<script>
  var showNbTarget;
  var nbTarget;
  var type;
  var myDate;
  var divTarget;
  var calendarDivLines;
  var checkDoubleCalendar = new Array();
  var test;
  var currentAttribute;
  var i;
</script>

<div class="text-center">
  <h1>

    <a href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>transport/calendar/date/<?php echo date('Y-m-d', strtotime('-7 day', strtotime($params->dateRef))); ?>/')">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a>
    
    <?php echo date('d/m/Y', strtotime($params->dateRef)); ?>
    
    <a href="javascript:void(0)" onclick="openDatePicker('week')">
      <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>

    <a  href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>transport/calendar/date/<?php echo date('Y-m-d', strtotime('+7 day', strtotime($params->dateRef))); ?>/')">
      <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
    </a>

  </h1>

</div>


<div id="datePickerInline"></div>


<div class="flexWeekView">

    
      <?php $i = 0; foreach ($params->pickups as $date => $allElements):?>
          <div class="flexColumn">
                    <div class="flexDate">
                          <a href="<?= HOST; ?>transport/dispatch/date/<?= $date; ?>/">
                            <?= showDate($date);?>
                          </a>
                          <br/>
                          <span id="showNb-<?= $date.'-dropin';?>"></span> PEC<br/>
                          <span id="showNb-<?= $date.'-dropoff';?>"></span> DEP<br/>
                          <span id="showNb-<?= $date.'-dropoff';?>Abs"></span> Absents

                    </div>   

                    <?php if($allElements):?>
                            <?php foreach($allElements as $type => $groups):?> 
                                    <hr/>
                                    <h6 style="text-align: center; font-weight: bold; color: darkblue"><?= trans($type.'All') ;?></h6>
                                    <?php $nb = 0; $abs = 0 ?>
                                    <?php foreach($groups as $groupTime => $allpickups):?>
                                            <br/>
                                            <h6 style="text-align: center; font-size: 12px; color: darkblue"><?= $groupTime;?></h6>
                                            <?php $l = 0; foreach($allpickups as $pickup):?>
                                                    <?php if($pickup->status != "npec") { $nb++; } else { $abs++ ;};?>
                                                    <?php ($pickup->ride_data == "") ? $style = "background-color: indianred" : $style = "";?> 
                                                    <?php ($pickup->status == "npec") ? $line = "text-decoration: line-through; color: red" : $line = "";?>

                                                    <div class="calendarDivLine" style="<?= $style;?>; <?= $line;?> " data-pickup-childId = "pickupchild-<?= $pickup->childId;?>">
                                                        <?php if($pickup->status == "pec") echo '<div style="font-style: italic; font-size: 2px; width: 20px; float: right; color: darkgreen"><i class="material-icons" style="font-size: 11px">airport_shuttle</i></div>';?>
                                                        <?php if($pickup->payment_due != ""):?>
                                                          <?php ($pickup->payment_due == $pickup->payment_done) ? $payment_color = "darkgreen" : $payment_color = "darkred";?>
                                                          <div style="font-style: italic; font-size: 2px; width: 20px; float: right; color: <?= $payment_color;?>;">
                                                              <i class="material-icons" style="font-size: 11px">euro_symbol</i>
                                                          </div>
                                                        <?php endif;?> 
                                                        <?php $l++;?>
                                                        <?php echo $l.' <b>'.$pickup->lastname.'</b> '.$pickup->firstname;?>
                                                        <?php if( strlen($pickup->info_medical) > 0):?>
                                                          <i class="material-icons" style="color: darkblue; font-size: 18px">local_hospital</i>
                                                      <?php endif;?>
                                                    </div>
                                                    <div class="calendarDivLineInfo">
                                                        <?= trans($type);?> : 
                                                        <?= $pickup->address;?>
                                                        <br/> Heure prévue: <?= $pickup->start;?>
                                                        <?php if($pickup->ride_data != "") echo '<br/>'.$pickup->ride_data;?>
                                                        <?php if($pickup->driver != "") echo ' - <span style="color: darkblue">'.$pickup->driver.'</span>';?>
                                                        <?php if($pickup->payment_due != "") echo '<br/>Montant du : '.$pickup->payment_due.' €';?>
                                                        <?php if($pickup->payment_done != "") echo '<br/>Montant payé : '.$pickup->payment_done.' €';?>
                                                        <?php if( strlen($pickup->info_medical) > 0) echo '<br/>'.$pickup->info_medical;?>
                                                    </div>
                                            <?php endforeach;?>
                                    <?php endforeach;?>
                                    <script>
                                        myDate = "<?= $date;?>";
                                        type   = "<?= $type;?>";
                                        nbTarget = "<?= $nb;?>";
                                        absTarget = "<?= $abs ;?>";
                                        divTarget = "showNb-"+myDate+"-"+type;
                                        showNbTarget = document.getElementById(divTarget);
                                        showAbsTarget = document.getElementById(divTarget+"Abs");
                                        showNbTarget.textContent = nbTarget;
                                        showAbsTarget.textContent = absTarget;

                                        delete checkDoubleCalendar;
                                        checkDoubleCalendar = new Array();
                                        calendarDivLines = document.getElementsByClassName('calendarDivLine');
                                        for(i = 0; i < calendarDivLines.length; i++ ) {
                                          currentAttribute = calendarDivLines[i].getAttribute("data-pickup-childId");
                                          test = checkDoubleCalendar.includes(currentAttribute);
                                          if(test == true) {
                                            //  créer le système de vérification si il y a bien un PEC et un DEP
                                          } else {
                                            checkDoubleCalendar.push(currentAttribute);
                                          }
                                        }                              
                                    </script>

                            <?php endforeach;?>
                    <?php endif;?>                
          </div>
      <?php endforeach; ?>
</div>
