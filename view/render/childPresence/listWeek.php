<?php $title = 'Gestion des présences des enfants'; ?>
<?php use_helper('photo'); $totalLocation = [] ?>


<?php $arr = ['Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa', 'Di'];?>
<script>
 var nbChildPresent, nbChildPresentAM, nbChildPresentDAY, nbChildPresentPM, nbChildPresentAbsent, nbChildPresentInconnnu, nbNoTransport;
 var total = [];
 var totalAM = [];
 var totalPM = [];
 var totalDAY = [];
 var totalOfferedAM = [];
 var totalOfferedPM = [];
 var totalOfferedDAY = [];
 var totalAbsent = [];
 var totalInconnu = [];
 var totalNoTransport = []
 var allDates = [];

 var targetLocation, targetLocationId, totalOnes, totalOnesOffered, contentLocationHtml; 
</script>

<style>
.countChild { "color: black; font-style: italic; font-size: 14px}
</style>

<div id="topHeader">
  <div class="text-center">
    <h1>

      <a href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>child/presence/date/<?php echo date('Y-m-d', strtotime('-1 day', strtotime($params->dateRef))); ?>/')">
        <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
      </a>
      
      <?php echo date('d/m/Y', strtotime($params->dateRef)); ?>
      
      <a href="javascript:void(0)" onclick="openDatePicker('week')">
        <i class="material-icons" class="calendar_change_date">date_range</i>
      </a>

      <a  href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>child/presence/date/<?php echo date('Y-m-d', strtotime('+1 day', strtotime($params->dateRef))); ?>/')">
        <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
      </a>

    </h1>

  </div>


  <div id="datePickerInline"></div>

  <?php include_once(VIEW.'render/home/_locationBar.php');?>

  <div id="calendarDayBar">
    <div class="showDateColButton">Lu</div>
    <div class="showDateColButton">Ma</div>
    <div class="showDateColButton">Me</div>
    <div class="showDateColButton">Je</div>
    <div class="showDateColButton">Ve</div>
    <div class="showDateColButton">Sa</div>
    <div class="showDateColButton">Di</div>
  </div>

</div>

<div class="flexWeekView">

      <?php $i = 0; foreach ($params->presences as $date => $allpresence):?>

          <div class="flexColumn">
                    <div id="showDateCol<?=$arr[$i];?>" class="flexDate">
                          <a href="<?= HOST; ?>child/presenceDay/date/<?= $date; ?>/">
                            <?= showDate($date, 'l');?>
                            <?= showDate($date);?>
                          </a>
                    </div>
                    <div id="<?= 'nbChildPresentAll'.$i;?>" class="locationInformation locationall" style="padding-left: 10px"></div>
                    <?php foreach($params->locations as $location):?>
                      <div id="<?= 'nbChildPresentLocation'.$location->locationId.$i;?>" class="locationInformation location<?= $location->locationId;?>" style="display: none; padding-left: 10px"></div>
                      <div id="<?= 'nbChildPresentLocationOffered'.$location->locationId.$i;?>" class="locationInformation location<?= $location->locationId;?>" style="display: none; padding-left: 10px"></div>
                    <?php endforeach;?>
                  
                    <?php $nbChildPresent = 0; $allready   = []; $nbChildAbsent = 0; $nbNoTransport = 0?> 
                    <?php $nbChildPresentMoment[$i]        = ['Matinée' => 0, 'Journée' => 0, 'Après-midi' => 0, 'Absent' => 0, 'inconnu' => 0];?>
                    <?php $nbChildPresentMomentOffered[$i] = ['Matinée' => 0, 'Journée' => 0, 'Après-midi' => 0, 'Absent' => 0, 'inconnu' => 0];?>
                    <?php if($allpresence):?>

                            <?php foreach($allpresence as $presence):?>
                                        <?php if(isset($presence->childId)):?>

                                            <?php $moment = showMoment($presence->start, $presence->end);?>

                                            <?php if(!in_array($moment.$presence->childId, $allready)):?>
                                                      <?php $allready[] = $moment.$presence->childId;?>

                                                      <?php ++$nbChildPresent; ?>


                                                      <?php if($presence->productIsOffered == 1):?>
                                                        <?php if(isset($nbChildPresentMomentOffered[$i][$moment])) ++$nbChildPresentMomentOffered[$i][$moment];?>
                                                      <?php else:?>
                                                          <?php if(isset($nbChildPresentMoment[$i][$moment])) ++$nbChildPresentMoment[$i][$moment];?>
                                                      <?php endif;?>

                                                      <?php ($presence->urlPhoto != '' || $presence->urlPhoto != null) ? $urlPhoto = HOST.$presence->urlPhoto : $urlPhoto = IMG.'no_photo.jpg'; ?>
                                                      <?php $showChildPresence[$moment][$presence->start][] =     [
                                                                                                  'colorMoment' => 'background-color: '.showColorMoment(showMomentShort($moment)),
                                                                                                  'childId'     => $presence->childId,
                                                                                                  'showTime'    => showTime($presence->start).' '.showTime($presence->end),
                                                                                                  'urlPhoto'    => $urlPhoto,
                                                                                                  'productIsOffered'   => $presence->productIsOffered,
                                                                                                  'name'        => $presence->lastname.' '.$presence->firstname,
                                                                                                  'lastDayOfWeek' =>$presence->lastDayOfWeek,
                                                                                                  'status'      => $presence->status,
                                                                                                  'hasTransport' => $presence->hasTransport,
                                                                                                  'registrationStatus' => $presence->registrationStatus,
                                                                                                  'paymentDue' => $presence->paymentDue,
                                                                                                  'paymentDone' => $presence->paymentDone,
                                                                                                  'locationId'    => $presence->locationId,
                                                                                                  'location' => $presence->location,
                                                                                                  'category' => $presence->category,
                                                                                                  'timeStart' => showTime($presence->start),
                                                                                                  'isHourSelectable' => $presence->isHourSelectable
                                                                                                ];
                                                      ?>
                                            <?php endif;?>

                                        <?php else :?>

                                          <?php $showChildPresence[$moment][$presence->start][] =     [
                                                                                        'colorMoment' => 'font-style:italic; color: gray; font-size: 10px',
                                                                                        'warning'     => 'Presence '.$presence->childPresenceId.' child not found - registration '.$presence->registrationId,
                                                                                      ];
                                            ?>
                                        <?php endif;?>
                                        
                            <?php endforeach;?>

                            <?php if(isset($showChildPresence)):?>
                                  <?php krsort($showChildPresence);?>
                                  <?php foreach($showChildPresence as $moment => $baseElements):?>


                                        <?php ksort($baseElements);?>

                                        <br/>
                                        <h6 style="text-align: center"><?= $moment;?></h6>

                                        <?php foreach($baseElements as $elements):?>                                                    
                                                    <?php $l = 0;?>
                                                    <?php foreach($elements as $liChildPresence):?>
                                                          <div style="<?= $liChildPresence['colorMoment'] ;?>">

                                                            <?php if(isset($liChildPresence['warning'])):?>
                                                                <?php echo $liChildPresence['warning'];?>
                                                            <?php else :?>

                                                                <!-- absence si npec -->
                                                                <?php if( $liChildPresence['status'] == "npec"):?>
                                                                  <?php ++$nbChildAbsent; ?>
                                                                    <div class="locationInformation locationall location<?= $liChildPresence['locationId'] ;?>" style="font-style: italic; color: grey; text-decoration: line-through;">
                                                                      <?php echo $liChildPresence['name'] ?>
                                                                    </div>

                                                                <?php else :?>

                                                                        <?php $l++; ?>
                                                                        <?php (isset($nbByLocation[$liChildPresence['locationId']])) ? $nbByLocation[$liChildPresence['locationId']]++ : $nbByLocation[$liChildPresence['locationId']] = 1 ;?>
                                                                        <?php (isset($totalLocation[$liChildPresence['locationId']][$moment])) ? $totalLocation[$liChildPresence['locationId']][$moment]++ : $totalLocation[$liChildPresence['locationId']][$moment] = 1 ;?>

                                                                        <?php if($liChildPresence['productIsOffered'] == 1):?>
                                                                            <?php (isset($totalLocationOffered[$liChildPresence['locationId']][$moment])) ? $totalLocationOffered[$liChildPresence['locationId']][$moment]++ : $totalLocationOffered[$liChildPresence['locationId']][$moment] = 1 ;?>
                                                                        <?php endif;?>

                                                                        <?php ($liChildPresence['registrationStatus'] == "waiting" || $liChildPresence['registrationStatus'] == "unpayed") ? $color = "darkred" : $color = "darkblue"?>
                                                                        <a class="locationInformation locationall location<?= $liChildPresence['locationId'] ;?>" href="<?= HOST; ?>child/display/id/<?= $liChildPresence['childId']; ?>/" title="<?php echo $liChildPresence['showTime'];?>" style="color: <?= $color;?>;">
                                                                          <div>
                                                                              <span class="countChild locationInformation locationall"><?= $l.' ';?></span>
                                                                              <span style="display:none" class="countChild location<?= $liChildPresence['locationId'] ;?> locationInformation"><?= $nbByLocation[$liChildPresence['locationId']];?></span>

                                                                              <?php if($liChildPresence['hasTransport'] == false):?>
                                                                                  <?php $nbNoTransport++;?>
                                                                                  <?php $ico = '<i class="material-icons" style="font-size: 11px">directions_walk</i>';?>
                                                                                  <?php $back = "background-color: white";?>
                                                                              <?php else:?>
                                                                                  <?php $ico = '';?>
                                                                                  <?php $back = "";?>
                                                                              <?php endif;?>

                                                                              <?php echo showIcon($liChildPresence['category'], 'width: 11px; height: 11px;');?>
                                                                              <?php if($liChildPresence['productIsOffered'] == 1) echo showIcon('offert', 'width: 11px; height: 11px;', 'png');?>

                                                                              <span style="<?= $back;?>">
                                                                                <?= $ico;?>
                                                                                <?php if($liChildPresence['isHourSelectable'] == 1)  echo  '<span style="font-size: 12px; font-style:italic">'.$liChildPresence['timeStart'].'</span>';?>

                                                                                <?php echo $liChildPresence['name'] ?>
                                                                              </span>
                                                                              <?php if($liChildPresence['lastDayOfWeek'] != ""):?>
                                                                                <span class="material-icons" style="font-size:16px">contactless</span>
                                                                              <?php endif;?> 


                                                                              <?php if($liChildPresence['paymentDue'] != "unknown"):?>
                                                                                <?php ($liChildPresence['paymentDue'] == $liChildPresence['paymentDone']) ? $payment_color = "darkgreen" : $payment_color = "darkred";?>
                                                                                <span style="font-style: italic; font-size: 12px; color: <?= $payment_color;?>;">
                                                                                    <?php echo ($payment_color == "darkgreeen") ? $liChildPresence['paymentDone'] : $liChildPresence['paymentDue'];?>
                                                                                    <i class="material-icons" style="font-size: 12px">euro_symbol</i>
                                                                                </span>
                                                                              <?php endif;?>

                                                                          </div>
                                                                        </a>
                                                                <?php endif;?>
                                                            <?php endif;?>
                                                          </div>
                                                    <?php endforeach;?>
                                        <?php endforeach;?>

                                        <?php unset($nbByLocation);?> 

                                  <?php endforeach;?>

                                  <?php foreach($totalLocation as $locationId => $totalsL):?>

                                        <?php $totalOnes = 0;?>
                                        <?php $html = "";?>
                                        <?php foreach($totalsL as $moment => $totalOne):?>
                                            <?php $html .= '<li>'.$totalOne.' en '.$moment.'</li>';?>
                                            <?php $totalOnes += $totalOne ;?>
                                        <?php endforeach; ?>


                                        <?php $contentLocationHtml = '<b style=\'color: darkblue\'>'.$totalOnes.' enfants</b><br/><ul>'.$html;?>
                                        <script>
                                          document.addEventListener("DOMContentLoaded", function() {
                                            targetLocationId    = "nbChildPresentLocation<?= $locationId.$i;?>";
                                            contentLocationHtml = "<?= $contentLocationHtml;?>";
                                            targetLocation = document.getElementById(targetLocationId);
                                            targetLocation.innerHtml = "<b>"+totalOnes+"</b>";
                                            $('#'+targetLocationId).html(contentLocationHtml);
                                          });

                                        </script>

                                  <?php endforeach;?>

                                              
                                  <?php if(isset($totalLocationOffered)):?>
                                          <?php foreach($totalLocationOffered as $locationIdOffered => $totalsLOffered):?>
                                                <?php $totalOnesOffered = 0;?>
                                                <?php $html = "";?>
                                                <?php foreach($totalsLOffered as $moment => $totalOneOffered):?>
                                                    <?php $html .= '<li>'.$totalOneOffered.' offert(s) en '.$moment.'</li>';?>
                                                    <?php $totalOnesOffered += $totalOneOffered ;?>
                                                <?php endforeach; ?>
                                                <?php $contentLocationHtmlOffered = '<b span=\'color: darkblue\'>'.$totalOnesOffered.' enfants offerts</b><br/><ul>'.$html;?>

                                                <script>
                                                  document.addEventListener("DOMContentLoaded", function() {
                                                    targetLocationId    = "nbChildPresentLocationOffered<?= $locationIdOffered.$i;?>";
                                                    contentLocationHtml = "<?= $contentLocationHtmlOffered;?>";
                                                    targetLocation = document.getElementById(targetLocationId);
                                                    targetLocation.innerHtml = "<b>"+totalOnesOffered+"</b>";
                                                    /*$('#'+targetLocationId).show();*/

                                                    console.log(targetLocationId);
                                                    $('#'+targetLocationId).append(contentLocationHtml);
                                                  });

                                                </script>

                                          <?php endforeach;?>
                                  <?php endif;?>
                                  <?php unset($showChildPresence, $totalLocation);?>
                            <?php endif;?>
                            
                    <?php endif;?>
                    <script>
                        nbChildPresent = "<?= $nbChildPresent; ?>";
                        nbChildPresentAM = "<?= $nbChildPresentMoment[$i]['Matinée'];?>";
                        nbChildPresentPM = "<?= $nbChildPresentMoment[$i]['Après-midi'];?>";
                        nbChildPresentDAY = "<?= $nbChildPresentMoment[$i]['Journée'];?>";

                        nbChildPresentOfferedAM = "<?= $nbChildPresentMomentOffered[$i]['Matinée'];?>";
                        nbChildPresentOfferedPM = "<?= $nbChildPresentMomentOffered[$i]['Après-midi'];?>";
                        nbChildPresentOfferedDAY = "<?= $nbChildPresentMomentOffered[$i]['Journée'];?>";


                        nbChildAbsent = "<?= $nbChildAbsent;?>";
                        nbChildInconnu = "<?= $nbChildPresentMoment[$i]['inconnu'];?>";
                        nbNoTransport = "<?= $nbNoTransport; ?>"

                        total.push(nbChildPresent);
                        
                        totalAM.push(nbChildPresentAM);
                        totalPM.push(nbChildPresentPM);
                        totalDAY.push(nbChildPresentDAY);

                        totalOfferedAM.push(nbChildPresentOfferedAM);
                        totalOfferedPM.push(nbChildPresentOfferedPM);
                        totalOfferedDAY.push(nbChildPresentOfferedDAY);

                        totalAbsent.push(nbChildAbsent);
                        totalInconnu.push(nbChildInconnu);
                        totalNoTransport.push(nbNoTransport);

                    </script>
                    <?php unset($nbChildPresent);?>
                    <?php unset($nbChildPresentMoment);?>
                    <?php unset($allready);?>
                    <?php unset($nbChildAbsent);?>
                    <?php unset($nbNoTransport);?>
                    <?php unset($totalLocationOffered);?>

          </div>
          <?php $i++;?>
      <?php endforeach; ?>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
   let target;
   for(let i =0; i < 7; i++) {
      if(total[i] > 0 ) {
        target = "nbChildPresentAll"+i;
        let contentHtml = '<b span="color: darkblue">'+total[i]+' enfants</b><br/><ul><li>'+totalAM[i]+ ' en matinée</li><li>'+totalPM[i]+' en après-midi</li><li>'+totalDAY[i]+' en journée</li>';
   
        contentHtml = contentHtml += "<hr/>";

        if (totalOfferedAM[i] >0) { contentHtml = contentHtml + '<li>'+totalOfferedAM[i]+ ' offert(s) en matinée</li>' };
        if (totalOfferedPM[i] >0) { contentHtml = contentHtml + '<li>'+totalOfferedPM[i]+ ' offert(s) en après-midi</li>' };
        if (totalOfferedDAY[i] >0) { contentHtml = contentHtml + '<li>'+totalOfferedDAY[i]+ ' offert(s) en journée</li>' };

        contentHtml = contentHtml += "<hr/>";

        if(totalNoTransport[i]>0) {
          contentHtml += '<li>'+totalNoTransport[i]+' sans transport';
          contentHtml += '</li>';
        }


        if(totalAbsent[i]>0) {
          contentHtml += '<li>'+totalAbsent[i]+' Absent';
          if(totalAbsent[i]>1) { contentHtml +='s'};
          contentHtml += '</li>';
        }



        if(totalInconnu[i]>0) {
          contentHtml += '<li>'+totalInconnu[i]+' inconnu</li>';
        }
        contentHtml += '</ul>';
        $('#'+target).html(contentHtml);


      }     
   }
   let showDateColButtons = document.getElementsByClassName('showDateColButton');

   for(z= 0; z < showDateColButtons.length; z++) {

        showDateColButtons[z].addEventListener('click', function() {

          let target = document.getElementById('showDateCol'+this.textContent);

          target.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
      })
   }



   

});
</script>