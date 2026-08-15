<script>
    console.log('reload');
</script>
    <section style="display: flex; flex-wrap: wrap; justify-content: space-around">
    <?php foreach($params->rides as $ride): ?>
            <div class="realTime-ride" style="">
                <div class="realTime-title" style="font-size: 16px; background-color: lightgray; padding: 10px; color: darkblue; font-weight: bold">
                        <?php echo $ride->name; ?> -
                        <?php if(isset($ride->staff->staffId)): ?>
                            <?= $ride->staff->person->firstname;?>
                        <?php else:?>
                            PAS DE DRIVER
                        <?php endif; ?>
                </div>
                <ul class="realTime-content">
                            <?php foreach($ride->pickups as $pickup):?>
                                        <?php ($pickup->status=="pec") ? $liColor = "color: MediumSeaGreen" : $liColor = "";?>

                                        <?php if($pickup->status == "npec") $liColor = "color: darkred";?>

                                        <li style="<?= $liColor;?>; border-bottom: 1px solid lightgray">
                                                <?php echo $pickup->child->firstname; ?> <?php echo $pickup->child->lastname; ?>
                                                <?php if( strlen($pickup->child->medical) > 0):?>
                                                    <i class="material-icons" style="color: darkblue" title="<?php echo $pickup->child->medical;?>">local_hospital</i>
                                                <?php endif;?>
                                                <?php if($pickup->paymentDue != ""):?>
                                                          <?php ($pickup->paymentDue == $pickup->paymentDone) ? $payment_color = "darkgreen" : $payment_color = "darkred";?>
                                                          <div style="font-style: italic; font-size: 2px; width: 20px; float: right; color: <?= $payment_color;?> ">
                                                              <i class="material-icons" style="font-size: 14px">euro_symbol</i>
                                                          </div>
                                                <?php endif;?> 
                                                <span class="hourPrevShown">
                                                    - <?php echo date('H:i', strtotime($pickup->start)); ?>
                                                </span>
                                                /
                                                <span class="hourRealShown">
                                                    <?php if($pickup->status=="pec"):?>
                                                        <?php echo date('H:i', strtotime($pickup->statusChange)); ?>
                                                    <?php endif;?>
                                                </span>
                                                <?php if($params->showAddress == "show"):?>
                                                    <span class="addressShown">
                                                        <br/>
                                                        <?php echo $pickup->address; ?>
                                                    </span>
                                                <?php endif;?>
                                        </li>

                            <?php endforeach; ?>

                            <?php if($params->kind == "dropoff" && $params->moment == "pm"):?>
                                <?php if($ride->report != ""):?>
                                    <?php $isGood = true;?>
                                    <?php foreach($ride->report as $rep):?>
                                        <?php $repArray = get_object_vars($rep);?>
                                        <?php foreach($repArray as $response => $question):?>
                                            <?php if($response == "bad")  { echo '<span style="color: red; font-style: italic; font-size: 13px">'.$question.'</span><br/>'; $isGood = false;};?>
                                            <?php if($response == "noanswer")  { echo '<span style="color: orange; font-style: italic; font-size: 13px">'.$question.'</span><br/>'; $isGood = false;};?>

                                        <?php endforeach;?>
                                    <?php endforeach;?>
                                    <?php if($isGood == true) { echo '<i class="material-icons" style="color: darkgreen">thumb_up_off_alt</i>';};?>
                                <?php else:?>
                                    <i class="material-icons" style="color: lightgrey">help</i>
                                <?php endif;?>
                            <?php endif;?>
                </ul>
            </div>
    <?php endforeach; ?>
    </section>

