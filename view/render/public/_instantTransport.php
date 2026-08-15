<?php use_helper('translation');?>
<?php use_helper('photo');?>

<?php $groups = $params->groups; $i = 0?>

<?php if(!$groups):?>

    Pas de transport

<?php elseif ($params->time >= '14'):?>




<?php else :?>

    <?php foreach($groups as $group):?>



        <div class="instantViewSlide" id="slide-<?= $i;?>" style="<?= ($i == 0) ? "display: flex" : "display:none";?>">

            <div class="instantViewRow">
                <?php if($group->staff):?>
                    <div class="showCoach">
                        <img src="<?= ($group->staff->photo != "") ? HOST.$group->staff->photo.randomValueCache() : IMG.'no_photo.jpg';  ?>" />
                        <h1><?= $group->staff->name;?></h1>
                    </div>
                <?php endif;?>
                <div class="showGroupInfo">
                    <div class="rSfxTitle"><?= trans($group->kind.'TV');?></div>
                    <div class="rSfxTitle">
                        <?= $group->name;?>
                        <?= $group->start;?>
                    </div>
                </div>
            </div>       


            <div class="instantViewRow">
                <?php foreach($group->pickups as $pickup):?>
                    <?php $child = $pickup->child;?>
                    <?php include(VIEW.'render/public/_showChild.php');?>
                <?php endforeach;?>
                    
            </div>
        
        </div>
        <?php $i++;?>

        

<?php endforeach;?>

<?php endif;?>