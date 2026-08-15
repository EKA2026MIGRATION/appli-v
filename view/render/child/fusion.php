<?php $title = "Fusion de profil"?>
<?php use_helper('age');?>
<?php use_helper('photo');?>

<h1>Fusion de fiches</h1>

<?php foreach($params->childs as $child):?>

    <div style="border-radius: 10px; border: 1px solid black; box-shadow: 2px 2px 2px black; padding: 20px">
        <h4><span style='font-size: 14px; font-weight: bold'>#<?= $child->childId;?></span> <?= $child->firstname." ".$child->lastname; ?></h4>
        <select name="childIdList">
            <option value=""></option>
            <option value="<?= $child->childId;?>-TARGET" style="text-align: center">CIBLE</option>
            <option value="<?= $child->childId;?>-ORIGIN" style="text-align: center">Sources</option>
        </select>
        <div>
            <?php $persons = $child->persons;?>
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
                    </div>
                </div>
                
            <?php endforeach;?>

        </div>
    </div>
    <br/>

<?php endforeach;?>

<div class='text-center'>
    <button class='button'>
        Fusionner les éléments sélectionner
    </button>
</div>