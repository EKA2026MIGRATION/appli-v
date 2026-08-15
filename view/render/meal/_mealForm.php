<form method="post" id="mealForm" action="meal/<?= (1 === $update) ? 'modify/'.$params->meal->mealId : 'create';  ?>">
    <div class="grid-container">
        <div class="grid-x grid-padding-x food_associated">
            <?php if(isset($viewCoach) && $viewCoach == 1):?>
                <input type="hidden" id="personId" name="person" value="<?= $currrentStaffId ?>">
                <input type="hidden" id="date" name="date" value="<?= $currentDate;?>"/>
            <?php else:?>
                <div class="medium-6 cell">
                    <label>Nom de l'enfant*
                        <?php (1 === $update && null !== $params->meal->child) ?  $val = $params->meal->child->firstname . ' ' . $params->meal->child->lastname: $val = '';  ?>
                        <?php if(isset($params->child)) $val = $params->child->firstname.' '.$params->child->lastname;?>
                        <input type="search" id="autocompleteListChild"  placeholder="Nom de l'enfant" value="<?= $val;?>" >
                        <?php (1 === $update && null !== $params->meal->child ) ?  $val = $params->meal->child->childId: $val = ''; ?>
                        <?php if(isset($params->child)) $val = $params->child->childId;?>
                        <input type="hidden" id="childId" name="child" value="<?= $val ?>">
                    </label>
                </div>

                <div class="medium-6 cell">
                    <label>Nom de la personne*
                        <?php (1 === $update && null !== $params->meal->person ) ?  $val = $params->meal->person->firstname . ' ' . $params->meal->person->lastname: $val = ''; ?>
                        <?php if(isset($params->person)) $val = $params->person->firstname.' '.$params->person->lastname;?>
                        <input type="search" id="autocompleteListPerson" placeholder="Nom de la personne" value="<?= $val ?>" >
                        <?php (1 === $update && null !== $params->meal->person) ?  $val = $params->meal->person->personId: $val = '';?>
                        <?php if(isset($params->person)) $val = $params->person->personId?>
                        <input type="hidden" id="personId" name="person" value="<?= $val ?>">
                    </label>
                </div>

                <div class="medium-6 cell">
                    <label> Nom libre*
                        <input type="text" id="freeName" name="freeName" placeholder="Saisir un nom" value="<?= (1 === $update && null !== $params->meal->freeName) ?  $params->meal->freeName: '';  ?> ">
                    </label>
                </div>
            

                <div class="medium-6 cell">
                    <label> Date *
                        <input type="text" id="datepicker"  placeholder="Choisir une date" value="<?= (1 === $update) ? date('d/m/Y', strtotime($params->meal->date)): date('d/m/Y', strtotime($params->date));  ?>" required" >
                    </label>
                    <input type="hidden" id="date" name="date" value="<?= (1 === $update) ? $params->meal->date: $params->date; ?>">
                </div>

            <?php endif;?>


            <div class="medium-6 medium-offset-3 cell">
                <?php foreach($params->foodCategories as $categorie=>$value): ?>
                    <fieldset class="fieldset">
                        <legend><?= $value ?> </legend>
                        <div class="radioImg">
                            <?php foreach($params->foods as $food):
                                if ($categorie === $food->kind && 'active'=== $food->status): ?>
                                    <label>
                                        <input
                                            <?php if (1 === $update):
                                                foreach ($params->meal->foods as $foodAsso):
                                                    if ($foodAsso->foodId === $food->foodId):
                                                        echo "class='asso-food'"; echo "checked=''";
                                                    else:
                                                        echo '';
                                                    endif;
                                                endforeach;
                                            endif ?> 
                                            type="checkbox" value="<?= $food->foodId ?>" onclick="addClass(this)"> <!-- TODO enlever le onClick -->
                                        <img src=<?= ($food->photo != "") ? HOST.$food->photo : IMG.'no_photo.jpg';  ?>>
                                    </label>
                                <?php endif;
                            endforeach ?>
                        </div>
                    </fieldset>
                <?php endforeach ?>
            </div>
            <div class="medium-12 cell">
                <center><input type="submit" class="button large" value="Envoyer" /></center>
            </div>
        </div>
    </div>
</form>