$(() => {
  const options = {
    componentRestrictions: { country: "fr" }
  };
  let i;
  const autocomplete = [];
  const input = [];

  for (i = 1; i < 4; i++) {
    input[i] = document.getElementById(`autocomplete${i}`);
    autocomplete[i] = new google.maps.places.Autocomplete(input[i], options);
  }
});

const addStep = () => {
  let step = $("#autocomplete3").val();

  $("#stepList").append(
    `<li><span><div><p class="list-header">${step}<div class="with-icon"><a href="#"><i class="material-icons" onclick="removeStep(this)">delete</i></a></div></p></div></span></li>`
  );
};

const removeStep = data => {
  $(data)
    .closest("li")
    .hide();
};

const launchIa = () => {
  $("#result").html("");
  let depart = $("#autocomplete1").val();
  let arrive = $("#autocomplete2").val();
  let waypts = [];
  $("#stepList")
    .find(".list-header")
    .each(function() {
      waypts.push({
        location: $(this).html()
      });
    });
  const directionService = new google.maps.DirectionsService();
  const geocoder = new google.maps.Geocoder();

  directionService.route(
    {
      origin: depart,
      destination: arrive,
      waypoints: waypts,
      optimizeWaypoints: true,
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
      for (i = 0; i < numberOfElements; i++) {
        $("#result").append(
          `${x} => Départ : ${legs[i].start_address} | Arrivée : ${legs[i].end_address} | ${legs[i].distance.text} • ${legs[i].duration.text} <br/>`
        );

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
        zoom: 10,
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
          position: new google.maps.LatLng(locations[i][1], locations[i][2])
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

      console.log(data);
    }
  );
};
