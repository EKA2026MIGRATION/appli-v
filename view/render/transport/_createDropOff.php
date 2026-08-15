<?php 
function getRideColor($time) {

    if($time < '115900') return "#FFDC00";
    if($time > '120000' && $time < '140000') return "#3D9970";
    if($time > '140000' && $time < '170000') return "#FF851B";
    if($time > '170000') return "#B10DC9";
};

function getRideType($time, $kind) {

    $r = "";
    if($time < '115900') {
        $r .="M";
    } else {
        $r .= "AM";
    }

    if($kind == "dropin") {
        $r .= "A";
    } else {
        $r .= "R";
    }

    return $r;   
};

?>

<style>
    #createDropOff {
        backface-visibility: hidden;
        display: none;
        padding: 1rem;
        border: 1px solid #cacaca;
        border-radius: 0;
        background-color: #fefefe;
        position: relative;
        margin-right: auto;
        margin-left: auto;
        overflow-y: auto;
    }


</style>

<div class="reveal-overlay" id="createDropOffOverlay" sytle="display:none">

    <div class="reveal" id="createDropOff" data-reveal>
        <p class="lead">Créer les retours</p>

        <button class="close-button" data-close aria-label="Close modal" type="button" onclick="closeCreateDropOff()">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="grid-container">
            <div class="grid-x grid-padding-x">

                <table id="createDropOffForm">
                    <thead>
                    <tr>
                        <th>Transport</th>
                        <th>Matin Retouro</th>
                        <th>Après midi Retour</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $arrayRides['dropin'] = $arrayRides['dropin'] ?? []; ?>
                    <?php ksort($arrayRides['dropin']);?>


                    <?php foreach ($arrayRides['dropin'] as $driverCD => $rideCD):?>

                        <?php $j = 0;?>


                        <?php foreach($rideCD as $timekey => $rideCD_in):?>


                            <tr>
                                <td>
                                    <b><?= $driverCD;?></b>
                                    <br/>
                                    <?= $rideCD_in['name'];?><br/>
                                    <?= showTime($rideCD_in['start']);?>
                                </td>
                                <?php foreach(['MR', 'AMR'] as $momentCD):?>
                                    <td>
                                        <?php if(key_exists($driverCD, $arrayRides['dropoff'] ?? [])):?>
                                                <?php foreach($arrayRides['dropoff'][$driverCD] as $timeKeyOff => $rideCD_off):?>
                                                    <?php if($momentCD != getRideType($timeKeyOff, 'dropoff')) continue;?>
                                    
                                                    <div class="switch">
                                                        <input class="switch-input"
                                                            type="checkbox" 
                                                            data-dropinid="<?= $rideCD_in['rideId'];?>" 
                                                            data-dropoffid="<?= $rideCD_off['rideId'];?>" 
                                                            id="CD-<?= $rideCD_off['rideId'].'-'.$j;?>"
                                                            <?php if($rideCD_in['linkedRideId'] == $rideCD_off['rideId']) echo 'checked';?>
                                                            >
                                                        <label class="switch-paddle" for="CD-<?= $rideCD_off['rideId'].'-'.$j;?>"></label>
                                                    </div>
                                                    <?php $j++;?>
                                                <?php endforeach;?>
                                        <?php endif;?>
                                    </td>
                                <?php endforeach;?>

                            </tr>
                        <?php endforeach;?>

                    <?php endforeach;?>

                </table>

                <div class="medium-12 cell">
                    <center><input type="submit" class="button" value="Créer les retours" id="createDropOffButton" /></center>
                </div>
            </div>
        </div>


    </div>
</div>


<script>

document.getElementById("createDropOffButton").addEventListener(
    "click",
    (event) => {

      var ridesDP = [];

      $("#createDropOffForm")
        .find(":checkbox:checked")
        .each(function () {
          let rideIdIn = $(this).attr('data-dropinid');
          let rideIdOff = $(this).attr('data-dropoffid');
          ridesDP.push({ rideIdIn, rideIdOff });
        });

      let url = "pickup/multiple-affect-pickup-linked-ride";

      $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "POST", url, data: ridesDP },
        dataType: "json",
        beforeSend() {
          $(".loading").show();
        },
        success(json) {
          $(".loading").hide();
          swal({
            title: "Confirmation",
            text: "Retours créés.",
            type: "success",
            confirmButtonText: "Actualiser",
            showCancelButton: false,
          }).then((result) => {
            locationRedirect();
            console.log(result);
          }); //TODO remplacer par toast ou pas ?
        },
      });
    }
  )

</script>