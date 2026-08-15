<?php $title = ""?>
<style>
    .title { background-color: darkblue!important; color: white!important;}
</style>


<h1>Liste des enfants par école</h1>



<table class="table">

        <?php foreach($params->childs as $schoolId => $list):?>
            <?php $currentSchool = $params->schools->$schoolId;?>
            <tr class="title">
                <td/>
                <td><b><?php echo $currentSchool->name;?></b></td>
                <td>
                    <?= $currentSchool->address.', '.$currentSchool->postal.' '.strtoupper($currentSchool->town);?>
                </td>
            </tr>
            <?php $i = 1; foreach($list as $childData):?>
                <tr>
                    <td><?= $i;?></td>
                    <td><?= $childData->fullname;?></td>
                    <td><?= $childData->age.' ans';?></td>
                </tr>
            <?php $i ++; endforeach;?>
        <?php endforeach; ?>
</table>

