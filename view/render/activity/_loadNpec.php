<?php
$lastStatus = "first";
$arraySport = [];
foreach ($params->pickups as $pickup) {
    if($pickup->sport) {
        $sportId = $pickup->sport->sportId;
        if(!in_array($sportId, $arraySport)) {
            array_push($arraySport, $sportId);
        }
    }
};
?>
<input type="hidden"id="groupForChild"value="">
<div class="npec">
    <?php foreach ($params->sports as $sport):
        if (in_array($sport->sportId, $arraySport)):?>
            <section class="block-list" data-id-activity="<?=$sport->sportId; ?>">
                <header><i class="material-icons arrow">keyboard_arrow_up</i><?= strtoupper($sport->name); ?></header>
                <ul class="inline-into-ul"style="height:auto; flex-wrap:wrap;">
                    <?php $myHourRef = ""; $k = 0?>
                    <?php  foreach ($params->pickups as $pickup):?>

                        <?php if($pickup->sport):?>
                            <?php if ($sport->sportId === $pickup->sport->sportId):?>

                                <?php $hourStart = date('H:i', strtotime($pickup->start));  $hourEnd = date('H:i', strtotime($pickup->end)); ?>
                                <?php if($myHourRef !=  $hourStart):?>
                                    <b style="display: inline-block; width: 100%;"><?= $hourStart;?> </b><br/>
                                <?php endif;?>
                                <?php $myHourRef = $hourStart;?>

                                <li class="tagLi inline-li <?php echo ($pickup->status != null) ? $pickup->status:'nopec';  ?>" data-id-child="<?php echo $pickup->child->childId; ?>" data-id-pickup="<?php echo $pickup->pickupActivityId; ?>" data-location="<?= (null != $pickup->location)? $pickup->location->locationId : ''; ?>"  data-end-hour="<?php echo str_replace(":", '',  $hourEnd); ?>"data-start-hour="<?php echo str_replace(":", '',  $hourStart); ?>"data-age="<?= showAge($pickup->child->birthdate); ?>"style="min-width: 150px;">
                                    <?php ($pickup->status == "npec") ? $colorName = "red" : $colorName = "darkblue";?>
                                    <a style="color: <?= $colorName;?>" id="a<?= $pickup->pickupActivityId; ?>"data-validated="<?= $pickup->validated; ?>" title href="javascript:void(0)"onmouseover="showGroups(<?= $pickup->pickupActivityId; ?>, <?= $pickup->child->childId ?>);getIdPickup(<?= $pickup->pickupActivityId; ?>) "onmouseout="hideTooltip()"onclick="getIdPickup(<?= $pickup->pickupActivityId; ?>); openRevealJS('action-pickupActivity') "data-id-pickup="<?= $pickup->pickupActivityId; ?>"data-registration="<?= (null != $pickup->registration)? $pickup->registration->registrationId : ''; ?>"data-age="<?= showAge($pickup->child->birthdate); ?>"data-child="<?= $pickup->child->childId; ?>"data-child-name="<?= $pickup->child->firstname . ' ' . $pickup->child->lastname; ?>"data-sport="<?= $pickup->sport->sportId; ?>"data-group = "<?php if (null != $pickup->groupActivities): foreach ($pickup->groupActivities as $groupActivity): echo $groupActivity->groupActivityId[0]; endforeach; else: echo 'aucun groupe '; endif ?>"data-photo="<?php if(null ==$pickup->child->photo ): echo IMG."no_photo.jpg"; else:  echo HOST.$pickup->child->photo; endif; ?>">
                                        <?= $pickup->child->firstname . ' ' . $pickup->child->lastname . ' ('.showAge($pickup->child->birthdate).') - ' . date('H:i', strtotime($pickup->start)) . ' - ' . date('H:i', strtotime($pickup->end)); ?>
                                    </a>
                                </li>
                            <?php endif;?>
                        <?php endif;?>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif;
    endforeach; ?>
</div>