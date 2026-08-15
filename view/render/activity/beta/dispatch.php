<?php include('_style.php');?>

<?php $childList = []; $staffsByGroup = (array)$params->staffsByGroup; $childIngroups = []; $childPickup = []; $sportExist = []; $childGroupChildList = []?>

<h1>Activité Dispatcher</h1>
<?php include('_filter_calendar.php');?>

<!--- filter by hour -->
<?php include('_filter_age.php');?>

<!--- filter by location -->
<?php include('_filter_location.php');?>

<!--- modal activite de l'enfant -->
<?php include('_modal_edit_pickup.php');?>

<!--- modal create group -->
<?php include('_modal_edit_group.php');?>

<!--- child pickups list --->
<h4 class="centerTitle">Tous les enfants</h4>

<?php if(hasCredential('activity::dispatcherAccess')) showFloatingActionButton($params->buttons); ?>

<div id="ulPickup">
    <?php $age = ""; $current_child_id = ""; $b = 0; $first = 1?>
    <?php foreach($params->pickups as $pickup):?>
        <?php if(!is_object($pickup)) continue;?>
        <?php if($age != $pickup->age):?>
            <?php if($age != "") echo '</ul>';?>
            <?php if($age != "") echo '</ul>';?>
            <ul>
                <div><?= $pickup->age;?> ans</div>
        <?php endif;?>

        <!-- show child name -->
        <?php if($current_child_id != $pickup->child_id):?>
            <?php $b = 0; $first = 1?>
            <br/>
            </span>
            <span class="lineChild" data-location="<?= $pickup->location_id;?>">

            <?php ob_start();?>
            <li onclick="openEditPickup(<?= $pickup->child_id;?>, '<?= addslashes($pickup->fullname);?>', '<?= $pickup->age;?>', '<?= $pickup->status;?>')" class="li-child" id="li-child-<?= $pickup->child_id ;?>"
                <?php if($pickup->status == "npec") echo "style='font-style: italic; font-size: 12px;  text-decoration: line-through;'";?>
            >
                <?= $pickup->fullname;?>
                (<?= $pickup->age;?>)
                <!-- moment -->
                <?php if( $b == 0) echo '<i style="font-size: 10px; font-weight: bold; color: black!important">'.strtoupper(showMomentShort($pickup->start, $pickup->end)).'</i>'; $b++?>

            </li>
            <?php $childList[$pickup->child_id] = ob_get_clean();?>

            <?= $childList[$pickup->child_id];?>
        <?php endif;?>

        <!-- sport -->
        <?php if(!isset($sportExist[$pickup->child_id][$pickup->sport_id])):?>

            <!-- pastille sport -->
            <span class="sport_pastille"
                  title="<?= $_SESSION['SPORTS'][$pickup->sport_id]['name'];?>"
                  style="border-color: <?= $_SESSION['SPORTS'][$pickup->sport_id]['color'];?>">
                <?= ucfirst($_SESSION['SPORTS'][$pickup->sport_id]['name'][0]);?>
            </span>

            <?php // create array pickup by child to JS
                $childPickup[$pickup->child_id][] = [
                                                        'pickup_id' => $pickup->pickup_activity_id,
                                                        'sport' => $_SESSION['SPORTS'][$pickup->sport_id]['name'],
                                                        'timePresence' => showTime($pickup->start, 'H:i').' - '.showTime($pickup->end, 'H:i'),
                                                        'sport_id' => $pickup->sport_id
                                    ];

                ;?>

            <?php $sportExist[$pickup->child_id][$pickup->sport_id] = $pickup->sport_id;?>
        <?php endif;?>

        <?php $age = $pickup->age; $current_child_id = $pickup->child_id?>

    <?php endforeach;?>

    </span>

    </ul>
</div>


<!--- groups view --->
<h4 class="centerTitle">Tous les groupes</h4>

<div id="ulGroups">

    <?php $group_id = ""; $startTime = ""; $backgroundColor = ""?>

    <?php if($params->groups):?>
        <?php foreach($params->groups as $group):?>
            <?php if(!is_object($group)) continue;?>

            <?php
                $hour = date('H:i', strtotime($group->start));
                $hourRef = date('H', strtotime($group->start));
                $moment = showMoment($hour, $hour, true);
                $groupNameClassName = "group-".showMomentShort($moment).$hourRef;
                if($group->lunch) $groupNameClassName = $groupNameClassName.'-lunch';
            ?>

            <?php if($group_id != $group->group_activity_id):?>
                <?php if($group_id != "") echo '</ul>';?>

                <!-- prepare data for time informations -->
                <?php
                    $hour = showTime($group->start, 'H:i');
                    $hourRef = showTime($group->start, 'H');
                    $moment = showMoment($hour, $hour, true);
                    $currentBackground = showColorMoment($moment);
                    $d_lunch = $group->lunch;
                ?>

                <!-- line time --->
                <?php if($startTime != $hourRef):?>

                    <?php if($startTime != "") echo '</div>';?>

                    <div class="timeLine">
                        <h2><?= $hourRef;?> heures</h2>

                        <h2>
                            <?php if($currentBackground != $backgroundColor):?>
                                <?= $moment;?>
                            <?php endif;?>
                            <?php if($d_lunch == 1) echo 'Déjeuner';?>
                            <?php $backgroundColor = $currentBackground;?>
                        </h2>

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
                    </div>

                    <div class="ulGroupMoment" data-hour="<?= $hourRef;?>" style="background-color: <?= $currentBackground ;?> "/>

                <?php endif;?>
                <?php $startTime = showTime($group->start, 'H');?>

                <!-- start group -->

                <?php
                    $coachArray = []; $coachIdList = []; $maxChildren = 0;
                    if(key_exists($group->group_activity_id, $staffsByGroup)) {
                        foreach($staffsByGroup[$group->group_activity_id] as $staff_id) {
                            $coachArray[] = $_SESSION['STAFFS'][$staff_id]['firstname'];
                            $coachIdList[] = $staff_id;
                            if(is_numeric($_SESSION['STAFFS'][$staff_id]['maxChildren']))
                                $maxChildren += $_SESSION['STAFFS'][$staff_id]['maxChildren'];
                        }
                    };
                    $coachsNames = implode(', ', $coachArray);
                    $coachIdList = implode(',', $coachIdList);

                    (isset($_SESSION['SPORTS'][$group->sport_id]['name'])) ? $sportname = $_SESSION['SPORTS'][$group->sport_id]['name'] : $sportname = '';
                    $timePresence = showTime($group->start, 'H:i').' - '.showTime($group->end, 'H:i');
                ?>

                <ul class="ulGroupItem" data-location="<?= $group->location_id?>" id="ulGroupItem-<?= $group->group_activity_id;?>">
                    <!-- head group -->
                    <div
                            class="groupDataInformation <?= $groupNameClassName;?>"
                            onclick="openEditGroup(this)"
                            data-groupid = "<?= $group->group_activity_id;?>"
                            data-time ="<?= $timePresence;?>"
                            data-sport ="<?= $sportname ?>"
                            data-sportid = "<?= $group->sport_id;?>"
                            data-coachsIdList = "<?= $coachIdList;?>"
                            data-coachs = "<?= $coachsNames;?>"
                            data-locationId = "<?= $group->location_id?>"
                            data-sports = "<?= $sportname;?>"
                            data-lunch = "<?= $group->lunch;?>"
                            style = "cursor: pointer"
                    >


                            <!-- name -->
                            <?php if($group->name != "") { echo '<b>'.$group->name.'</b><br/>';}?>

                            <!-- coachs -->
                            <?= $coachsNames;?><br/>
                            <!-- heure start/end -->

                            <!-- sport & capacity-->
                            <div style="display: flex; justify-content: space-between">
                                <div><?= $timePresence ;?></div>
                                <div><?= $sportname;?></div>
                                <div id="maxChildren-<?= $group->group_activity_id;?>" >
                                </div>
                            </div>

                            <i style="font-weight: bold; font-variant-caps: small-caps;">
                                <?php if(isset($_SESSION['LOCATIONS'][$group->location_id]->name)) echo $_SESSION['LOCATIONS'][$group->location_id]->name ;?>
                            </i>

                            <!-- area -->
                            <?php unset($coachArray);?>
                    </div>
            <?php endif;?>

            <!-- body group -->
            <li>
                <?php if(key_exists($group->child_id, $childList)) echo $childList[$group->child_id];?>
                <?php
                    // create php array to JS
                    if (!isset($childInGroups[$group->child_id])) $childInGroups[$group->child_id] = ['child_id' => $group->child_id, 'count' => 0];
                    $childInGroups[$group->child_id]['count']++;

                    // create php array to list all child in group for JS
                    $childGroupChildList[$group->group_activity_id][$group->child_id] = $group->child_id;
                ?>
            </li>
            <!-- end group -->
            <?php $group_id = $group->group_activity_id;?>

        <?php endforeach;?>

    <?php endif;?>
    </ul>
</div>
<?php (!isset($childInGroups)) ? $childInGroups = [] :  $childInGroups = array_values($childInGroups);?>

<input type="hidden" id="childInGroupsInput" value='<?= json_encode($childInGroups);?>'/>
<input type="hidden" id="childPickupInput" value='<?= json_encode($childPickup);?>'/>
<input type="hidden" id="childGroupChildListInput" value = '<?= json_encode($childGroupChildList);?>'/>
<input type="hidden" id="staffPresences" value='<?= json_encode($params->staff_presence);?>'/>
