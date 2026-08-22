var currentCategoryType = "";
var j = 0;
var l = 0;


$(() => {

  var productsALaCarte = JSON.parse($('#inputProductALaCarte').val());

  var i = 0;
  var array = [];
  var dates = $("#datePicker").datepicker({
     closeText: "Fermer",
     prevText: "Précédent",
     firstDay: 1,
     yearRange: "-1:+1",
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
     dateFormat: "yy-mm-dd",
     changeYear: true,
     numberOfMonths: 1,
     beforeShowDay: function(date){
         var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
         return [ array.indexOf(string) == -1 ]
     },
     onSelect(dateText, el) {

              let selectHtml = `<select name="productALacarte[${dateText}]" style="width: 200px; margin-left: 20px;" id="selectProductALaCarte-${dateText}" onchange="productALaCarte('${dateText}')">`;
              selectHtml += "<option>Choisir un produit</option>"
              for (idProduct in productsALaCarte) {
                selectHtml += `<option value="${idProduct}"  data-category='EKA-DAYCAMP' data-startSession='${productsALaCarte[idProduct].start}' data-endSession='${productsALaCarte[idProduct].end}' data-pricettc = '${productsALaCarte[idProduct].priceTtc}'>${productsALaCarte[idProduct].name}</option>`
              }
              selectHtml += '</select>';


              l++
                
              $("#listDates").append(`<li data-date="${dateText}">
                <a href="javascript:void(0)">
                    <div>
                        <p class="list-header second-row" style="display: flex; align-items: center;">
                            ${formatDate(dateText)}  ${selectHtml} 
                            <div class="with-icon">
                              <div class="switch">
                                      <input class="switch-input" name="productALacarte[checkbutton][${dateText}]" data-date="${dateText}" id="dateALC${l}" type="checkbox" checked>
                                      <label class="switch-paddle" for="dateALC${l}"></label>
                                </div>
                            </div>
                        </p>
                    </div>
                </a>
              </li>`);           
     }
   });    
});

const formatDate = date => {
  var date_string = date.split('-').join('-');
  var date = new Date(date_string);
  return ((date.getDate()).toString().length > 1 ? date.getDate()  : '0'+ (date.getDate()) )+'/'+ ((date.getMonth()) > 8 ? date.getMonth() + 1 : '0'+ (date.getMonth() + 1 ) ) + '/' + date.getFullYear()  ;
}


// select product a la carte
const productALaCarte = (dateSelected) => {
    let idProduct = $("#selectProductALaCarte-"+dateSelected).find(':selected').val();
    let category  = $("#selectProductALaCarte-"+dateSelected).find(':selected').data('category');
    let startSession  = $("#selectProductALaCarte-"+dateSelected).find(':selected').data('startsession');
    let endSession  = $("#selectProductALaCarte-"+dateSelected).find(':selected').data('endsession');
    let priceTtc = $("#selectProductALaCarte-"+dateSelected).find(':selected').data('pricettc');


    if(currentCategoryType != "EKA-DAYCAMP") {
      $("#listLocations").html('');
      $('#listSports').html('');
      $('#listHours').html('');
      $('#pickupDateUl').html('');
      $('#inputDateHourSession').html('');
      reload = true;
    } else {
      reload = false;
    }

    addDateHourSession(idProduct, dateSelected, startSession, endSession)

    currentCategoryType = category;
    loadProduct(idProduct, reload, dateSelected, priceTtc);
}

$('.deleteRegistration').click(function() {
    let idRegistration = $(this).data('registrationid');

    let url = `registration/delete/${idRegistration}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {

        },
        success(json) {
            $('#regisrationLiId'+idRegistration).remove();
        }
    });







})

// select standard product
$("#selectProduct").change(() => {

  $('.partial').hide();
  $('.partial2').hide();

  // clear all details (if previous choose exit)
  $("#listLocations").html('');
  $('#listSports').html('');
  $('#listHours').html('');
  $('#pickupDateUl').html('');
  $('#inputDateHourSession').html('');
  
  let idProduct = $("#selectProduct").find(':selected').val();
  let category  = $("#selectProduct").find(':selected').data('category');


  if(category == "EKA-DAYCAMP") {
    $('#EKA-DAYCAMP-PRODUCTS').show();
  } else {
    $('#EKA-DAYCAMP-PRODUCTS').hide();
    currentCategoryType = category;
    loadProduct(idProduct, true, null, null);
  }
});

const loadProduct = (idProduct, reload, dateSelected, priceTtc) => {

    console.log(priceTtc);


  let url = `product/display/${idProduct}`;

  let startSession = '';
  let endSession = ''

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {},
    success(json) {

      // open all details window
      $('.partial').show();
      changePayedSatus();

      // check if transport
      if(json.transport == true)
      {
        $("#isTransport").val('1');
        $("#dropIn").val(json.hourDropin);
        $("#dropOff").val(json.hourDropoff);        
      } else {
        $("#isTransport").val('0');
      }

      // only charge if need to reload (only use with daycamp)
        // only update the paiement li but not all options (sport ,location, hours, etc.)
      if(reload == false) {
          addPickupDateLi(dateSelected, json.priceTtc);
      }  else {

          // check if location is selectable
          if(json.isLocationSelectable == true) {
            $(".isLocationSelectable").show();
            const locations = json.locations;

              locations.forEach(function(location, i=0) {
        
                  $("#listLocations").append(`<li>
                                <a href="javascript:void(0)">
                                    <div>
                                        <p class="list-header second-row">
                                            ${location.name}
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon">
                                              <div class="switch">
                                                      <input class="switch-input" onclick="changeLocation(this)" name="location" data-location="${location.locationId}" id="location${i}" type="radio">
                                                      <label class="switch-paddle" for="location${i}"></label>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                </a>
                            </li>`);
                  i++;
                
              });    		
          } else {
            $(".isLocationSelectable").hide();
            $("#locationId").val(json.locations[0].locationId);
          }


          // check if sport is selectable
          if(json.isSportSelectable == true) {
            $(".isSportSelectable").show();
            const sports = json.sports;

            let latestSports = $('#latestSports').val();
            let checked;

      
            sports.forEach(function(sport, i=0) {

                if(latestSports.indexOf(sport.sportId) > -1) {
                  checked = ' checked = "checked" ';
                } else {
                  checked = '';
                }
                $("#listSports").append(`<li>
                              <a href="javascript:void(0)">
                                  <div>
                                      <p class="list-header second-row">
                                          ${sport.name}
                                          <aside class="subtitles"></aside>
                                          <div class="with-icon">
                                            <div class="switch">
                                                    <input class="switch-input" onclick="changeSport(this)" name="sport" data-sport="${sport.sportId}" id="sport${i}" type="checkbox" ${checked}>
                                                    <label class="switch-paddle" for="sport${i}"></label>
                                              </div>
                                          </div>
                                      </p>
                                  </div>
                              </a>
                          </li>`);
                i++;
                
             

                changeSport();


            });

          } else {
            $(".isSportSelectable").hide();
            let sports = json.sports;
            var sportval = '';
            sports.forEach(function(sport, i=0) {
                if(sportval != '') {
                  sportval = sportval + ',' + sport.sportId;
                } else {
                  sportval = sport.sportId;
                }
                i++;
            });
            $("#sportId").val(sportval);
          } 


          // is jour selectable
          if((json.isHourSelectable == true && json.isDateSelectable == false) || (json.isHourSelectable == true && json.isDateSelectable == true && json.dates != '')) 
          {
            $(".isHourSelectable").show();
            const hours = json.hours;

              hours.forEach(function(hour, i=0) {
        
                  $("#listHours").append(`<li>
                                <a href="javascript:void(0)">
                                    <div>
                                        <p class="list-header second-row">
                                            ${hour.start} - ${hour.end}
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon">
                                              <div class="switch">
                                                      <input class="switch-input" onclick="changeHour(this)" name="hour" data-end-hour="${hour.end}" data-start-hour="${hour.start}" id="hour${i}" type="radio">
                                                      <label class="switch-paddle" for="hour${i}"></label>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                </a>
                            </li>`);
                  i++;
                
              });
          } else if(json.isHourSelectable == false) {
            $(".isHourSelectable").hide()
            $("#sessionStart").val(json.hours[0].start + ':00');
            $("#sessionEnd").val(json.hours[0].end + ':00');

            startSession = json.hours[0].start + ':00';
            endSession    = json.hours[0].end + ':00';


          } else {
            $("#listHours").css('visibility', 'hidden');
            const hours = json.hours;
            hours.forEach(function(hour, i=0) {
                if(i == 0)
                {
                  var checked = "checked";
                } 
                else
                {
                  var checked = "";
                }
                $("#listHours").append(`<label><input type="radio" data-start="${hour.start}" data-end="${hour.end}" style="margin-right:8px;" ${checked}>${hour.start} - ${hour.end} </label> `);
                i++;
            });
          }


          // if date is selectable
          if(json.isDateSelectable == true) {

            // choix calendar
            price = json.priceTtc;
            addPickupDateLi(dateSelected, price);

          } else {

            // add liste date in pickupDateUl with paiement of first date
            const dates = json.dates;
            dates.forEach(function(date, i = 0) {

             // if(i == 0) {
                price = json.priceTtc;
             // } else {
              //  price = "";
              //}

              addPickupDateLi(date, price);

              addDateHourSession(idProduct, date, startSession, endSession);

            });
          }

      }
    }
  });
};

const updateTotalPrice = () => {

}


// Mise à jour des données checkbox

// location
const changeLocation = (data) => {
  $("#locationId").val($(data).attr('data-location'));
}

//Mise à jour des sports
const changeSport = (data) => {
    var listSport = '';
    $("#listSports")
      .find(":checkbox:checked")
      .each(function() {
        if(listSport != '') {
          listSport = listSport + ',' + $(this).attr('data-sport');
        } else {
          listSport = $(this).attr('data-sport');          
        }
      });
      $("#sportId").val(listSport);


}

const changeHour = (data) =>
{
  $("#sessionEnd").val($(data).attr('data-end-hour') + ':00');
  $("#sessionStart").val($(data).attr('data-start-hour') + ':00');
}

const changePickupDate = () => {
  
    let pickupDatePaiementData = "";
    $("#pickupDateUl")
      .find(":checkbox:checked")
      .each(function() {
            
        let targetId = $(this).attr('id');
        let value = $('#input'+targetId).val();
        let dateSelected = $(this).data('date');

        let mydata = value+'|'+dateSelected;

        if(pickupDatePaiementData != "") {
          pickupDatePaiementData = pickupDatePaiementData + ',' +mydata;
        } else {
          pickupDatePaiementData = mydata;
        }
      });
      $('#pickupDatePaiement').val(pickupDatePaiementData);

}


$('#changePayedStatus').change(function() {
  changePayedSatus();   
});

const changePayedSatus = () => {
  let status = $('#changePayedStatus').val();

  if(status == "payed") {
      $('#pickupDateDiv').hide();
  };
  if(status == "unpayed" || status == "waiting") {
    $('#pickupDateDiv').show();
  }
}


const addPickupDateLi = (date, price) => {

              j++;
              $("#pickupDateUl").append(`<li>
                                            <a href="javascript:void(0)">
                                              <div style="display: flex; justify-content: space-between">
                                                      <div style="width: 300px">${formatDate(date)}</div>
                                                      <div style="width: 150px;">
                                                        <input type="text" placeholder="montant à payer ce jour" value="${price}" id="inputdatepickup${j}">
                                                      </div>
                                                      <div class="switch">
                                                        <input class="switch-input" onclick="changePickupDate()" name="sport" data-date="${date}" id="datepickup${j}" type="checkbox">
                                                        <label class="switch-paddle" for="datepickup${j}"></label>
                                                      </div>
                                              </div>
                                            </a>
                                          </li>
              `);
}

const addDateHourSession = (idProduct, dateSelected, start, end) => {
    let inputLineData = idProduct+'-'+start+'-'+end
    let inputLine = "<input type='hidden' name='dateHourSession["+dateSelected+"]' value='"+inputLineData+"' >"; 

    $('#inputDateHourSession').append(inputLine);
}

$('#submitButton').click(function(e) {

  let validation = true;

  let selectAddress = $('#selectAddress').val();
  let freeAddress = $('#freeAddress').val();
  let sportId = $('#sportId').val();


  // check if registration exist
  if(selectAddress == "" && freeAddress == "") {
    toastr.error('Choisissez une adresse');
    validation = false;
  }
 
  if(sportId == "") {
    toastr.error('Choisissez au moins un sport');
    validation = false;
  }

  return validation;
  
})

