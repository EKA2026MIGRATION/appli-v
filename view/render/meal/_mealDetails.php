
<h5>Les enfants</h5>

<?php if($presences):?>
    <?php foreach($presences as $presence):?>

            <?php if($presence->status != "npec"):?>
                    <section class="block-list">
                        <ul>

                            <?php if(isset($mealChild) &&key_exists($presence->childId, $mealChild)):?>                    
                                <?= $mealChild[$presence->childId];?>
                            <?php else:?>
                                <?php if(!isset($arr[$presence->firstname.' '.$presence->lastname])):?>
                                    <?php echo liWithoutMeal($params->date, $presence->firstname.' '.$presence->lastname, $presence->childId, 'childId');?>
                                <?php endif;?>
                                <?php $arr[$presence->firstname.' '.$presence->lastname] = $presence->firstname.' '.$presence->lastname;?>
                            <?php endif;?>
                        </ul>
                    </section>
            <?php endif;?>
    <?php endforeach;?>
<?php else:?>
    Aucun enfant présent aujourd'hui
<?php endif;?>


<?php if(isset($mealPerson)):?>
    <h5>Coachs</h5>

    <?php if($presenceCoachs):?>
        <?php foreach($presenceCoachs as $presenceCoach):?>
                <?php $person = $presenceCoach->staff->person;?>
                <section class="block-list">
                    <ul>
                        <?php if(key_exists($person->personId, $mealPerson)):?>
                            <?= $mealPerson[$person->personId];?>
                        <?php else:?>
                            <?php if(!isset($arr[$person->firstname.' '.$person->lastname])):?>
                                <?php echo liWithoutMeal($params->date, $person->firstname.' '.$person->lastname, $person->personId, 'personId');?>
                            <?php endif;?>
                            <?php $arr[$person->firstname.' '.$person->lastname] = $person->firstname.' '.$person->lastname;?>
                        <?php endif;?>
                    </ul>
                  </section>
        <?php endforeach;?>
    <?php else:?>
        Aucun coach présent aujourd'hui
    <?php endif;?>
<?php endif;?>

<?php if(isset($mealFreeName)):?>
    <h5>Personnes ajoutées manuellement</h5>
    <?php foreach($mealFreeName as $liFreeName):?>
        <section class="block-list">
            <ul>
                <?= $liFreeName;?>
            </ul>
        </section>
    <?php endforeach;?>
<?php endif;?>

<?php if(isset($mealNoContext)):?>
    <h5>Personnes hors contexte</h5>
    <?php foreach($mealNoContext as $liNoContext):?>
        <section class="block-list">
            <ul>
                <?= $liNoContext;?>
            </ul>
        </section>
    <?php endforeach;?>
<?php endif;?>