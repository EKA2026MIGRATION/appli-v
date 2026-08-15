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


$('.monthNameBar').click(function() {
  $(this).next().toggle();
})

$('.dateRow').click(function(e) {
    let x = e.pageX
    let y = e.pageY;
    let staffPresenceId = $(this).attr('id').split('-')[1];
    $('#staffPresenceIdToUpdate').val(staffPresenceId);
    $('#showStaffPresenceForm').css({'position': 'absolute', 'top': y});
    $('#showStaffPresenceForm').toggle();
})

$('.editButton').click(function() {
  let staffPresenceId = $('#staffPresenceIdToUpdate').val();
  let typeName = $(this).attr('id').split('-')[1];
  console.log(staffPresenceId+' '+typeName);

  let data = [];
  data.push({staffPresenceId, typeName});
  let url = "staff/presence/modify/"+staffPresenceId+"/"+typeName;
  let type = "GET";

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type, data },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(".loading").hide();
      if(typeName == "DELETE") {
        $('#presence-'+staffPresenceId).remove();
      } else {
        $('#presence-'+staffPresenceId).removeClass().addClass("dateRow").addClass("type"+typeName);
      }
    }


  });

  $('#showStaffPresenceForm').hide();


})

$('#closeStaffPresence').click(function() {
  $('#showStaffPresenceForm').hide();
})

// pagination task list
//
//
let taskBlockDayToDo = $('#todoTask .taskBlockDay');
let taskBlockDayDone = $('#doneTask .taskBlockDay');
let paginationBarTodo = $('#todoTask .taskPaginationBar');
let paginationBarDone = $('#doneTask .taskPaginationBar');

let itemByPage = 4;
let page    = 1;
paginatetask(taskBlockDayToDo,paginationBarTodo, page, 'todo' );
paginatetask(taskBlockDayDone, paginationBarDone, page, 'done');

function paginatetask(taskBlockDay, paginationBar, page, target) {
  let totalItems = taskBlockDay.length;
  let totalPage  = Math.ceil(totalItems/itemByPage);
  let  i = 0;
  taskBlockDay.each(function() {
      i++;
      if( i > itemByPage*(page-1) && i <= itemByPage*page) {
        $(this).show();
      } else {
        $(this).hide()
      }
  })

  let html = "<ul>";
  let classInfo = "";
  for(let j = 1; j <= totalPage; j++ ) {
      if (j == page ) {
        classInfo = "class=\"selected\"";
      } else {
        classInfo = "";
      }
      html +=  "<li><div "+classInfo+" onclick='changePage("+j+", \""+target+"\")'>"+j+"</div></li>";
  }
  html += "</ul>";

  paginationBar.html(html);

}

function changePage(page, target) {
  let taskBlockDay = $('#'+target+'Task .taskBlockDay');
  let paginationBar = $('#'+target+'Task .taskPaginationBar');
  paginatetask(taskBlockDay,paginationBar, page, target );

}
