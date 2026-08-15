var url = null;
var intId = null;
var targetUrl = null;
var currentDate = $('#date').val();
var nbStaff;
var nbChild;


if(localStorage.getItem('defaultDashboard')!='undefined' && localStorage.getItem('defaultDashboard') != null) {
  let defaultDashboard = localStorage.getItem('defaultDashboard');
  dash = defaultDashboard;
  button = "#button"+dash;
} else {
  dash = "Operationnel";
  button = "#button"+dash;
}

loadDashboard(dash, button);

// navigation onglet menu
$('#dashboardMenuLi .liButtonMenu').click(function() {
    let dash = $(this).data('dash');
    localStorage.setItem('defaultDashboard', dash);
    button = "#button"+dash;
    loadDashboard(dash, button)
})

function loadDashboard(dash, button) {
    $(".loading").show();

    let myUrl = urlHost+'dashboard/show/type/'+dash+'/date/'+currentDate+'/';
    
    $('#dashboardContent').load(myUrl, function() {
      $(".loading").hide();

      if(dash == "Operationnel") {
              let nbStaff = document.getElementById('nbStaffPresentInput').value;
              let nbChild = document.getElementById('nbChildPresentInput').value;
              let nbDriver= document.getElementById('nbDriverPresentInput').value;
              let nbCoach = document.getElementById('nbCoachPresentInput').value;

              let capacityChildStaffed = document.getElementById('capacityChildStaffedInput').value;
              let capacityDrived       = document.getElementById('capacityDrivedInput').value;

              $('#nbStaffPresent').text(nbStaff);
              $('#nbChildPresent').text(nbChild);
              $('#nbDriverPresent').text(nbDriver);
              $('#nbCoachPresent').text(nbCoach);

              $('#capacityDrived').text(capacityDrived);
              $('#capacityChildStaffed').text(capacityChildStaffed);



              // information
              let spanCoachInformation = document.getElementById('capacityCoachInformation');
              let spanDriverInformation = document.getElementById('capacityDriverInformation');

              let capacityChildText = "";

              if(capacityChildStaffed >= nbChild) {
                  let nbDispo2 = capacityChildStaffed - nbChild;
                  capacityChildText = 'Suffisament de coachs disponibles - '+nbDispo2+' place(s) disponible(s)';
              } else {
                  capacityChildText = "Attention, il n'y a pas assez de coachs";
              }
              $('#capacityCoachInformation').html(capacityChildText);


              let capacityDriverText = "";

              if(capacityDrived >= nbChild) {
                  let nbDispo = capacityDrived - nbChild;
                  capacityDriverText = 'Suffisament de drivers disponibles - '+nbDispo+' place(s) disponible(s)' ;

              } else {
                  capacityDriverText = "Attention, il n'y a pas assez de drivers";
              }
              $('#capacityDriverInformation').html(capacityDriverText);
      }


    });
    $('#dashboardMenuLi .liButtonMenu').removeClass('selected');
    $(button).addClass("selected");
}


/*********** REAL TIME WINDOWSD *********/

$('#gotToSupervision').click(function(e) {
  e.preventDefault();
  url = $(this).attr('href');
  url = url+currentDate+'/filter/dropin,am/';
  window.open(url, '_blank');
})

if(sessionStorage.getItem('filter')) {
  let filterString = sessionStorage.getItem('filter');
  $(".filterItemSelectButton").each(function() {
    let filter = $(this).attr('data-name');
    let re = new RegExp(filter, 'g');
    let found = filterString.match(re);
    if(found == null) {
      $(this).attr('data-value', 0);
      $(this).removeClass('filterActive');
    } else {
      $(this).attr('data-value', 1);
      $(this).addClass('filterActive');
    }
  });

};

function refreshTransport() {
  let params = new Array();
  let apiFilter = new Array();
  $(".filterItemSelectButton").each(function() {
      let val = $(this).attr('data-value');
      if(val == 1)
      {
        let filter = $(this).attr('data-name');
        params.push(filter);

        if( $(this).hasClass('apiFilter')) {
          apiFilter.push(filter);
        }
      }
  });

  let filter = params.toString();
  let apiFilterString = apiFilter.toString();
  sessionStorage.setItem('filter', filter);
  let randNumber =  Math.floor(Math.random() * Math.floor(1000000));
  targetUrl = url+'filter/'+apiFilterString+'/rand/'+randNumber+'/';

  $('#reveal-content').load(targetUrl);
}

$('#closeModalRealTime').click(function() {
  $('#reveal-transport-real-time2').toggle();
  clearInterval(intId);
})

$('.filterItemSelectButton').click(function() {

  let filter = $(this).attr('data-name');

  // desactive filter
  if($(this).hasClass('filterActive')) {

    // color button
    $(this).removeClass('filterActive');
    $(this).attr('data-value', 0);

    if(filter == "dropin") {
      // active dropoff
      activeFilter('dropoff');
    }
    if(filter == "dropoff") {
      // active dropin
      activeFilter('dropin');
    }

    if(filter == "am") {
      // active dropoff
      activeFilter('pm');
    }
    if(filter == "pm") {
      // active dropin
      activeFilter('am');
    }

  } else {
    // active filter

    // color button
    $(this).addClass('filterActive');
    $(this).attr('data-value', 1);

    if(filter == "dropin") {
      // active dropoff
      desactiveFilter('dropoff');
    }
    if(filter == "dropoff") {
      // active dropin
      desactiveFilter('dropin');
    }

    if(filter == "am") {
      // active dropoff
      desactiveFilter('pm');
    }
    if(filter == "pm") {
      // active dropin
      desactiveFilter('am');
    }

  }
})

function activeFilter(filtername)
{
  $('.filterItemSelectButton[data-name="'+filtername+'"]').addClass('filterActive');
  $('.filterItemSelectButton[data-name="'+filtername+'"]').attr('data-value', 1);
}

function desactiveFilter(filtername)
{
  $('.filterItemSelectButton[data-name="'+filtername+'"]').removeClass('filterActive');
  $('.filterItemSelectButton[data-name="'+filtername+'"]').attr('data-value', 0);
}

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

function jumpToDay(dateText) {
        currentDate = dateText;
        $('#date').val(dateText);
        $('#datePickerInline').hide();
        let dateTextFr = convertDateToFr(dateText)
        $('#showCurrentDate').html(dateTextFr);
        loadDashboard(dash, button);
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
