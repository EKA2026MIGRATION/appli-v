<?php if(isset($pickup->child->childId)):?>
    <?php $hour = date('H:i', strtotime($pickup->start)); ?>

    <li data-name="<?= $pickup->child->lastname;?>" data-postal="<?= $pickup->postal;?>" class="<?php echo ($pickup->status != null) ? $pickup->status:'NPEC';  ?>" data-hour="<?php echo str_replace(":", '',  $hour); ?>" data-id-pickup="<?php echo $pickup->pickupId; ?>" data-address="<?php echo $pickup->address; ?>">
        <a href="javascript:void(0)" onclick="getIdPickup('<?php echo $pickup->pickupId; ?>');openRevealJS('action-pickup')" data-kind="<?php echo $pickup->kind; ?>" >
            <div>
                <p class="list-header padding-left-0 margin-left-0 padding-right-0" data-id-child="<?= $pickup->child->childId; ?>">
                    <?php echo $pickup->child->lastname; ?> <?php echo $pickup->child->firstname; ?> - <?php echo showAge($pickup->child->birthdate); ?>  - 
                    <span class="timePickup"
                          style="font-weight: bold; background-color: <?php if($pickup->currentSession) echo showColorMoment(showMoment($pickup->currentSession->start, $pickup->currentSession->end));?> ">&nbsp;<?php echo $hour; ?>&nbsp;</span>
   
                    <?php if( strlen($pickup->child->medical) > 0):?>
                        <i class="material-icons" style="color: darkblue" title="<?php echo $pickup->child->medical;?>">local_hospital</i>
                    <?php endif;?>
                    <?php if(isset($pickup->category)) echo showIcon($pickup->category); ?>

                    <?php if(isset($pickup->registrationData)):?>
                        <?php if($pickup->registrationData->productIsOffered == 1) echo showIcon('offert', null, 'png');?>
                    <?php endif;?>

                    <?php if($pickup->lastDayOfWeek ==  date('Y-m-d', strtotime($pickup->start)) ):?>
                        <span class="material-icons" style="font-size:18px">contactless</span>
                    <?php endif;?>

                    <?php echo showNewCustomer($pickup->child->createdAt);?>
                    <?php if($pickup->paymentDue != ''): ?>
                        <span style="font-size: 12px; font-style: italic; color: darkblue;">
                            - Paiement en attente : <?= $pickup->paymentDue; ?> - Paiement effectué : 
                            <?php if($pickup->paymentDone != ''): ?>
                            <?= $pickup->paymentDone; ?>
                            <?php else: ?>
                            aucun
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>

                    <aside class="subtitles padding-left-0">
                        <?= $pickup->address; ?> <br/>
                        <i class="comment-child-transport"><?= $pickup->child->comment; ?></i>
                    </aside>
                </p>
            </div>
        </a>
        <div class="with-icon">
            <?php
                showIconStatus($pickup->status, $lastStatus);
                $lastStatus = $pickup->status;
            ?>
        </div>

        <div class="with-select">
        <div class="rideDropDown" onclick="openRideDropdown(this)"></div>
        </div>
    </li>
<?php else:?>
    <li class="NPEC" style="display: bloc!important; background-color: lightsteelblue">
        <p class="list-header padding-left-0 margin-left-0 padding-right-0" style="color: darkred; font-style: italic">
        Le pickup <?= $pickup->pickupId;?> n'a pas d'enfant - 
        <?php if(isset($pickup->registration) && isset($pickup->registration->registrationId)):?>
            Il est lié à l'inscription <?= $pickup->registration->registrationId;?>
        <?php endif;?>
        </p>
    </li>
<?php endif;?>