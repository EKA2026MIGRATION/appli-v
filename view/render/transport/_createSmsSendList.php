<!--- version iphone --->
<?php $message = "
Bonjour, Energy Kids Academy vous confirme la ".strtolower($kindText)." de ".$pickup->child->firstname."
%0ale ".date('d/m/Y', strtotime($params->date))." vers ".date('H:i', strtotime($pickup->start))."
%0a".$pickup->address." . 
%0aIl est inutile de descendre avant que je n'appelle à l'approche de votre domicile.
%0aCordialement, ".$params->active_driver->person->firstname." - ".$staffTel."
%0aEnergy Kids Academy.";?>
<?php 
    $messageGroup = 
    "Bonjour, Energy Kids Academy vous confirme la ".strtolower($kindText)." de \n[child_name_data] \nle ".date('d/m/Y', strtotime($params->date))." \nvers ".date('H:i', strtotime($pickup->start))." \n".$pickup->address." \nIl est inutile de descendre avant que je n'appelle à l'approche de votre domicile. \n\nCordialement, ".$params->active_driver->person->firstname." - ".$staffTel." \nEnergy Kids Academy.";?>

<!-- version android -->
<?php //$message = str_replace('%0a', ',', $message)?>
<?php //$messageGroup = str_replace('%0a', ',', $messageGroup)?>

<?php $startNum = substr($phone->phone, 0, 2); $numberList = [];?>
<?php $infoPickUp = date('d/m/Y', strtotime($params->date))." - ".date('H:i', strtotime($pickup->start)). ' - '.$pickup->address;?>

<?php $smsSentData = $pickup->smsSentData;?>

<?php if( ($startNum != "01") && !in_array($phone->phone.$kindText, $numberList)):?>
    <?php $numberList[] = $phone->phone.$kindText;?>

    <?php $smsList[$kindText][$ride->name][$person->firstname.' '.$person->lastname][$phone->phone.'-'.$phone->name][] = [
                                                                      'child_name' => $pickup->child->firstname.' '.$pickup->child->lastname,
                                                                      'message' => $messageGroup,
                                                                      'infoPickUp' => $infoPickUp,
                                                                      'pickupId' => $pickup->pickupId,
                                                                      'smsSentData' => $smsSentData,

                                                                      ] ;

    ;?>
<?php endif;?>
