<?php
use_helper('dates');
$lastStatus = "first";
$title = "Dispatcher Activité";
if(hasCredential('activity::dispatcherAccess')) {
    echo '<input type="hidden" name="user_role" id="user_role" value="ADMIN"/>';
} else {
    echo '<input type="hidden" name="user_role" id="user_role" value=""/>';
}
$colorGroups = ['', '35d0ba', 'FF9234', 'ffe79a',  'c9f658', 'f9f8eb', '9795cf', 'FFDC00', 'ffdede', 'feff89', 'e6e6fa', 'FF9280', 'fdb44b', 'ccffec', 'c7f3ff', 'd6f8b8', '87e0ff'];


foreach($_SESSION['CREDENTIALS'] as $credentials) {
    $el = explode('::', $credentials);
    if($el[0] == "activity") {
        $credential = str_replace('dispatcher', '', $el[1]);
        if($credential != "Access" && $credential != "coachView") {
            $credentialUpdate[] = $credential;
        }
    }

}

echo "<input type='hidden' name='credentialUpdate' id='credentialUpdate' value='".json_encode($credentialUpdate)."'/>";

?>


<style>
    .tagLi {
        background-color: darkslategray!important;
        color: black;
        border: 2px solid black;
        height: 25px; width: 25px;
        padding: 5px!important;
        text-align: center;
        font-size: 12px;
        border-radius: 150px;
        margin: 0px;
        margin-left: 5px;
    }

    .ageBar {
        display: block; font-style: italic; width: 100%; border-bottom: 1px solid grey;
        font-weight: bold; font-size: 18px; margin-top: 20px;
    }

    .ulTagLi {
        display: flex;
    }

    .ulLineName {
        line-height: 1.6;
        background-color: darkred;
        color: white;
        border-radius: 6px;
        padding: 1px;
        margin-bottom: 1px;
    }

    #blockAgeList {
        display: flex;
        flex-wrap: wrap;
    }

    #blockAgeList .item {
        margin-right: 30px;
        border-right: 1px solid grey;
        padding-right: 30px;
    }
</style>

<?php if(hasCredential('activity::dispatcherAccess')) showFloatingActionButton($params->buttons); ?>

<div class="actionsPage">
    <a href="<?= HOST ?>activity/calendar/date/<?php echo $params->date; ?>/">
        <button class="button">
            <i class="material-icons">arrow_back</i>
        </button>
    </a>
</div>

<?php showDatePickerNavigation('activity/dispatch/date', $params->date); ?>
<?php include('_actionPickupActivity.php');?>
<?php include('_createGroup.php');?>
<?php include('_createMultipleGroup.php');?>
<?php include('_createPickup.php');?>
<?php include('_filterDispatch.php');?>

<!-- traitement php pour calculs ... -->
<?php $totalPickups = count((array)$params->pickups); ?>

<?php
$arraySport = [];
foreach ($params->pickups as $pickup) {
    if(isset($pickup->sport)) {
        if($pickup->sport) {
            $sportId = $pickup->sport->sportId;
            if(!in_array($sportId, $arraySport)) {
                array_push($arraySport, $sportId);
            }
        }
    }

};
?>
<input type="hidden"id="groupForChild"value="">
<div class="dragDispatch">
    <div class="column1">
        <div class="npec">
            <?php $locationSportAge = []; $childSport = [];?>
            <?php foreach ($params->sports as $sport):
                if (in_array($sport->sportId, $arraySport)):?>

                            <?php $myHourRef = ""; $k = 0; ?>
                            <?php foreach ($params->pickups as $pickup):?>



                                <?php if($pickup->sport):?>

                                    <?php if ($sport->sportId === $pickup->sport->sportId):?>

                                        <?php if($pickup->sport->sportId != 10) $childSport[$pickup->child->childId][$pickup->sport->sportId] = $pickup->sport->color;?>

                                        <?php $hourStart = date('H:i', strtotime($pickup->start));  $hourEnd = date('H:i', strtotime($pickup->end)); ?>

                                        <?php $myHourRef = $hourStart;?>

                                        <?php $moment = showMomentShort($pickup->start,$pickup->end);?>

                                        <?php ob_start();?>
                                            <li class="ulLineName"
                                                data-id-child="<?= $pickup->child->childId;?>"
                                                data-id-pickup="<?php echo $pickup->pickupActivityId; ?>"
                                                data-location="<?= (null != $pickup->location)? $pickup->location->locationId : ''; ?>"
                                                data-end-hour="<?php echo str_replace(":", '',  $hourEnd); ?>"
                                                data-start-hour="<?php echo str_replace(":", '',  $hourStart); ?>"
                                                data-age="<?= showAge($pickup->child->birthdate); ?>"
                                            >
                                                <?= $fullname = strtoupper($pickup->child->lastname).' '.ucfirst(strtolower($pickup->child->firstname)) ;?>
                                                <?php echo showNewCustomer($pickup->child->createdAt, '20'); ?>
                                                <?php if( strlen($pickup->child->medical) > 0):?>
                                                    <i class="material-icons" title="<?php echo $pickup->child->medical;?>" style="width: 20px; height: 20px; line-height: 0px">local_hospital</i>
                                                <?php endif;?>
                                            </li>

                                        <?php $datas[showAge($pickup->child->birthdate, "")][$fullname]['childInfo'] = ob_get_clean();?>


                                        <?php ob_start();?>

                                            <li class="tagLi inline-li"
                                                data-id-child="<?php echo $pickup->child->childId; ?>"
                                                data-sport-id="<?= $sport->sportId; ?>"
                                                data-id-child="<?= $pickup->child->childId;?>"
                                                data-id-pickup="<?php echo $pickup->pickupActivityId; ?>"
                                                data-location="<?= (null != $pickup->location)? $pickup->location->locationId : ''; ?>"
                                                data-end-hour="<?php echo str_replace(":", '',  $hourEnd); ?>"
                                                data-start-hour="<?php echo str_replace(":", '',  $hourStart); ?>"
                                                data-age="<?= showAge($pickup->child->birthdate); ?>"
                                                >
                                                <?php ($pickup->status == "npec") ? $colorName = "red" : $colorName = "darkblue";?>
                                                <a style="color: <?= $colorName;?>"
                                                    data-sport-id="<?= $sport->sportId; ?>" id="a<?= $pickup->pickupActivityId; ?>"
                                                    data-validated="<?= $pickup->validated; ?>" title href="javascript:void(0)"
                                                    onmouseover="showGroups(<?= $pickup->pickupActivityId; ?>, <?= $pickup->child->childId ?>);getIdPickup(<?= $pickup->pickupActivityId; ?>, '') "
                                                    onmouseout="hideTooltip()"
                                                    onclick="getIdPickup(<?= $pickup->pickupActivityId; ?>, ''); openRevealJS('action-pickupActivity') "
                                                    data-id-pickup="<?= $pickup->pickupActivityId; ?>"
                                                    data-registration="<?= (!$pickup->registration) ? $pickup->registration->registrationId : ''; ?>"
                                                    data-age="<?= showAge($pickup->child->birthdate); ?>"
                                                    data-child="<?= $pickup->child->childId; ?>"
                                                    data-child-name="<?= $pickup->child->firstname . ' ' . $pickup->child->lastname; ?>"
                                                    data-sport="<?= $pickup->sport->sportId; ?>"
                                                    data-group = "<?php if (!$pickup->groupActivities): foreach ($pickup->groupActivities as $groupActivity): echo $groupActivity->groupActivityId[0]; endforeach; else: echo 'aucun groupe '; endif ?>"data-photo="<?php if(null ==$pickup->child->photo ): echo IMG."no_photo.jpg"; else:  echo HOST.$pickup->child->photo; endif; ?>">

                                                    <?php echo $pickup->sport->name[0];?>

                                                </a>
                                            </li>

                                        <?php $datas[showAge($pickup->child->birthdate, "")][$fullname]['sportInfo'][] = ob_get_clean();?>


                                        <?php $ageRef = showAge($pickup->child->birthdate, "");?>

                                        <?php $locationSportAge[$pickup->location->locationId]["sport".$pickup->sport->sportId."age".$ageRef."-hour".str_replace(':', '', $hourStart)] = "sport".$pickup->sport->sportId."-age".$ageRef."-hour".str_replace(':', '', $hourStart);?>

                                    <?php endif;?>
                                <?php endif;?>
                            <?php endforeach; ?>
                <?php endif;
            endforeach; ?>

            <section id="blockAgeList" class="block-list" data-id-activity="<?=$sport->sportId; ?>">


                <?php if(isset($datas)):?>

                    <?php ksort($datas);?>

                    <?php foreach($datas as $currentAge => $elements):?>
                        <div class="item">
                                <div class="ageBar" id="sport<?= $pickup->sport->sportId;?>age<?= showAge($pickup->child->birthdate, '');?>Div">
                                    <?php echo $currentAge;?> ans
                                </div>


                                <?php asort($elements);?>

                                <?php foreach($elements as $data):?>

                                    <div class="ulTagLi">

                                        <?= $data['childInfo'];?>

                                        <?php foreach($data['sportInfo'] as $pastille):?>
                                            <?= $pastille;?>
                                        <?php endforeach;?>
                                    </div>

                                <?php endforeach;?>

                        </div>
                    <?php endforeach;?>

                <?php endif;?>


            </section>

        </div>
    
        <input type='hidden' name='locationSportAge' id='locationSportAge' value='<?= json_encode($locationSportAge);?>'/>

        <?php if($params->groups):?>
                    <div class="column2-ter">

                        <?php $timeref = "00"; $backgroundColor = ""?>

                        <?php foreach($params->groups as $group):

                            $nbChild = 0; $maxChildren = 0;
                            $hour = date('H:i', strtotime($group->start));
                            $hourRef = date('H', strtotime($group->start));
                            $hour_end = date('H:i', strtotime($group->end));
                            $arrayMonitor = [];
                            $moment = showMoment($hour, $hour, true);
                            $d_lunch = $group->lunch;


                            $groupNameClassName = "group-".showMomentShort($moment).$hourRef;
                            if($d_lunch) $groupNameClassName = $groupNameClassName.'-lunch';

                            $currentBackground = showColorMoment($moment);

                            foreach ($group->staff as $staff):
                                $staffId = $staff->staffId;
                                array_push($arrayMonitor, $staffId);
                            endforeach;?>
                        
                            <?php if($hourRef.$d_lunch != $timeref):?>
                                <?php if($timeref != "00") echo '</div>'; $needToClose = 0;?>
                                <h2 data-hour="<?= $hourRef;?>00" style="display: flex; justify-content: space-between; width: 100%; border-bottom: 1px solid darkblue; margin-top: 100px;">
                                    <?php ($currentBackground != $backgroundColor) ? $styleH2 = "font-weight: bold" : $styleH2="";?>
                                        
                                    <div style="<?= $styleH2;?>"><?= $hourRef;?> heures</div>

                                    <?php if($currentBackground.$d_lunch != $backgroundColor):?>
                                        <div>
                                            <?= $moment;?>
                                            <?php if($d_lunch) echo ' - Déjeuner';?>
                                        </div>
                                    <?php endif;?>

                                    <div class="actionGroupButton" style="width: 380px; font-family: arial; line-height: 2.6rem;">
                                        <div style="font-size: 1.1rem; display: flex; justify-content: space-around">
                                            <div>
                                                DUPLIQUER A 
                                            </div>
                                            <select name = "selecHour-<?= $groupNameClassName;?>" id="selectHour-<?= $groupNameClassName;?>" style="width: 80px">
                                                <?php for($i= 10; $i<17; $i++):?>
                                                    <option value="<?= $i;?>"><?= $i;?> H </option>
                                                <?php endfor;?>
                                            </select>
                                            <select name="selectMinute-<?= $groupNameClassName;?>" id="selectMinute-<?= $groupNameClassName;?>" style="width: 60px">
                                                <?php for($i= 0; $i<60;  $i = $i+5):?>
                                                    <?php $j = $i;?>
                                                    <?php if($i == 0) $j = '00';?>
                                                    <?php if($i == 5) $j = '05';?>
                                                    <option value="<?= $j;?>"><?= $j;?></option>
                                                <?php endfor;?>
                                            </select>
                                            <div>
                                                <input type="checkbox" id="isLunch-<?= $groupNameClassName;?>" name ="isLunch-<?= $groupNameClassName;?>"value="1" style="width: 20px; height: 20px">
                                                <i class="material-icons">fastfood</i>
                                            </div>
                                            <a href="javascript:void(0)" style="padding: 4px;"><i class="material-icons" onclick="copyMoment('<?= $groupNameClassName;?>')" title="copier">swap_horizontal_circle</i></a>
                                        </div>
                                    </div>
                                  


                                </h2>
                                <div class="column2-bis" style="background-color: <?= $currentBackground;?>; width: 100%">
                                <?php $needToClose = 1;?>
                                <?php $timeref = $hourRef.$d_lunch; $backgroundColor = $currentBackground.$d_lunch?>
                            <?php endif;?>

                        

                            <?php

                            ($group->locked === true) ? $locked = "isLocked" : $locked = "";
                            $class_name = $groupNameClassName." block-list ".$locked;
                            $d_start = date('H:i', strtotime($group->start));
                            $d_end   = date('H:i', strtotime($group->end));
                            $d_hour  = str_replace(":", '',  $hour);
                            $d_hour_end  = str_replace(":", '',  $hour_end);
                            $d_group = $group->groupActivityId;


                            $d_monitor = "";
                            if (count((array) $arrayMonitor)> 1) {
                                for ($i = 0; $i < count((array) $arrayMonitor); $i++ ) {
                                    if ($i == count((array) $arrayMonitor)-1 ) {
                                        $d_monitor .= $arrayMonitor[$i];
                                    }else {
                                        $d_monitor .=  $arrayMonitor[$i]. '-';
                                    }
                                }
                            } else {
                                foreach ($group->staff as $staff) {
                                    $d_monitor .=  $staff->staffId;
                                }
                            }

                            $d_location= $group->location->locationId;
                            $d_sport = $group->sport->sportId;

                            $d_g_child = "";

                            $d_g_child .= $group->name .' - ';
                            foreach ($group->staff as $staff) {
                                $d_g_child .=  $staff->person->firstname . ' - ';
                                $maxChildren += $staff->maxChildren;
                            };
                            $d_g_child .=  date('H:i', strtotime($group->start)) . ' - ' . date('H:i', strtotime($group->end)). ' - '. strtoupper($group->sport->name). ' - '.strtoupper($group->area).' / '.$group->location->name;
                            ?>
                        
                            <section data-hour-h2="<?= $timeref; ?>00" class="<?= $class_name;?>" data-start="<?= $d_start;?>" data-end="<?= $d_end;?>"
                            data-hour="<?= $d_hour;?>" data-hour-end="<?= $d_hour_end; ?>" data-id-group="<?= $d_group;?>" data-lunch="<?= $d_lunch;?>"
                            data-monitor="<?= $d_monitor;?>" data-location="<?= $d_location;?>" data-sport="<?= $d_sport;?>"
                            data-group-for-child="<?= $d_g_child;?>" style="background-color: initial; margin: 1px">
                                <div style="height: 8px;"></div>
                                <center><strong>GROUPE <span class="numberGroup"></span></strong></center>
                                <div style="height: 8px;"></div>
                                <header style="padding-top: 35px; border: 1px solid gray; background-color: #<?= $colorGroups[$d_sport];?>">
                                    <i class="material-icons arrow"style="position:absolute; left:5px; top:3px;">keyboard_arrow_up</i>
                                    <?php if($group->name) { echo $group->name.' - ' ;}; foreach ($group->staff as $staff): echo $staff->person->firstname . ' - '; endforeach; ?><?php echo date('H:i', strtotime($group->start)); ?> - <?php echo date('H:i', strtotime($group->end)); ?> - <?php echo strtoupper($group->sport->name); ?> - <?php echo strtoupper($group->area).' / '.$group->location->name; ?>
                                    
                                    <div class="icons_activity actionGroupButton">
                                        <a href="javascript:void(0)"><i class="material-icons"onclick="lockGroup(this)">lock</i></a>
                                        <a href="javascript:void(0)"><i class="material-icons" onclick="duplicateGroup('<?php echo $group->groupActivityId; ?>')">file_copy</i></a>
                                        <a href="javascript:void(0)"><i class="material-icons" onclick="editGroup('<?php echo $group->groupActivityId; ?>');openRevealJS('revealCreateActivityGroup')">edit</i></a>
                                        <a href="javascript:void(0)"><i class="material-icons"onclick="deleteGroup('<?php echo $group->groupActivityId; ?>')">delete</i></a>
                                    </div>
                                

                                </header>
                            

                                <ul id="ul<?php echo $group->groupActivityId; ?>"class="ul-group"data-id-group="<?php echo $group->groupActivityId; ?>">

                                    <?php if(null != $group->pickupActivities):
                                        foreach($group->pickupActivities as $pickup):?>
                                            <?php $hour = date('H:i', strtotime($pickup->start)); ?>
                                            <li style="border-right: 1px solid gray; border-bottom: 1px solid gray; background-color: <?= showColorMoment(showMomentShort(showMoment($pickup->start, $pickup->end))) ;?>" data-age="<?= showAge($pickup->child->birthdate); ?>"data-id-pickup="<?php echo $pickup->pickupActivityId; ?>"data-id-child="<?php echo $pickup->child->childId; ?>" data-sport-id="<?= $group->sport->sportId; ?>" class="<?php echo ($pickup->status != null) ? $pickup->status:'nopec';  ?>">
                                                <?php if( hasCredential('activity::dispatcherUpdateAll') || hasRole(['MANAGER']) ):?>
                                                    <a href="javascript:void(0)" onclick="getIdPickup('<?php echo $pickup->pickupActivityId; ?>', '<?php echo $group->groupActivityId; ?>');openRevealJS('action-pickupActivity')">
                                                <?php else:?>
                                                    <a href="javascript:void(0)">
                                                <?php endif;?>
                                                    <div>
                                                        <p class="list-header" style="margin-left: 0; padding-left: 0;"  >
                                                            <?php if($pickup->child->photo == ''): $photo = IMG."no_photo.jpg"; else:  $photo = HOST.$pickup->child->photo; endif; ?>
                                                            <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?>

                                                            <span style="font-size: 12px; font-style: italic;">-<?= showAge($pickup->child->birthdate); ?></span>


                                                            <?php echo showNewCustomer($pickup->child->createdAt, '20'); ?>

                                                            <!-- show sport -->
                                                            <?php if(key_exists($pickup->child->childId, $childSport)):?>
                                                                <?php foreach($childSport[$pickup->child->childId] as $color):?>
                                                                    <i class="material-icons" style="color: <?= $color;?>">circle</i>
                                                                <?php endforeach;?>

                                                            <?php endif;?>

                                                            <?php if( strlen($pickup->child->medical) > 0):?>
                                                                <i class="material-icons" style="color: darkblue" title="<?php echo $pickup->child->medical;?>">local_hospital</i>
                                                            <?php endif;?>
                                                            <?php if($pickup->lastDayOfWeek ==  date('Y-m-d', strtotime($pickup->start)) ):?>
                                                                <span class="material-icons" style="font-size:22px">contactless</span>
                                                            <?php endif;?>

                                                            <?php if($pickup->status != "npec") $nbChild ++;?>
                                                            <aside class="subtitles">
                                                            </aside>

                                                        </p>
                                                    </div>
                                                </a>

                                                    <div class="with-icon">
                                                        <?php if( hasCredential('activity::dispatcherUpdateAll')):?>
                                                            <i class="material-icons"style="cursor:pointer;"onclick="removeElement(this)">delete</i>
                                                        <?php endif;?>
                                                        <?php if( hasRole(['MANAGER'])):?>
                                                            <?php showIconStatus($pickup->status, $lastStatus); $lastStatus = $pickup->status; ?>
                                                        <?php endif;?>

                                                    </div>
                                            </li>
                                        <?php endforeach;?>
                                    <?php endif?>
                                    <div style="background-color: black; color: white; padding-left: 10px; font-size: 12px">
                                        CAPACITE
                                        <span class="nbPlacesMax"> <?php echo $maxChildren;?></span>
                                        &nbsp;/&nbsp;
                                        Enfants :
                                        <span class="nbChild">
                                            <?= $nbChild;?>
                                        </span>
                                    </div>
                                </ul>
                                <button onclick="unLockGroup(this)"class="unlock button withIcon <?= (true === $group->locked) ? '' : 'displayNone';  ?>"><i class="material-icons">lock_key</i> Débloquer ce groupe </button>
                            </section>
                        <?php endforeach; ?>
                        <?php if(isset($needToClose) && $needToClose ==1) echo '</div>';?>
                    </div>
        <?php endif;?>
    </div>
</div>
<input type="hidden" id="lastIdPickup">
<input type="text" id="actualGroupPickup">
<div class="space_actions_page_mobile"></div>
