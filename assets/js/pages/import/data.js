$("#datePickerTransport").datepicker({
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
  dateFormat: "yy-mm-dd",
  changeYear: true,
  onSelect(dateText) {

    $('#dataSearched').val(dateText);
    let html = '<div style="color: darkblue; font-style: italic;">Recherche de transport en cours pour le '+dateText+'</div>';
    $('#showTransportInfo').html(html);
    $('#datePickerTransport').hide();
    let url = urlHost+'import/transport/date/'+dateText+'/';
    $(".loading").show();

    $('#showTransportInfo').load(url, function() {
      $(".loading").hide();
    });
    $('#reloadImport').html('Relancer pour le '+dateText);

  }
});

$('#datePickerTransportButton').click(function() {
  $('#datePickerTransport').toggle();
})

$('#reloadImport').click(function() {
  let dateText = $('#dataSearched').val();
  $(".loading").show();

  let html = '<div style="color: darkblue; font-style: italic;">Recherche de transport en cours pour le '+dateText+'</div>';
  $('#showTransportInfo').html(html);
  $('#datePickerTransport').hide();
  let url = urlHost+'import/transport/date/'+dateText+'/';
  $('#showTransportInfo').load(url, function() {
    $(".loading").hide();
  });
})






$("#datePickerActivity").datepicker({
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
  dateFormat: "yy-mm-dd",
  changeYear: true,
  onSelect(dateText) {
    $(".loading").show();

    $('#dataSearched2').val(dateText);
    let html = '<div style="color: darkblue; font-style: italic;">Recherche activités en cours pour le '+dateText+'</div>';
    $('#showActivityInfo').html(html);
    $('#datePickerActivity').hide();
    let url = urlHost+'import/activity/date/'+dateText+'/';
    $('#showActivityInfo').load(url, function() {
      $(".loading").hide();
    });
    $('#reloadImport').html('Relancer pour le '+dateText);

  }
});

$('#datePickerActivityButton').click(function() {
  $('#datePickerActivity').toggle();
})

$('#reloadImport2').click(function() {
  $(".loading").show();

  let dateText = $('#dataSearched2').val();

  let html = '<div style="color: darkblue; font-style: italic;">Recherche activités en cours pour le '+dateText+'</div>';
  $('#showActivityInfo').html(html);
  $('#datePickerActivity').hide();
  let url = urlHost+'import/activity/date/'+dateText+'/';
  $('#showActivityInfo').load(url, function() {
    $(".loading").hide();
  });
})

$('#importChild').click(function() {
  $(".loading").show();
  let url = urlHost+'import/child/';
  $('#showChildInfo').load(url, function() {
    $(".loading").hide();
  });
})
