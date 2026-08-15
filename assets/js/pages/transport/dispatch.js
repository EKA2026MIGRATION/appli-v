var minutesToAdd = 120000;

$(() => {
  initDragAndDrop();
  initMultiSelect();
  initAutoComplete();
  moveMenuLeft();
  scrollIfAnchor();
  loadNpec();
  loadRides();
  loadChangeRide();
  //loadValidation();
});



/********** LOAD DRIVERS - On open rideMultiple/createRide/filterSelect ***********/

var driversIsLoaded = false;
const loadDrivers = () => {

  if (driversIsLoaded) {
    return null;
  }

  const date = $('#dateDispatch').val();
  const url = `staff/presence/list/driver/${date}/PRESENCE`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type: "GET" },
    dataType: "json",
    beforeSend() { },
    success(json) {
      
      json.map(staffPresence => {

        // Append the zmultiselect
        if (staffPresence.staff.person) {
          $("#driverFilter").zmultiselect('add', {
            value: staffPresence.staff.staffId,
            text: `${staffPresence.staff.person.firstname} ${staffPresence.staff.person.lastname}`,
            checked: true
          },
            'append');
        } else {
          $("#driverFilter").zmultiselect('add', {
            value: '',
            text: `ATTENTION LA PRESENCE ${staffPresence.staffPresenceId} N'A PAS DE DRIVER`,
            checked: true
          },
            'append');
        }

        // Append driver list in create ride
        if (staffPresence.staff.vehicle) {
          $('#selectDriver').append(`
          <option
            data-id-vehicle="${staffPresence.staff.vehicle.vehicleId}"
            data-id-person="${staffPresence.staff.person.personId}"
            value="${staffPresence.staff.staffId}">
            ${staffPresence.staff.person.firstname} ${staffPresence.staff.person.lastname}
            </option>
        `);
        }


        //Append driver in ride mutliple


        if (staffPresence.staff.staffId && staffPresence.staff.vehicle && staffPresence.staff.address) {
          let driverZone = '';
          staffPresence.staff.driverZones.map(zone => {
            driverZone = `
            <div>
               ${zone.postal} 
              <i  class="material-icons selectButtonDriversZone" 
                  style="cursor: pointer; line-height: 0; font-size: 12px" 
                  id="minus-driversZone-${zone.driverZoneId}-value">
                  keyboard_arrow_left
              </i>
                  <span id="driversZone-priority-value-${zone.driverZoneId}">${zone.priority}</span>
              <i  class="material-icons selectButtonDriversZone"
                  style="cursor: pointer; line-height: 0; font-size: 12px" 
                  id="plus-driversZone-${zone.driverZoneId}">
                  keyboard_arrow_right
              </i>
            </div>
            `;
          });

          $('.ridesMultiplesDriver').append(`
            <tr>
            <td>
                ${staffPresence.staff.person.firstname} ${staffPresence.staff.person.lastname}
                <i class="material-icons editDriverZones" style="cursor: pointer; float: right; color: darkblue">edit</i>
                <div style="display: none; padding-left: 20px">
                    <div id="divListDriverZone-${staffPresence.staff.staffId}">
                      ${driverZone}
                    </div>
                    <div>
                        <input  type="text" 
                                placeholder="75001" 
                                class="addDriverZone" 
                                id="addDriverZone-${staffPresence.staff.staffId}" 
                                name="postalZip"
                                style="height: 18px; width: 100px"/>
                    </div>
                </div>
        
            </td>
            <td>
                <div class="switch">
                    <input
                      class="switch-input"
                      data-constante="ma"
                      data-start="08:00:00"
                      data-kind="dropin"
                      data-arrival="10:00:00"
                      data-name="Matin aller"
                      data-start-point="${staffPresence.staff.address.address} ${staffPresence.staff.address.address2} ${staffPresence.staff.address.postal} ${staffPresence.staff.address.country}"
                      data-end-point="Energy Kids Academy - Lieu-dit Les Jonnières, 91570 Bièvres"
                      data-id-driver="${staffPresence.staff.staffId}"
                      data-vehicle="${staffPresence.staff.vehicle.vehicleId}"
                      id="ma${staffPresence.staff.staffId}"
                      type="checkbox"
                      name="ma${staffPresence.staff.staffId}">
                    <label class="switch-paddle" for="ma${staffPresence.staff.staffId}"></label>
                </div>
            </td>
            <td>
                <div class="switch">
                    <input 
                    class="switch-input"
                    data-constante="mr"
                    data-start="11:30:00" 
                    data-kind="dropoff"
                    data-arrival="12:40:00"
                    data-name="Matin retour" 
                    data-start-point="Energy Kids Academy - Lieu-dit Les Jonnières, 91570 Bièvres" 
                    data-end-point="${staffPresence.staff.address.address} ${staffPresence.staff.address.address2} ${staffPresence.staff.address.postal} ${staffPresence.staff.address.country}"
                    data-id-driver="${staffPresence.staff.staffId}"
                    data-vehicle="${staffPresence.staff.vehicle.vehicleId}"
                    id="mr${staffPresence.staff.staffId}"
                    type="checkbox"
                    name="mr<${staffPresence.staff.staffId}">
                    <label class="switch-paddle" for="mr${staffPresence.staff.staffId}"></label>
                </div>
            </td>
            <td>
                <div class="switch">
                    <input
                    class="switch-input"
                    data-constante="ama"
                    data-start="12:45:00"
                    data-kind="dropin"
                    data-arrival="14:00:00"
                    data-name="Après-midi aller"
                    data-start-point="${staffPresence.staff.address.address} ${staffPresence.staff.address.address2} ${staffPresence.staff.address.postal} ${staffPresence.staff.address.country}"
                    data-end-point="Energy Kids Academy - Lieu-dit Les Jonnières, 91570 Bièvres"
                    data-id-driver="${staffPresence.staff.staffId}"
                    data-vehicle="${staffPresence.staff.vehicle.vehicleId}"
                    id="ama${staffPresence.staff.staffId}"
                    type="checkbox"
                    name="ama${staffPresence.staff.staffId}">
                    <label class="switch-paddle" for="ama${staffPresence.staff.staffId}"></label>
                </div>
            </td>
            <td>
                <div class="switch">
                    <input
                    class="switch-input"
                    data-constante="amr"
                    data-start="16:30:00"
                    data-kind="dropoff"
                    data-arrival="18:00:00"
                    data-name="Après-midi retour"
                    data-start-point="Energy Kids Academy - Lieu-dit Les Jonnières, 91570 Bièvres"
                    data-end-point="${staffPresence.staff.address.address} ${staffPresence.staff.address.address2} ${staffPresence.staff.address.postal} ${staffPresence.staff.address.country}"
                    data-id-driver="${staffPresence.staff.staffId}"
                    data-vehicle="${staffPresence.staff.vehicle.vehicleId}"
                    id="amr${staffPresence.staff.staffId}"
                    type="checkbox"
                    name="amr${staffPresence.staff.staffId}">
                    <label class="switch-paddle" for="amr${staffPresence.staff.staffId}"></label>
                </div>
            </td>
        </tr>
          
          `);
        }

      })

      driversIsLoaded = true;
    },
  });

}
/********** END LOADED DRIVERS - On open rideMultiple/createRide/filterSelect ***********/


/********** LOAD VEHICLES on createRide ***********/

var vehiclesIsLoaded = false;
const loadVehicles = () => {

  if (vehiclesIsLoaded) {
    return null;
  }

  const url = `vehicle/list?page=1&size=200`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type: "GET" },
    dataType: "json",
    beforeSend() { },
    success(json) {
      json.map(vehicle => {
        $("#vehiclesCreateRide").append(`
          <option
          value="${vehicle.vehicleId}">
          ${vehicle.name} ${vehicle.matriculation}
          </option>
        `)
      })
      vehiclesIsLoaded = true;
    },
  });

}
/********** END LOADED VEHICLES - On open createRide ***********/

/********** LOAD RIDES - On open createRide ***********/

var ridesIsLoaded = false;
const loadRidesForList = () => {


  const date = $('#dateDispatch').val();
  const url = `ride/list/${date}`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type: "GET" },
    dataType: "json",
    beforeSend() { },
    success(json) {
      json.map(ride => {
        let rideDriver = 'PAS DE DRIVER';
        if(ride.staff.staffId) {
          rideDriver = `${ride.staff.person.firstname}`;
        }

        $("#ridesCreateRide").append(`
          <option
          value="${ride.rideId}">
          ${ride.name} ${ride.start} ${rideDriver}
          </option>
        `)
      })
      ridesIsLoaded = true;
    },
  });

}
/********** END LOAD RIDES - On open createRide ***********/

/********** START LOAD PICKUP NPEC ***********/

async function loadChangeRide() {
  try {
    const date = $('#dateDispatch').val();
    const url = urlHost + `/transport/loadChangeRide/date/${date}/`;
    var content;
    $.get(url, function (data) {
      content = data;
      $(".loadChangeRide").replaceWith(content);
    });
  } catch {
    console.log('une erreur est survenue');
  }
}



/********** START LOAD VALIDATION ***********/

async function loadValidation() {
  try {
    const date = $('#dateDispatch').val();
    const url = urlHost + `/transport/loadValidation/date/${date}/`;
    var content;
    $.get(url, function (data) {
      content = data;
      $(".validationInformation").replaceWith(content);
    });
  } catch {
    console.log('une erreur est survenue');
  }
}


/********** START LOAD PICKUP NPEC ***********/

async function loadNpec() {
  try {
    $('.reloadingPickup').show();
    const date = $('#dateDispatch').val();
    const url = urlHost + `/transport/loadNpec/date/${date}/`;
    var content;
    $.get(url, function (data) {
      content = data;
      $(".column1 section").replaceWith(content);
    });
  } catch {
    console.log('une erreur est survenue');
  }
}

/********** END LOAD PICKUP NPEC ***********/


/********** START LOAD RIDES ***********/

async function loadRides() {
  try {
    $('.reloadingRide').show();
    const date = $('#dateDispatch').val();
    const url = urlHost + `/transport/loadAllRides/date/${date}/`;
    var content;
    $.get(url, function (data) {
      content = data;

      $(".column2").replaceWith(content);
      colorRide();
      countPlaces();
      
    });

  } catch {
    console.log('une erreur est survenue');
  }
}

/********** END LOAD RIDES  ***********/



$("[data-curtain-menu-button]").click(function () {
  $(this)
    .parent()
    .toggleClass("curtain-menu-open");
});

$(".orderPickups").click(function () {
  let el = $(this).attr("id");
  let type = el.split("-")[1];
  let key = el.split("-")[2];

  $("#ulPickups" + type).each(function () {
    $(this).html(
      $(this)
        .children("li")
        .sort(function (a, b) {
          return $(b).data(key) < $(a).data(key) ? 1 : -1;
        })
    );
  });

  $(this).css("color", "darkblue");
  let other;
  if (key == "postal") {
    other = "name";
  } else {
    other = "postal";
  }
  $("#button-" + type + "-" + other).css("color", "lightgrey");
});

const scrollIfAnchor = () => {
  if (window.location.hash) {
    var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
    $("html, body").animate(
      { scrollTop: $("#" + hash).offset().top - 60 },
      1000
    );
  }
};

var colorRide = () => {
  $(".column2")
    .find("section")
    .each(function () {
      if ($(this).attr("data-hour") <= 1159) {
        $(this)
          .find("header")
          .css("background-color", "#FFDC00");
      }

      if (
        $(this).attr("data-hour") > 1200 &&
        $(this).attr("data-hour") < 1400
      ) {
        $(this)
          .find("header")
          .css("background-color", "#3D9970");
      }

      if (
        $(this).attr("data-hour") >= 1400 &&
        $(this).attr("data-hour") < 1700
      ) {
        $(this)
          .find("header")
          .css("background-color", "#FF851B");
      }

      if ($(this).attr("data-hour") >= 1700) {
        $(this)
          .find("header")
          .css("background-color", "#B10DC9");
      }
    });
};

const openCreateDropOff = () => {
  document.getElementById('createDropOff').style.display= "block";
  document.getElementById('createDropOffOverlay').style.display= "block";

}

const closeCreateDropOff = () => {
  document.getElementById('createDropOff').style.display= "none";
  document.getElementById('createDropOffOverlay').style.display= "none";

}

/*
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
  )*/



document.getElementById("createRideMultiple").addEventListener(
  "click",
  (event) => {
    var rides = [];
    var date = $("#date").val();

    $("#rideMultipleForm")
      .find(":checkbox:checked")
      .each(function () {
        let name = $(this).attr("data-name");
        let startPoint = $(this).attr("data-start-point");
        let endPoint = $(this).attr("data-end-point");
        let staff = $(this).attr("data-id-driver");
        let vehicle = $(this).attr("data-vehicle");
        let start = $(this).attr("data-start");
        let arrival = $(this).attr("data-arrival");
        let kind = $(this).attr("data-kind");

        rides.push({
          date,
          name,
          startPoint,
          endPoint,
          staff,
          vehicle,
          start,
          arrival,
          kind,
        });
      });

    let url = "ride/create-multiple";

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "POST", url, data: rides },
      dataType: "json",
      beforeSend() {
        $(".loading").show();
      },
      success(json) {
        $(".loading").hide();
        swal({
          title: "Confirmation",
          text: "Trajets ajoutés.",
          type: "success",
          confirmButtonText: "Actualiser",
          showCancelButton: false,
        }).then((result) => {
          locationRedirect();
        }); //TODO remplacer par toast ou pas ?
      },
    });
  },
  false
);

var moveMenuLeft = () => {
  var width = $(window).width();
  if (width > 1023) {
    let menuLeft = document.getElementsByClassName("menu__left")[0];

    $(menuLeft).animate(
      {
        marginLeft: "-=260px",
      },
      500
    );

    setTimeout(() => {
      $(".container__menu__left").css("width", "40px");
      $(".page__container").css("width", "calc(100% - 100px)");
      $(".closeLeftMenu i").html("arrow_forward");
    }, 500);
  }
};

var initAutoComplete = () => {
  const options = {
    componentRestrictions: { country: "fr" },
  };

  let i;
  const autocomplete = [];
  const input = [];

  for (i = 1; i < 4; i++) {
    input[i] = document.getElementById(`autocomplete${i}`);
    autocomplete[i] = new google.maps.places.Autocomplete(input[i], options);
  }

  google.maps.event.addListener(autocomplete[3], "place_changed", function () {
    var place = autocomplete[3].getPlace();
    for (var i = 0; i < place.address_components.length; i++) {
      for (var j = 0; j < place.address_components[i].types.length; j++) {
        if (place.address_components[i].types[j] == "postal_code") {
          $("#postal_pickup").val(place.address_components[i].long_name);
        }
      }
    }
  });
};

var toogleDropIn = (data) => {
  if ($(".dropin").css("display") == "none") {
    $(".dropin").show();
    $(data)
      .find("i")
      .html("keyboard_arrow_up");
  } else {
    $(".dropin").hide();
    $(data)
      .find("i")
      .html("keyboard_arrow_down");
  }
};

var toogleDropOff = (data) => {
  if ($(".dropoff").css("display") == "none") {
    $(".dropoff").show();
    $(data)
      .find("i")
      .html("keyboard_arrow_up");
  } else {
    $(".dropoff").hide();
    $(data)
      .find("i")
      .html("keyboard_arrow_down");
  }
};

var countPlaces = () => {
  const nbRide = $(".column2 > section > ul").length;
  let x = 0;
  let nbRideFull = 0;
  $(".column2")
    .find("section")
    .each(function () {
      x++;
      const idRide = $(this).attr("data-id-ride");
      const nbPickUpInRide = $(`[data-id-ride=${idRide}] ul > li.pecPickup`)
        .length;
      const nbPlacesMax = $(`[data-id-ride=${idRide}] .nbPlacesMax`).html();

      $(`[data-id-ride=${idRide}] .nbPlaces`).html(nbPickUpInRide);

      if (nbPickUpInRide > nbPlacesMax) {
        nbRideFull++;
        $(`[data-id-ride=${idRide}] .nbPlaces`).addClass("nbPlacesWarning");
      } else {
        $(`[data-id-ride=${idRide}] .nbPlaces`).removeClass("nbPlacesWarning");
      }

      if (x == nbRide) {
        messagePlaces(nbRideFull);
      }
    });
};

var messagePlaces = (nbRideFull) => {
  if (nbRideFull != 0) {
    $("#pickUpFull").show();
    /*$("#pickUpFull .msdriverFilters trajets ont plus de passagers que de places."
    );*/
  } else {
    $("#pickUpFull").hide();
  }
};

var modeEditVar = false;
var modeEdit = (action) => {


  if (modeEditVar == false) {
    initDragAndDrop(true);
    modeEditVar = true;
    $(action).attr('data-mfb-label', 'Annuler mode édition');
  } else {
    modeEditVar = false;
    $(".column1").draggable("destroy");
    $(action).attr('data-mfb-label', 'Mode édition (drag/drop)');
    $(".column1").resizable("destroy");
    $(".dragDispatch ul:not(.isLocked), .dropin, .dropoff").sortable("destroy");
  }

}

var initDragAndDrop = (modeEdit) => {
  if ($(window).width > 1024 || modeEdit) {
    $(".column1").draggable();
    $(".column1").resizable();

    $(".dragDispatch ul:not(.isLocked), .dropin, .dropoff")
      .sortable({
        connectWith: "ul",
        scroll: true,
        receive(event, ui) {
          ui.item.bind("click.prevent", function (event) {
            event.preventDefault();
          });
          countPlaces();
          countValidate();
          if (
            $(ui.sender)
              .parent("section")
              .attr("data-id-ride") !== undefined
          ) {
            saveDispatch(
              "change",
              $(ui.sender)
                .parent("section")
                .attr("data-id-ride")
            );
          }
        },
        stop(event, ui) {
          $(event.originalEvent.target).one("click", function (e) {
            e.stopImmediatePropagation();
          });
          countValidate();
          saveDispatch(
            "change",
            $(ui.item)
              .parent("ul")
              .parent("section")
              .attr("data-id-ride")
          );
        },
      })
      .disableSelection();
  }
};

var initMultiSelect = () => {
  $("#driverFilter").zmultiselect({
    filter: true,
    filterResult: true,
    selectAll: true,
    selectAllText: ["Tout cocher", "Tout décocher"],
    selectedText: ["Sélectionné : ", "/"],
    filterPlaceholder: "",
    filterResultText: "",
    filterPlaceholder: "Filtrer par",
    get: "zmultiselect",
    placeholder: "Filtrer les chauffeurs",
    live: "#liveResult",
  });
};


const openRideDropdown = (elm) => {
  localStorage.setItem('dropdownClickPickup', $(elm).parent("div").parent("li").attr("data-id-pickup"));
  localStorage.setItem('dropdownClickRide', $(elm).parent("div").parent("li").parent("ul").parent("section").attr("data-id-ride"));
  localStorage.setItem('dropdownClickKind', $(elm).parent("div").parent("li").attr("data-kind"));
  openRevealJS('revealChangeRide');
}

const changeRide = (newRide) => {

  if (newRide == "npec") {
    const lastIdPickup = localStorage.getItem('dropdownClickPickup');
    const lastRide = localStorage.getItem('dropdownClickRide');
    const lastKind = localStorage.getItem('dropdownClickKind');

    const lastPickUpInNewRide = $(`.${lastKind} li:last-of-type`).attr(
      "data-id-pickup"
    );

    if (lastPickUpInNewRide == undefined) {
      $(`[data-id-pickup=${lastIdPickup}]`).appendTo(`.${lastKind}`);
    } else {
      $(`[data-id-pickup=${lastIdPickup}]`).insertAfter(`.${lastKind}`);
    }

    $(`[data-id-pickup=${lastIdPickup}]`).removeClass().addClass('NPEC');

    saveDispatch("change", newRide);
    saveDispatch("change", lastRide);
    countPlaces();
  } else {
    const lastIdPickup = localStorage.getItem('dropdownClickPickup');
    const lastRide = localStorage.getItem('dropdownClickRide');

    $(`[data-id-pickup=${lastIdPickup}]`).removeClass().addClass('pecPickup').addClass('nopec');

    const lastPickUpInNewRide = $(
      `[data-id-ride=${newRide}] ul > li:last-of-type`
    ).attr("data-id-pickup");

    if (lastPickUpInNewRide == undefined) {
      $(`[data-id-pickup=${lastIdPickup}]`).appendTo(
        `[data-id-ride=${newRide}] ul`
      );
    } else {
      $(`[data-id-pickup=${lastIdPickup}]`).insertAfter(
        `[data-id-pickup=${lastPickUpInNewRide}]`
      );
    }

    saveDispatch("change", newRide);
    saveDispatch("change", lastRide);
    countPlaces();

  }
}


var countValidate = () => {
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth() + 1; //January is 0!
  var yyyy = today.getFullYear();
  var hh = today.getHours();
  var ii = today.getMinutes();
  if (dd < 10) {
    dd = "0" + dd;
  }

  if (mm < 10) {
    mm = "0" + mm;
  }

  today = dd + "/" + mm + "/" + yyyy + " à " + hh + ":" + ii;

  const nbPEC = $("#pickUpListNPEC > aside > li").length;
  $("#nbNPEC").html(nbPEC);

  const nbNoValidate = $(".column2 > .noValidateRide > ul > li").length;

  $("#nbPickUp").html(nbNoValidate);

  if (nbNoValidate == 0 && nbPEC == 0) {
    $("#jValidate").show();
    $("#jNoValidate").hide();
    var nameValidate = $("#person_connected").val();
    $("#infoValidate").html("par " + nameValidate + " le " + today);
  } else {
    $("#jValidate").hide();
    $("#jNoValidate").show();
  }
};

const numberFormat = (number, width) =>
  new Array(+width + 1 - (number + "").length).join("0") + number;

$(".slider").on("moved.zf.slider", () => {
  let hour1 = $("#hour1").val();
  let hour2 = $("#hour2").val();
  let hour1Length = hour1.length;
  let hour2Length = hour2.length;
  let last2Hours1 = hour1.slice(-2);
  let last2Hours2 = hour2.slice(-2);
  last2Hours1 = (last2Hours1 * 60) / 100;
  last2Hours2 = (last2Hours2 * 60) / 100;
  last2Hours1 = numberFormat(last2Hours1, 2);
  last2Hours2 = numberFormat(last2Hours2, 2);

  if (hour1Length == 3) {
    var firstHours1 = hour1.substring(0, 1);
  } else {
    var firstHours1 = hour1.substring(0, 2);
  }

  if (hour2Length == 3) {
    var firstHours2 = hour2.substring(0, 1);
  } else {
    var firstHours2 = hour2.substring(0, 2);
  }

  let aecrireHour1 = `${firstHours1}h${last2Hours1}`;
  let aecrireHour2 = `${firstHours2}h${last2Hours2}`;
  let reqHour1 = firstHours1 + last2Hours1;
  let reqHour2 = firstHours2 + last2Hours2;

  $("#hourFilter").html(`${aecrireHour1} - ${aecrireHour2}`);

  $(".column2")
    .find("section")
    .each(function () {
      const id = this.id;
      const hour = $(this).attr("data-hour");

      if (
        parseInt(hour) <= parseInt(reqHour2) &&
        parseInt(hour) >= parseInt(reqHour1)
      ) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });

  $(".column1")
    .find("li")
    .each(function () {
      const hour = $(this).attr("data-hour");

      if (
        parseInt(hour) <= parseInt(reqHour2) &&
        parseInt(hour) >= parseInt(reqHour1)
      ) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
});

$("#driverFilterValidate").click(() => {
  var myValue = $("#liveResult").val();
  var myValue = myValue.split(",");

  $(".column2")
    .find("section")
    .each(function () {
      const id = this.id;
      const driver = $(this).attr("data-driver");

      if (jQuery.inArray(driver, myValue) == -1) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
});

const closeAll = () => {
  $(".dragDispatch")
    .find("ul")
    .each(function () {
      if (
        $(this)
          .find("li")
          .css("display") == "none"
      ) {
        $(this)
          .find("li")
          .show();
        $(this)
          .find("div")
          .show();
        $(this)
          .prev("header")
          .find("i.arrow")
          .html("keyboard_arrow_up");
      } else {
        $(this)
          .find("li")
          .hide();
        $(this)
          .find("div")
          .hide();
        $(this)
          .prev("header")
          .find("i.arrow")
          .html("keyboard_arrow_down");
      }
    });
};

const changeColumn = () => {
  const f =
    ($(".dragDispatch .column2 section").width() /
      $(".dragDispatch .column2 section")
        .parent()
        .width()) *
    100;

  if (f == 50) {
    $(".dragDispatch .column2 section").css("max-width", "100%");
  } else if (f == 100) {
    $(".dragDispatch .column2 section").css("max-width", "50%");
  } else {
    $(".dragDispatch .column2 section").css("max-width", "100%");
  }
};

$(".block-list header i.arrow").click(function () {
  let element = $(this)
    .parent()
    .next("ul");

  if (
    $(element)
      .find("li")
      .css("display") == "none"
  ) {
    $(element)
      .find("li")
      .show();
    $(element)
      .find("div")
      .show();
    $(this).html("keyboard_arrow_up");
  } else {
    $(element)
      .find("li")
      .hide();
    $(element)
      .find("div")
      .hide();
    $(this).html("keyboard_arrow_down");
  }
});

const openDatePicker = () => {
  $("#datePickerInline").datepicker({
    closeText: "Fermer",
    prevText: "Précédent",
    nextText: "Suivant",
    firstDay: 1,
    yearRange: "-5:+5",
    currentText: "Aujourd'hui",
    monthNames: [
      "Janvier",
      "Février",
      "Mars",
      "Avril",
      "Mai",
      "Juin",
      "Juillet",
      "Août",
      "Septembre",
      "Octobre",
      "Novembre",
      "Décembre",
    ],
    monthNamesShort: [
      "Janv.",
      "Févr.",
      "Mars",
      "Avril",
      "Mai",
      "Juin",
      "Juil.",
      "Août",
      "Sept.",
      "Oct.",
      "Nov.",
      "Déc.",
    ],
    dayNames: [
      "Dimanche",
      "Lundi",
      "Mardi",
      "Mercredi",
      "Jeudi",
      "Vendredi",
      "Samedi",
    ],
    dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
    dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
    weekHeader: "Sem.",
    dateFormat: "yy-mm-dd",
    changeYear: true,
    onSelect(dateText) {
      var url = `${urlHost}transport/dispatch/date/${dateText}/`;
      locationRedirect(url);
    },
  });
};

const deleteRide = (idRide) => {
  swal({
    title: "Attention",
    text: "La suppression est irréversible.",
    type: "warning",
    confirmButtonText: "Supprimer",
    cancelButtonText: "Annuler",
    showCancelButton: true,
  }).then((result) => {
    if (result.value) {
      deleteRideSubmit(idRide);
    }
  });
};

/*** beginning sms uber */
$("#closeShowUberRide").click(function () {
  $("#showUberRide").toggle();
});

$("#sendUberRide").click(function (e) {
  e.preventDefault();
  let emailC = $("#customEmail").val();
  let emailP = $("#prestEmail").val();
  let content = $("#uberRideContent").html();

  let title = $("#showUberRide > h7").text();
  let dateDay = $("#showUberRide > h6").text();

  if (emailC != "" || emailP != "") {
    let emails = emailC + "|" + emailP;
    let address = new Array();

    $(".uberRideLiElement").each(function () {
      let currentAddress = $(this).text();
      address.push(currentAddress);
    });


    let content = address.join("|");

    let url = urlHost + "sendMail/uberRide/";

    $.ajax({
      url: url,
      type: "POST",
      data:
        "emails=" +
        emails +
        "&content=" +
        content +
        "&title=" +
        title +
        "&dateDay=" +
        dateDay,
      dataType: "html",
      success: function (html, statut) {
        toastr.success("Email(s) envoyés");
      },
    });
  }
});

const exportUber = (idRide) => {
  $("#showUberRide").toggle();

  let title = $("#rideHeaderName-" + idRide).text();

  let section = $("#ride" + idRide);
  let startAdd, endAdd;
  if (section.hasClass("dropinBlock")) {
    startAdd = "<i>Départ : Premier stop</i>";
    endAdd = "<b>Arrivée : ENERGY KIDS ACADEMY";
  } else {
    startAdd = "<b>Départ : ENERGY KIDS ACADEMY - BIÈVRES</b>";
    endAdd = "<i>Arrivée : Dernier stop</i>";
  }

  $("#showUberRide > h7").html(title);

  let htmlContent = "<ul>";
  htmlContent += "<li class='uberRideLiElement'>" + startAdd + "</li>";
  $(`[data-id-ride=${idRide}]`)
    .find("li")
    .each(function () {
      let address = $(this).attr("data-address");

      let age = $(this).attr("data-age");

      let hour = $(this)
        .children()
        .attr("data-hour");
      let time = hour.substring(0, 2);
      let minu = hour.substring(2, 4);
      htmlContent +=
        "<li class='uberRideLiElement'>" +
        time +
        ":" +
        minu +
        " : " +
        address + " / " + age +
        "</li>";
    });
  htmlContent += "<li class='uberRideLiElement'>" + endAdd + "</li>";
  htmlContent += "</ul>";

  $("#uberRideContent").html(htmlContent);
};
/*** end sms uber */

const duplicateRide = (self) => {
  let element = $(self)
    .parent()
    .parent()
    .parent()
    .parent();

  var idRide = $(element).attr("data-id-ride");
  swal({
    title: "Attention",
    text: "Le trajet va être dupliqué sur le trajet lié.",
    type: "warning",
    confirmButtonText: "Dupliquer",
    cancelButtonText: "Annuler",
    showCancelButton: true,
  }).then((result) => {
    if (result.value) {
      let data = {};
      let url = "pickup/affect-linked-ride/" + idRide;
      let type = "PUT";
      $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type, url, data },
        dataType: "json",
        beforeSend() {
          $(".loading").show();
        },
        success(json) {
          $(".loading").hide();
          locationRedirect();
        },
      });
    }
  });
};

const lockRide = (self) => {
  let element = $(self)
    .parent()
    .parent()
    .parent()
    .parent();

  var idRide = $(element).attr("data-id-ride");

  let data = { locked: 1 };
  let url = "ride/modify/" + idRide;
  let type = "PUT";
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type, url, data },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(".loading").hide();

      toastr.success(json.message);
    },
  });

  $("select option[value=" + idRide + "]").attr("disabled", "disabled");

  $(element)
    .addClass("isLocked")
    .append(
      '<button onclick="unLockRide(this)" class="unlock button withIcon"><i class="material-icons">lock_key</i> Débloquer ce trajet </button>'
    );

  $(element)
    .find("ul")
    .sortable("disable");
};

const changeStatus = (status) => {
  let idPickUp = $("#lastIdPickup").val();
  let url = `pickup/modify/${idPickUp}`;
  let data = [];
  data = { status };

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "PUT", url, data },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(".loading").hide();
      const date = new Date(json.pickup.updatedAt);

      $(`[data-id-pickup=${idPickUp}]`)
        .removeClass("npec")
        .removeClass("pec")
        .removeClass("automatic")
        .addClass(json.pickup.status);

      if (json.pickup.status == "pec") {
        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status olive">check</i>'
        );
      } else if (json.pickup.status == "npec") {
        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status red">close</i>'
        );
      } else {
        $(`[data-id-pickup=${idPickUp}]`)
          .removeClass("npec")
          .removeClass("pec")
          .removeClass("automatic")
          .addClass("nopec");

        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status blue">access_time</i>'
        );
      }
    },
  });
};

const unLockRide = (self) => {
  let element = $(self).parent();

  $(element).removeClass("isLocked");

  var idRide = $(element).attr("data-id-ride");
  var data = { locked: 0 };
  let url = "ride/modify/" + idRide;
  let type = "PUT";
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type, url, data },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(".loading").hide();

      toastr.success("Trajet unlock");
    },
  });

  $("select option[value=" + idRide + "]").removeAttr("disabled");

  $(element)
    .find("ul")
    .sortable("enable");

  $(self).remove();
};

var saveDispatch = (type, ride) => {
  const nbPEC = $("#pickUpListNPEC > aside > li").length;
  countPlaces();
  if (type == "button") {
    $(".column2 > section").removeClass("noValidateRide");
    countValidate();
    var stateValidated = "validated";
  } else {
    var stateValidated = "no";
  }

  const pickups = [];
  const pickupsNPEC = [];

  if (ride == null || ride == "all") {
    // alert('test');
    $(".column2")
      .find("section")
      .each(function () {
        const idRide = $(this).attr("data-id-ride");
        let sortOrder = 0;
        let sortOrderLetter = 0;

        $(`[data-id-ride=${idRide}]`)
          .find("li")
          .each(function () {
            sortOrder++;
            const idPickUp = $(this).attr("data-id-pickup");
            $(`[data-id-pickup=${idPickUp}]`)
              .find(".numberOrder.number")
              .html(sortOrder);
            var checkbox = $(this).find(".checkboxRideFixed");

            pickups.push({
              pickupId: idPickUp,
              rideId: idRide,
              sortOrder,
              validated: stateValidated,
              start: "null",
            });
          });
      });

    var sortOrderNpec = 0;
    var sortOrderLetter = 0;
    $(".column1")
      .find("li")
      .each(function () {
        sortOrderNpec++;
        const idPickUp = $(this).attr("data-id-pickup");
        $(`[data-id-pickup=${idPickUp}]`)
          .find(".numberOrder.number")
          .html(sortOrderNpec);

        pickupsNPEC.push({
          pickupId: idPickUp,
          rideId: "null",
          sortOrder: sortOrderNpec,
          validated: "no",
          start: "null",
        });
      });

    let url = "pickup/dispatch";

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "PUT", url, data: pickups },
      dataType: "json",
      beforeSend() { },
      success(json) { },
    });

    if (nbPEC > 0) {
      $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "PUT", url, data: pickupsNPEC },
        dataType: "json",
        beforeSend() { },
        success(json) { },
      });
    }
  } else {
    if (ride == "npec") {
      var sortOrderNpec = 0;

      $(".column1")
        .find("li")
        .each(function () {
          sortOrderNpec++;
          const idPickUp = $(this).attr("data-id-pickup");

          pickups.push({
            pickupId: idPickUp,
            rideId: "null",
            sortOrder: sortOrderNpec,
            validated: "no",
            start: "null",
          });
        });
    } else {
      const idRide = ride;
      let sortOrder = 0;
      $(`[data-id-ride=${idRide}]`).addClass("noValidateRide");
      countValidate();

      var mapRideOpen = $("#mapRideOpen").val();

      if (mapRideOpen == 1) {
        openMapRide("", "", ride);
      }

      $(`[data-id-ride=${idRide}]`)
        .find("li")
        .each(function () {
          sortOrder++;
          const idPickUp = $(this).attr("data-id-pickup");

          $(`[data-id-pickup=${idPickUp}]`)
            .find(".numberOrder.number")
            .html(sortOrder);
          pickups.push({
            pickupId: idPickUp,
            rideId: idRide,
            sortOrder,
            validated: stateValidated,
            start: "null",
          });
        });
    }

    let url = "pickup/dispatch";

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "PUT", url, data: pickups },
      dataType: "json",
      beforeSend() { },
      success(json) { },
    });
  }
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
        .each(function () {
          const name = $(this).attr("name");
          $(this).val(json[name]);
        });

      $("#payment_due").val(json.paymentDue);
      $("#payment_done").val(json.paymentDone);

      loadAdressesChild(json.child.childId);
      let hour = json.start;
      hour = hour.slice(-5);
      $("#start_not").val(hour);
      $("[name=kind]").val(json.kind);
    },
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
  loadAdressesDriver(
    $("#selectDriver")
      .find(":selected")
      .data("id-person")
  );
  var idVehicle = $("#selectDriver")
    .find(":selected")
    .data("id-vehicle");
  $("[name=vehicle]").val(idVehicle);
});

const editRide = (idRide) => {
  loadDrivers();
  loadRidesForList();
  loadVehicles();

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
        .each(function () {
          const name = $(this).attr("name");
          $(this).val(json[name]);
        });

      if (json.places == null) {
        $("[name=places]").val(8);
      }

      if (json.staff.staffId != null) {
        //doute sur cette ligne
        $("[name=staff]").val(json.staff.staffId);
      }

      if (json.linkedRide != null) {
        $("[name=linkedRide]").val(json.linkedRide.rideId);
      }

      $("#start_ride").val(json.start);
      $("#arrival_ride").val(json.arrival);

      if (json.staff.person.personId != null) {
        loadAdressesDriver(json.staff.person.personId);
      }

      if (json.staff.vehicle.vehicleId != null) {
        $("[name=vehicle]").val(json.staff.vehicle.vehicleId);
      }
    },
  });
};

const getIdPickup = (idPickUp) => {
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
    showCancelButton: true,
  }).then((result) => {
    if (result.value) {
      deletePickupSubmit(idPickUp);
    }
  });
};

var deleteRideSubmit = (idRide) => {
  let url = `ride/delete/${idRide}`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type: "DELETE" },
    dataType: "json",
    beforeSend() { },
    success(json) {
      if (json.status == true) {
        toastr.success(json.message, "Suppression");
        $(`[data-id-ride=${idRide}]`)
          .addClass("animated bounceOutUp")
          .delay(750)
          .hide(0);
      } else {
        swal({
          title: "Suppression",
          text: "Une erreur est survenue.",
          type: "warning",
        });
      }
    },
  });
};

var deletePickupSubmit = (idPickUp) => {
  let url = `pickup/delete/${idPickUp}`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type: "DELETE" },
    dataType: "json",
    beforeSend() { },
    success(json) {
      if (json.status == true) {
        toastr.success(json.message, "Suppression");
        $(`[data-id-pickup=${idPickUp}]`)
          .addClass("animated bounceOutUp")
          .delay(750)
          .remove(0);
        setTimeout(function () {
          countPlaces();
        }, 1500);
      } else {
        swal({
          title: "Suppression",
          text: "Une erreur est survenue.",
          type: "warning",
        });
      }
    },
  });
};

document.getElementById("pickUpForm").addEventListener(
  "submit",
  (event) => {
    event.preventDefault();
    let form = $("#pickUpForm");
    let url = form.attr("action");
    let type = "POST";
    let data = $(form).serializeToJSON();

    if (url.includes("modify")) {
      type = "PUT";
    }

    if ($("#addPresence").is(":checked")) {
      let data4 = [];
      data4.push({
        child,
        person,
        registration: "",
        date: dateData,
        location,
        start: sessionStart,
        end: sessionEnd,
      });
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
          $("#revealPickUp").foundation("close");
          toastr.success(json.message, "Confirmation");
          let photo = photoProfilDefault;

          if (json.pickup.child.photo != null) {
            photo = json.pickup.child.photo;
          }

          const date = new Date(json.pickup.start);
          const hours = date.getHours();
          const minutes = date.getMinutes();
          const select = $(".with-select").html();

          if ($("#addActivity").is(":checked")) {
            let child = $("#formChildId").val();
            let date = $("#date").val();

            openRevealJS("reveal-iframe");
            $("#reveal-iframe")
              .find("#close-iframe-full")
              .attr("onClick", "location.reload()");
            $(".frameFullScreen").attr(
              "src",
              `${urlHost}activity/create-pickup/date/${date}/child/${child}/iframe/yes/`
            );
          } else {
          }

          if (url.includes("modify")) {
            if (json.pickup.ride == null) {
              let date = $("#date").val();
              const url = urlHost + "/transport/loadNpec/date/" + date + "/";
              var content;
              $.get(url, function (data) {
                content = data;
                $(".column1 section").replaceWith(content);
              });
            } else {
              let date = $("#date").val();
              const url =
                urlHost +
                "/transport/loadOneRide/date/" +
                date +
                "/idRide/" +
                json.pickup.ride.rideId +
                "/";
              var content;
              $.get(url, function (data) {
                content = data;
                $(`[data-id-ride=${json.pickup.ride.rideId}]`).replaceWith(
                  content
                );
                countPlaces();
                colorRide();
              });
            }
          } else {
            let date = $("#date").val();
            const url = urlHost + "/transport/loadNpec/date/" + date + "/";
            var content;
            $.get(url, function (data) {
              content = data;
              $(".column1 section").replaceWith(content);
            });
          }
        } else {
          $("#revealPickUp").foundation("close");
          swal({
            title: "Erreur",
            text: "Une erreur est survenue.",
            type: "warning",
          });
        }
      },
    });
  },
  false
);

document.getElementById("rideForm").addEventListener(
  "submit",
  (event) => {
    event.preventDefault();
    let form = $("#rideForm");
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
        $("#rideForm [type=submit]")
          .attr("disabled", true)
          .attr("value", "Envoi en cours..");
      },
      success(json) {
        $("#rideForm [type=submit]")
          .attr("disabled", false)
          .attr("value", "Envoyer");

        if (json.status == true) {
          $("#revealCreateTrajet").foundation("close");
          toastr.success(json.message, "Confirmation");

          if (url.includes("modify")) {
            let date = $("#date").val();
            const url =
              urlHost +
              "/transport/loadOneRide/date/" +
              date +
              "/idRide/" +
              json.ride.rideId +
              "/";
            var content;
            $.get(url, function (data) {
              content = data;
              $(`[data-id-ride=${json.ride.rideId}]`).replaceWith(content);
              countPlaces();
              colorRide();
              const hour = $(`[data-id-ride=${json.ride.rideId}]`).attr(
                "data-hour"
              );
              $(".column2")
                .find(".breakTime")
                .each(function () {
                  if ($(this).attr("data-hour") <= hour) {
                    $(`[data-id-ride=${json.ride.rideId}]`).insertAfter(
                      $(this)
                    );
                  }
                });
            });
          } else {
            let date = $("#date").val();
            const url =
              urlHost +
              "/transport/loadOneRide/date/" +
              date +
              "/idRide/" +
              json.ride.rideId +
              "/";
            var content;
            $.get(url, function (data) {
              content = data;
              $(".column2").prepend(content);
              countPlaces();
              colorRide();
              const hour = $(`[data-id-ride=${json.ride.rideId}]`).attr(
                "data-hour"
              );

              $(".column2")
                .find(".breakTime")
                .each(function () {
                  if ($(this).attr("data-hour") <= hour) {
                    $(`[data-id-ride=${json.ride.rideId}]`).insertAfter(
                      $(this)
                    );
                  }
                });
            });
          }
        } else {
          $("#revealCreateTrajet").foundation("close");
          swal({
            title: "Erreur",
            text: "Une erreur est survenue.",
            type: "warning",
          });
        }
      },
    });
  },
  false
);

const changeActionRide = () => {
  $("#rideForm").attr("action", "ride/create");
  $("#rideForm").trigger("reset");
};

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

const goToProfilChild = () => {
  const idPickUp = $("#lastIdPickup").val();
  const idChild = $(`[data-id-pickup=${idPickUp}]`)
    .find(".list-header")
    .attr("data-id-child");

  openRevealJS("reveal-iframe");

  $(".frameFullScreen").attr(
    "src",
    `${urlHost}child/display/id/${idChild}/iframe/yes/`
  );
};

document.getElementById("loadMoreListChild").addEventListener(
  "click",
  function (event) {
    const element = $(this);
    let page = parseInt($(element).attr("data-page"));
    const size = $(element).attr("data-size");

    if ($("#searchListChild").val() != "") {
      const searchTerm = $("#searchListChild").val();
      var pageSuivante = parseInt($("#pageSearch").val()) + 1;
      var url = `child/search/${searchTerm}?size=${size}&page=${pageSuivante}`;
      $("#pageSearch").val(pageSuivante);
    } else {
      var pageSuivante = page + 1;
      var url = `child/list?page=${pageSuivante}&size=${size}`;
    }

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type: "GET" },
      dataType: "json",
      beforeSend() {
        $(element)
          .attr("disabled", true)
          .html("Chargement en cours..");
      },
      success(json) {
        $(element)
          .attr("disabled", false)
          .html("Afficher plus");
        const numberOfElements = json.length;

        if (numberOfElements > 0) {
          for (i = 0; i < numberOfElements; i++) {
            let photo = photoProfilDefault;

            if (json.photo != null) {
              photo = json.photo;
            }

            $("#childList").append(
              `<li id="li${json[i].childId}"><a href="javascript:void(0)" onclick="addThisChild(\`${json[i].childId}\`, this)"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${json[i].firstname} ${json[i].lastname}<div class="with-icon">AJOUTER</div> </p>  </div> </a></li>`
            );
          }

          $(element).attr("data-page", pageSuivante);
        } else {
          $(element)
            .attr("disabled", true)
            .html("Liste terminée.");
        }
      },
    });
  },
  false
);

document.getElementById("searchListChild").addEventListener(
  "keyup",
  function (event) {
    $("#loadMoreListChild").show();

    let searchTerm = $(this).val();
    let size = $("#loadMoreListChild").attr("data-size");
    let url = `child/search/${searchTerm}?size=${size}&page=1`;
    $("#childList").html("");
    $("#pageSearch").val(1);
    $("#loadMoreListChild").attr("disabled", false);

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type: "GET" },
      dataType: "json",
      beforeSend() {
        $("#childList").html(showLoader);
      },
      success(json) {
        const numberOfElements = json.length;

        if (numberOfElements > 0) {
          $("#childList").html("");

          for (i = 0; i < numberOfElements; i++) {
            let photo = photoProfilDefault;

            if (json.photo != null) {
              photo = json.photo;
            }

            $("#childList").append(
              `<li id="li${json[i].childId}"><a href="javascript:void(0)" onclick="addThisChild(\`${json[i].childId}\`, this)"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${json[i].firstname} ${json[i].lastname}<div class="with-icon"> AJOUTER</div> </p>  </div> </a></li>`
            );
          }
        } else {
          $("#childList").html(
            "<p><strong><center>Aucun résultat.</center></strong></p>"
          );
        }
      },
    });
  },
  false
);

const addThisChild = (idChild, data) => {
  const li = $(data).parent("li");
  $(li).css("background-color", "#dcedc8");
  const idLi = $(li).attr("id");
  $(`#childList li:not(#${idLi})`).hide();
  $("[name=child]").val(idChild);
  $("#loadMoreListChild").hide();

  loadAdressesChild(idChild);
};

var loadAdressesChild = (idChild) => {
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
    },
  });
};

const changeAddress = (data) => {
  const address = $(data).attr("data-address");
  const postal = $(data).attr("data-postal");
  $("[name=postal]").val(postal);
  $("#autocomplete3").val(address);
};

var loadAdressesDriver = (idDriver) => {
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
    },
  });
};

const changeAddressDriver = (data) => {
  const address = $(data).attr("data-address");
  $("#autocomplete1").val(address);
};

const launchIa = (idRide) => {
  $(".loading").show();
  let depart = $(`[data-id-ride=${idRide}]`).attr("data-startPoint");
  let arrive = $(`[data-id-ride=${idRide}]`).attr("data-endPoint");
  let waypts = [];

  $(`[data-id-ride=${idRide}]`)
    .find("li")
    .each(function () {
      const idPickUp = $(this).attr("data-id-pickup");

      waypts.push({
        location: $(this).attr("data-address"),
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
      travelMode: google.maps.TravelMode.DRIVING,
    },
    (data, status2) => {
      const legs = data.routes[0].legs;
      const waypoint_order = data.routes[0].waypoint_order;
      const numberOfElementsWay = waypoint_order.length;

      const lists = $(`[data-id-ride=${idRide}] li`);
      lists.detach();
      const order = [];

      for (i = 0; i < numberOfElementsWay; i++) {
        let waypointsid = waypoint_order[i];
        order.push(waypoint_order[i]);
      }

      const len = order.length;
      const temp = [];

      for (var i = 0; i < len; i++) {
        temp.push(lists[order[i]]);
      }

      $(`[data-id-ride=${idRide}] ul`).append(temp);
      $(".loading").hide();

      var mapRideOpen = $("#mapRideOpen").val();

      if (mapRideOpen == 1) {
        openMapRide("", "", idRide);
      }

      numberOfElements = legs.length;
      const x = 1;
      const z = 0;
      let geocoder;
      let map;
      let directionsDisplay;
      const directionsService = new google.maps.DirectionsService();
      const locations = [];
    }
  );
};

const countTime = (idRide) => {
  $(".loading").show();
  let depart = $(`[data-id-ride=${idRide}]`).attr("data-startPoint");
  let arrive = $(`[data-id-ride=${idRide}]`).attr("data-endPoint");
  let waypts = [];

  $(`[data-id-ride=${idRide}]`)
    .find("li")
    .each(function () {
      const idPickUp = $(this).attr("data-id-pickup");

      var spec = $(this).hasClass("npec");

      if (spec == false) {
        waypts.push({
          location: $(this).attr("data-address"),
        });
      }
    });

  const directionService = new google.maps.DirectionsService();
  const geocoder = new google.maps.Geocoder();

  directionService.route(
    {
      origin: depart,
      destination: arrive,
      waypoints: waypts,
      travelMode: google.maps.TravelMode.DRIVING,
    },
    (data, status2) => {
      const legs = data.routes[0].legs;
      numberOfElements = legs.length;

      let startHour = $(`[data-id-ride=${idRide}]`).attr("data-start");
      var d = new Date(startHour.replace(" ", "T"));
      startHour = new Date(d);
      /** 
      if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i))) {
        startHour.setHours(startHour.getHours() - 2);
      }*/
      let sortOrder = 0;
      let sortArray = 0;
      let pickups = [];
      let arrayTime = [];
      for (i = 0; i < numberOfElements; i++) {
        const time = legs[i].duration.value;
        arrayTime.push(time);
      }

      $(`[data-id-ride=${idRide}]`)
        .find("li")
        .each(function () {
          var spec = $(this).hasClass("npec");

          if (spec == false) {
            var timeTravel = arrayTime[sortArray];
          } else {
            var timeTravel = 0;
          }

          if (timeTravel == 0) {
            totalMilliSecond = startHour.getTime() + timeTravel * 1000;
          } else {
            totalMilliSecond = startHour.getTime() + timeTravel * 1000;
            if (sortArray != 0) {
              totalMilliSecond = totalMilliSecond + minutesToAdd;
            }
          }

          startHour = new Date(totalMilliSecond);

          const year = startHour.getFullYear();
          const month = ("0" + (startHour.getMonth() + 1)).slice(-2);
          const day = ("0" + startHour.getDate()).slice(-2);
          let hours = startHour.getHours();
          hours = `0${hours}`.slice(-2);
          let minutes = startHour.getMinutes();
          minutes = `0${minutes}`.slice(-2);

          if (spec == false) {
            var dateFormat = `${year}-${month}-${day} ${hours}:${minutes}:00`;
            sortArray++;
            var displayTime = `${hours}:${minutes}`;
          } else {
            var dateFormat = `${year}-${month}-${day} 00:00:00`;
            var displayTime = `00:00`;
          }

          $(this)
            .find(".timePickup")
            .html(displayTime);

          sortOrder++;
          const idPickUp = $(this).attr("data-id-pickup");

          pickups.push({
            pickupId: idPickUp,
            rideId: idRide,
            sortOrder,
            validated: "no",
            start: dateFormat,
          });
        });

      let url = "pickup/dispatch";

      $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "PUT", url, data: pickups },
        dataType: "json",
        beforeSend() {
          $(".loading").show();
        },
        success(json) {
          $(".loading").hide();
          //location.hash = 'ride' + idRide;
          toastr.success("Horaires modifiées.");
          // setTimeout(function(){ locationRedirect(); }, 3000);
        },
      });
    }
  );
};

const autoDispatch = (force, date, kind) => {
  if (kind == undefined) {
    let url = `pickup/affect/${date}/all`;

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "PUT", url },
      dataType: "json",
      beforeSend() {
        $(".loading").show();
      },
      success(json) {
        $(".loading").hide();
        locationRedirect();
      },
    });
  } else {
    let url = `pickup/affect/${date}/${kind}/${force}`;

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "PUT", url },
      dataType: "json",
      beforeSend() {
        $(".loading").show();
        locationRedirect();
      },
      success(json) {
        $(".loading").hide();
        locationRedirect();
      },
    });
  }
};

const autoDispatchUnaffect = (date, kind) => {
  if (kind == undefined) {
    let url = `pickup/unaffect/${date}/dropoff`;

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "PUT", url },
      dataType: "json",
      beforeSend() {
        $(".loading").show();
      },
      success(json) {
        $(".loading").hide();
        locationRedirect();
      },
    });

    let url2 = `pickup/unaffect/${date}/dropin`;

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "PUT", url: url2 },
      dataType: "json",
      beforeSend() {
        $(".loading").show();
      },
      success(json) {
        $(".loading").hide();
        locationRedirect();
      },
    });
  } else {
    let url = `pickup/unaffect/${date}/${kind}`;

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "PUT", url },
      dataType: "json",
      beforeSend() {
        $(".loading").show();
      },
      success(json) {
        $(".loading").hide();
        locationRedirect();
      },
    });
  }
};
