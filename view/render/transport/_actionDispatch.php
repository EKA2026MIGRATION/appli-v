<div class="reveal mobile-ios-modal" id="auto-dispatch" data-reveal>
    <p> <center><strong> Vous souhaitez </strong></center></p>
    <div class="mobile-ios-modal-options-stacked">
        <button data-close class="button" onclick="autoDispatch('false', '<?php echo $params->date; ?>')">Affecter tout le monde (non compris dans un  un trajet)</button>
        <button data-close class="button" onclick="autoDispatch('false', '<?php echo $params->date; ?>', 'dropin')">Affecter les "Prise en charge" (non compris dans un trajet)</button>
        <button data-close class="button" onclick="autoDispatch('false', '<?php echo $params->date; ?>', 'dropoff')">Affecter les déposés (non compris dans un trajet)</button>
        <hr />
        <button data-close class="button" onclick="autoDispatchUnaffect('<?php echo $params->date; ?>')">Désaffecter tous les pickups</button>
        <button data-close class="button" onclick="autoDispatchUnaffect('<?php echo $params->date; ?>', 'dropin')">Désaffecter tous les pickups PEC</button>
        <button data-close class="button" onclick="autoDispatchUnaffect('<?php echo $params->date; ?>', 'dropoff')">Désaffecter tous les pickups DEP</button>

        <hr />
        <button data-close class="button" onclick="autoDispatch('true', '<?php echo $params->date; ?>')">Affecter tous les pickups</button>
        <button data-close class="button" onclick="autoDispatch('true', '<?php echo $params->date; ?>', 'dropin')">Affecter  tous les PEC</button>
        <button data-close class="button" onclick="autoDispatch('true', '<?php echo $params->date; ?>', 'dropoff')">Affecter tous les DEP</button>

        <button data-close class="button red" >Fermer</button>
    </div>
</div>