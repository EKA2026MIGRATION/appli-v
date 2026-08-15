<?php $ride = $params->ride;
      $lastStatus = 'first'; ?>
<?php
$hour = date('H:i', strtotime($ride->start));
foreach ($ride->pickups as $pickup):

    if ($pickup->validated != 'validated'):
        $class = 'noValidateRide';
    else:
        $class = '';
    endif;
endforeach; ?>
<section  id="ride<?= $ride->rideId; ?>" class="<?= $ride->kind; ?>Block block-list <?= (true === $ride->locked) ? 'isLocked' : ''; ?> <?= $class; ?>" data-startPoint="<?php echo $ride->startPoint; ?>" data-endPoint="<?php echo $ride->endPoint; ?>"  data-id-ride="<?php echo $ride->rideId; ?>" data-start="<?php echo $params->date; ?> <?php echo $ride->start; ?>" data-hour="<?php echo str_replace(':', '', $hour); ?>" data-driver="<?php echo $ride->staff->staffId; ?>">

    <header><i class="material-icons arrow">keyboard_arrow_up</i>
        <span id="rideHeaderName-<?php echo $ride->rideId; ?>">
            <?php echo $ride->name; ?> -
            <?php if (isset($ride->staff->staffId)): ?>
                <?php echo $ride->staff->person->firstname; else: echo 'PAS DE DRIVER'; ?>
            <?php endif; ?>
            -
            <?php echo $ride->start; ?>
        </span>
         -
         <span class="nbPlaces">0</span>
        /
        <span class="nbPlacesMax">
            <?php echo ($ride->places == null) ? '8' : $ride->places; ?>
        </span>
        <div class="icons_trajet">
            <?php include '_linksActionPickup.php'; ?>
        </div>
    </header>
    <ul style="position: relative;">
        <div style="padding:20px;">

            <div style="display: flex">
                <aside>
                    <span class="numberOrder letter letterDeparture ride-<?= $ride->rideId; ?>">A</span>
                </aside>
                <aside><strong> Départ : </strong> <?= $ride->startPoint; ?></aside>
                <input
                    type="checkbox"
                    class="checkboxRideFixed checkboxDeparture"
                    onclick="saveDispatch('', <?= $ride->rideId; ?>)"
                    checked
                    style="display: none;"
                />
            </div>
            <div style="display: flex">
                <aside>
                    <span class="numberOrder letter letterArrive ride-<?= $ride->rideId; ?>">A</span>
                </aside>
                <aside><strong> Arrivé : </strong> <?= $ride->endPoint; ?></aside>
                <input
                    type="checkbox"
                    class="checkboxRideFixed checkboxArrival"
                    onclick="saveDispatch('', <?= $ride->rideId; ?>)"
                    checked
                    style="display: none;"
                />
            </div>
            <strong> Heure d'arrivée : </strong> <?= $ride->arrival; ?>
        </div>

        <?php
        $nbStop = 0; $nbStopLetter = 0; $nbChild = 0; $currentAdd = '';
        $alphabet = range('A', 'Z');
        foreach ($ride->pickups as $pickup):
            $nbChild++; if ($currentAdd != $pickup->address) {
                ++$nbStop;
            }
            $currentAdd = $pickup->address;
            $hour = date('H:i', strtotime($pickup->start)); ?>

            <?php ($pickup->status == 'npec') ? $statusPickup = 'npecPickup' : $statusPickup = 'pecPickup'; ?>

            <li class="<?= $statusPickup; ?> <?php echo ($pickup->status != null) ? $pickup->status : 'nopec'; ?>" data-age="<?= showAge($pickup->child->birthdate);?>" data-id-pickup="<?php echo $pickup->pickupId; ?>" data-address="<?php echo $pickup->address; ?>" data-kind="<?php echo $pickup->kind; ?>">
                <a href="javascript:void(0)" data-hour="<?php echo str_replace(':', '', $hour); ?>" onclick="getIdPickup('<?php echo $pickup->pickupId; ?>');openRevealJS('action-pickup')">
                    <div class="<?php echo ($pickup->status != null) ? $pickup->status : 'nopec'; ?>">
                        <span class="numberOrder number ride-<?= $ride->rideId; ?> <?php echo showNewCustomerColor($pickup->child->createdAt); ?>" id="pickupOrder-<?php echo $pickup->pickupId; ?>"><?= $nbStop; ?></span>
                        <?php if ($pickup->status != 'npec'): $nbStopLetter++; ?>
                            <span class="numberOrder letter ride-<?= $ride->rideId; ?> <?php echo showNewCustomerColor($pickup->child->createdAt); ?>" id="pickupOrder-<?php echo $pickup->pickupId; ?>"><?= $alphabet[$nbStopLetter]; ?></span>
                        <?php endif; ?>
                        <p class="list-header" data-id-child="<?= $pickup->child->childId; ?>" style="padding-left:0px; margin-left:0px;">
                            <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?> - <?php echo showAge($pickup->child->birthdate); ?> - <strong class="timePickup">  <?php echo date('H:i', strtotime($pickup->start)); ?> </strong>
                             <?php if ($pickup->paymentDue != ''): ?>
                              <span style="font-size: 12px; font-style: italic; color: darkblue;">
                                - Paiement en attente : <?= $pickup->paymentDue; ?> - Paiement effectué : 
                                <?php if ($pickup->paymentDone != ''): ?>
                                  <?= $pickup->paymentDone; ?>
                                <?php else: ?>
                                  aucun
                                <?php endif; ?>
                              </span>
                            <?php endif; ?>
                            <?php if (isset($pickup->category)) {
                echo showIcon($pickup->category);
            } ?>
                            <aside class="subtitles padding-left-0">
                                <?= $pickup->address; ?> <br/>
                                <i class="comment-child-transport"><?= $pickup->child->comment; ?></i>
                            </aside>
                        </p>

                    </div>

                </a>

                <div class="with-checkbox" style="display: none;">
                    <?php if ($pickup->status != 'npec'): ?>
                        <input
                            type="checkbox"
                            class="checkboxRideFixed"
                            onclick="saveDispatch('', <?= $ride->rideId; ?>)"
                            checked
                        />
                    <?php endif; ?>
                </div>
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
        <?php endforeach; ?>
    </ul>
    <button onclick="unLockRide(this)" class="unlock button withIcon <?= (true === $ride->locked) ? '' : 'displayNone'; ?>"><i class="material-icons">lock_key</i> Débloquer ce trajet </button>
</section>