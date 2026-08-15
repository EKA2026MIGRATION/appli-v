<?php use_helper('dates'); ?>
<?php use_helper('translation'); ?>
<?php if (null != $params->pickups):?>
        <?php foreach ($params->pickups as $month => $allPickups): ?>

            <h5 style="text-align: center"><?= showDate($month, 'F - Y'); ?></h5>

            <ul style="display: flex; flex-wrap: wrap;">
                <?php foreach ($allPickups as $week => $pickups):?>
                    <div style="min-width: 250px; margin-right: 10px">
                        <div style="font-weight: bold; text-align: left; padding-left: 20px; ">Semaine <?= $week; ?></div>
                        <?php $currentDate = "";?>
                        <?php foreach ($pickups as $pickup):?>
                            <li style="display: block;">
                                
                                <?php (!$pickup->ride) ? $style = 'background-color: #FBEBEA' : $style = ''; ?> 
                                <?php if($currentDate != showDate($pickup->start, 'l d F')) echo showDate($pickup->start, 'l d F').'<br/>'; ?>
                                <?php $currentDate = showDate($pickup->start, 'l d F');?>
                                <div class="calendarDivLine" style="<?= $style; ?>; padding: 4px; border: 1px solid grey; border-radius: 10px">
                                    <b><?= trans($pickup->kind); ?></b>
                                    Heure prévue: <?= showTime($pickup->start, 'H:i'); ?>
                                    <?php if ($pickup->status == 'pec'):?>
                                        <span style="font-style: italic; font-size: 2px; width: 20px; color: darkgreen">
                                            <i class="material-icons" style="font-size: 11px">airport_shuttle</i>
                                        </span>
                                        &nbsp;
                                    <?php endif; ?>

                                    <?php if ($pickup->paymentDue != ''):?>
                                        <?php ($pickup->paymentDue == $pickup->paymentDone) ? $payment_color = 'darkgreen' : $payment_color = 'darkred'; ?>
                                        <div style="font-style: italic; font-size: 2px; width: 20px; float: right; color: <?= $payment_color; ?> ">
                                            <i class="material-icons" style="font-size: 11px">euro_symbol</i>
                                        </div>
                                    <?php endif; ?> 
                                    <br/>
                                    <span style="font-size: 12px; font-style: italic">
                                        <?= $pickup->address; ?>
                                    </span>
                                    <?php //if($pickup->ride->rideId != "") echo '<br/>'.$pickup->ride->name.' '.showTime($pickup->ride->start);?>
                                    <?php //if($pickup->ride->rideId != "") echo ' - <span style="color: darkblue">'.$pickup->driver.'</span>';?>
                                    <?php if ($pickup->paymentDue != '') { echo '<br/>Montant du : '.$pickup->paymentDue.' €';} ?>
                                    <?php if ($pickup->paymentDone != '') { echo '<br/>Montant payé : '.$pickup->paymentDone.' €';} ?>
                                </div>



                            </li>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </ul> 
            <br/><br/>         
        <?php endforeach; ?>
                  
        <div class='text-center'><button class='button' onclick='deleteAllPickups()'>Supprimer les transports sélectionnés</button></div>

<?php else: ?>
        <ul><li><p>Aucune transport enregistré.</p></li></ul>
<?php endif; ?>