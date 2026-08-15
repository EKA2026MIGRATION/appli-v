<?php
$totalNPEC = count((array) $params->pickups_unaffected_dropin) + count((array) $params->pickups_unaffected_dropoff);
$x = 0;

foreach ($params->rides as $ride) {
    if (is_object($ride)) {
        foreach ($ride->pickups as $pickup) {
            if ($pickup->validated != 'validated') {
                ++$x;
            }
        };
    }
};
?>
<div class="validationInformation">
    <div <?php echo ($totalNPEC == 0 and $x == 0) ? '' : 'style="display:none;"'; ?> id="jValidate" data-closable class="callout alert-callout-subtle success">
        <strong>Information !<br></strong> Journée validée <span id="infoValidate"><?= $params->validated; ?></span>
        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
            <span aria-hidden="true">⊗</span>
        </button>
    </div>

    <div <?php echo ($totalNPEC == 0 and $x == 0) ? 'style="display:none;"' : ''; ?> id="jNoValidate" data-closable class="callout alert-callout-subtle alert">
        <strong>Information !<br></strong> <span id="nbNPEC"><?= $totalNPEC; ?></span> pickup(s) non pris en charge
        <span id="noValidatedPickUp"><br /> <span id="nbPickUp"><?= $x; ?></span> pickup(s) non validé(s).</span>
        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
            <span aria-hidden="true">⊗</span>
        </button>
    </div>
</div>