var activeSortableActive = 0;
let isUber = 0;
const urlApi = $('#urlApi').val();

for(let key in rides)
{
    $('#headerRide'+key+'NbStop').html(nbStops[key]);
    $('#headerRide'+key+'NbChild').html(nbChilds[key]);
    $('#nextPecButton-'+lastPickUp[key]).hide();
}

$(() => {
  $( ".dialog" ).dialog({
    autoOpen: false,
  });

  var needCheckup = $('#needCheckup').val();

  if(needCheckup == 1) {
    openRevealJS('revealAddCheckup');
  }

});



const openDialog = (id) => {
  $("#dialog" + id).show();
  $("#dialog" + id).dialog('open');
}


const activeSortable = () =>
{

  if(activeSortableActive == 0)
  {
    initDragAndDrop();
    $("section ul").sortable({ disabled: false });
    $(".barreScroll").show();
    $(".ridePage").css('width', 'calc(100% - 20px)');
    activeSortableActive = 1;
  }
  else
  {
    $("section ul").sortable({ disabled: true });
    $(".barreScroll").hide();
    $(".ridePage").css('width', 'calc(100%)');
    activeSortableActive = 0;
  }

}

const goToProfilChild = (idChild) => {
    openRevealJS('reveal-iframe')
    $(".frameFullScreen").attr(
        "src",
        `${urlHost}child/display/id/${idChild}/iframe/yes/`
    );
};


var initDragAndDrop = () => {


  $("section ul")
    .sortable({
      scroll: true,
      receive(event, ui) {



      },
      stop(event, ui) {
        saveDispatch();
      }
    })
    .disableSelection();

};



var saveDispatch = () => {

    var pickups = [];
    $("#ride")
      .find("section")
      .each(function() {
        const idRide = $(this).attr("data-id-ride");
        let sortOrder = 0;

        $(`[data-id-ride=${idRide}]`)
                  .find("li")
                  .each(function() {
                    sortOrder++;
                    const idPickUp = $(this).attr("data-id-pickup");
                    if(idPickUp != undefined)
                    {

                      pickups.push({
                        pickupId: idPickUp,
                        rideId: idRide,
                        sortOrder,
                        start: null,
                        validated: 'yes'
                      });

                    }

                  });
      });

    let url = "pickup/dispatch";

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "PUT", url, data: pickups },
      dataType: "json",
      beforeSend() {

      },
      success(json) {
       toastr.success('Ordre modifié');
      }
    });

};

const addPayment = idPickUp => {
  let url = `pickup/modify/${idPickUp}`;
  let data = [];
  var payment_done = $(`#dialog${idPickUp} .paymentDoneAdd`).val();
  data = { payment_done };

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "PUT", url, data },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(`[data-id-pickup=${idPickUp}] .paymentDone`).html(json.pickup.paymentDone);
      $(`#dialog${idPickUp} .paymentDoneAmount`).html(json.pickup.paymentDone);
      $(`#dialog${idPickUp} .paymentDoneModify`).val(json.pickup.paymentDone);      
      $(".loading").hide();
      $(`#dialog${idPickUp} .payment-not-added`).fadeOut();
      $(`#dialog${idPickUp} .payment-added`).fadeIn();
      toastr.success('Informations modifiées.');
    }
  });
};

const modifyPayment = idPickUp => {
  let url = `pickup/modify/${idPickUp}`;
  let data = [];
  var payment_done = $(`#dialog${idPickUp} .paymentDoneModify`).val();
  data = { payment_done };

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "PUT", url, data },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(`#dialog${idPickUp} .paymentDoneModify`).val(json.pickup.paymentDone); 
      $(`#dialog${idPickUp} .paymentDoneAmount`).html(json.pickup.paymentDone);
      $(`[data-id-pickup=${idPickUp}] .paymentDone`).html(json.pickup.paymentDone);
      $(".loading").hide();
      toastr.success('Informations modifiées.');
    }
  });
};

const cancelPayment = idPickUp => {
  let url = `pickup/modify/${idPickUp}`;
  let data = [];
  data = { payment_done: "" };

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "PUT", url, data },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(`[data-id-pickup=${idPickUp}] .paymentDone`).html('aucun');
      $(".loading").hide();
      $(`#dialog${idPickUp} .payment-not-added`).fadeIn();
      $(`#dialog${idPickUp} .payment-added`).fadeOut();
      toastr.success('Informations modifiées.');
    }
  });
};



const changeStatus = (status, idPickUp) => {
  let url = `pickup/modify/${idPickUp}/driver`;
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
      $(`#dialog${idPickUp} .deletePec`).show();
      
      const date = new Date(json.pickup.updatedAt);

      let dateToShow;
      if(date instanceof Date && !isNaN(date)) {
        dateToShow = date.toLocaleString("fr-FR");
      } else {
          let elements = json.pickup.updatedAt.split(' ');
          dateToShow = elements[1];
      }

      var kindText;
      $(`li[data-id-pickup=${idPickUp}]`).removeClass().addClass(json.pickup.status);
      if (json.pickup.status == "pec") {
        if(json.pickup.kind == "dropin") {
          var kindText = "Pris en charge";
        } else {
          var kindText = "Dépose";
        }

        $(`#dialog${idPickUp} .phrasePec`).html(
          `${kindText} le ${dateToShow}`
        );
     
        $(`#dialog${idPickUp} .iconRevealPEC`).html(
          '<i class="material-icons status olive">check</i>'
        );
        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status olive">check</i>'
        );
        $(`#dialog${idPickUp} .phrasePec`).removeClass('npec');
        $(`#dialog${idPickUp} .phrasePec`).addClass('pec');
        $(`#dialog${idPickUp} .nextPec`).fadeIn();

        let myLi = $(`li[data-id-pickup=${idPickUp}]`);
        myLi.css('background-color', 'white');

      } else if(json.pickup.status == "npec") {
        $(`#dialog${idPickUp} .phrasePec`).html(
          `Absence confirmée le ${dateToShow}`
        );
        $(`#dialog${idPickUp} .iconRevealPEC`).html(
          '<i class="material-icons status red">close</i>'
        );

        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status red">close</i>'
        );
        $(`#dialog${idPickUp} .phrasePec`).removeClass('pec');
        $(`#dialog${idPickUp} .phrasePec`).addClass('npec');
        $(`#dialog${idPickUp} .nextPec`).fadeIn();

        let myLi = $(`li[data-id-pickup=${idPickUp}]`);
        myLi.css('background-color', 'lightpink');

      } else {
        $(`#dialog${idPickUp} .phrasePec`).html('');
        $(`#dialog${idPickUp} .phrasePec`).removeClass('pec');
        $(`#dialog${idPickUp} .phrasePec`).removeClass('npec');
        $(`li[data-id-pickup=${idPickUp}]`).removeClass().addClass('nopec');
        $(`#dialog${idPickUp} .nextPec`).fadeOut();
        $(`#dialog${idPickUp} .deletePec`).hide();
        $(`#dialog${idPickUp} .iconRevealPEC`).html(
          '<i class="material-icons status blue">access_time</i>'
        );

        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status blue">access_time</i>'
        );

        let myLi = $(`li[data-id-pickup=${idPickUp}]`);
        myLi.css('background-color', 'white');

      }
      $(this).close;
    }
  });
};


const closeMyDialog = (pickupId) => {
  $("#dialog" + pickupId).dialog('close');

  $('html, body').animate({
    scrollTop: $("#pickupChildList"+pickupId).offset().top - 150
  }, 200);
} 

const nextPec = (el, pickupId) =>
{

  var reveal = $("#dialog" + pickupId);
  var revealId = $(reveal).attr('id');
  var depart = $(reveal).attr('data-address');
  $("#dialog" + pickupId).dialog('close');
  var beforeReveal = $(reveal).parent();
  console.log(beforeReveal);
  var nextReveal = $(beforeReveal).next('.ui-dialog');
  var arrive = $(nextReveal).find('.dialog').attr('data-address');
  var nextRevealId = $(nextReveal).find('.dialog').attr('id');
  var idPickUp = $(nextReveal).find('.dialog').attr('data-id-pickup');

  $("#" + nextRevealId).dialog('open');
  $("#lastPickup").val(idPickUp);

  let waypts = [];

  const directionService = new google.maps.DirectionsService();
  const geocoder = new google.maps.Geocoder();

  directionService.route(
    {
      origin: depart,
      destination: arrive,
      travelMode: google.maps.TravelMode.DRIVING
    },
    (data, status2) => {
      const legs = data.routes[0].legs;
      const time = legs[0].duration.value/60;
      var date = new Date();
      var date_arrival = new Date(date.getTime() + time * 60000);
      var time_arrival = date_arrival.getHours() + ":" + ("0" + date_arrival.getMinutes()).slice(-2);
      var time_minutes = Math.round(time);
      $(nextReveal).find('.dialog').find('.time_estimated').show();
      $(nextReveal).find('.dialog').find('.time').html(`<strong>${time_arrival} - ${time_minutes} minutes </strong>`);
      $(nextReveal).find('.dialog').find('.nextSMS').show();

    }
  );

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

      var url = `${urlHost}transport/ride/date/${dateText}/`;
      locationRedirect(url);


    }
  });
};

$("#selectDriver").change(() => {
  var date = $("#date").val();
  var idDriver = $("#selectDriver").find(':selected').val();
  locationRedirect(urlHost + 'transport/ride/date/' + date + '/idDriver/' + idDriver + '/');
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

const updateLastPickup = idPickUp =>
{
  $("#lastPickup").val(idPickUp);
}

const addClass = data => {
    if ($(data).hasClass("asso-food") === true) {
        $(data).removeAttr("checked");
    } else {
        $(data).attr("checked");
    }
    $(data).toggleClass("asso-food");
};

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
            var idPickUp = $("#lastPickup").val();

            $(`#dialog${idPickUp} .repasNok`).fadeOut();
            $(`#dialog${idPickUp} .repasOk`).fadeIn().css('display', 'block');
            $(`#dialog${idPickUp} .repasPrempli`).fadeOut();


            if(type == "POST")
            {
              toastr.success('Repas pris en compte.');
              $(form).attr('action', 'meal/modify/' + json.meal.mealId);
            }
            else
            {
              toastr.success('Repas modifié avec succès.');
            }

            $("#lunchIconRide"+idPickUp).css({"color": "green"});
            $('#lunchIconRide2'+idPickUp).css('color', 'green'); // change icon on top of jquery modal
            $('#submitMealButton'+idPickUp).css('background-color', 'green').css['color', 'white'];

                  //  $("#dialog" +idPickUp).scrollTop(0);

            //  console.log("#dialog" +idPickUp);
          }
          else {
            toastr.error('Une erreur est survenue');
          }
      }
  });

});

$('.checkboxSendSms').click(function() {
  if($(this).hasClass("sendSms")) {
    $(this).removeClass('sendSms');
    $(this).addClass('noSendSms');
  } else {
    $(this).removeClass('noSendSms');
    $(this).addClass('sendSms');
  }
})

$('#closeSmsModal').click(function() {
  $('#showSmsSendList').toggle();
})


$('#buttonSendSms').click(function() {
  $('#showSmsSendList .sendSms').each(function() {

    let number = $(this).attr('data-number');

    let reference = $(this).attr('data-reference');
    let message = $('#'+reference).val();
    let pickupString = $(this).attr('data-pickupid');

    // numberTest
    //number = "0620653588";

    sendSmsAjax(number, message, pickupString);
  })

});

const sendSMS = () =>
{
  $('#showSmsSendList').toggle();
}

function updatePickupSmsSentData(pickupId, number, pickupString)
{
  let url = 'pickup/update-sms-sent-data';
  let data = pickupId+';'+number;

  $.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type: "POST", data},
      dataType: "json",
      success(data) {
          $('#'+pickupString+'-'+number).html('dernier sms envoyé le '+data.currentDateSent);
          $('#li-'+pickupString+'-'+number).addClass('smsSent');
      }
  });
}

const sendSmsNextPec = data =>
{
  var phone = $(data).attr('data-phone');
  var messageBefore = $(data).attr('data-message-before');
  var messageAfter = $(data).attr('data-message-after');
  var el = $(data).parent().parent().parent().parent().parent().parent().parent();
  var time = el.find('.time strong').html();
  var message = messageBefore + time + ' ' + messageAfter;
  window.open('sms:'+phone+'&body='+message+'', '_self');
  return false;

}


function sendSmsAjax(tel, message, pickupString = null) {
  $.ajax({
    type: "POST",
    url: urlSMS,
    data: {phone: tel, content:message},
    dataType: "json",
    beforeSend() {
        $(".loading").show();
    },
    success(json) {
        $(".loading").hide();
        if(pickupString != null) {

          let pickupIds = pickupString.split('-');

          for (let j = 0; j < pickupIds.length; j++) {
             updatePickupSmsSentData(pickupIds[j], tel, pickupString);
          }

        }
    }
  })
};

document.getElementById("mealFormStaff").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#mealFormStaff");
        let url = form.attr("action");
        const dataRelation = [];
        let i = 0;

        $(".food_associated_staff")
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
                  
                    swal({
                        title: "Confirmation",
                        text: json.message,
                        type: "success",
                        confirmButtonText: "Afficher le repas",
                        cancelButtonText: "Fermer",
                        showCancelButton: true
                    }).then(result => {
                        if (result.value) {
                            //location.href = `${urlHost}meal/display/id/${json.meal.mealId}/`;
                        }
                    });
                   

                } else {
                    swal({
                        title: "Erreur",
                        text: "Une erreur est survenue.",
                        type: "warning"
                    });
                }
            }
        });
    },
    false
);


$('.isPreferedButton').click(function() {
  // id // type
  let id = $(this).attr('id');
  let e = id.split('-');

  let phoneId = e[2];
  let isPrefered = e[1];
   
  let url = `phone/isPrefered/${phoneId}/${isPrefered}`;

  $.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type: "GET" },
      dataType: "json",
      success(json) {
          let mycolor = "";
          if(isPrefered == "call") { mycolor = "green" ;} else { mycolor = "blue" ; };
          if(json.action == "add") {
            $('#isPreferedShow-'+isPrefered+'-'+phoneId).addClass(mycolor);
            console.log('add');
          } else {
            $('#isPreferedShow-'+isPrefered+'-'+phoneId).removeClass(mycolor);
            console.log('delete');
          }

      } 
  });

}); 

$('#reportTransport').click(function() {
    $('#checkReportTransport').show();
    isUber = parseInt($("#isUberInput").val());
    if(isUber == 1) {
      $('#nextReportTransport').show();
      $('#validReportTransport').hide();
    } 
})


$('#nextReportTransport').click(function() {
    $('#nextReportTransport').hide();
    $('#validReportTransport').show();
    $('#uberQuestions').show();
    $('#standardQuestion').hide();

})

$('#closeReportTransport').click(function() {
      $('#checkReportTransport').hide();
})

$('.moodReportTransport').click(function() {
    let key  = $(this).attr('data-questionkey');
    let mood = $(this).attr('data-mood');
    let other;

    if(mood == "bad") {
      other1 = "good";
      other2 = "noanswer";

    } ;
    
    
    if(mood == "good") {
      other1 = "bad";
      other2 = "noanswer";

    }


    if(mood == "noanswer") {
      other1 = "bad";
      other2 = "good";

    }

    if( $(this).hasClass('neutral')  ) {
      $(this).removeClass('neutral');
      $(this).addClass(mood);

      $("#moodReportTransport"+key+other1).addClass("neutral");
      $("#moodReportTransport"+key+other1).removeClass(other1);
      $("#moodReportTransport"+key+other2).addClass("neutral");
      $("#moodReportTransport"+key+other2).removeClass(other2);

      $('#question'+key).val(mood);
      
    } else {

      $(this).removeClass(mood);
      $(this).addClass('neutral');
      $('#question'+key).val("");

    }
})



$('#validReportTransport').click(function() {

  let setUber = true;

  const idRide = $("#reportTransport").attr('data-lastrideid');
  let reports = [];  
  let line;
  $('.inputQuestions').each(function() {


      if( $(this).hasClass('uberQuestions')) {
          if( isUber != 1) {
            setUber = false
          }
      } 

      if(setUber == true) {
          line = $(this).val()+"|"+$(this).attr('name');
          reports.push(line);
      }

      
  });

  let data = {
    rideId : idRide,
    report : reports
  }

  data = JSON.stringify(data);

  console.log(data);
  let url = urlApi + 'ride/report/update';

console.log(url);

  $.ajax({
        url: url,
        type: 'POST',
        contentType: "application/json",
        headers: {
            'Authorization':'Bearer ' + tokenAuth
        },
        contentLength: data.length,
        crossDomain: true,
        dataType: "json",
        data,
        beforeSend() {
        }, success(data) {
            toastr.success("Fin de trajet validé");
             $('#checkReportTransport').hide();
        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });


})


$('.startTransportChrono').click(function() {
    let current = new Date();
    let start   = current.getHours()+':'+current.getMinutes();
    let rideId  = $(this).attr('id').split('-')[1];

    // change screen
    $('#screenChrono-'+rideId).html('Transport en cours');
    $(this).parent().addClass('check');
    $('#screenChrono-'+rideId).addClass('check');

    // save rideId
    // transportStarChrono
    console.log(start);


})

$('.stopTransportChrono').click(function() {
    let current = new Date();
    let stop   = current.getHours()+':'+current.getMinutes();
    let rideId  = $(this).attr('id').split('-')[1];

    // change screen
    $('#screenChrono-'+rideId).html('Transport arrêté');
    $('#startTransportChrono-'+rideId).parent().removeClass('check');
    $('#screenChrono-'+rideId).removeClass('check');

    // save rideId
    // transportStopChrono

    console.log(stop);

})


/*
    let url = urlApi + 'bookletchild/modify/' + bookletChildId;
    let data = {status : status};
    data = JSON.stringify(data);

const updateData = (url, data, type) => {
 $.ajax({
        url: url,
        type: 'PUT',
        contentType: "application/json",
        headers: {
            'Authorization':'Bearer ' + tokenAuth
        },
        contentLength: data.length,
        crossDomain: true,
        dataType: "json",
        data,
        beforeSend() {
        }, success(data) {
            toastr.success("Saved");
            console.log(data);
        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });
}*/