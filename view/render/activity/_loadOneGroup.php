<?php $group = $params->group;
$lastStatus = 'first'; ?>
<?php
$nbChild = 0;
$maxChildren = 0;
$hour = date('H:i', strtotime($group->start));
$hourRef = date('H', strtotime($group->start));
$hour_end = date('H:i', strtotime($group->end));
$arrayMonitor = [];
foreach ($group->staff as $staff) :
    $staffId = $staff->staffId;
    array_push($arrayMonitor, $staffId);
endforeach; ?>

<?php
$class_name = "block-list <?= (true === $group->locked) ? 'isLocked' : '';  ?>";
$d_start = date('H:i', strtotime($group->start));
$d_end   = date('H:i', strtotime($group->end));
$d_hour  = str_replace(":", '',  $hour);
$d_hour_end  = str_replace(":", '',  $hour_end);
$d_group = $group->groupActivityId;
$d_lunch = $group->lunch;

$d_monitor = "";
if (count((array) $arrayMonitor) > 1) {
    for ($i = 0; $i < count((array) $arrayMonitor); $i++) {
        if ($i == count((array) $arrayMonitor) - 1) {
            $d_monitor .= $arrayMonitor[$i];
        } else {
            $d_monitor .=  $arrayMonitor[$i] . '-';
        }
    }
} else {
    foreach ($group->staff as $staff) {
        $d_monitor .=  $staff->staffId;
    }
}

$d_location = $group->location->locationId;
$d_sport = $group->sport->sportId;

$d_g_child = "";

$d_g_child .= $group->name . ' - ';
foreach ($group->staff as $staff) {
    $d_g_child .=  $staff->person->firstname . ' - ';
    $maxChildren += $staff->maxChildren;
};
$d_g_child .=  date('H:i', strtotime($group->start)) . ' - ' . date('H:i', strtotime($group->end)) . ' - ' . strtoupper($group->sport->name) . ' - ' . strtoupper($group->area) . ' / ' . $group->location->name;
?>
<section data-hour-h2="" class="<?= $class_name; ?>" data-start="<?= $d_start; ?>" data-end="<?= $d_end; ?>" data-hour="<?= $d_hour; ?>" data-hour-end="<?= $d_hour_end; ?>" data-id-group="<?= $d_group; ?>" data-lunch="<?= $d_lunch; ?>" data-monitor="<?= $d_monitor; ?>" data-location="<?= $d_location; ?>" data-sport="<?= $d_sport; ?>" data-group-for-child="<?= $d_g_child; ?>">
    <div style="height: 8px;"></div>
    <center><strong>GROUPE <span class="numberGroup"></span></strong></center>
    <div style="height: 8px;"></div>
    <header style="padding-top: 35px;">
        <i class="material-icons arrow" style="position:absolute; left:5px; top:3px;">keyboard_arrow_up</i>
        <?php if ($group->name) {
            echo $group->name . ' - ';
        };
        foreach ($group->staff as $staff) : echo $staff->person->firstname . ' - ';
        endforeach; ?><?php echo date('H:i', strtotime($group->start)); ?> - <?php echo date('H:i', strtotime($group->end)); ?> - <?php echo strtoupper($group->sport->name); ?> - <?php echo strtoupper($group->area) . ' / ' . $group->location->name; ?>
        <div class="icons_activity">
            <a href="javascript:void(0)"><i class="material-icons" onclick="lockGroup(this)">lock</i></a>
            <a href="javascript:void(0)"><i class="material-icons" onclick="duplicateGroup('<?php echo $group->groupActivityId; ?>')">file_copy</i></a>
            <a href="javascript:void(0)"><i class="material-icons" onclick="editGroup('<?php echo $group->groupActivityId; ?>');openRevealJS('revealCreateActivityGroup')">edit</i></a>
            <a href="javascript:void(0)"><i class="material-icons" onclick="deleteGroup('<?php echo $group->groupActivityId; ?>')">delete</i></a>
        </div>

    </header>

    <ul id="ul<?php echo $group->groupActivityId; ?>" class="ul-group" data-id-group="<?php echo $group->groupActivityId; ?>">

        <?php if (null != $group->pickupActivities) :
            foreach ($group->pickupActivities as $pickup) : ?>
                <?php //echo '<pre>'; var_dump($pickup->groupActivities); echo '</pre>'; 
                ?>
                <?php $hour = date('H:i', strtotime($pickup->start)); ?>
                <li data-age="<?= showAge($pickup->child->birthdate); ?>" data-id-pickup="<?php echo $pickup->pickupActivityId; ?>" data-id-child="<?php echo $pickup->child->childId; ?>" class="<?php echo ($pickup->status != null) ? $pickup->status : 'nopec';  ?>">
                    <a href="javascript:void(0)" onclick="getIdPickup('<?php echo $pickup->pickupActivityId; ?>', '<?php echo $group->groupActivityId; ?>');openRevealJS('action-pickupActivity')">
                        <div>
                            <p class="list-header" style="margin-left: 0; padding-left: 0;">
                                <?php if ($pickup->child->photo == '') : $photo = IMG . "no_photo.jpg";
                                else :  $photo = HOST . $pickup->child->photo;
                                endif; ?>
                                <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?> (<?= showAge($pickup->child->birthdate); ?>)
                                <?php $nbChild++; ?>
                                <aside class="subtitles">
                                </aside>

                            </p>
                        </div>
                    </a>
                    <div class="with-icon">
                        <i class="material-icons" style="cursor:pointer;" onclick="removeElement(this)">delete</i>
                        <?php
                        showIconStatus($pickup->status, $lastStatus);
                        $lastStatus = $pickup->status;
                        ?>
                    </div>
                </li>
        <?php endforeach;
        endif ?>
        <div style="background-color: black; color: white; padding-left: 10px; font-size: 12px">
            CAPACITE
            <span class="nbPlacesMax"> <?php echo $maxChildren; ?></span>
            &nbsp;/&nbsp;
            Enfants :
            <span class="nbChild">
                <?= $nbChild; ?>
            </span>
        </div>
    </ul>
    <button onclick="unLockGroup(this)" class="unlock button withIcon <?= (true === $group->locked) ? '' : 'displayNone';  ?>"><i class="material-icons">lock_key</i> Débloquer ce groupe </button>

</section>