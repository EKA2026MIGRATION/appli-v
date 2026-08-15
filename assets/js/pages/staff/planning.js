
// select straff
$("#selectMember").change(function() {
  let idMember = $(this).val();
  let seasonId = $('#selectSeason').val();
  locationRedirect(urlHost + 'staff/planning/id/' + idMember + '/seasonId/'+seasonId+'/');
});


// scroll to current day and pass change css row
$( document ).ready(function() {
  let dateToday = $('#targetDate').val();
  let target = $("#celDay-"+dateToday);
  $("html, body").stop().animate( { scrollTop: target.offset().top-80 }, 1500);


  target.parent().parent().css('border', '3px solid darkblue')
});


// show add form
$('.addStaffPresence').click(function(e) {
      let dateCurrent = $(this).attr('id').split('_')[1];

     $("#lastDatePresence").val(dateCurrent);
     openRevealJS("action-add-presence");
})


// event on click ok to addPresnece
document.getElementById("createPresence").addEventListener(
  "click",
  event => {
    let type = "POST";
    let url = "staff/presence/create";
    let staff = $("#currentStaffId").val();
    let date = $("#lastDatePresence").val();
    let end = $("#end").val();
    let start = $("#start").val();
    let location = $('#location').val();

    let typeName = $('#type_name').val();

    let teamsIdList = "";

    $('.checkboxTeams').each(function() {
      if( $(this).prop('checked') ) {
          let myTeam = $(this).val();
          teamsIdList += ","+myTeam;
      }
    })

    if (end != "" && start != "") {
      end = `${end}:00`;
      start = `${start}:00`;
      var data = [{ staff, date, start, end, typeName, teamsIdList, location}];
    } else {
      var data = [{ staff, date, typeName , teamsIdList, location}];
    }


    console.log(data);
     launchCreatePresence(url, type, data, "autoclose", date, staff, typeName);
  },
  false
);

const launchCreatePresence = (url, type, data, close = null, currentDate, staffId, typeName) =>
{

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
        if(close == "autoclose") {
          $("#action-add-presence").foundation('close');
        }
        let targetDiv = 'addPresence_'+currentDate+'_'+staffId;

        console.log(json);
        let html = `<div class="devContent type${typeName} celContentPresence" id="presence">${typeName}</div>`; 
        $(html).insertAfter( '#'+targetDiv );
        $('#'+targetDiv).remove();
      

      //  $('#presence-'+staffPresenceId).removeClass().addClass("type"+typeName);
      //  $('#typeName-'+staffPresenceId).html(typeName);

      }
    });

}





// show update form
$('.celContentPresence').click(function(e) {
    let x = e.pageX
    let y = e.pageY;
    let staffPresenceId = $(this).attr('id').split('-')[1];

    $('#staffPresenceIdToUpdate').val(staffPresenceId);
    $('#showStaffPresenceForm').css({'position': 'absolute', 'top': y, "left": x-400});
    $('#showStaffPresenceForm').toggle();
})


// close update form
$('#closeStaffPresence').click(function() {
  $('#showStaffPresenceForm').hide();
})


// update staff presence
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
        $('#presence-'+staffPresenceId).removeClass().addClass("type"+typeName);
        $('#typeName-'+staffPresenceId).html(typeName);
      }
    }


  });

  $('#showStaffPresenceForm').hide();


})
