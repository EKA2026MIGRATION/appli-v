<?php $title = "Envoi des SMS"; ?>
<?php $historicSMS = $params->historicSms;?>
<input type="hidden" id="messageToSend" value="<?= $historicSMS->content;?>"/>
<input type="hidden" id="signatureToSend" value="<?= $historicSMS->signature;?>"/>
<input type="hidden" id="isUnicode" value="<?= $historicSMS->unicode;?>"/>

<h2 class="text-center margin-top-20">Envoi des SMS en cours</h2>


<div id="dialogSendSms">

    <div style="margin-top: 80px; background-color: lightgray; padding: 30px">
        <br/>
            <i class="material-icons" style="font-size: 40px; color: darkred; float: right; margin-right: 25px; cursor: pointer; display: none" id="closeDialogButtonSendSms">close</i>
        <br/>
        <h2>
            <?= $historicSMS->name;?>
            <?php if(count((array) $historicSMS->phoneNumbers) > 0):?>
                    <img src="<?= IMG; ?>loadSpinner3.gif" style="width: 25px; height: 25px;" id="loadSpinnerSendSms"/>
            <?php endif;?>
        </h2>


        <div id="messageSmsSend" style="padding: 10px; border-radius: 20px; border: 3px solid darkblue; background-color: white; width: 90%; margin: 6px">
            <?= $historicSMS->content;?>
            <br/>
            <?= $historicSMS->signature;?>
        </div>

        <br/><br/>

        <?php if(count((array) $historicSMS->phoneNumbers) > 0):?>

            <ul id="ulDialogSendSms" style="background-color: lightgray; min-height: 400px">

                <?php foreach($historicSMS->phoneNumbers as $phone):?>
                    <li class="phoneNumber" data-phoneid = "<?= $phone->id;?>" data-phonenumber="<?= $phone->phoneNumber;?>" style="display: flex; justify-content: space-between; width: 80%; border-bottom: 1px solid grey; padding-bottom: 2px">
                        <div>
                            <b><?= $phone->phoneName;?></b> - <?= $phone->phoneNumber;?><br/>
                            <div id="statusSent-<?= $phone->id;?>" style="font-size: 12px; font-style: italic"></div>
                        </div>
                        <div id="iconSend-<?= $phone->id;?>" style="display: none">
                            <i class="material-icons" style="font-size: 20px; color: darkgreen;">check</i>
                        </div>
                    </li>
                <?php endforeach;?>
                <li class="phoneNumber" data-phoneid = "0" data-phonenumber="end" style="display: flex; justify-content: space-between; width: 80%;">
                </li>
            </ul>
            <br/>
            <div class="medium-12 cell">
                <center><a href="<?= HOST;?>communication/doSend/id/<?= $historicSMS->id;?>/" class="button margin-top-20">Suivant</a></center>
            </div>
        <?php else:?>

            Toutes les messages ont été envoyés

        <?php endif;?>            
    </div> 
</div>
