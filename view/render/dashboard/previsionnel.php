<style>
ul { margin-left: 10px; padding: 4px; border-right: 1px solid lightgrey; list-style-type: none; }
ul:last-child {
  border-right: 0px solid red;
}
.partBar { background-color: darkblue; color: white; font-weight: bold; text-align: center; padding: 10px;font-size: 20px }
.group { display: flex; padding: 10px; justify-content: space-around; flex-wrap: wrap }
.sportGroup { border: 2px solid darkblue; border-radius: 10px; margin: 4px }
.sportGroupTitle { text-align: center; color: white; background-color: darkred; font-weight: bold;}
.dataInfo { text-align: center; font-size: 13px; border-bottom: 1px solid lightgrey }
#totalChildGroupData { border: 1px solid darkblue;}
#totalChildGroupData ul { width: 200px; margin: 0 auto; text-align: right}

</style>
<script>
  let nbChild, keyData, target, nbStaff, targetStaff, role, contentText, maxChild, capacityDriver, pluriel;           
</script>

<?php $totalChild = []; $totalChildGroup = []?>

<?php $title = "Prévisionnel - Energy Academy"; ?>
<?php use_helper('dates', 'photo');?>

<?php if(!isset($print)):?>

<?php use_helper('buttons');?>
<?php showFloatingActionButton($params->buttons); ?>

<h1>Prévisionnel</h1>

<input id="date" value="<?= $params->date ?>" type="hidden">
<div class="text-center">
  <h1>
    <a href="#" id="previousDay" class="jumpToDayButton">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a>

    <span id="showCurrentDate">
      <?php echo date('d/m/Y', strtotime($params->date)); ?>
    </span>

    <a href="javascript:void(0)" onclick="openDatePicker()">
      <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>

    <a href="#" id="nextDay" class="jumpToDayButton">
      <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
    </a>
  </h1>
</div>
<div id="datePickerInline"></div>

<?php endif;?>

<div style="margin-bottom: 30px">
  
  <div class="partBar">
     STAFF
  </div>
  <div class="group">
    <?php foreach($params->staff_presence as $role => $staffs):?>
      <div class="sportGroup">
          <div class="sportGroupTitle">
            <?php echo $role;?>
          </div>

          <div id="dataStaff-<?= $role;?>" class="dataInfo"> 
          </div>

          <ul>
              <?php $nbStaff = 0; $maxChild = 0; $capacityDriver = 0?>
              <?php foreach($staffs as $staff):?>
                  <li>
                      <?php echo $staff['name'];?>
                      <span style="font-size: 10px; font-style: italic">
                        <?php if($role == "COACH") echo $staff['maxChild'];?>
                        <?php if($role == "DRIVER") echo $staff['capacityDriver'];?>
                      </span>
                  </li>
                  <?php $nbStaff++;?>
                  <?php $maxChild += $staff['maxChild'];?>
                  <?php $capacityDriver += $staff['capacityDriver'];?>
              <?php endforeach;?>
          </ul>
      </div>
      <script>
          role = "<?php echo $role ;?>";
          nbStaff = "<?php echo $nbStaff;?>";
            
          maxChild = "<?php echo $maxChild;?>";
          capacityDriver = "<?php echo $capacityDriver;?>";

          targetStaff = document.getElementById("dataStaff-"+role);

          contentText = nbStaff+' '+role+'S';

          if(role == "COACH" || role == "SUPERVISEUR") {
            contentText += "<br/>"+maxChild+" enfants";
          }

          if(role == "DRIVER" || role == "SUPERVISEUR")  {
            contentText += "<br/>"+capacityDriver+"  transports";
          }

          targetStaff.innerHTML = contentText;
      </script>
    <?php endforeach;?>
  </div>
</div>     

<br/>
<div style="margin-bottom: 30px">
  <div class="partBar">
     <?= $params->totalChild;?> ENFANTS
  </div>
  <div id="totalChildGroupData"></div>
</div>
<br/>
<?php if($params->presences):?>
    <?php foreach($params->presences as $nbSport => $bySport):?>

        <div class="sportUnique">

            <div style="margin-bottom: 30px">
              <div class="partBar">
                <?= $nbSport;?> SPORT<?php if($nbSport>1) echo 'S';?>
              </div>
              <div class="group">
                  <?php foreach($bySport as $sportname => $groups):?>

                    <?php ksort($groups);?>

                    <div class="sportGroup">
                        <div class="sportGroupTitle">
                          <?php echo $sportname;?>
                        </div>
                        
                        <div class="bySport" style="display: flex; justify-content: space-around; padding: 10px; flex-wrap: wrap">
                          <?php foreach($groups as $groupAge => $momentGroups):?>

                              <?php krsort($momentGroups);?>

                              <?php $keyData = trim(str_replace(' ', '', $nbSport.$sportname.$groupAge));?>
                              <ul>
                                <div style="font-weight: bold; text-align: center">
                                    <?php echo $params->groupAgeName[$groupAge];?>
                                </div>
                                <div id="dataGroup-<?php echo $keyData;?>" class="dataInfo">
                                </div>


                                <?php $nbChild = 0;?>
                                <?php foreach($momentGroups as $moment => $momentGroup):?>

                                    <div style="text-align: center; color: darkred"><?= $moment;?></div>
                                    <?php ksort($momentGroup);?>
                                    <?php foreach($momentGroup as $child):?>
                                        <li>
                                            <?php echo showIcon($child->category, 'width: 10px; height: 10px');?>
                                            <?php echo $child->lastname.' '.$child->firstname.' <span style="font-size: 10px; font-style: italic">('.$child->age.')</span>';?>
                                            <?php $nbChild++;?>
                                        </li>
                                        <?php if(!isset($totalChildGroup[$groupAge])) $totalChildGroup[$groupAge] = 0;?>
                                        <?php $totalChildGroup[$groupAge]++;?>
                                    <?php endforeach;?>
                                <?php endforeach;?>
                                <script>
                                    nbChild = "<?php echo $nbChild;?>";
                                    keyData = "<?php echo $keyData;?>";
                                    target = document.getElementById('dataGroup-'+keyData);
                                    if(parseInt(nbChild) > 1) {
                                        pluriel = "s";
                                    } else {
                                        pluriel = "";
                                    }
                                    target.textContent = nbChild+ ' enfant'+pluriel;
                                </script>
                              </ul>
                          <?php endforeach;?>
                        </div>

                    </div>
                  <?php endforeach;?>
              </div>
            </div>
        </div>
    <?php endforeach;?>
<?php endif;?>

<?php ksort($totalChildGroup);?>

<input type="hidden" value="<?php echo implode(',', $totalChildGroup);?>" id="totalChildGroup" name="totalChildGroup"/>
<input type="hidden" value="<?php echo implode(',', $params->groupAgeName);?>" id="groupAgeName" name="groupAgeName"/>


<script>
  let totalChildGroup = document.getElementById('totalChildGroup').value;
  let groupAgeName = document.getElementById('groupAgeName').value;
  let totalChildGroupData = document.getElementById('totalChildGroupData');

  let datas = totalChildGroup.split(',');
  let groupAge = groupAgeName.split(',');

  let html = "<ul>";
  for(let i = 0; i < datas.length; i++ ) {
    html += "<li>"+groupAge[i]+" : "+datas[i]+" enfants</li>";
  }
  html += "</ul>";
  
  totalChildGroupData.innerHTML = html;

</script>