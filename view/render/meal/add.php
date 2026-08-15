<?php use_helper('dates');?>
<?php $title = "Ajouter / Modifier un repas"; ?>

<input type="hidden" id="autoreturn" value="<?= $params->autoreturn;?>"/>
<input type="hidden" id="autoreturnUrl" value="<?= $params->returnUrl;?>"/>

<?php $update = 0; if(isset($params->meal->mealId)):  $update = 1; endif; ?>

<h2 class="text-center">
  <?= (1 === $update) ? 'Modifier' : 'Ajouter';  ?>  un repas
  <?php echo showDate($params->date);?>
</h2>


<div class="actionsPage"><a href="<?= $params->returnUrl;?>"> <button class="button"><i class="material-icons">arrow_back</i> </button> </a></div>

<div class="grid-container">
    <div class="medium-12 cell">
        <select id="selectStaff" name="person" required>
            <option value="0">Choisir un staff </option>
            <optgroup label="Repas pour moi">
                <option value="<?php echo PERSON_CONNECTED['personId']; ?>" selected><?php echo PERSON_CONNECTED['firstname']; ?> <?php echo PERSON_CONNECTED['lastname']; ?></option>
            </optgroup>
            <optgroup label="Repas pour un autre staff">
                <?php foreach($params->staff as $staff):?>
                    <option value="<?php echo $staff->person->personId; ?>"><?php if(isset($staff->person->personId)): ?> <?php echo $staff->person->firstname.' '.$staff->person->lastname; else: echo 'PAS DE PERSON'; endif; ?></option>
                <?php endforeach; ?>
            </optgroup>
        </select>
    </div>
</div>
<div class="grid-container">
    <div class="medium-12 cell">
      <section class="block-list" id="create_pickup">
          <div>
            <ul>
                 <li style="padding-left: 0;">
                    <a href="javascript:void(0)">
                        <div>
                            <p class="list-header second-row" style="padding-left: 0; margin-left: 1rem !important;">
                                Utiliser le staff ci-dessus pour le repas
                                <aside class="subtitles"></aside>
                                <div class="with-icon">
                                 <div class="switch">
                                    <input class="switch-input" type="checkbox" id="useStaff" onclick="changeStaff()">
                                    <label class="switch-paddle" for="useStaff"></label>
                                  </div>
                                </div>
                            </p>
                        </div>
                    </a>
                </li>
            </ul>
          </div>
      </section>
    </div>
</div>

<?php include("_mealForm.php");?>


<div class="medium-12 cell">
    <center><a href="<?= HOST ?>meal/add"><button class='button'>Ajouter un autre repas</button></a></center>
</div>

<p>* champ obligatoire</p>
<div class="space_actions_page_mobile"></div>
