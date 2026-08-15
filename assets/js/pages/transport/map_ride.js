const openMapRide = (data, from, idRide)  =>
{

	if(from == 'dispatch')
	{
		$("#mapRideOpen").val(1);

		const ride = $(data).parent().parent().parent().parent().addClass('rideFixed');
		const rideId = $(data).parent().parent().parent().parent().attr('data-id-ride');
		openMapRide('', '', rideId);
	}
	else
	{

		const rideId = idRide;
		
		var depart = $(`[data-id-ride=${rideId}]`).attr('data-startPoint');
		var arrive = $(`[data-id-ride=${rideId}]`).attr('data-endPoint');
		$(`[data-id-ride=${rideId}]`).find('.numberOrder.letter').css('opacity', 1);
		var i = 0;
		var x = 0;
		var letterSortOrder = 0;
		var waypts = [];
		var nbLi = $(`[data-id-ride=${rideId}] li`).length;
		var nbLi = nbLi-1;
		var nbLiChecked = $(`[data-id-ride=${rideId}]`).find('input:checkbox:checked').length; 
		$(`[data-id-ride=${rideId}]`).find('.letterArrive').html(String.fromCharCode(nbLiChecked+64)); 
		var lastAdresse = '';
		$(`[data-id-ride=${rideId}]`)
		.find("li")
		.each(function() {


			var checkbox = $(this).find('.checkboxRideFixed');
			var departureCheckbox = $(`[data-id-ride=${rideId}]`).find('.checkboxDeparture');
			var arrivalCheckbox = $(`[data-id-ride=${rideId}]`).find('.checkboxArrival');

		    if($(checkbox).is(':checked')) {

				if(lastAdresse != $(this).attr('data-address')) {
						letterSortOrder++; 
				}
				else
				{
					nbLiChecked = nbLiChecked-1;
					$(`[data-id-ride=${rideId}]`).find('.letterArrive').html(String.fromCharCode(nbLiChecked+64)); 
				}


		    	var spec = $(this).hasClass('npec');
		    	if(spec == false) {

		    		if(x == 0) {
		    			
			    		if($(departureCheckbox).is(':checked')) {

							let address = $(this).attr('data-address');

							$(this).find('.numberOrder.letterDeparture').html(String.fromCharCode(65)); 
							$(`[data-id-ride=${rideId}]`).find('.letterDeparture').css('opacity', 1);

			    		} else {
			    			letterSortOrder = letterSortOrder-1;
			    			$(`[data-id-ride=${rideId}]`).find('.letterDeparture').css('opacity', 0);
			    			depart = $(this).attr('data-address');

            				$(this).find('.numberOrder.letter').html(String.fromCharCode(letterSortOrder+65));         

			    		}

		    		}

		    		if(i == nbLi) {

			    		if($(arrivalCheckbox).is(':checked')) {

							let address = $(this).attr('data-address');
							if(lastAdresse != $(this).attr('data-address')) {
								waypts.push({
									location: address
								});	
							}
							
							$(`[data-id-ride=${rideId}]`).find('.letterArrive').css('opacity', 1);
							$(this).find('.numberOrder.letter').html(String.fromCharCode(letterSortOrder+65));

			    		} else {
			    			$(`[data-id-ride=${rideId}]`).find('.letterArrive').css('opacity', 0);
			    			arrive = $(this).attr('data-address');
			    			$(this).find('.numberOrder.letter').html(String.fromCharCode(letterSortOrder+65)); 
							if(lastAdresse == $(this).attr('data-address')) {
								waypts.pop();
							}
			    			
			    		}

		    		} else {


		    			$(this).find('.numberOrder.letter').html(String.fromCharCode(letterSortOrder+65)); 
						let address = $(this).attr('data-address');
						if(lastAdresse != $(this).attr('data-address')) {
							if(depart != $(this).attr('data-address')) {
								waypts.push({
									location: address
								});								
							}
						}

		    		}

					lastAdresse = $(this).attr('data-address'); 

	    			x++;
		    	}

		    } else {
		    		$(this).find('.numberOrder.letter').css('opacity', 0);
		    	}

		    i++;
		});
	}

	const directionService = new google.maps.DirectionsService();
	const geocoder = new google.maps.Geocoder();

	directionService.route(
	{
	  origin: depart,
	  destination: arrive,
	  waypoints: waypts,
	  optimizeWaypoints: false,
	  travelMode: google.maps.TravelMode.DRIVING
	},
	(data, status2) => {
	  const legs = data.routes[0].legs;
	  numberOfElements = legs.length;
	  let x = 1;
	  let z = 0;
	  let geocoder;
	  var map;
	  let directionsDisplay;
	  const directionsService = new google.maps.DirectionsService();
	  const locations = [];

      var time = 0;
      for (i = 0; i < numberOfElements; i++) {
        time = time + legs[i].duration.value;
      }

      $(".timeMap").html(Math.round(time/60) + ' minutes');

	  for (i = 0; i < numberOfElements; i++) {


	    if (i == 0) {
	      locations[z] = [
	        legs[i].start_address,
	        legs[i].start_location.lat(),
	        legs[i].start_location.lng(),
	        x
	      ];
	      z++;
	    }

	    locations[z] = [
	      legs[i].end_address,
	      legs[i].end_location.lat(),
	      legs[i].end_location.lng(),
	      x
	    ];
	    z++;
	    x++;
	  }

	  directionsDisplay = new google.maps.DirectionsRenderer();

	  var map = new google.maps.Map(document.getElementById("map"), {
	    zoom: 14,
	    center: new google.maps.LatLng(48.856614, 2.3522219000000177),
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	  directionsDisplay.setMap(map);
	  const infowindow = new google.maps.InfoWindow();

	  let marker;
	  var i;
	  const request = {
	    travelMode: google.maps.TravelMode.DRIVING
	  };
	  for (i = 0; i < locations.length; i++) {
	    marker = new google.maps.Marker({
	        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
		    icon: {
		      url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
		    }
	    });

	    google.maps.event.addListener(
	      marker,
	      "click",
	      (((marker, i) => () => {
	        infowindow.setContent(locations[i][0]);
	        infowindow.open(map, marker);
	      }))(marker, i)
	    );

	    if (i == 0) request.origin = marker.getPosition();
	    else if (i == locations.length - 1)
	      request.destination = marker.getPosition();
	    else {
	      if (!request.waypoints) request.waypoints = [];
	      request.waypoints.push({
	        location: marker.getPosition(),
	        stopover: true
	      });
	    }
	  }
	  directionsService.route(request, (result, status) => {
	    if (status == google.maps.DirectionsStatus.OK) {
	      directionsDisplay.setDirections(result);
	    }
	  });
	}
	);
}

const closeMapRide = () =>
{	
	$("#mapRideOpen").val(0);
	$('section').removeClass('rideFixed');
}