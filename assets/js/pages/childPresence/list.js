$(() => {
  initMultiSelect();
});


var initMultiSelect = () => {
  $("#locationsFilters").zmultiselect({
    filter: true,
    filterResult: true,
    selectAll: true,
    selectAllText: ["Tout cocher", "Tout décocher"],
    selectedText: ["Sélectionné : ", "/"],
    filterPlaceholder: "",
    filterResultText: "",
    filterPlaceholder: "Filtrer par",
    get: "zmultiselect",
    placeholder: "Filtrer les lieux",
    live: "#liveResult"
  });
};


const numberFormat = (number, width) => new Array(+width + 1 - (number + "").length).join("0") + number;

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

  $("#childPresenceList")
    .find("li")
    .each(function() {
      const endHour = $(this).attr("data-end-hour");
      const startHour = $(this).attr("data-start-hour");

     if (
        parseInt(startHour) >= parseInt(reqHour1) &&
        parseInt(endHour) <= parseInt(reqHour2)
      ) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });

});



$("#locationsFilterValidate").click(() => {
  var myValue = $("#liveResult").val();
  var myValue = myValue.split(",");

  $("#childPresenceList")
    .find("li")
    .each(function() {
      const location = $(this).attr("data-location");

      if (jQuery.inArray(location, myValue) == -1) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
});


const openDatePicker = (route) => {

  if(route == "week") {
    route = "";
  }

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
    dateFormat: "yy-mm-dd",
    changeYear: true,
    onSelect(dateText) {
      var url = `${urlHost}child/presence${route}/date/${dateText}/`;
      locationRedirect(url);
    }
  });
};
