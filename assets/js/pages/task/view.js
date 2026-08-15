$( document ).ready(function() {
  let dateToday = $('#dateToday').val();
  let target = $("#titleTask-"+dateToday);
  $("html, body").stop().animate( { scrollTop: target.offset().top-80 }, 1500);
});


$('#selectMember').change(function() {
  let staffId = $(this).val();
  let url = urlHost+'staff/resume/id/'+staffId+'/';
  window.location = url;
})

function showAddTaskForm() {
  $('#showAddTaskForm').toggle();
  let topPos = (window.pageYOffset);
  $('#showAddTaskForm').css({top:topPos})
}

$('#closeAddTask').click(function() {
  $('#showAddTaskForm').hide();

})
function manageBasicTask() {
    $('#showFormManageTask').show();
}

$('#closeManageTask').click(function() {
  $('#showFormManageTask').hide();

})

$('.deleteTask').click(function() {
    let id = $(this).attr('id');
    let key = id.split('-')[1];
    $('#tr-'+key).remove();

    let url = urlHost+"task/deleteBasicTask/taskId/"+key+'/';

    $('#nomessageBox').load(url);
    toastr.success('Tache supprimée');

})

$('.submitAddBasickTask').click(function() {
  let id = $(this).attr('id');
  let moment = id.split('-')[2];
  let taskname = $('#input-taskname-'+moment).val();

  let url = urlHost+"task/addBasicTask/";
  $('#nomessageBox').load(url, {name:taskname, moment:moment});
  toastr.success('Tache de base ajoutée');
})

/***** taskForm ***********/
$('#dateTodo').change(function() {
  let datepicker = $('#datepicker').val();
  let element = datepicker.split('-');
  $('#dateLimit').val(element[2]+'/'+element[1]+'/'+element[0]);
  $('#datepicker2').val(datepicker);
})


$('#selectStaffId').change(function() {
    let staffId = $(this).val();
    let name    = $("#selectStaffId option:selected").text();
    let listIdString = $('#listStaffId').val();
    listIdString = listIdString+','+staffId;
    $('#listStaffId').val(listIdString);
    let html = '<span id="span-task-staff-'+staffId+'" onclick="retrieveTaskStaff('+staffId+')" style="cursor:pointer">'+name+'<span> | ';
    $('#listaffectation').append(html);
})

function retrieveTaskStaff(staffId) {
    let listString = $('#listStaffId').val();
    let arr = listString.split(',');

    $('#span-task-staff-'+staffId).remove();

    let newListString = "";
    for(let i = 1; i < arr.length ; i++) {
      if(staffId != arr[i]) {
        newListString = newListString+','+arr[i];
      }
    }

    $('#listStaffId').val(newListString);
}

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

      var url = `${urlHost}task/view/date_ref/${dateText}/`;
      locationRedirect(url);


    }
  });
};


$("#dateTodo").datepicker({
    altField: "#datepicker",
    altFormat: "yy-mm-dd",
    closeText: "Fermer",
    firstDay: 1,
    yearRange: "-1:+3",
    prevText: "Précédent",
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
    dateFormat: "dd/mm/yy",
    changeYear: true,
});



$("#dateLimit").datepicker({
    altField: "#datepicker2",
    altFormat: "yy-mm-dd",
    closeText: "Fermer",
    firstDay: 1,
    yearRange: "-1:+3",
    prevText: "Précédent",
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
    dateFormat: "dd/mm/yy",
    changeYear: true,
});
