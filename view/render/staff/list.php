<?php require_once(HELPER.'formTools.php');?>

<?php $title="Liste du personnel "; ?>

<?php $list_role = ['ROLE_COACH', 'ROLE_DRIVER', 'ROLE_MANAGER'];?>
<?php if(hasRole('ADMIN')) $list_role[] = 'ROLE_ADMIN';?>
<?php $staffProtected = [75, 76, 77];?>

<input type="hidden" id="isAdmin" value="<?= hasRole('ADMIN');?>" name="isAdmin"/>

<h1> Liste du personnel </h1>

<?php if(hasRole('ADMIN')):?>
<div  data-closable class="callout alert-callout-subtle success">
    <strong>Profil de tests</strong> pour les Admin uniquement
    <ul>
      <li>Ellen Ripley
        <ul>
          <li>Profil : Coach</li>
          <li>login : ellen@ripley.com</li>
          <li>password: ellenRipley</li>
        </ul>
      </li><!--
      <li>Ayrton Senna
        <ul>
          <li>Profil : Driver</li>
          <li>login : ayrton@senna.com</li>
          <li>password: ayrtonSenna</li>
        </ul>
      </li>
      <li>Ion Tiriac
        <ul>
          <li>Profil : Manager</li>
          <li>login : ion@tiriac.com</li>
          <li>password: ionTiriac</li>
        </ul>
      </li>-->
    </ul>
</div>
<?php endif;?>


<!--
<div class="reveal mobile-ios-modal" id="action-driver" data-reveal>

  <div class="mobile-ios-modal-options-stacked">
    <button data-close class="button" onclick="editDriver();openRevealJS('createDriver')">Actions</button>
    <?php if(hasRole('ADMIN')):?>
      <button data-close class="button" onclick="deleteDriver()">Supprimer</button>
    <?php endif;?>
    <button data-close class="button" style="color:red;">Fermer</button>
  </div>
</div>-->


<?php include('_createDriverFormDetails.php');?>

<div class="text-center"><button class="button margin-right-10" onclick="changerActionDriver();openRevealJS('createDriver')"> Ajouter une personne au Staff</button></div>

<section class="block-list">
  <ul id="driverList">
      <?php foreach($params->staff as $staff):?>


            <?php if($staff->staffId == 70) continue;?>

            <?php (in_array($staff->staffId, [75, 76, 77]) || $staff->isActive == 0 ) ? $backStyle  = "background-color: lightgrey" : $backStyle  ='';?>
            <li id="li-driver-<?php echo $staff->staffId; ?>" data-id-driver="<?php echo $staff->staffId; ?>" data-id-person="<?php echo $staff->person->personId; ?>" style="<?= $backStyle;?>">
              <a class="barUserInformation" href="javascript:void(0)" onclick="editDriver('<?php echo $staff->staffId; ?>');openRevealJS('createDriver')" >
                <div>
                  <p class="list-header">
                    <img src="<?php echo ($staff->person->photo != "") ? HOST.$staff->person->photo : IMG.'no_photo.jpg';  ?>" class="width-30 height-30" />

                    <?php echo "<span style='font-size:12px; font-style: italic'>#".$staff->staffId.'</span> '.$staff->person->firstname; ?>
                    <?php echo $staff->person->lastname; ?>
                      <?php if($staff->kind != ""):?>
                        <?php if( $staff->kind == "driver") echo "<i class='material-icons' style='font-size:10px'>directions_cars</i>"?>
                        <?php //if ('trainee' === $staff->kind): echo 'stagiaire'; else: echo $staff->kind; endif; ?>
                      <?php endif;?>
                      <?= (null != $staff->maxChildren)? " Enfants pris en charge : ".$staff->maxChildren : '';?>
                    <div class="with-icon">
                      <i class="material-icons">edit</i>
                    </div>
                  </p>
                </div>
              </a>


              <div class="actionUserPanel" style="position: relative; text-align: right">

                <!--- update role --->
                <span id="listRoleUser-<?= $staff->person->myIdentifier;?>">
                      <?php if(isset($staff->person->roles)):?>

                                <?php $user_roles = $staff->person->roles;?>
                                <?php foreach($user_roles as $role):?>
                                  <?php if($role != "ROLE_USER"):?>
                                    <?php (!in_array('ROLE_ADMIN', $user_roles) || hasRole('ADMIN')) ? $class = "roleStaffUserToDelete" : $class = "roleStaffUserUndelete"?>
                                    <?php if( in_array($staff->staffId, $staffProtected) && !hasRole('ADMIN')) $class = "roleStaffUserUndelete";?>
                                    <span title="Click to delete" class="<?= $class;?>" id="roleStaffUserToDelete-<?= $staff->person->myIdentifier;?>-<?= $role;?>-<?= $staff->staffId;?>">
                                      <?= str_replace('ROLE','ACCES', $role);?>
                                    </span>
                                  <?php endif;?>
                                <?php endforeach;?>

                                <?php if(!in_array('ROLE_ADMIN', $user_roles) || hasRole('ADMIN')   ) :?>

                                    <?php if( !in_array($staff->staffId, $staffProtected) || hasRole(['ADMIN'])):?>
                                        <select name="role_staff" id="selectRole-id-<?= $staff->person->myIdentifier?>-<?= $staff->staffId;?>" class="updateRoleSelect">
                                            <option value="">+</option>
                                            <?php foreach($list_role as $r):?>
                                                <option value="<?= $r;?>" <?php if(in_array($r, $user_roles)):?>disabled="disabled"<?php endif?>>
                                                  <?= str_replace('ROLE','ACCES', $r);?>
                                                </option>
                                            <?php endforeach;?>
                                        </select>

                                        <?php if(!in_array($staff->staffId, $staffProtected)) :?>
                                              <input class="checkboxIsActive" id="checkboxIsActive-<?= $staff->staffId;?>" type="checkbox" <?php if($staff->isActive == 1) { echo "checked" ;};?>/>
                                              &nbsp;
                                        <?php endif;?>



                                    <?php endif;?>

                                <?php endif;?>

                      <?php else :?>

                                <!--- set person to user --->
                                <input type="email" placeholder="Ajouter l'email d'un user pour créer un compte" id="addUserEmail-<?= $staff->staffId;?>" class="addUserEmail"/>

                                <div class="showUserListByEmail" id="showUserList-<?= $staff->staffId;?>">
                                </div>

                      <?php endif;?>
                </span>
                

              </div>
            </li>
      <?php endforeach ?>
  </ul>
</section>

<div class="text-center margin-top-12" >
  <button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreDriver"> Afficher plus </button>
</div>

<input type="hidden" id="pageSearch">
<input type="hidden" id="lastStaffId">
<input type="hidden" id="lastIdDriver">

<input id="urlApi" value="<?= API;?>" type="hidden">
