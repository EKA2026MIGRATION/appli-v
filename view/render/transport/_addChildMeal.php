<hr/>
        <h4>Repas</h4>
        <section class="repas">

        <?php $update = 0; if(isset($params->$mealChild)): $update = 1; endif; ?>

            <strong class="alertCustom redAlert repasPrempli" <?php if(isset($pickup->child->latestMeal->mealId) and $update == 0): ?> style="display:block;" <?php endif; ?>> Pré-remplissage avec le dernier repas.</strong>

            <strong class="alertCustom redAlert repasNok" <?php if(!isset($pickup->child->latestMeal->mealId) and $update == 0): ?> style="display:block;"<?php endif; ?>>Aucun repas a été ajouté.</strong>

            <strong class="alertCustom greenAlert repasOk"  <?php if($update == 1): ?> style="display:block;" <?php endif; ?>> Repas pris en compte.</strong>


            <form method="post" class="mealForm" action="meal/<?= (1 === $update) ? 'modify/'.$params->$mealChild->mealId : 'create';  ?>">
                <div class="grid-container">
                    <div class="grid-x grid-padding-x food_associated">
                        <input type="hidden" value="<?php echo $pickup->child->childId; ?>" name="child">
                        <input type="hidden" name="date" value="<?= $params->date; ?>">
                        <div class="medium-12 small-12 cell">
                            <?php foreach($params->foodCategories as $categorie=>$value): ?>
                                <fieldset class="fieldset" style="padding: 0px">
                                    <legend style="font-size: 12px"><?= $value ?> </legend>
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
                                                        else:
                                                            if(isset($pickup->child->latestMeal->mealId)):

                                                            foreach ($pickup->child->latestMeal->allfoods as $foodAsso):
                                                                if ($foodAsso->foodId === $food->foodId):
                                                                    echo "class='asso-food'"; echo "checked=''";
                                                                else:
                                                                    echo '';
                                                                endif;
                                                            endforeach;

                                                            endif;

                                                        endif ?> type="checkbox" value="<?= $food->foodId ?>" onclick="addClass(this)"> <!-- TODO enlever le onClick -->
                                                    <?php if($food->photo != ""):?>
                                                        <img src=<?= ($food->photo != "") ? HOST.$food->photo : IMG.'no_photo.jpg';  ?>>
                                                    <?php endif;?>
                                                </label>
                                            <?php endif;
                                        endforeach ?>
                                    </div>
                                </fieldset>
                            <?php endforeach ?>
                        </div>
                        <div class="medium-12 cell text-center">
                            <input type="submit"  class="button large" id="submitMealButton<?= $pickup->pickupId;?>" value="Envoyer" style="margin-bottom: 50px;">
                        </div>
                    </div>
                </div>
            </form>
        </section>