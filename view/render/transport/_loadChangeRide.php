<?php use_helper('photo, translation'); ?>
<?php $backcolors = ['AMdropin' => '#FFDC00', 'AMdropoff' => '#3D9970', 'PMdropin' => '#3D9970', 'PMdropoff' => '#FF851B']; ?>
<section class="block-list loadChangeRide">
    <li style="padding: 16px 0;"><a href="javascript:void(0)" data-close onclick="changeRide('npec')">
            <div>
                <p class="list-header">Déplacer vers "Prise en charge / Dépose"</p>

                </p>
            </div>
        </a>
    </li>

    <?php
    $arrRide = [];
    foreach ($params->rides as $ride) {

        $start = str_replace(':', '', $ride->start);
        ($start < '120000') ? $moment = "AM" : $moment = "PM";
        (isset($ride->staff->staffId)) ? $driver = $ride->staff->person->firstname : $driver = "PAS DE DRIVER";
        $arrRide[$moment][$ride->kind][$driver][] = $ride;
    }
    arsort($arrRide); ?>


    <?php foreach ($arrRide as $moment => $elements) : ?>
        <div style="text-align: center; font-size: 18px; background-color: darkblue; color: white; font-weight: bold; padding: 16px"><?= $moment; ?></div>
        <?php foreach ($elements as $kind => $myrides) : ?>
            <?php ksort($myrides); ?>
            <div style="text-align: center; font-size: 16px; text-align: center; color: darkblue; padding: 16px; font-weight: bold">
                <?php echo trans($kind . 'All') ?>
            </div>
            <?php foreach ($myrides as $drivername => $rides) : ?>
                <?php foreach ($rides as $ride) : ?>
                    <li style="padding: 16px 0; background-color: <?= $backcolors[$moment . $kind]; ?>">
                        <a href="javascript:void(0)" data-close onclick="changeRide('<?php echo $ride->rideId; ?>')">
                            <div>
                                <p class="list-header">
                                    <?php if (isset($ride->staff->staffId)) : ?> <?php echo $ride->staff->person->firstname;
                                                                                else : echo 'PAS DE DRIVER';
                                                                                endif; ?>
                                    - <?php echo $ride->name; ?> - <?php echo $ride->start; ?>

                                </p>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</section>