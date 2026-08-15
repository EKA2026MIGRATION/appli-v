<?php use_helper('photo');?>
<?php if(!isset($hideElement)) $hideElement = null;?>

<?php foreach ($presences as $presence):?>

    <?php if (showDate($presence->date, 'W') != $week):?>
        <?php if ($week != 0) { echo '</div>';} ?>
        <br/>
        <div style="min-width: 250px">
        <div style="font-weight: bold; text-align: left; padding-left: 20px">Semaine <?= showDate($presence->date, 'W'); ?></div>
    <?php endif; ?>
    <?php $moment = showMoment($presence->start, $presence->end); ?>
    <?php if (isset($presence->registration->registrationId)):?>
            <?php $group = 'liRegistrationGroup'.$presence->registration->registrationId; ?>       
    <?php endif; ?>
    <?php ($presence->status == "npec") ? $color="color: red" : $color = "color: black" ;?>
    <li id="<?= $presence->childPresenceId; ?>" 
                class="liPresenceElement <?= $group; ?>"
                data-element = "liElement" 
                data-registration-group= "<?= $group; ?>" 
                style="cursor: pointer; background-color: <?= showColorMoment(showMomentShort($moment)); ?>; <?= $color;?>" 
                title="<?= showTime($presence->start).' '.showTime($presence->end); ?>">
        <?php if(!$hideElement):?>
            <input  class="checkbox-childPresence" 
                        type="checkbox" 
                        style="position: relative; left: 0px"
                        onclick="selectMultiplePresence(<?= $presence->childPresenceId;?>)"
                        value='checkbox-childPresence-<?= $presence->childPresenceId; ?>' 
                        />
        <?php endif;?>
        <?php echo showIcon($presence->category);?>

        

        <?php if(isset($presence->product_is_offered) && $presence->product_is_offered == 1) echo showIcon('offert', null, 'png')?>


        <?= showDate($presence->date, 'l d F Y'); ?>
        <?php if (isset($presence->location->locationId)):?>
            <span style="font-style: italic; font-size: 10px; <?= $color;?>"><?= $presence->location->name;?></span>
        <?php endif ;?>
    </li>
    <?php $week = showDate($presence->date, 'W'); ?>
<?php endforeach; ?>
</div>
