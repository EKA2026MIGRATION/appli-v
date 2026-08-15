<a title="1 place occupée" href="javascript:void(0)">
	<i class="material-icons" onclick="">plus_one</i>
</a>

<a title="Map ride" href="javascript:void(0)">
	<i class="material-icons" onclick="openMapRide(this, 'dispatch', '0');openRevealJS('mapRide')">map</i>
</a>

<a title="Export Uber" href="javascript:void(0)">
	<i class="material-icons" onclick="exportUber('<?php echo $ride->rideId; ?>')">directions_car</i>
</a>

<a title="Duplication" href="javascript:void(0)">
	<i class="material-icons" onclick="duplicateRide(this)">file_copy</i>
</a>

<a title="Verrouiller" href="javascript:void(0)">
	<i class="material-icons" onclick="lockRide(this)">lock</i>
</a>

<a title="Heure de prise en charge" href="javascript:void(0)">
	<i class="material-icons" onclick="countTime('<?php echo $ride->rideId; ?>')">access_time</i>
</a>

<a title="Ordre idéal" href="javascript:void(0)">
	<i class="material-icons" onclick="launchIa('<?php echo $ride->rideId; ?>')">code</i>
</a>

<a title="Modifier" href="javascript:void(0)">
	<i class="material-icons" onclick="editRide('<?php echo $ride->rideId; ?>');openRevealJS('revealCreateTrajet')">edit</i>
</a>

<a title="Supprimer" href="javascript:void(0)">
	<i class="material-icons" onclick="deleteRide('<?php echo $ride->rideId; ?>')">delete</i>
</a>