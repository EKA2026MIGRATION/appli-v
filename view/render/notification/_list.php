<?php use_helper('dates');?>
<ul style="list-style:none;margin-left:0;padding-left:0; background-color: white; overflow: scroll; max-height: 600px">

    <?php if($params->notifications):?>

    <?php $i = 0; foreach($params->notifications as $k => $notification):?>
        <?php $i++;?>
        <li id="closeNotification-<?= $notification->id;?>-li" style="background-color: lightgrey; padding: 10px">
            <i  onclick="closeNotification(<?= $notification->id;?>, <?= $params->person_id;;?>)" class="material-icons closeNotification" style="float: right; cursor: pointer; color: darkred; font-size: 2em">close</i>
            <b><?= $notification->name;?></b>
            <br/>
            <?= $notification->description;?>
            <?php if($notification->url != ""):?>
                <br/>
                <a href="<?= HOST.$notification->url; ?>" onclick="closeNotification(<?= $notification->id;?>)" style="margin: 0px; padding: 0px; color: darkred">En savoir plus</a>
            <?php endif;?>
            <i><?= showDate($notification->dateNotification, 'd/m/Y H:i');?></i>
        </li>
    <?php endforeach;?>
    <br/>
    <?php endif;?>

    <!--
    <li onclick="deleteAll(<?php //echo $params->person_id;?>)" style="background-color: darkblue; color: white; padding: 10px; text-align: center; cursor: pointer">
        Marquer comme lu toutes les notifications
    </li>-->
</ul>

<div id="no"></div>

<script>
    let i = "<?= $i;?>";
    let newI, iText;
    const closeNotification = (notificationId, personId) => {       
        let urlNotification = urlHost+"notification/removePerson/notificationId/"+notificationId+"/personId/"+personId+"/";
        $('#no').load(urlNotification, function() {
            $('#closeNotification-'+notificationId+'-li').remove();
            iText = $('#notificationBellCount').text();
            newId = parseInt(iText) - 1;
            $('#notificationBellCount').text(newId);
          
        })
    }
    const deleteAll = (personId) => {
        let urlNotification = urlHost+"notification/deleteAll/personId/"+personId+"/";
        $('#no').load(urlNotification, function() {
            $('#notificationBlock').remove();
        })
    }

    if(parseInt(i) > 0) {
        $('#notificationBellCount').text(i);
        $('#notificationBell').css('color', 'white');
    }
    

</script>