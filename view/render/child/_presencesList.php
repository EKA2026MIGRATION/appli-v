<?php use_helper('dates'); ?>
<?php if (null != $params->presences):;?>
        <?php foreach ($params->presences as $month => $presences): ?>
            <h6 style="text-align: center"><?= showDate($month, 'F - Y'); ?></h6>
            <ul style="display: flex; flex-wrap: wrap">
                    <?php $week = 0;?>
                    <?php include('_presencesListDetails.php');?>                    
            </ul>
            <hr/>
        <?php endforeach;?>
        <div class='text-center'><button class='button' onclick='deleteAllPresence()'>Supprimer les présences sélectionnées</button></div>

<?php else: ?>
        <ul><li><p>Aucune présence enregistrée.</p></li></ul>
<?php endif; ?>


<script>
var presenceIdList = [];
var selectMultiplePresence = presenceId => {
    // check if child is in array
    let test = presenceIdList.includes(presenceId);
    if(test == true) {
        // if in array delete
        let filtered = presenceIdList.filter(function(value, index, arr){ 
            return value != presenceId;
        });
        presenceIdList = filtered;
    } else {
        // if not in array push
        presenceIdList.push(presenceId);
    }
 }

 var deleteAllPresence = () => {
    
   let data = presenceIdList.join();
   let url = "child/presence/delete/string/"+data; 

     $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url,  type: "DELETE" },
            dataType: "json",
            beforeSend() {
                $(".loading").show();
            },
            success(json) {
                $(".loading").hide();
                for (let i = 0; i < json.length; i++) {

                    let idElement = json[i];
                    $('#'+idElement).remove();
                }

            }
    });
               
 }

</script>