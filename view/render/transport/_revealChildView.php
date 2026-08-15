<style>
    .button-document {
        font-weight: bold;
        border: 1px solid black;
        height: 40px;
        width: 40px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }

    . button-icon {
    }
</style>

<div class="dialog" style="display: none;" data-address="<?= $pickup->address; ?>" data-id-pickup="<?php echo $pickup->pickupId; ?>" id="dialog<?php echo $pickup->pickupId; ?>" title="<?= $pickup->child->firstname.' '.$pickup->child->lastname;?>">
    <div class="containerLoader" id="loaderFormEditPickUp" style="display: none;">
        <div class="lds-roller">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <ul class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
        <li class="mfb-component__wrap">
            <a href="javascript:void(0)" class="mfb-component__button--main">
                <i class="mfb-component__main-icon--resting material-icons">menu</i>
                <i class="mfb-component__main-icon--active material-icons">close</i>
            </a>
            <ul class="mfb-component__list">
                <?php foreach ($pickup->child->persons as $person) : ?>
                    <?php foreach ($person->phones as $phone) : ?>

                        <!--- version iphone --->
                        <?php //$message = "Bonjour, Energy Academy vous confirme la ".$kindText." de votre enfant %0a le ".date('d/m/Y', strtotime($params->date))." vers ".date('H:i', strtotime($pickup->start))."  %0a ".$pickup->address." . %0a Cordialement, ".$params->active_driver->person->firstname." - Energy Academy.";
                        ?>

                        <!-- version android -->
                        <?php $messageBeforeHour = 'Bonjour, Energy Kids Academy vous informe que votre chauffeur est en route pour la ' . $kindText . " de votre enfant. L'heure d'arrivée estimée est "; ?>
                        <?php $messageAfterHour = "à l'adresse. " . $pickup->address . ' . Cordialement, ' . $params->active_driver->person->firstname . ' - Energy Kids Academy.'; ?>
                        <?php $message = 'Bonjour, Energy Kids Academy vous confirme la ' . $kindText . ' de votre enfant le ' . date('d/m/Y', strtotime($params->date)) . ' vers ' . date('H:i', strtotime($pickup->start)) . ' ' . $pickup->address . ' . Cordialement, ' . $params->active_driver->person->firstname . ' - Energy Kids Academy.'; ?>
                        <?php $messageGroup = 'Bonjour, Energy Kids Academy vous confirme la ' . $kindText . ' de votre enfant le ' . date('d/m/Y', strtotime($params->date)) . ' vers ' . date('H:i', strtotime($pickup->start)) . ' ' . $pickup->address . ' . Cordialement, ' . $params->active_driver->person->firstname . ' - Energy Kids Academy.'; ?>

                        <li>
                            <a href="tel:<?php echo $phone->phone; ?>" data-mfb-label="Appeler <?= $phone->name; ?>" class="mfb-component__button--child">
                                <i class="mfb-component__child-icon material-icons">phone</i>
                            </a>
                        </li>

                        <li>
                            <a href="sms:<?php echo $phone->phone; ?>&body=<?php echo $message; ?>" data-mfb-label="SMS <?= $phone->name; ?>" class="mfb-component__button--child">
                                <i class="mfb-component__child-icon material-icons">sms</i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>

    <p class="lead">

        <span onclick="closeMyDialog(<?= $pickup->pickupId;?>)" style="background-color: darkblue; color: white; font-weight: bold; font-size: 1.2rem; padding: 10px; border-radius: 10px; cursor: pointer">
            FERMER
        </span>

        <div style="display: flex; align-content: center">

            <?php if($pickup->child->frontDocument != ''):?>
                <a href="<?= $pickup->child->frontDocument;?>" target="_blank" class="button-document">A</a>
            <?php endif;?>
            <?php if($pickup->child->frontQr != ''):?>
                <a href="<?= $pickup->child->frontQr;?>" target="_blank" class="button-document">QR</a>
            <?php endif;?>

            <a class="button-document" title="Imprimer reçu de <?= $kindText; ?>" target="_blank" href="<?= HOST; ?>transport/exportReceiptPickup/driver/<?= $params->active_driver->person->firstname . ' ' . $params->active_driver->person->lastname; ?>/pickupId/<?= $pickup->pickupId; ?>/">
                <i class="material-icons button-icon">receipt</i>
            </a>
            <a class="button-document" title="Télécharger la fiche contact" href="<?= HOST; ?>notification/vcf/type/child/id/<?= $pickup->child->childId; ?>/">
                <i class="material-icons button-icon">contact_phone</i>
            </a>
            

            <?php if(isset($pickup->registrationData)):?>
                <?php if ($pickup->registrationData->hasLunch && $pickup->kind == 'dropin' && date('Hi', strtotime($pickup->start)) < '1245'):?>
                    <?php $mealChild = 'meal-child'.$pickup->child->childId; ?>
                    <?php (isset($params->$mealChild)) ? $colorLunch = 'green' : $colorLunch = 'darkred'; ?>
                    <i class="material-icons button-document" id="lunchIconRide2<?= $pickup->pickupId; ?>">fastfood</i>
                <?php endif; ?>
            <?php endif;?>
            <button class="button nextPec" onclick="nextPec(this, <?= $pickup->pickupId; ?>)"
                <?php if ($pickup->status != 'pec' and $pickup->status != 'npec') : ?>
                    style="display:none;"
                <?php else :?>
                    style="margin: auto 0; font-size: 0.9rem"
                <?php endif; ?>
            > > </button>
        </div>

        <h2 style="color: #98061a; text-align: center; font-weight: bold">
            <?php echo showNewCustomer($pickup->child->createdAt); ?>
            <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?><br /><?= showAge($pickup->child->birthdate); ?>
            <?php if($pickup->lastDayOfWeek ==  date('Y-m-d', strtotime($pickup->start)) ):?>
                <span class="material-icons" style="font-size:24px">contactless</span>
            <?php endif;?>
        </h2>
        <div class="text-center"><?= showGender($pickup->child->gender);?></div>
        <div style="text-align: center; font-style: italic; color: black; font-weight: bold">
            <?php if ($pickup->child->medical != '') { echo 'Informations médicales :' . $pickup->child->medical;} ?>
            <br/>
        </div>

        <h5 style="text-align: center; font-weight: bold; color: darkblue">
            <?php if(isset($pickup->registrationData)):?>
                <?php if(count((array) $pickup->registrationData->productHours) > 0):?>
                    Présence en <?= strtolower(showMoment($pickup->registrationData->productHours[0]->start . ':00', $pickup->registrationData->productHours[0]->end . ':00')); ?>
                <?php endif;?>
            <?php endif;?>
        </h5>
        <div style="text-align: center;">
            <?php if ($pickup->child->pickupInstruction != '') : ?>
                <?php echo $pickup->child->pickupInstruction; ?>
            <?php else : ?>
                Le coach téléphone et j’accompagne mon enfant au minivan
            <?php endif; ?>
        </div>

    
    </p>

    <span class="iconRevealPEC" style="position: absolute; right:8px; top:8px;">
        <?= showIconStatus($pickup->status, $lastStatus); ?>
    </span>

    <div class="cadrePec">

        <img src="<?php echo ($pickup->child->photo != '') ? HOST . $pickup->child->photo : IMG . 'no_photo.jpg'; ?>">


        <div class="text">

            <p style="color: #182d61; font-size: 1.3em"> <?php echo $pickup->address; ?> </p>
            <p>
                <a href="maps://maps?q=<?php echo $pickup->address; ?>">Map</a> -
                <a href="https://waze.com/ul?q=<?php echo $pickup->address; ?>"> Waze </a>
            </p>

            <button class="button buttonStatus" onclick="changeStatus('pec', '<?php echo $pickup->pickupId; ?>')"><?= $kindText; ?></button>
            <button class="alert button buttonStatus" onclick="changeStatus('npec', '<?php echo $pickup->pickupId; ?>')"> Absent</button>
            <!--<button class="button buttonStatus" style="background-color: darkblue; border-color: darkblue;"  onclick="changePaid('<?php echo $pickup->pickupId; ?>')"> 180€ payé </button><br/>-->

            <p><strong>
                    <span class="phrasePec <?= $pickup->status; ?>">
                        <?php if ($pickup->status == 'pec') {
                            echo $kindText . ' le ' . showDate($pickup->updatedAt, 'd/m/y H:i:s');
                        } elseif ($pickup->status == 'npec') {
                            echo 'Absence confirmée le ' . date('d/m/Y à H:i:s', strtotime($pickup->updatedAt));
                        }
                        ?>
                    </span>

                    <a href="javascript:void(0)" class="deletePec" style="margin-bottom: 12px; <?php if ($pickup->status != 'pec' or $pickup->status != 'npec') {
                                                                                                    echo 'display:none;';
                                                                                                } ?>" onclick="changeStatus(null, '<?php echo $pickup->pickupId; ?>')">
                        Supprimer la prise en charge / absence
                    </a>

                </strong>
            </p>

            <?php if ($pickup->paymentDue != '') : ?>
                <?php $backPayementColor = "lightsalmon"; ?>
                <?php if ($pickup->paymentDone == '') $backPayementColor = "lightpink"; ?>
                <?php if ($pickup->paymentDone == $pickup->paymentDue) $backPayementColor = "lightblue"; ?>

                <span style="font-size: 18px; font-style: italic; color: darkblue; padding: 14px; border-radius: 10px; background-color: <?= $backPayementColor; ?>">

                    <img src="<?= IMG . "cash.svg"; ?>" style="width: 26px; padding-top: 16px" />

                    <?= $pickup->paymentDue; ?>

                    <i class="material-icons" style="font-size: 14px">euro</i>
                </span>
                <span>
                    <div class="payment-not-added" <?php if ($pickup->paymentDone != '') : ?> style="display: none; <?php endif; ?>">
                        <p>Insérez si un paiement est effectué :</p>
                        <input type="number" class="paymentDoneAdd" value="<?= $pickup->paymentDue; ?>" style="text-align: center; width: 80px; float: left" />
                        <button class="button" onclick="addPayment('<?= $pickup->pickupId; ?>')">VALIDEZ</button>
                    </div>

                    <div class="payment-added" <?php if ($pickup->paymentDone == '') : ?> style="display: none; <?php endif; ?>">
                        Paiement effectué : <span class="paymentDoneAmount"><?= $pickup->paymentDone; ?></span>
                        <div style="display: flex; justify-content: space-around; flew-wrap: wrap">
                            <input type="number" class="paymentDoneModify" value="<?= $pickup->paymentDone; ?>" style="text-align: center; width: 80px;" />
                            <button class="button" onclick="modifyPayment('<?= $pickup->pickupId; ?>')">Modifier</button>
                            <button class="button" onclick="cancelPayment('<?= $pickup->pickupId; ?>')">Annuler</button>
                        </div>
                    </div>
                </span>
            <?php endif; ?>

            <div style="font-size: 12px">
                Dernière heure de <?php if ($pickup->kind == 'dropin') : echo 'prise en charge';
                                    else : echo 'dépose';
                                    endif; ?>
                <br />
                <?php if (isset($pickup->child->latestPEC->status_change)) : ?>
                    <?php echo date('d/m/y H:i', strtotime($pickup->child->latestPEC->status_change->date)); ?>
                <?php else : echo 'Aucune information';
                endif; ?>
            </div>


            <p id="nextPecButton-<?= $pickup->pickupId; ?>">
                <script>
                    lastPickUp[<?= $ride->rideId; ?>] = <?= $pickup->pickupId; ?>;
                </script>
                <button class="button nextPec" onclick="nextPec(this, <?= $pickup->pickupId; ?>)" <?php if ($pickup->status != 'pec' and $pickup->status != 'npec') : ?> style="display:none;" <?php endif; ?>> Prise en charge suivante </button>
            </p>
            <div class="time_estimated" style="text-align: center; display: none;">Heure d'arrivée estimée : <span class="time"></span></div>


            <p>
                <?php if ($pickup->comment != '') : ?>
                    Commentaire : <span style="color: darkblue; font-weight: bold"><?= $pickup->comment; ?></span>
                <?php endif; ?>
            </p>

        </div>
    </div>

    <hr />
        <section class="block-list">
            <header>Téléphone personnel</header>
            <ul>
                <li style="height:50px; padding-left:0;">
                    <div>
                        <p class="list-subheader dark" style="padding-left: 0px;"><?= $pickup->child->phone; ?> </p>
                    </div>
                    <div class="with-icon" style="top: calc(50% - 0.7rem);">
                        <button href="javascript:void(0)" class="button nextSMS" style="display: none; margin-top: -16px; height: 30px; line-height: 0px; margin-right: 8px;" data-message-before="<?= $messageBeforeHour; ?>" data-message-after="<?= $messageAfterHour; ?>" data-phone="<?php echo $pickup->child->phone; ?>" onclick="sendSmsNextPec(this)">SMS heure d'arrivée</button>
                        <a href="tel:<?php echo $pickup->child->phone; ?>" >
                            <span>
                                <i class="material-icons" style="width:23px; font-size: 2em; margin-right: 20px;">phone</i>
                            </span>
                        </a>
                        <a class="smsMessagePerso" href="sms:<?php echo $pickup->child->phone; ?>&body=<?php echo $message; ?>" >
                            <span>
                                <i class="material-icons" style="width:23px; font-size: 2em">sms</i>
                            </span>
                        </a>
                    </div>
                </li>
            </ul>
        </section>

        <?php
        $phoneList = []; $addressList = [];
        $mealChild = 'meal-child'.$pickup->child->childId;


        foreach ($pickup->child->persons as $person):?>

        <div class="parent">

            <!--
                <h3> <?php echo $person->firstname . ' ' . $person->lastname . ' | ' . $person->relation; ?><a href="javascript:void(0)" onclick="openPerson(this, '<?= $person->personId; ?>')"> <i class="material-icons">keyboard_arrow_up</i></a></h3>
        -->
            <section class=" person<?= $person->personId; ?>">

                <section class="block-list">
                    <header>Téléphone(s)</header>
                    <ul>
                        <?php foreach ($person->phones as $phone) : ?>

                            <?php if (!in_array($phone->phone, $phoneList)) : ?>

                                <?php $phoneList[] = $phone->phone; ?>

                                <?php if($pickup->status != 'npec'):?>
                                    <?php require '_createSmsSendList.php'; ?>
                                <?php endif;?>

                                <li style="height:50px; padding-left:0;">
                                    <div>
                                        <p class="list-header" style="padding-left: 0px;"><?= $phone->name; ?></p>
                                        <p class="list-subheader dark" style="padding-left: 0px;"><?= $phone->phone; ?> </p>
                                    </div>
                                    <div style="flex: auto; padding-left: 20px">
                                        <i class="material-icons isPreferedButton" id="isPreferedButton-call-<?= $phone->phoneId; ?>" style="color: lightgray; margin-right: 20px">phone</i>
                                        <i class="material-icons isPreferedButton" id="isPreferedButton-sms-<?= $phone->phoneId; ?>" style="color: lightgray">message</i>
                                    </div>
                                    <div class="with-icon" style="top: calc(50% - 0.7rem);">
                                        <button href="javascript:void(0)" class="button nextSMS" style="display: none; margin-top: -16px; height: 30px; line-height: 0px; margin-right: 8px;" data-message-before="<?= $messageBeforeHour; ?>" data-message-after="<?= $messageAfterHour; ?>" data-phone="<?php echo $phone->phone; ?>" onclick="sendSmsNextPec(this)">SMS heure d'arrivée</button>
                                        <?php (in_array('call', array_map('trim', explode(',', $phone->isPrefered)))) ? $colorIsPrefered = 'green' : $colorIsPrefered = ''; ?>
                                        <a href="tel:<?php echo $phone->phone; ?>">
                                            <span>
                                                <i class="material-icons <?= $colorIsPrefered; ?>" id="isPreferedShow-call-<?= $phone->phoneId; ?>" style="width:23px; font-size: 2em; margin-right: 20px;">phone</i>
                                            </span>
                                        </a>
                                        <?php (in_array('sms', array_map('trim', explode(',', $phone->isPrefered)))) ? $colorIsPrefered = 'blue' : $colorIsPrefered = ''; ?>
                                        <a class="smsMessagePerso" href="sms:<?php echo $phone->phone; ?>&body=<?php echo $message; ?>">
                                            <span>
                                                <i class="material-icons <?= $colorIsPrefered; ?>" id="isPreferedShow-sms-<?= $phone->phoneId; ?>" style="width:23px; font-size: 2em">sms</i>
                                            </span>
                                        </a>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <!--- create the smsSendList --->


                        <?php endforeach; ?>
                    </ul>
                </section>

                <section class="block-list">
                    <header>Adresse(s)</header>
                    <ul>
                        <?php foreach ($person->addresses as $address) : ?>
                            <?php if (!in_array($address->address . $address->address2 . $address->postal . $address->town, $addressList)) : ?>
                                <?php $addressList[] = $address->address . $address->address2 . $address->postal . $address->town; ?>
                                <li style="height:auto; padding-left:0;">
                                    <div style="padding-right: 30px;">
                                        <p class="list-header" style="padding-left: 0px;"><?= $address->name; ?></p>
                                        <p class="list-subheader dark" style="padding-left: 0px;"><?= $address->address; ?>
                                            <?= $address->address2; ?> <br />
                                            <?= $address->postal; ?> - <?= $address->town; ?></p>
                                    </div>
                                    <div class="with-icon" style="top: calc(50% - 2rem);">

                                        <a style="font-size:22px;" href="https://www.google.com/maps/dir/<?php echo $address->address; ?> <?php echo $address->address2; ?>, <?php echo $address->postal; ?> - <?php echo $address->town; ?>/"><span><i class="material-icons">location_on</i></span> Maps</a><br />
                                        <a style="font-size:22px;" href="https://waze.com/ul?q=<?php echo $address->address; ?> <?php echo $address->address2; ?>, <?php echo $address->postal; ?> - <?php echo $address->town; ?>"><span><i class="material-icons">location_on</i></span> Waze</a>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <br />

                <a href="<?= HOST; ?>child/updateData/childId/<?= $pickup->child->childId; ?>/date/<?= $params->date; ?>/staffId/<?= $ride->staff->staffId; ?>/" title="mettre à jour depuis myclub">
                    <i class="material-icons" style="font-size: 50px">contact_phone</i>
                </a>

            </section>
        </div>
    <?php endforeach; ?>

    <?php if ($pickup->registrationData->hasLunch && $pickup->kind == 'dropin' && date('Hi', strtotime($pickup->start)) < '1245') : ?>
        <?php include '_addChildMeal.php'; ?>
    <?php endif; ?>


    <br /><br /><br /><br />

</div>