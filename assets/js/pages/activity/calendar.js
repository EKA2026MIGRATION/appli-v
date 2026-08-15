
$(() => {

  $("#calendar").fullCalendar({
    defaultView: "agendaDay",
    defaultDate: "2018-10-17",
    locale: "fr",
    editable: true,
    schedulerLicenseKey: "CC-Attribution-NonCommercial-NoDerivatives",
    selectable: true,
    eventLimit: true,
    header: {
      left: "",
      center: "",
      right: ""
    },
    allDaySlot: false,
    resources: generateRessources,
    events: generateEvents,
    eventRender(event, element, view) {
      let elementToHtml = $(`#listChild${event.id}`).html();
      $(element).append(elementToHtml);

      $(element).css("overflow", "auto");
    },
    select(start, end, jsEvent, view, resource) {
      console.log(
        "select",
        start.format(),
        end.format(),
        resource ? resource.id : "(no resource)"
      );
    },
    dayClick(date, jsEvent, view, resource) {
      console.log(
        "dayClick",
        date.format(),
        resource ? resource.id : "(no resource)"
      );
    },
    eventClick(event) {
      if (event.type) {
        $(`#dialog${event.id}`).remove();
        $("#dialogAppend").append(
          `<div id="dialog${event.id}" title="${event.title}"><section class="block-list"><ul class="contentDialog${event.id}"></ul></section></div>`
        );
        if (event.type == "npec") {
          $("#revealActivity").foundation("open");
        } else {
          $(`#revealGroup${event.id}`).foundation("open");
        }
      }
    }
  });
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
    dateFormat: "yy-mm-dd",
    changeYear: true,
    onSelect(dateText) {

      var url = `${urlHost}activity/calendar/date/${dateText}/`;
      locationRedirect(url);


    }
  });
};
