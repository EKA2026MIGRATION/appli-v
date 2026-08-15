<?php $title = "Recherche une personne"; ?>
<h3 class="text-center margin-top-20"><?= $title;?></h3>

<form method="post" id="searchForm" action="<?= HOST.'person/doSearch' ;?>">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="medium-4 cell">
                <label>Numéro de téléphone
                    <input type="text" id="number" name="number" placeholder="Numéro" value="<?= $params->data['number'];?>">
                </label>
            </div>
            <div class="medium-4 cell">
                <label>Nom de famille
                    <input type="text" id="name" name="name" placeholder="Nom" value="<?= $params->data['name'];?>">
            </div>
            <div class="medium-4 cell">
                <label>Nom de l'enfant
                    <input type="text" id="childname" name="childname" placeholder="Nom" value="<?= $params->data['childname'];?>">
            </div>

            <div class="medium-12 cell">
                <center><input type="submit" class="button large margin-top-20" value="Rechercher" /></center>
            </div>
        </div>
    </div>
</form>

<?php if(isset($params->result) && !$params->result->error):?>
    <section class="block-list">
        <ul id="personList">
            <?php foreach($params->result as $element):?>
                <li>
                    <a href="<?= HOST ?>person/display/id/<?= $element->person->id; ?>/">
                        <div>
                            <p class="list-header">
                                <?= $element->person->firstname." ".$element->person->lastname; ?>

                                <span style="color: darkblue">
                                    &nbsp;&nbsp;&nbsp;
                                    <?= implode( ', ' , (array) $element->phone);?>
                                </span>

                                <span style="color: black; font-style: italic;">
                                    <?php $arr = []; foreach($element->child as $child):?>
                                        <?php $arr[] = $child->firstname." ".$child->lastname; ?>
                                    <?php endforeach;?>
                                    <?php if(count((array) $arr) > 0):?>
                                        &nbsp;&nbsp;&nbsp;
                                        <?= implode(',' , $arr);?>
                                    <?php endif;?>
                                </span>

                                <div class="with-icon">
                                    <i class="material-icons">send</i>
                                </div>
                            </p>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>

        </ul>
    </section>
<?php else :?>

    Aucun résultat

<?php endif;?>
