var targetDate;
var currentDate = $('#currentDate').val();

$("#datePicker").datepicker({
  closeText: "Fermer",
  prevText: "Précédent",
  nextText: "Suivant",
  firstDay: 1,
  yearRange: "-2:+2",
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
    targetDate = dateText;
    let element = dateText.split('-');
    let dateFr = element[2]+'/'+element[1]+'/'+element[0];
    $('#checkDate').show();
    $('#datePicker').hide();
    $('#infoCheckDate').text('Préparez la duplication pour le '+dateFr);
    $('#replicationLi').show();
  }
});

$('#datePickerButton').click(function() {
  $('#datePicker').toggle();
})


$('#replicationButton').click(function() {
  $(".loading").show();
  let url = urlHost+'activity/executeDuplicate/source/'+currentDate+'/target/'+targetDate+'/';
  $('#duplicationResult').load(url, function() {
    $(".loading").hide();
  });
})



