<?php use_helper('photo');?>
<?php $groups = $params->groups;?>
<script>
    var group;
</script>
<?php if(!$groups):?>
    Pas de transport
<?php else :?>

    <?php if($params->age != 0):?>
        <h2 style="text-align: center; font-family: 'Arial', sans-serif; color: #2c3e50; margin-bottom: 20px;">Départ de l'après-midi</h2>

        <div style="display: flex; flex-wrap: wrap; justify-content: space-around">

            <?php $allstaffs = []; ?>
            <?php foreach ($groups as $group): ?>
                <?php $staff_name = $group->staff->name; ?>
                <?php $staff_photo = $group->staff->photo; ?>
                <div style="display: flex; flex-wrap: wrap; border: 6px solid darkred; margin-bottom: 20px" id="group-staff-<?= $staff_name?>">

                    <?php $i = 0;?>
                    <?php foreach ($group->pickups as $pickup): ?>

                        <?php if ($pickup->child->age > $params->age) continue; ?>
                        <?php $i++;?>
                        <?php if(!in_array($staff_name, $allstaffs)):?>
                            <div style="text-align: center; background-color: darkred; color: white; font-weight: bold">
                                <?= $staff_name ?><br/>
                                <img style="width : 120px;" src="<?= ($group->staff->photo != "") ? HOST.$group->staff->photo.randomValueCache() : IMG.'no_photo.jpg';  ?>" />
                            </div>
                            <?php $allstaffs[] = $staff_name; ?>
                        <?php endif;?>

                        <div style="text-align: center">
                            <?= $pickup->child->firstname ?><br/>
                            <img style="width : 120px;" src="<?= ($pickup->child->photo != "") ? HOST.$pickup->child->photo.randomValueCache() : IMG.'no_photo.jpg';  ?>" />
                            <!--<img style="width : 150px;" src="<?= IMG.'no_photo.jpg';  ?>" />-->
                        </div>

                    <?php endforeach; ?>
                </div>
                <?php if($i == 0):?>
                    <script>
                        group = document.getElementById('group-staff-<?= $staff_name?>');
                        group.style.display = 'none';
                    </script>

                <?php endif;?>
            <?php endforeach; ?>
        </div>
    <?php else :?>
        <div style="display: flex; flex-wrap: wrap; justify-content: space-around; margin: 20px; font-size: 20px">
            <?php foreach($groups as $group):?>
                <div style="border: 3px solid darkred; background-color: white; border-bottom-left-radius: 36px; border-bottom-right-radius: 36px; margin: 20px">
                        <?php if($group->staff):?>
                            <div style="padding: 10px; background-color: darkblue; color: white; font-weight: bold; font-family: Arial, Helvetica, sans-serif">
                                <b><?= $group->staff->name;?></b><br/>
                                <span>
                                    <?= $group->name;?>
                                </span>
                            </div>
                        <?php endif;?>
                        <ul style="list-style: none; margin: 0; padding: 0; padding-left: 10px" >
                            <?php foreach($group->pickups as $pickup):?>
                                <li><?php echo $pickup->child->firstname.' <b>'.$pickup->child->lastname;?></b></li>
                            <?php endforeach;?>
                        </ul>
                </div>
            <?php endforeach;?>
        </div>

    <?php endif;?>

<?php endif;?>