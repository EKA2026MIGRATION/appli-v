<div id="showSmsSendList">

      <button id="closeSmsModal" class="button">X</button>

      <?php foreach($smsList as $title => $parts):?>

                    <?php (is_object($person)) ? $person_name = $person->firstname.' '.$person->lastname : $person_name = "inconnu";?>

                    <?php $smsList[$kindText][$pickup->child->firstname.' '.$pickup->child->lastname][$person_name][] = ['name' => $phone->name, 'number' => $phone->phone, 'message' => $message] ;?>

                      <h3 class="kindRide"><?= $title;?></h3>

                      <?php foreach($parts as $rideName => $elements):?>

                           <div class="rideName">
                                 <?= $rideName;?>
                           </div>

                                        <?php foreach($elements as $person => $elements):?>

                                              <?php $i = 0;?>

                                              <ul style="list-style-type: none;">


                                                          <?php foreach($elements as $tel => $datas):?>

                                                                       <?php $i++;?>

                                                                       <?php $telInfos = explode('-', $tel);?>
                                                                       <?php $number = $telInfos[0]; $typeNumber = $telInfos[1];?>


                                                                       <!-- show message only the firstime -->
                                                                        <?php if($i == 1):?>

                                                                                          <?php $reference = "ref-".sha1(date('YmdHis')).rand(0,10000);?>

                                                                                          <?php foreach($datas as $k => $d):?>
                                                                                                <?php $child_list_name[] = $d['child_name'];?>
                                                                                                <?php $pickupId_arr[] = $d['pickupId'];?>
                                                                                          <?php endforeach;?>

                                                                                          <?php $pickupId_string = implode('-', $pickupId_arr);?>
                                                                                          <?php $child_string = implode(', ', $child_list_name);?>

                                                                                          <?php $messageShow =  str_replace('[child_name_data]', '<span style="color: darkblue; font-weight: bold">'.$child_string.'</span>', $d['message']);?>
                                                                                          <?php $messageShow = str_replace(['%0a', '\n'], '<br/>', $messageShow);?>
                                                                                          <?php $messageEdit = str_replace('<br/>', '', $messageShow);?>

                                                                                          <?php $messageSent =  str_replace('[child_name_data]', $child_string, $d['message']);?>

                                                                                          <!-- show data -->
                                                                                          <span style="font-size: 1.1em; color: darkblue; font-weight: bold">
                                                                                                <?= $child_string;?>
                                                                                          </span>
                                                                                          <br/>
                                                                                          <div style="text-align: center; font-weight: bold">Message envoyé par SMS</div>
                                                                                          <div style="border-radius: 4px; border: 1px solid black; padding: 10px">
                                                                                              <textarea rows="9" id="<?= $reference;?>"><?= $messageSent;?></textarea>
                                                                                            <?php //echo $messageShow;?>
                                                                                          </div>
                                                                                          <br/>


                                                                        <?php endif;?>




                                                                        <?php if($number != ""):?>

                                                                                          <?php $addClass = ""; $infoSmsSentString = ""?>
                                                                                          <?php //echo '<pre>'; print_r($datas); echo '<pre>';?>

                                                                                          <?php foreach($datas as $pu):?>
                                                                                                      <?php if($pu['smsSentData'] != null) :?>
                                                                                                            <?php $p = 0; foreach($pu['smsSentData'] as $infoSmsSentData):?>
                                                                                                                        <?php if($number == $infoSmsSentData->number):?>

                                                                                                                                    <?php $addClass= 'smsSent';?>

                                                                                                                                    <?php if($p > 0) $infoSmsSentString .= ', ';?>
                                                                                                                                    <?php $p++;?>
                                                                                                                                    <?php $infoSmsSentString .= ' le '.showDate($infoSmsSentData->timeSent, 'd/m H:i');?>


                                                                                                                        <?php endif;?>
                                                                                                            <?php endforeach;?>
                                                                                                      <?php endif;?>
                                                                                          <?php endforeach;?>

                                                                                          <li id="li-<?=$pickupId_string;?>-<?= $number;?>"
                                                                                              class="checkboxSendSms noSendSms <?= $addClass;?>"
                                                                                              data-pickupid="<?=$pickupId_string;?>"
                                                                                              data-reference="<?= $reference;?>"
                                                                                              data-number="<?= $number;?>">

                                                                                                      <?= '<b>'.$number.'</b> - <i>'.$typeNumber.'</i>';?>


                                                                                                      <?php if($addClass == 'smsSent'):?>
                                                                                                            <div class="allSent">
                                                                                                                        <b>SMS déjà envoyé(s): </b>
                                                                                                                        <?= $infoSmsSentString;?>
                                                                                                            </div>
                                                                                                    <?php endif;?>



                                                                                                      <div id="<?=$pickupId_string;?>-<?= $number;?>" class="infoSmsSent">
                                                                                                      </div>


                                                                                          </li>

                                                                        <?php endif;?>



                                                                        <?php unset($child_list_name, $child_string, $pickupId_arr);?>

                                                          <?php endforeach;?>

                                             </ul>


                                              <br/>
                                              <hr/>
                                              <br/>


                                        <?php endforeach;?>

                         <?php endforeach;?>

      <?php endforeach;?>

      <button id="buttonSendSms" class="button">ENVOYER LES SMS AUX BLEUS</button>

</div>
