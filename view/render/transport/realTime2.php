<?php //echo date('H:i:s');?>
<section style="display: flex; flex-wrap: wrap; justify-content: space-around">
  <?php foreach($params->rides as $ride): ?>
        <div class="realTime-ride" style="width: 180px;">
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
                                            <span class="hourPrevShown">
                                                - <?php echo date('H:i', strtotime($pickup->start)); ?>
                                            </span>
                                            <span class="hourRealShown">
                                                <?php if($pickup->status=="pec"):?>
                                                    <?php echo date('H:i', strtotime($pickup->updatedAt)); ?>
                                                <?php endif;?>
                                            </span>
                                            <span class="addressShown">
                                                <br/>
                                                <?php echo $pickup->address; ?>
                                            </span>
                                    </li>

                        <?php endforeach; ?>
            </ul>
        </div>
  <?php endforeach; ?>
</section>

<script>

if(sessionStorage.getItem('filter')) {
  let filterString = sessionStorage.getItem('filter');
  $(".filterItemSelectButton").each(function() {
    let filter = $(this).attr('data-name');
    let value = $(this).attr('data-value');
    if(value == 1)
    {
      $('.'+filter+'Shown').show();
    } else {
      $('.'+filter+'Shown').hide();
    }
  });
}
</script>
