$(() => {
  //initFullCalendar();
});

$("#selectMember").change(() => {
  var date = $("#dateCalendar").val();
  var idMember = $("#selectMember").find(':selected').val();
  locationRedirect(urlHost + 'staffPresence/display/id/' + idMember + '/');
});

const openDatePicker = () => {
  $("#datePickerInline").datepicker({
    closeText: "Fermer",
    prevText: "Précédent",
    firstDay: 1,
    yearRange: "-1:+3",
    nextText: "Suivant",
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

      var url = `${urlHost}staffPresence/calendar/date/${dateText}/`;
      locationRedirect(url);


    }
  });
};

const initFullCalendar = () =>
{
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
      url: `${urlHost}staffPresence/calendarResumeJson/`,
      type: "POST",
      data: {
        date: dateCalendar
      },
      error(e) {
        console.log(e);
        alert("there was an error while fetching events!");
      },
    },
    eventRender: function (info) {
      console.log('ello');
      console.log(info.event.extendedProps);
      // {description: "Lecture", department: "BioChemistry"}
    }
   
  });
}
