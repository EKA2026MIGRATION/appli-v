<div class="reveal" id="revealPEC<?php echo $pickup->pickupActivityId; ?>" data-reveal>

  <div class="containerLoader" id="loaderFormEditPickUp" style="display: none;"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>


  <p class="lead"><?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?> </p>
  <div class="cadrePec">

  <img src="<?php echo ($pickup->child->photo != "") ? HOST.$pickup->child->photo : IMG.'no_photo.jpg';  ?>" >

  <div class="text">


    <button class="button buttonStatus"  onclick="changeStatus('pec', '<?php echo $pickup->pickupActivityId; ?>')" >Présent</button>
    <button class="alert button buttonStatus"  onclick="changeStatus('npec', '<?php echo $pickup->pickupActivityId; ?>')"> Absent</button> <br/>

    <p><strong>
        <span class="phrasePec <?= $pickup->status; ?>">
        <?php if($pickup->status == "pec")
        {
            echo 'Présence confirmée '.showDate($pickup->updatedAt, 'd/m/y H:i:s');
        }
        elseif($pickup->status == "npec")
        {
            echo 'Absence confirmée le '.date('d/m/Y à H:i:s', strtotime($pickup->updatedAt));
        }
        ?>


        </span>
        <a href="javascript:void(0)"  class="deletePec" style="margin-bottom: 12px; <?php if($pickup->status != "pec" OR $pickup->status != "npec") { echo 'display:none;'; } ?>"  onclick="changeStatus(null, '<?php echo $pickup->pickupActivityId; ?>')"> 
                Supprimer la présence / absence
        </a>

    </strong>
    </p>
  </div>
  </div>

   <hr/>

   <?php $child = "child".$pickup->child->childId;
   	$mealChild = "meal-child".$pickup->child->childId;
   foreach($params->$child->persons as $person):?>

   <div class="parent">
    <h2> <?php echo $person->firstname.' '.$person->lastname.' | '.$person->relation; ?><a href="javascript:void(0)" onclick="openPerson(this, '<?= $person->personId; ?>')"> <i class="material-icons">keyboard_arrow_up</i></a></h2>
        <section  class=" person<?= $person->personId; ?>">
        <p class="lead">Téléphones </p>
        <div id="person_phone">
            <?php foreach($person->phones as $phone):?>
                <div class="card-wrap horizontal" id="blockPhone<?= $phone->phoneId; ?>">
                    <div class="card-img-container">
                        <figure>
                            <i class="material-icons">phone</i>
                        </figure>
                    </div>

                    <div class="card-info">
                        <div class="card-primary">
                            <figure>
                                <p class="card-title"><?= $phone->name; ?></p>
                                <p><?= $phone->phone; ?> </p>
                            </figure>
                        </div>


                        <div class="card-secondary">
                            <a href="tel:<?php echo $phone->phone; ?>" ><span><i class="material-icons">phone</i></span> Appeler</a>
                            <a href="sms:/<?php echo $phone->phone; ?>/?body=Bonjour, Energy Academy vous confirme la prise en charge de votre enfant le <?php echo date('d/m/Y', strtotime($params->date)); ?> à <?php echo date('H:i', strtotime($pickup->start)); ?>. Cordialement l'équipe Energy Academy." ><span><i class="material-icons">sms</i></span> SMS</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <p class="lead">Adresses </p>
    <?php foreach($person->addresses as $address):?>


      <div class="card-wrap horizontal" id="blockAdress<?= $address->addressId; ?>">

          <div class="card-img-container">
              <figure>
                <i class="material-icons">location_on</i>
              </figure>
          </div>

          <div class="card-info">
              <div class="card-primary">
                  <figure>
                      <p class="card-title"> <?= $address->name; ?></p>
                      <?= $address->address; ?>
                      <?= $address->address2; ?>
                      <br/> <?= $address->postal; ?> - <?= $address->town; ?>
                  </figure>
              </div>

              <div class="card-secondary">
                  <a href="https://www.google.com/maps/dir/<?php echo $address->address; ?> <?php echo $address->address2; ?>, <?php echo $address->postal; ?> - <?php echo $address->town; ?>/"><span><i class="material-icons">location_on</i></span> Maps</a>
                  <a href="https://waze.com/ul?q=<?php echo $address->address; ?> <?php echo $address->address2; ?>, <?php echo $address->postal; ?> - <?php echo $address->town; ?>"><span><i class="material-icons">location_on</i></span> Waze</a>
              </div>

          </div>
      </div>


     <?php endforeach; ?>
   </section>


  </div>
  <?php endforeach; ?>


   <hr/>

      <h2>Repas</h2>
      <section class="repas">
      <?php $update = 0; if(isset($params->$mealChild)): $update = 1; endif; ?>


        <form method="post" class="mealForm" action="meal/<?= (1 === $update) ? 'modify/'.$params->$mealChild->mealId : 'create';  ?>">
            <div class="grid-container">
                <div class="grid-x grid-padding-x food_associated">
                    <input type="hidden" value="<?php echo $pickup->child->childId; ?>" name="child">
                    <input type="hidden" name="date" value="<?= $params->date; ?>">

                    <div class="medium-12 small-12 cell">
                        <?php foreach($params->foodCategories as $categorie=>$value): ?>
                            <fieldset class="fieldset">
                                <legend><?= $value ?> </legend>
                                <div class="radioImg">
                                    <?php foreach($params->foods as $food):
                                        if ($categorie === $food->kind && 'active'=== $food->status): ?>
                                            <label>
                                                <input
                                                    <?php if (1 === $update):
                                                        foreach ($params->$mealChild->foods as $foodAsso):
                                                            if ($foodAsso->foodId === $food->foodId):
                                                                echo "class='asso-food'"; echo "checked=''";
                                                            else:
                                                                echo '';
                                                            endif;
                                                        endforeach;
                                                    endif ?> type="checkbox" value="<?= $food->foodId ?>" onclick="addClass(this)"> <!-- TODO enlever le onClick -->
                                                <img src=<?= ($food->photo != "") ? HOST.$food->photo : IMG.'no_photo.jpg';  ?>>
                                            </label>
                                        <?php endif;
                                    endforeach ?>
                                </div>
                            </fieldset>
                        <?php endforeach ?>
                    </div>
                    <div class="medium-12 cell text-center">
                       <input type="submit"  class="button large" value="Envoyer" />
                    </div>
                </div>
            </div>
        </form>

    </section>

  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
