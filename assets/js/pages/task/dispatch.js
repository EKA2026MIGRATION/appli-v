// open modal list staff
var color;
var criticity
$('.affectTaskButton').click(function(e) {
  e.preventDefault;


  // add the title of task
  let taskId = $(this).data('id'); 
  let taskName = $(this).data('name');
  $('#listStaffTitle').html(taskName);
  $('#taskIdInput').val(taskId);

  // show listsatff and move to correct position
  $('#listStaff').show();
  let yPosition = e.pageY;
  $('#listStaff').css({ top: yPosition-200});

})

// close modal list staff
$('#closeListStaff').click(function() {
    $('#listStaff').hide();
    $('#taskIdInput').val(' ');
    $('#showListStaff').hide();
  })

$('.criticity').click(function() {

  criticity = $(this).data('criticity');
  color = $(this).css('background-color');
  $('#listStaffTitle').css('color', color);
  $('#showListStaff').show();
})

// add task to staff
$('.staffName').click(function() {

  $(this).css('color', color);

  let staffId = $(this).data('id');
  let staffName = $(this).text();
  let taskId = $('#taskIdInput').val();
  let dateRef = $('#dateRef').val();

  let url = urlHost+"task/addBasicToStaff/taskId/"+taskId+'/staffId/'+staffId+'/date/'+dateRef+'/criticity/'+criticity+'/';

  $('#taskStaffAjaxDiv').load(url);


  if( $('#staffNameTask-'+taskId).text() != "" ) {
    staffName = ", "+staffName; 
  }

  let taskStaffId = 5;

  $('#staffNameTask-'+taskId).append('<span onclick="retrieveTask('+taskStaffId+')" id="span-'+taskStaffId+'">'+staffName+'<span>');
  $('#taskName-'+taskId).css('color', 'darkblue');


  toastr.success('Tache ajoutée');
  

})


const retrieveTask = (taskStaffId) => {

  let url = urlHost+"task/unaffectBasickTaskStaff/taskStaffId/"+taskStaffId+'/';

  $('#taskStaffAjaxDiv').load(url);

  $('#span-'+taskStaffId).remove();

}






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
      dateFormat: "yy-mm-dd",
      changeYear: true,
      onSelect(dateText) {
  
        var url = `${urlHost}staff/workload/date_ref/${dateText}/`;
        locationRedirect(url);
  
  
      }
    });
  };
  