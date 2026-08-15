$(() => {
  initFullCalendar();
  initDatePicker();
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
      "Décembre"
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
      "Déc."
    ],
    dayNames: [
      "Dimanche",
      "Lundi",
      "Mardi",
      "Mercredi",
      "Jeudi",
      "Vendredi",
      "Samedi"
    ],
    dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
    dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
    weekHeader: "Sem.",
    dateFormat: 'MM yy',
    changeMonth: true,
    changeYear: true,
    onSelect(dateText) {


    },
    onChangeMonthYear: function (year, month) {

      var staffId = $("#staffId").val();
      month = ('0' + month).slice(-2);
      var url = `${urlHost}staffPresence/display/id/${staffId}/date/${year}-${month}/`;
      locationRedirect(url);

    }
  });
};



function getDates(startDate, stopDate) {
    var dateArray = [];
    var currentDate = moment(startDate);
    var stopDate = moment(stopDate);
    while (currentDate <= stopDate) {
        dateArray.push( moment(currentDate).format('YYYY-MM-DD') )
        currentDate = moment(currentDate).add(1, 'days');
    }
    return dateArray;
}

const initFullCalendar = () =>
{

  const staffId = $("#staffId").val();
  const dateCalendar = $("#dateCalendar").val();
  $("#calendar").fullCalendar({
    defaultView: "month",
    locale: "fr",
    defaultDate: dateCalendar,
    editable: true,
    schedulerLicenseKey: "CC-Attribution-NonCommercial-NoDerivatives",
    selectable: true,
    eventLimit: true, // allow "more" link when too many events
    header: {
      left: "",
      center: "",
      right: ""
    },
    allDaySlot: false,
    events: {
      url: `${urlHost}staffPresence/json/`,
      type: "POST",
      data: {
        staffId,
        date: dateCalendar
      },
      error(e) {
        alert("there was an error while fetching events!");
      }
    },
    eventRender(event, element, view) {
      $(element).css("height", "250px");
    },
    select(start, end, jsEvent, view, resource) {
      /*
      console.log(
        "select",
        start.format(),
        end.format(),
        resource ? resource.id : "(no resource)"
      );*/
    },
    dayClick(date, jsEvent, view, resource) {
      $("#lastDatePresence").val(date.format());
      openRevealJS("action-add-presence");
    },
    eventClick(event) {
      $("#lastIdPresence").val(event.id);
      openRevealJS("action-presence");
    }
  });
}



document.getElementById("createPresenceSeason").addEventListener(
  "click",
  event => {

    let type = "POST";
    let url = "staff/presence/create";
    let staff = $("#staffId").val();
    let startHour = $("#start-hour-season").val();
    let endHour = $("#end-hour-season").val();
    let arrayDateTotal = [];


    $("#seasonList")
      .find(":checkbox:checked")
      .each(function() {

        let dateStart = $(this).attr('data-start');
        let dateEnd = $(this).attr('data-end');
        let arrayDate = getDates(dateStart, dateEnd);
        arrayDate.forEach(function(date) {

          arrayDateTotal.push(date);

        });


      });


      let data = [];

    if (startHour != "" && endHour != "") {
      end = `${endHour}:00`;
      start = `${startHour}:00`;

      arrayDateTotal.forEach(function(date) {
        data.push({
          staff,
          date,
          start,
          end
        });
      });

    } else {

      arrayDateTotal.forEach(function(date) {
        data.push({
          staff,
          date
        });
      });

    }

    launchCreatePresence(url, type, data);


  },
  false
);

const checkAll = () =>
{
    $("#seasonList")
      .find(":checkbox")
      .each(function() {

        $(this).attr('checked', 'checked');

      });
}

const unCheckAll = () =>
{

    $("#seasonList")
      .find(":checkbox:checked")
      .each(function() {

        $(this).removeAttr('checked');

      });


}

document.getElementById("createPresenceByPlage").addEventListener(
  "click",
  event => {

    let type = "POST";
    let url = "staff/presence/create";
    let staff = $("#staffId").val();
    let startDate = $("#startDate").val();
    let endDate = $("#endDate").val();
    let startHour = $("#start-hour-plage").val();
    let endHour = $("#end-hour-plage").val();
    let arrayDate = getDates(startDate, endDate);
    let data = [];


    if (startHour != "" && endHour != "") {
      end = `${endHour}:00`;
      start = `${startHour}:00`;

      arrayDate.forEach(function(date) {
        data.push({
          staff,
          date,
          start,
          end
        });
      });

    } else {

      arrayDate.forEach(function(date) {
        data.push({
          staff,
          date
        });
      });

    }

    launchCreatePresence(url, type, data);




  },
  false
);


document.getElementById("createPresence").addEventListener(
  "click",
  event => {
    let type = "POST";
    let url = "staff/presence/create";
    let staff = $("#staffId").val();
    let date = $("#lastDatePresence").val();
    let end = $("#end").val();
    let start = $("#start").val();
    let location = $('#location').val();

    let typeName = $('#type_name').val();

    let teamsIdList = "";

    $('.checkboxTeams').each(function() {
      if( $(this).prop('checked') ) {
          let myTeam = $(this).val();
          teamsIdList += ","+myTeam;
      }
    })

    if (end != "" && start != "") {
      end = `${end}:00`;
      start = `${start}:00`;
      var data = [{ staff, date, start, end, typeName, teamsIdList, location}];
    } else {
      var data = [{ staff, date, typeName , teamsIdList, location}];
    }


    console.log(data);
     launchCreatePresence(url, type, data, "autoclose");
  },
  false
);

document.getElementById("createPresenceProduct").addEventListener(
  "click",
  event => {

    let type = "POST";
    let url = "staff/presence/create";
    let staff = $("#staffId").val();
    let startHour = $("#start-hour-product").val();
    let endHour = $("#end-hour-product").val();
    let location = $('#location-product').val();

      let arrayDateTotal = [];


      console.log(location);


    $(".headerProduct")
      .find(":checkbox:checked")
      .each(function() {

        let idProduct = $(this).attr('data-product');

        $("#ulproduct" + idProduct)
          .find(":checkbox:checked")
          .each(function() {

            let date = $(this).attr('data-date');

            arrayDateTotal.push(date);

          });

      });


      let data = [];

    if (startHour != "" && endHour != "") {
      end = `${endHour}:00`;
      start = `${startHour}:00`;

      arrayDateTotal.forEach(function(date) {
        data.push({
          staff,
          date,
          start,
          end,
          location
        });
      });

    } else {

      arrayDateTotal.forEach(function(date) {
        data.push({
          staff,
          date,
          location
        });
      });

    }
    launchCreatePresence(url, type, data);


    console.log(data);

  },
  false
);



const launchCreatePresence = (url, type, data, close = null) =>
{

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type, data },
      dataType: "json",
      beforeSend() {
        $(".loading").show();
      },
      success(json) {
        $(".loading").hide();
        if(close == "autoclose") {
          $("#action-add-presence").foundation('close');
        }
        if (json.status == true) {
          $('#calendar').fullCalendar( 'refetchEvents' );
          toastr.success('Présences ajoutées');

        } else {
          swal({
            title: "Erreur",
            text: "Une erreur est survenue.",
            type: "warning"
          });
        }
      }
    });

}


$(".block-list div header i.arrow").click(function() {
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

document.getElementById("deletePresence").addEventListener(
  "click",
  event => {

    var idPresence = $("#lastIdPresence").val();


    let url = `staff/presence/delete/${idPresence}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
          $(".loading").show();
        },
        success(json) {
            $(".loading").hide();

            if (json.status == true) {
                $('#calendar').fullCalendar( 'refetchEvents' );
                toastr.success('Présence supprimée');
            } else {
                swal({
                    title: "Suppression",
                    text: "Une erreur est survenue.",
                    type: "warning"
                });
            }
        }
    });


  },
  false
);



const initDatePicker = () =>
{

    $("#startDate, #endDate").datepicker({
        altField: "#datepicker",
        altFormat: "yy-mm-dd",
        closeText: "Fermer",
        prevText: "Précédent",
        nextText: "Suivant",
        firstDay: 1,
        yearRange: "-2:+5",
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
            "Décembre"
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
            "Déc."
        ],
        dayNames: [
            "Dimanche",
            "Lundi",
            "Mardi",
            "Mercredi",
            "Jeudi",
            "Vendredi",
            "Samedi"
        ],
        dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
        dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
        weekHeader: "Sem.",
        dateFormat: "yy-mm-dd",
        changeYear: true
    });

}




$("#selectMember").change(() => {
  var date = $("#dateCalendar").val();
  var idMember = $("#selectMember").find(':selected').val();
  locationRedirect(urlHost + 'staffPresence/display/id/' + idMember + '/');
});


$("#productsFiltersValidate").click(() => {
  var myValue = $("#liveResult").val();
  var myValue = myValue.split(",");

  $("#productList")
    .find("section")
    .each(function() {
      const id = this.id;

      if (jQuery.inArray(id, myValue) == -1) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
});
