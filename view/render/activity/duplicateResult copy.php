<?php use_helper('translation');?>
<br/><hr/><br/>

<?php $datas = $params->data;?>
<?php if(isset($datas->message)):?>
  <b style="color: darkblue; font-size: 20px">
    <?php if($datas->message == 'no_target_activities') echo "Pas d'activité trouvée sur la date cible";?>
    <?php if($datas->message == 'source_no_groups') echo "Pas d'activité trouvée sur la date source";?>
  </b>
<?php endif;?>

<?php foreach($datas as $data):?>

    <?php if(isset($data->target_ride_created)):?>
          <h3>Groupes créés</h3>
          <?php foreach($data->target_ride_created as $moment => $rides):?>
                <h5><?= trans($moment);?></h5>
                <ul>
                    <?php foreach($rides as $ride):?>
                          <li><?= $ride;?></li>
                    <?php endforeach;?>
                </ul>
          <?php endforeach;?>
    <?php endif;?>

    <?php if(isset($data->target_child_associated_to_group)):?>
          <hr/><br/>
          <h3>Enfants mis à jour dans les groupes</h3>
          <div style="display: flex; flex-wrap: wrap">
            <?php foreach($data->target_child_associated_to_ride as $child_name):?>
                <div style="width: 300px; "><?= $child_name;?></div>
            <?php endforeach;?>
          </div>
    <?php endif;?>


    <?php if(isset($data->target_child_not_in_target)):?>
          <hr/><br/>
          <h3>Enfants non présents le jour cible</h3>
          <div style="display: flex; flex-wrap: wrap">
            <?php foreach($data->target_child_not_in_target as $child_name):?>
                <div style="width: 300px; "><?= $child_name;?></div>
            <?php endforeach;?>
          </div>
    <?php endif;?>


    <?php if(isset($data->target_staff_absent)):?>
          <hr/><br/>
          <h3>Staffs absents le jour cible</h3>
          <div style="display: flex; flex-wrap: wrap">
            <?php foreach($data->target_staff_absent as $staff_name):?>
                <div style="width: 300px; "><?= $staff_name;?></div>
            <?php endforeach;?>
          </div>
    <?php endif;?>

<?php endforeach;?>
