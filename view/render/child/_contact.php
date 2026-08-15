<?php $persons = $params->child->persons;?>
<div class="tabs-panel" id="panel4">
    <?php foreach($persons as $person):?>
        <div class="card-wrap horizontal" id="cardPerson-<?= $person->personId;?>" style="height: auto">
            <div class="card-img-container">
                <figure>
                    <i class="material-icons">face</i>
                </figure>
            </div>
            <div class="card-info">
                <div class="card-primary with second">
                    <figure>
                        <p class="card-title">
                            <?= $person->firstname.' '.$person->lastname;?>
                            <br>
                            <i style="font-weight: normal; font-size: 14px; text-align: left">
                                <?= $person->relation;?>
                            </i>
                        </p>
                        <p>
                            <?php $arrayAddr = [];?>
                            <?php foreach($person->addresses as $address):?>
                                <?php $currentAddr = $address->address.', '.$address->postal.' '.$address->town;?>
                                <?php if(!in_array($currentAddr, $arrayAddr)):?>
                                    <li>
                                        <b><?= $address->name;?></b>
                                        <?= $currentAddr ?>
                                    </li>
                                    <?php $arrayAddr[] = $currentAddr;?>
                                <?php endif;?>
                            <?php endforeach;?>
                        </p>

                        <p>
                            <?php $arrayTel = [];?>
                            <?php foreach($person->phones as $phone):?>
                                <?php $currentTel = $phone->phone;?>
                                <?php if(!in_array($currentTel, $arrayTel)):?>
                                    <li>
                                        <b><?= $phone->name;?></b>
                                        <?= $currentTel ?>
                                        <span style="font-size: 18px">
                                            <?= showIcoPrefered($phone->isPrefered);?>
                                        </span>
                                    </li>
                                    <?php $arrayTel[] = $currentTel;?>
                                <?php endif;?>
                            <?php endforeach;?>
                        </p>

                        <p>
                            Email : <?= $person->email;?>
                        </p>


                        <p>
                            Personnes associées :
                            <ul>
                                <?php foreach($person->relations as $personA):?>
                                    <li><?= $personA->firstname.' '.$personA->lastname;?></li>
                                <?php endforeach;?>
                            </ul>
                        </p>

                    </figure>
                </div>
                <div class="card-secondary">
                    <a href="<?= HOST ?>person/display/id/<?= $person->personId; ?>/">Modifier<span><i class="material-icons">mode_edit</i></span></a>
                    
                    <a href="#" data-personId = "<?=$person->personId;?>" data-link="<?= $params->child->childId?>/<?= $person->personId;?>" class="removeLink">
                        Désassocier<span><i class="material-icons">do_not_disturb</i></span>
                        </a>
                                    
                </div>
            </div>
        </div>
        
    <?php endforeach;?>
</div>
