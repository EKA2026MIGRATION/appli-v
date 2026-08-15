const openDatePicker = () => {
  $("#datePickerInline").datepicker({
    closeText: "Fermer",
    prevText: "Précédent",
    nextText: "Suivant",
    firstDay: 1,
    yearRange: "-100:+0",
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
      var url = `${urlHost}ticket/rdv/date/${year}-${month}/`;
      locationRedirect(url);

    }
  });
};