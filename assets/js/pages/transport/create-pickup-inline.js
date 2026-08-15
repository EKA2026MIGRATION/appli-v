$(() => {
  initAutoComplete();
  let idChild = $("#childParam").val();
  loadAdressesChild(idChild);
});


var initAutoComplete = () => {
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

  google.maps.event.addListener(autocomplete[3], 'place_changed', function() {

    var place = autocomplete[3].getPlace();
    for (var i = 0; i < place.address_components.length; i++) {
      for (var j = 0; j < place.address_components[i].types.length; j++) {
        if (place.address_components[i].types[j] == "postal_code") {

          $("#postal_pickup").val(place.address_components[i].long_name);

        }
      }
    }
  })

};

const editPickUp = () => {
  let idPickUp = $("#lastIdPickup").val();
  let url = `pickup/display/${idPickUp}`;
  $("#pickUpForm").attr("action", `pickup/modify/${idPickUp}`);
  $("#listChildPickUp").hide();

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {
      $("#loaderFormEditPickUp").show();
    },
    success(json) {
      $("#loaderFormEditPickUp").hide();

      const inputs = $("input, textarea, select").not(
        ":input[type=button], :input[type=submit], :input[type=reset]"
      );

      $("#pickUpForm")
        .find(inputs)
        .each(function() {
          const name = $(this).attr("name");
          $(this).val(json[name]);
        });

      loadAdressesChild(json.child.childId);
      let hour = json.start;
      hour = hour.slice(-5);
      $("#start_not").val(hour);
      $("[name=kind]").val(json.kind);
    }
  });
};

$("#start_ride").change(() => {
  const time = $("#start_ride").val();

  if (time.length == 5) {
    $("#start_ride_2").val(`${time}:00`);
  }
});

$("#arrival_ride").change(() => {
  const time = $("#arrival_ride").val();

  if (time.length == 5) {
    $("#arrival_ride_2").val(`${time}:00`);
  }
});


$("#selectDriver").change(() => {
  loadAdressesDriver($("#selectDriver").find(':selected').data('id-person'));
  var idVehicle = $("#selectDriver").find(':selected').data('id-vehicle');
  $("[name=vehicle]").val(idVehicle);
});

const editRide = idRide => {
  let url = `ride/display/${idRide}`;
  $("#rideForm").attr("action", `ride/modify/${idRide}`);

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {
      $("#loaderFormEditRide").show();
    },
    success(json) {
      $("#loaderFormEditRide").hide();
      const inputs = $("input, textarea, select").not(
        ":input[type=button], :input[type=submit], :input[type=reset]"
      );

      $("#rideForm")
        .find(inputs)
        .each(function() {
          const name = $(this).attr("name");
          $(this).val(json[name]);
        });

      if(json.places == null)
      {
        $("[name=places]").val(8);
      }

      if(json.staff.staffId != null) //doute sur cette ligne
      {
        $("[name=staff]").val(json.staff.staffId);
      }


      if(json.linkedRide != null)
      {
        $("[name=linkedRide]").val(json.linkedRide.rideId);
      }

      $("#start_ride").val(json.start);
      $("#arrival_ride").val(json.arrival);


      if(json.staff.person.personId != null)
      {
        loadAdressesDriver(json.staff.person.personId);
      }

      if(json.staff.vehicle.vehicleId != null)
      {
        $("[name=vehicle]").val(json.staff.vehicle.vehicleId);
      }


    }
  });
};

const getIdPickup = idPickUp => {
  $("#lastIdPickup").val(idPickUp);
};


const deletePickUp = () => {
  let idPickUp = $("#lastIdPickup").val();

  swal({
    title: "Attention",
    text: "La suppression est irréversible.",
    type: "warning",
    confirmButtonText: "Supprimer",
    cancelButtonText: "Annuler",
    showCancelButton: true
  }).then(result => {
    if (result.value) {
      deletePickupSubmit(idPickUp);
    }
  });
};

var deleteRideSubmit = idRide => {
  let url = `ride/delete/${idRide}`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type: "DELETE" },
    dataType: "json",
    beforeSend() {},
    success(json) {
      if (json.status == true) {
          toastr.success(json.message, 'Suppression');
          locationRedirect();
          $(`[data-id-ride=${idRide}]`)
              .addClass("animated bounceOutUp")
              .delay(750)
              .hide(0);

      } else {
        swal({
          title: "Suppression",
          text: "Une erreur est survenue.",
          type: "warning"
        });
      }
    }
  });
};

var deletePickupSubmit = idPickUp => {
  let url = `pickup/delete/${idPickUp}`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type: "DELETE" },
    dataType: "json",
    beforeSend() {},
    success(json) {
      if (json.status == true) {
        toastr.success(json.message, 'Suppression');
        $(`[data-id-pickup=${idPickUp}]`)
            .addClass("animated bounceOutUp")
            .delay(750)
            .hide(0);
      } else {
        swal({
          title: "Suppression",
          text: "Une erreur est survenue.",
          type: "warning"
        });
      }
    }
  });
};

document.getElementById("pickUpForm").addEventListener(
  "submit",
  event => {
    event.preventDefault();
    let form = $("#pickUpForm");
    let url = form.attr("action");
    let type = "POST";
    let data = $(form).serializeToJSON();

    if (url.includes("modify")) {
      type = "PUT";
    }

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type, url, data },
      dataType: "json",
      beforeSend() {
        $("#pickUpForm [type=submit]")
          .attr("disabled", true)
          .attr("value", "Envoi en cours..");
      },
      success(json) {
        $("#pickUpForm [type=submit]")
          .attr("disabled", false)
          .attr("value", "Envoyer");

        if (json.status == true) {
            
            toastr.success(json.message, 'Confirmation');
              let photo = photoProfilDefault;

              if (json.pickup.child.photo != null) {
                photo = json.pickup.child.photo;
              }

              const date = new Date(json.pickup.start);
              const hours = date.getHours();
              const minutes = date.getMinutes();
              const select = $(".with-select").html();
              location.reload();

              if (url.includes("modify")) {
                $(`[data-id-pickup=${json.pickup.pickupId}]`).html(
                  `<a href="#" onclick="getIdPickup(\`${json.pickup.pickupId}\`)" data-open="action-pickup"><div><p class="list-header"><img src="${photo}" data-id-child="${json.pickup.child.chilId}" class="width-30 height-30" alt=""> ${json.pickup.child.firstname} ${json.pickup.child.lastname} - ${json.pickup.kind}<aside class="subtitles">${json.pickup.address} - ${hours}:${minutes}</aside></p></div></a><div class="with-select">${select}</div>`
                );
              } else {

                let kind = $("#kindPickup").val();

                if(kind == "dropin")
                {
                  let element = $(".dropin");
                }
                else
                {
                  let element = $(".dropoff");
                }

                $(element).append(
                  `<li data-id-pickup="${json.pickup.pickupId}">
                       <a href="#" onclick="getIdPickup(\`${json.pickup.pickupId}\`)" data-open="action-pickup">
                            <div>
                                <p class="list-header">
                                    <img src="${photo}" data-id-child="${json.pickup.child.chilId}" class="width-30 height-30" alt=""> ${json.pickup.child.firstname} ${json.pickup.child.lastname} - ${json.pickup.kind}
                                    <aside class="subtitles">${json.pickup.address} - ${hours}:${minutes}</aside>
                                </p>
                            </div>
                       </a>
                       <div class="with-select">
                            ${select}
                       </div>
                  </li>`
                );
              }

        } else {
          $("#revealPickUp").foundation("close");
          swal({
            title: "Erreur",
            text: "Une erreur est survenue.",
            type: "warning"
          });
        }
      }
    });
  },
  false
);

const changeActionPickUp = () => {
  $("#pickUpForm").attr("action", "pickup/create");
  $("#pickUpForm").trigger("reset");
  $("#listChildPickUp").show();
};

const changeDateStart = () => {
  let time = $("#start_not").val();
  let date = $("#date").val();

  $("#start_note_2").val(`${date} ${time}`);
};

const addThisChild = (idChild, data) => {
  const li = $(data).parent("li");
  $(li).css("background-color", "#dcedc8");
  const idLi = $(li).attr("id");
  $(`#childList li:not(#${idLi})`).hide();
  $("[name=child]").val(idChild);
  $("#loadMoreListChild").hide();

  loadAdressesChild(idChild);
};

var loadAdressesChild = idChild => {
  let url = `child/display/${idChild}`;
  $("#resultAdress").html("");

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {
      $("#loaderLoadAdress").show();
    },
    success(json) {
      $("#loaderLoadAdress").hide();

      const numberOfElements1 = json.persons.length;

      if (numberOfElements1 > 0) {
        for (i = 0; i < numberOfElements1; i++) {
          const numberOfElements2 = json.persons[i].addresses.length;

          if (numberOfElements2 > 0) {
            for (z = 0; z < numberOfElements2; z++) {
              $("#resultAdress").append(
                `<label data-address="${json.persons[i].addresses[z].address}, ${json.persons[i].addresses[z].postal}, ${json.persons[i].addresses[z].town}, ${json.persons[i].addresses[z].country}" data-postal="${json.persons[i].addresses[z].postal}" onclick="changeAddress(this)"><input type="radio"> ${json.persons[i].addresses[z].name} => ${json.persons[i].addresses[z].address}, ${json.persons[i].addresses[z].postal}, ${json.persons[i].addresses[z].town}, ${json.persons[i].addresses[z].country}</label>`
              );
            }
          } else {
            $("#resultAdress").html("Aucune adresse associée.");
          }
        }
      } else {
        $("#resultAdress").html("Aucune adresse associée.");
      }
    }
  });
};

const changeAddress = data => {
  const address = $(data).attr("data-address");
  const postal = $(data).attr("data-postal");
  $("[name=postal]").val(postal);
  $("#autocomplete3").val(address);
};

var loadAdressesDriver = idDriver => {
  let url = `person/display/${idDriver}`;
  $("#resultAdressDriver").html("");

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {
      $("#loaderLoadAdressDriver").show();
    },
    success(json) {
      $("#loaderLoadAdressDriver").hide();

      const numberOfElements = json.addresses.length;

      if (numberOfElements > 0) {
        for (z = 0; z < numberOfElements; z++) {
          $("#resultAdressDriver").append(
            `<label data-address="${json.addresses[z].address}, ${json.addresses[z].postal}, ${json.addresses[z].town}, ${json.addresses[z].country}" onclick="changeAddressDriver(this)"><input type="radio"> ${json.addresses[z].name} => ${json.addresses[z].address}, ${json.addresses[z].postal}, ${json.addresses[z].town}, ${json.addresses[z].country}</label>`
          );
        }
      } else {
        $("#resultAdressDriver").html("Aucune adresse associée.");
      }
    }
  });
};

const changeAddressDriver = data => {
  const address = $(data).attr("data-address");
  $("#autocomplete1").val(address);
};
