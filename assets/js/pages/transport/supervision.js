let supervisionUrlBase = $('#supervisionUrlBase').val();
let supervisionReload = $('#supervisionReload').val();
let kind = "";
let moment = "";
let showAddress = '';

setInterval(() => {
    $('#showSupervision').load(supervisionReload);
}, 240000);



const openDatePicker = () => {
  $('#datePickerInline').show();
  $("#datePickerInline").datepicker({
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
    changeYear: true,
    onSelect(dateText) {
      jumpToDay(dateText);
    }
  });
};

$('.selectButton').change(function(){
    let selectedDate = $('#date').val();
    console.log('changeSelectButton');
    jumpToDay(selectedDate);
});

function jumpToDay(dateText) {
        currentDate = dateText;
        $('#date').val(dateText);
        $('#datePickerInline').hide();
        let dateTextFr = convertDateToFr(dateText)
        $('#showCurrentDate').html(dateTextFr);

        kind = $('#kind').val();
        moment = $('#moment').val();
        showAddress = $('#selectedDate').val();
        let url = supervisionUrlBase+dateText+'/filter/'+kind+','+moment+'/showAddress/'+showAddress+'/';
        document.location.replace(url);
}

$('.jumpToDayButton').click(function(e) {
    let currentDate = $('#date').val();
    let dateText;
    e.preventDefault();
    let direction = $(this).attr('id');
    if(direction == "previousDay") {
      dateText = previousDay(currentDate);
    } else {
      dateText = nextDay(currentDate);
    }
    jumpToDay(dateText);
})

function convertDateToFr(myDate) {
  let newDate = myDate.split('-');
  return newDate[2]+'/'+newDate[1]+'/'+newDate[0];
}

function previousDay(myDate) {
  let newDate = myDate.split('-');
  let newDay = parseInt(newDate[2]) - 1;
  if(newDay < 10) {
    newDay = '0'+newDay;
  }
  return newDate[0]+'-'+newDate[1]+'-'+newDay;
}

function nextDay(myDate) {
  let newDate = myDate.split('-');
  let newDay = parseInt(newDate[2]) + 1;
  if(newDay < 10) {
    newDay = '0'+newDay;
  }
  return newDate[0]+'-'+newDate[1]+'-'+newDay;
}