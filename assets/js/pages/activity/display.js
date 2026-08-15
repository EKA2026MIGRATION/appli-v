const changeStatus = (status, idPickUp) => {
  let url = `pickup-activity/modify/${idPickUp}`;
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
      $(`#revealPEC${idPickUp} .deletePec`).show();
      
      const date = new Date(json.pickupActivity.updatedAt);

      let dateToShow;
      if(date instanceof Date && !isNaN(date)) {
        dateToShow = date.toLocaleString("fr-FR");
      } else {
          let elements = json.pickupActivity.updatedAt.split(' ');
          dateToShow = elements[1];
      }

      $(`li[data-id-pickup=${idPickUp}]`).removeClass().addClass(json.pickupActivity.status);
      if (json.pickupActivity.status == "pec") {


        $(`#revealPEC${idPickUp} .phrasePec`).html(
          `Présence confirmée le ${dateToShow}`
        );
        console.log(date);
        console.log(date.toLocaleString("fr-FR"));
        console.log(json.pickupActivity.updatedAt);
        $(`#revealPEC${idPickUp} .iconRevealPEC`).html(
          '<i class="material-icons status olive">check</i>'
        );
        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status olive">check</i>'
        );
        $(`#revealPEC${idPickUp} .phrasePec`).removeClass('npec');
        $(`#revealPEC${idPickUp} .phrasePec`).addClass('pec');
        $(`#revealPEC${idPickUp} .nextPec`).fadeIn();

      } else if(json.pickupActivity.status == "npec") {
        $(`#revealPEC${idPickUp} .phrasePec`).html(
          `Absence confirmée le ${dateToShow}`
        );
        $(`#revealPEC${idPickUp} .iconRevealPEC`).html(
          '<i class="material-icons status red">close</i>'
        );

        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status red">close</i>'
        );
        $(`#revealPEC${idPickUp} .phrasePec`).removeClass('pec');
        $(`#revealPEC${idPickUp} .phrasePec`).addClass('npec');
        $(`#revealPEC${idPickUp} .nextPec`).fadeIn();

      } else {
        $(`#revealPEC${idPickUp} .phrasePec`).html('');
        $(`#revealPEC${idPickUp} .phrasePec`).removeClass('pec');
        $(`#revealPEC${idPickUp} .phrasePec`).removeClass('npec');
        $(`li[data-id-pickup=${idPickUp}]`).removeClass().addClass('nopec');
        $(`#revealPEC${idPickUp} .nextPec`).fadeOut();
        $(`#revealPEC${idPickUp} .deletePec`).hide();
        $(`#revealPEC${idPickUp} .iconRevealPEC`).html(
          '<i class="material-icons status blue">access_time</i>'
        );

        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status blue">access_time</i>'
        );

      }
      $(this).close;
    }
  });
};


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

      var url = `${urlHost}activity/display/date/${dateText}/`;
      locationRedirect(url);


    }
  });
};

$('#showAllTaskDayButton').click(function() {
    $('#showAllTaskDay').toggle();
    $('#showAllTaskDay').empty();
    let date = $("#date").val();
    let url = `task/list/done/${date}`;
    let data = [];

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "GET", url, data },
      dataType: "json",
      success(json) {

        let html = "";
        let morningTask = json.morning;
        let afterTask = json.afternoon;

        html += createHtmlListTask("Tâches du Matin", morningTask);
        html += createHtmlListTask("Tâches de l'Après-midi", afterTask);


        $('#showAllTaskDay').html(html);

      }
    })



})

function createHtmlListTask(title, currentTasks) {
      let html = "<ul><h5>"+title+"</h5>";
      for (key in currentTasks) {
          let style = "";
          let task = currentTasks[key];

          if(task.status == 1) {
            style = "style='color: green'";
          }

          html += "<li "+style+" >"+task.name;

          if(task.status == 1) {
            html += "<br/><span style='font-style: italic; font-size: 10px'>"+task.staff+'</span>';
          }

          html += "</li>";
      }
      html += "</ul>"
      return html;
}

$("#selectCoach").change(() => {
  var date = $("#date").val();
  var idCoach = $("#selectCoach").find(':selected').val();
  locationRedirect(urlHost + 'activity/display/date/' + date + '/idCoach/' + idCoach + '/');
});

var openPerson = (data, idPerson) =>
{

  if ($(".person" + idPerson).css("display") == "none") {
   $(".person" + idPerson).show();
   $(data).children('i').html('keyboard_arrow_up');
  } else {
    $(".person" + idPerson).hide();
    $(data).children('i').html('keyboard_arrow_down');
  }

}

var openRepas = data =>
{

  if ($(".repas").css("display") == "none") {
   $(".repas").show();
   $(data).children('i').html('keyboard_arrow_up');
  } else {
    $(".repas").hide();
    $(data).children('i').html('keyboard_arrow_down');
  }


}

const addClass = data => {
    if ($(data).hasClass("asso-food") === true) {
        $(data).removeAttr("checked");
    } else {
        $(data).attr("checked");
    }
    $(data).toggleClass("asso-food");
};
/*

$( ".mealForm" ).submit(function( event ) {

  event.preventDefault();

  let form = $(this);
  let url = form.attr("action");
  const dataRelation = [];
  let i = 0;

  $(form).find(".food_associated")
      .find(".asso-food")
      .each(function() {
          const idFood = $(this).attr("value");
          dataRelation[i] = { foodId: idFood };
          i++;
      });

  let data = $(form).serializeToJSON();
  let type = "POST";

  if (url.includes("modify")) {
      type = "PUT";
  }

  $.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type, data, links: dataRelation },
      dataType: "json",

      success(json) {
          if (json.status == true) {

              if(type == "POST")
              {
                toastr.success('Repas pris en compte.');
                $(form).attr('action', 'meal/modify/' + json.meal.mealId);
              }
              else
              {
                toastr.success('Repas modifié avec succes.');
              }
          } else {
              toastr.error('Une erreur est survenue');
          }
      }
  });

});
*/

// add task
$('#selectTaskMorningButton').click(function() {

  let task_id = $('#selectTaskMorning').val();
  let coach_id = $('#currentStaffId').val();
  let url = urlHost+"activity/addTask/taskId/"+task_id+'/coachId/'+coach_id+'/';
  $('#taskList').load(url);
  toastr.success('Tache ajoutée');
})

$('#selectTaskAfternoonButton').click(function() {

  let task_id = $('#selectTaskAfternoon').val();
  let coach_id = $('#currentStaffId').val();
  let url = urlHost+"activity/addTask/taskId/"+task_id+'/coachId/'+coach_id+'/';
  $('#taskList').load(url);
  toastr.success('Tache ajoutée');
})


$('.clearActivityButton').click(function() {

  let taskStaffId = $(this).attr('id').split('-')[1];
  let coach_id = $('#currentStaffId').val();
  let dateTask = $('#date').val();
  let url = urlHost+"activity/deleteTask/taskStaffId/"+taskStaffId+'/coachId/'+coach_id+'/dateTask/'+dateTask+'/';
  $('#taskList').load(url);
  toastr.success('Tache effacée');
})


$('#buttonTasks').click(function() {
  $('#showActivityTasks').show();
  $('#showActivityGroups').hide();
})

$('#buttonGroups').click(function() {
  $('#showActivityTasks').hide();
  $('#showActivityGroups').show();
})