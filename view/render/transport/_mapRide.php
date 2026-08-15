<div class="reveal mapRide" id="mapRide" data-reveal>
    <p class="lead">Map du trajet</p>

    <div id="rideCopy"></div>

    <div id="map" class="map"></div>
    <div style="height: 20px;"></div>
    <p class="text-center">
    	<button class="button" onclick="closeMapRide()" data-close>Fermer</button><br/>
    	Temps de trajet : <span class="timeMap"></span>
    </p>
</div>

<input type="hidden" id="mapRideOpen" value="0" />