<?php use_helper('translation');?>
<br/><hr/><br/>

<?php $datas = $params->data;?>
<?php if(isset($datas->message)):?>
  <b style="color: darkblue; font-size: 20px">
    <?php if($datas->message == 'target_no_pickup') echo 'Pas de pickup trouvé sur la date cible';?>
    <?php if($datas->message == 'source_no_ride') echo 'Pas de trajet trouvé sur la date source';?>
  </b>
<?php endif;?>

<?php foreach($datas as $data):?>

    <?php if(isset($data->target_ride_created)):?>
          <h3>Trajets créés</h3>
          <?php foreach($data->target_ride_created as $moment => $rides):?>
                <h5><?= trans($moment);?></h5>
                <ul>
                    <?php foreach($rides as $ride):?>
                          <li><?= $ride;?></li>
                    <?php endforeach;?>
                </ul>
          <?php endforeach;?>
    <?php endif;?>

    <?php if(isset($data->target_child_associated_to_ride)):?>
          <hr/><br/>
          <h3>Enfants mis à jour dans les trajets</h3>
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


    <?php if(isset($data->target_child_exists_but_different_product)):?>
          <hr/><br/>
          <h3>Enfant présent MAIS avec un produit différent</h3>
          <div style="display: flex; flex-wrap: wrap">
            <?php foreach($data->target_child_exists_but_different_product as $staff_name):?>
                <div style="width: 300px; "><?= $staff_name;?></div>
            <?php endforeach;?>
          </div>
    <?php endif;?>

    <?php if(isset($data->no_start_time_for)):?>
          <hr/><br/>
          <h3>Enfant présent MAIS posant un pb d'horaire (à vérifier)</h3>
          <div style="display: flex; flex-wrap: wrap">
            <?php foreach($data->no_start_time_for as $staff_name):?>
                <div style="width: 300px; "><?= $staff_name;?></div>
            <?php endforeach;?>
          </div>
    <?php endif;?>

    <?php if(isset($data->address_changed)):?>
          <hr/><br/>
          <h3>Enfant dont l'adresse a changé</h3>
          <div style="display: flex; flex-wrap: wrap">
            <?php foreach($data->address_changed as $staff_name):?>
                <div style="width: 300px; "><?= $staff_name;?></div>
            <?php endforeach;?>
          </div>
    <?php endif;?>


<?php endforeach;?>
