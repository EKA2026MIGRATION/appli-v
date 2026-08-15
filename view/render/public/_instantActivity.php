<?php use_helper('photo');?>
<?php $groups = $params->groups; $i = 0?>

<?php if(!$groups):?>

    Pas d'activités

<?php endif;?>



<?php foreach($groups as $group):?>
    <div class="instantViewSlide" id="slide-<?= $i;?>" style="<?= ($i == 0) ? "display: flex" : "display:none";?>">

        <div class="instantViewRow">
            <?php foreach($group->staffs as $staff):?>
                <div class="showCoach">
                    <img src="<?= ($staff->photo != "") ? HOST.$staff->photo.randomValueCache() : IMG.'no_photo.jpg';  ?>" />
                    <h1><?= $staff->name;?></h1>
                </div>
            <?php endforeach;?>
            <div class="showGroupInfo">
                <div><?= $group->sport;?></div>
                <div><?= $group->start;?> - <?= $group->area;?></div>
            </div>
        </div>

        <div class="instantViewRow">
            <?php foreach($group->childs as $child):?>
                <?php include(VIEW.'render/public/_showChild.php');?>
            <?php endforeach;?>
                
        </div>

    </div>
    <?php $i++;?>

<?php endforeach;?>
