<script>
    const forceActivityToGroup = (pickupActivityId, selectId) => {

        let select = document.getElementById(selectId);
        let selectIndex = select.selectedIndex;
        let groupId = select.options[selectIndex].value;

        $(".loading").show();

        let url = "https://api.appli-v.net/pickup-activity/addTogroup/"+pickupActivityId+"/"+groupId;

        console.log(url);

        $('#showMessage'+selectId).load(url, function(response) {
            $(".loading").hide();
            $('#showMessage'+selectId).html("<span style='color: darkgreen'>Activité de l'enfant ajoutée au groupe</span>");
            $('#selectBar'+selectId).hide();

        });
    }
</script>
<?php use_helper('translation');?>
<br/><hr/><br/>

<?php $data = $params->data->messages;?>



<?php if(isset($data->message)):?>
  <b style="color: darkblue; font-size: 20px">
    <?php if($data->message == 'no_activity_on_target_day') echo "Pas d'activité trouvée sur la date cible";?>
    <?php if($data->message == 'no_groups_founded_in_source') echo "Pas de groupes trouvées sur la date source";?>
  </b>
<?php endif;?>





<?php if(isset($data->child_founded_and_updated) && ($data->child_founded_and_updated)):?>
        <hr/><br/>
        <h3>Enfants trouvé et mis à jour sur la cible</h3>
        <div style="display: flex; flex-wrap: wrap">
        <?php $arr = [];?>
        <?php foreach($data->child_founded_and_updated as $name):?>
            <?php if(!in_array($name, $arr)):?>
                <div style="width: 300px; "><?= $name;?></div>
                <?php $arr[] = $name;?>
            <?php endif;?>
        <?php endforeach;?>

        </div>
<?php endif;?>

<?php if(isset($data->child_founded_but_has_not_sport_source_on_target) && ($data->child_founded_but_has_not_sport_source_on_target)):?>
        <hr/><br/>
        <h3>Enfant trouvé MAIS pas de sport sur la date cible </h3>
        <div style="display: flex; flex-wrap: wrap">
            <?php $arr = [];?>
            <?php foreach($data->child_founded_but_has_not_sport_source_on_target as $name):?>
                    <?php if(!in_array($name, $arr)):?>
                        <div style="width: 300px; "><?= $name;?></div>
                        <?php $arr[] = $name;?>
                    <?php endif;?>
            <?php endforeach;?>
        </div>

        <hr/>
        <h4>Forcer les affectations</h4>
        <?php $increment = 0; foreach($params->forcedChildList as $e):?>

            <?php $increment++;?>
            <?php $selectId = "selectGroup".$e['childListElements']->pickup_activity_id.$increment;?>

            <div style="border: 1px black solid; border-radius: 10px; padding: 15px">

                    <b><?php echo $e['childListElements']->child_name.'</b> était prévu(e) en '.$e['childListElements']->sport_name_start;?><br/>
                    <div style="color: darkblue">
                        Groupe de départ:<br/>
                        <?php unset($staffArray);foreach($e['childListElements']->group_start_staff as $staff):?>
                            <?php $staffArray[] = $staff->staffName;?>
                        <?php endforeach;?>
                        <?php  ($e['childListElements']->group_start_age > 1) ? $age = $e['childListElements']->group_start_age : $age = '/'; ;?>
                        Staff:  <?php echo implode(',', $staffArray);?> - <?= $age ?> ans - <?= $e['childListElements']->group_start_time;?>
                       
                        
                    </div>
                    <div id="selectBar<?= $selectId ?>" style="display: flex; ">

                        <i style="line-height: 40px; margin-right: 20px">Forcer l'inscription sur un groupe &nbsp;</i>

                        <select name="selectGroup" id="<?= $selectId ?>" style="width: 300px; border-radius: 30px; background-color: lightblue; color: black; margin-right: 20px; height: 40px;">

                            <optgroup label="Meilleure(s) correspondance(s)">
                                <?php foreach($e['groups']->ideal as $g):?>
                                    <option value="<?= $g->groupdId;?>" selected><?= $g->groupInfo?></option>
                                <?php endforeach;?>
                            </optgroup>

                            <optgroup label="Correspondance(s) possible(s">

                                <?php foreach($e['groups']->match as $g):?>
                                    <option value="<?= $g->groupdId;?>"><?= $g->groupInfo?></option>
                                <?php endforeach;?>
                            </optgroup>

                            <optgroup label="Autre(s)">
                                <?php foreach($e['groups']->basic as $g):?>
                                    <option value="<?= $g->groupdId;?>"><?= $g->groupInfo?></option>
                                <?php endforeach;?>
                            </optgroup>

                        </select>

                        <button class="button" onclick="forceActivityToGroup(<?= $e['childListElements']->pickup_activity_id;?>, '<?= $selectId;?>')" style="border-radius: 30px; height: 40px;">Ajouter au groupe</button>
                    
                        
                    
                    </div>

                    <div id="showMessage<?= $selectId;?>">
                    </div>
            </div>

        <?php endforeach;?>

<?php endif;?>

<?php if(isset($data->child_founded_but_cant_add_to_lunch) && ($data->child_founded_but_cant_add_to_lunch)):?>
        <hr/><br/>
        <h3>Enfant avec un repas au départ sans repas prévu à l'arrivée </h3>
        <div style="display: flex; flex-wrap: wrap">
        <?php $arr = [];?>
        <?php foreach($data->child_founded_but_cant_add_to_lunch as $name):?>
            <?php if(!in_array($name, $arr)):?>
                <div style="width: 300px; "><?= $name;?></div>
                <?php $arr[] = $name;?>
            <?php endif;?>
        <?php endforeach;?>
        </div>
<?php endif;?>

<?php if(isset($data->child_founded_but_presence_is_not_compatible) && ($data->child_founded_but_presence_is_not_compatible)):?>
        <hr/><br/>
        <h3>Enfant trouvé MAIS la présence n'est pas compatible (différente à vérifier) </h3>
        <div style="display: flex; flex-wrap: wrap">
        <?php $arr = [];?>
        <?php foreach($data->child_founded_but_presence_is_not_compatible as $name):?>
            <?php if(!in_array($name, $arr)):?>
                <div style="width: 300px; "><?= $name;?></div>
                <?php $arr[] = $name;?>
            <?php endif;?>
        <?php endforeach;?>
        </div>
<?php endif;?>

<?php if(isset($data->staff_not_founded_on_target_day) && ($data->staff_not_founded_on_target_day)):?>
        <hr/><br/>
        <h3>Staff non présents le jour cible</h3>
        <div style="display: flex; flex-wrap: wrap">
        <?php $arr = [];?>
        <?php foreach($data->staff_not_founded_on_target_day as $name):?>
            <?php if(!in_array($name, $arr)):?>
                <div style="width: 300px; "><?= $name;?></div>
                <?php $arr[] = $name;?>
            <?php endif;?>
        <?php endforeach;?>
        </div>
<?php endif;?>