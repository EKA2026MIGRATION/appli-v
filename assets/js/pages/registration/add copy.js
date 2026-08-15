$(() => {
   var i = 0;
   var array = [];
   var dates = $("#datePicker").datepicker({
      closeText: "Fermer",
      prevText: "Précédent",
      firstDay: 1,
      yearRange: "-100:+0",
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
      numberOfMonths: 3,
      beforeShowDay: function(date){
          var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
          return [ array.indexOf(string) == -1 ]
      },
      onSelect(dateText, el) {

      array.push(dateText);
      var listHours = $("#listHours").html();
      const randomId = makeid();

      $("#listHours")
      .find(":radio")
      .each(function() {
       
        $(this).attr('name', randomId);
        
      });
        

      $("#listDates").append(`<li data-date="${dateText}">
                    <a href="javascript:void(0)">
                        <div>
                            <p class="list-header second-row">
                                ${dateText}
                                <aside class="subtitles" style="padding-top:8px;">${listHours}</aside>
                                <div class="with-icon">
                                   <div class="switch">
                                          <input class="switch-input" onclick="changeDateAll(this)" name="date" data-date="${dateText}" id="date${i}" type="checkbox" checked>
                                          <label class="switch-paddle" for="date${i}"></label>
                                    </div>
                                </div>
                            </p>
                        </div>
                    </a>
                </li>`);
      changeDateAll(this);
      i++;

      }
    });    
});

  



document.getElementById("loadMoreListChild").addEventListener(
  "click",
  function(event) {
    const element = $(this);
    let page = parseInt($(element).attr("data-page"));
    const size = $(element).attr("data-size");

    if ($("#searchListChild").val() != "") {
      const searchTerm = $("#searchListChild").val();
      var pageSuivante = parseInt($("#pageSearch").val()) + 1;
      var url =
        `child/search/${searchTerm}?size=${size}&page=${pageSuivante}`;
      $("#pageSearch").val(pageSuivante);
    } else {
      var pageSuivante = page + 1;
      var url = `child/list?page=${pageSuivante}&size=${size}`;
    }

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type: "GET" },
      dataType: "json",
      beforeSend() {
        $(element)
          .attr("disabled", true)
          .html("Chargement en cours..");
      },
      success(json) {
        $(element)
          .attr("disabled", false)
          .html("Afficher plus");
        const numberOfElements = json.length;

        if (numberOfElements > 0) {
          for (i = 0; i < numberOfElements; i++) {
            let photo = photoProfilDefault;

            if (json.photo != null) {
              photo = json.photo;
            }

            if(json[i].persons[0].personId != '')
            {
              var idPerson = json[i].persons[0].personId;

              if(json[i].persons[0].addresses[0].address != '')
              {
                var address = json[i].persons[0].addresses[0].address + ' ' + json[i].persons[0].addresses[0].postal + ' ' + json[i].persons[0].addresses[0].country;
                var postal = json[i].persons[0].addresses[0].postal;     
              }
              else
              {
                var address = 0;
                var postal = 0;                     
              }

            }
            else
            {
              var idPerson = 0;
              var address = 0;
              var postal = 0;              
            }



            $("#childList").append(
              `<li id="li${json[i].childId}"><a href="javascript:void(0)" data-postal="${postal}" data-address="${address}" data-id-person="${idPerson}" onclick="addThisChild(\`${json[i].childId}\`, this)"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${json[i].firstname} ${json[i].lastname}<div class="with-icon">AJOUTER</div> </p>  </div> </a></li>`
            );
          }

          $(element).attr("data-page", pageSuivante);
        } else {
          $(element)
            .attr("disabled", true)
            .html("Liste terminée.");
        }
      }
    });
  },
  false
);

document.getElementById("searchListChild").addEventListener(
  "keyup",
  function(event) {
    $("#loadMoreListChild").show();

    let searchTerm = $(this).val();
    let size = $("#loadMoreListChild").attr("data-size");
    let url = `child/search/${searchTerm}?size=${size}&page=1`;
    $("#childList").html("");
    $("#pageSearch").val(1);
    $("#loadMoreListChild").attr("disabled", false);

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type: "GET" },
      dataType: "json",
      beforeSend() {
        $("#childList").html(showLoader);
      },
      success(json) {
        const numberOfElements = json.length;

        if (numberOfElements > 0) {
          $("#childList").html("");

          for (i = 0; i < numberOfElements; i++) {
            let photo = photoProfilDefault;

            if (json.photo != null) {
              photo = json.photo;
            }

            if(json[i].persons[0].personId != '')
            {
              var idPerson = json[i].persons[0].personId;

              if(json[i].persons[0].addresses[0].address != '')
              {
                var address = json[i].persons[0].addresses[0].address + ' ' + json[i].persons[0].addresses[0].postal + ' ' + json[i].persons[0].addresses[0].country;
                var postal = json[i].persons[0].addresses[0].postal;     
              }
              else
              {
                var address = 0;
                var postal = 0;                     
              }

            }
            else
            {
              var idPerson = 0;
              var address = 0;
              var postal = 0;              
            }


      

            $("#childList").append(
              `<li id="li${json[i].childId}"><a href="javascript:void(0)" data-postal="${postal}" data-address="${address}" data-id-person="${idPerson}" onclick="addThisChild(\`${json[i].childId}\`, this)"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${json[i].firstname} ${json[i].lastname}<div class="with-icon"> AJOUTER</div> </p>  </div> </a></li>`
            );
          }
        } else {
          $("#childList").html(
            "<p><strong><center>Aucun résultat.</center></strong></p>"
          );
        }
      }
    });
  },
  false
);

const addThisChild = (idChild, data) => {
  const li = $(data).parent("li");
  $(li).css("background-color", "#dcedc8");
  const idLi = $(li).attr("id");
  let idPerson = $(data).attr('data-id-person');
  let address = $(data).attr('data-address');
  let postal = $(data).attr('data-postal');
  $("#postalChild").val(postal);
  $("#addressChild").val(address);
  $("#personId").val(idPerson);
  $(`#childList li:not(#${idLi})`).hide();
  $("[name=child]").val(idChild);
  $("#loadMoreListChild").hide();
};

var changeDate = (data) =>
{
  $("#sessionDate").val($(data).attr('data-date'));
}

var changeDateAll = (data) =>
{
    var listDates = '';
    $("#listDates")
      .find(":checkbox:checked")
      .each(function() {
       
        if(listDates != '')
        {
        listDates = listDates + ',' + $(this).attr('data-date');
        }
        else
        {
        listDates = $(this).attr('data-date');          
        }

        

        
      });
        
      $("#sessionDate").val(listDates);
}




var changeHour = (data) =>
{
  $("#sessionEnd").val($(data).attr('data-end-hour') + ':00');
  $("#sessionStart").val($(data).attr('data-start-hour') + ':00');
}

var changeLocation = (data) =>
{
  $("#locationId").val($(data).attr('data-location'));
}
var changeSport = (data) =>
{
    var listSport = '';
    $("#listSports")
      .find(":checkbox:checked")
      .each(function() {
       
        if(listSport != '')
        {
        listSport = listSport + ',' + $(this).attr('data-sport');
        }
        else
        {
        listSport = $(this).attr('data-sport');          
        }

        

        
      });
        
      $("#sportId").val(listSport);
}


$("#selectProduct").change(() => {
  
  let idProduct = $("#selectProduct").find(':selected').val();

  let url = `product/display/${idProduct}`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {},
    success(json) {
    	$("#listDates").html('');
    	$("#listHours").html('');
    	$("#listLocations").html('');
    	$("#listSports").html('');
      $("#datePicker").hide();
      $("#sessionDate").val('');
      $("#sessionStart").val('');
      $("#sessionEnd").val('');
      $("#locationId").val('');
      $("#sportId").val('');      
      $("#listHours").css('visibility', 'visible');
      $("#alacarte").val(0);

      if(json.transport == true)
      {
        $("#isTransport").val('1');
        $("#dropIn").val(json.hourDropin);
        $("#dropOff").val(json.hourDropoff);        
      }
      else
      {
        $("#isTransport").val('0');
      }

    	if(json.isDateSelectable == true)
    	{
        $(".isDateSelectable").show();
        if(json.dates != '')
        {

    		  dates = json.dates;

	        dates.forEach(function(date, i=0) {

	            $("#listDates").append(`<li>
		                        <a href="javascript:void(0)">
		                            <div>
		                                <p class="list-header second-row">
		                                    ${date}
		                                    <aside class="subtitles"></aside>
		                                    <div class="with-icon">
		                                       <div class="switch">
		                                              <input class="switch-input" onclick="changeDate(this)" name="date" data-date="${date}" id="date${i}" type="radio">
		                                              <label class="switch-paddle" for="date${i}"></label>
		                                        </div>
		                                    </div>
		                                </p>
		                            </div>
		                        </a>
		                    </li>`);
	            i++;
	           
	        });
        }
        else // A LA CARTE 
        {
          $("#datePicker").show();
          $("#alacarte").val(1);
        }

    		
    	}
    	else
    	{
    		$(".isDateSelectable").hide();
    		$("#sessionDate").val(json.dates[0]);
    	}

    	if(json.isLocationSelectable == true)
    	{
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

    		
    	}
    	else
    	{
    		$(".isLocationSelectable").hide();

    		$("#locationId").val(json.locations[0].locationId);
    	}



    	if(json.isSportSelectable == true)
    	{
    		$(".isSportSelectable").show();
    		const sports = json.sports;

	        sports.forEach(function(sport, i=0) {
	   
	            $("#listSports").append(`<li>
		                        <a href="javascript:void(0)">
		                            <div>
		                                 <p class="list-header second-row">
		                                    ${sport.name}
		                                    <aside class="subtitles"></aside>
		                                    <div class="with-icon">
		                                       <div class="switch">
		                                              <input class="switch-input" onclick="changeSport(this)" name="sport" data-sport="${sport.sportId}" id="sport${i}" type="checkbox">
		                                              <label class="switch-paddle" for="sport${i}"></label>
		                                        </div>
		                                    </div>
		                                </p>
		                            </div>
		                        </a>
		                    </li>`);
	            i++;
	           
	        });

    	
    	}
    	else
    	{

    		$(".isSportSelectable").hide();

          let sports = json.sports;
          var sportval = '';
          sports.forEach(function(sport, i=0) {
              if(sportval != '')
              {
                sportval = sportval + ',' + sport.sportId;
              }
              else
              {
                sportval = sport.sportId;
              }
              
              
              i++;
             
          });

          $("#sportId").val(sportval);
    		
    	} 



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

    		
    	}
    	else if(json.isHourSelectable == false)
    	{
    		$(".isHourSelectable").hide();

        $("#sessionStart").val(json.hours[0].start + ':00');
        $("#sessionEnd").val(json.hours[0].end + ':00');

    	}
      else
      {
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








    }
  });

});

const makeid = () => {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 5; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}

const submitProductRegistration = () =>
{
 	  let child = $("[name=child]").val();
	  let product = $("[name=product]").val();
    let payed = $("[name=payed]").val();
    let status = $("[name=status]").val();
    let person = $("#personId").val();;
    let location = $("#locationId").val();
    let sport = $("#sportId").val();
    let sessionDate = $("#sessionDate").val();
    let sessionStart =  $("#sessionStart").val();
    let sessionEnd = $("#sessionEnd").val();
    let dropin = $("#dropIn").val();
    let dropoff =  $("#dropOff").val();
    let transport = $("#isTransport").val();
    let address = $("#addressChild").val();
    let postal = $("#postalChild").val();
    let alacarte = $("#alacarte").val();

    let splitDate = sessionDate.split(',');
   
    let splitSport = sport.split(',');

    if(splitSport.length >= 1)
    {
      let sportArray = [];

      splitSport.forEach(function(sportData, i=0) {

          sportArray.push({sportId: sportData});
          i++;
         
      });

      sport = sportArray;
      var sports = sport;
    }

    if(splitDate.length == 1 && alacarte == 0)
    {
      let dateArray = [];

      splitDate.forEach(function(dateData, i=0) {

          dateArray.push({date:dateData, start:sessionStart, end: sessionEnd});
          i++;
         
      });

      sessions = dateArray;


    }
    else
    {
    let dateArray = [];


    $("#listDates")
      .find(":checkbox:checked")
      .each(function() {
        var element = $(this).parent().parent().parent().parent();
        var date = $(this).attr('data-date');

        if(sessionEnd != '')
        {

          dateArray.push({date, start:sessionEnd, end:sessionEnd});

        }
        else
        {

          $(element)
          .find(":radio:checked")
          .each(function() {
           
            var start = $(this).attr('data-start'); 
            var end  = $(this).attr('data-end'); 

            dateArray.push({date, start, end});

          });

        }


        
      });

      var sessions = dateArray;

    }


    let data = {child, product, person, payed, status, location, sports, sessions};

    let url = "registration/create";
    let type = "POST";
    $.ajax({
      type: "POST",
      url: urlRequest,
      data: {type, url, data},
      dataType: "json",
      beforeSend() {

      },
      success(json) {
        $(".progress .progress-meter").css('width','33%');          


        // Générer les présences et transport si il y a 
        let url3 = "child/presence/create";
        let data4 = [];
        let data2 = []; 
        let data3 = []; 

        if(splitDate.length == 1 && alacarte == 0)
        {
        

          splitDate.forEach(function(dateData, i=0) {


            data4.push({child, person, registration: json.registration.registrationId, date: dateData, location, start: sessionStart, end: sessionEnd});
            data2.push({registration: json.registration.registrationId, kind: 'dropin', start: dateData + ' ' + dropin, address: address,  postal: postal, sortOrder: 12, comment: '', child: child, ride: null});
            data2.push({registration: json.registration.registrationId, kind: 'dropoff', start: dateData + ' ' + dropoff, address: address,  postal: postal, sortOrder: 12, comment: '', child: child, ride: null});

            if(splitSport.length >= 1)
            {

              splitSport.forEach(function(sportData, i=0) {
      
                data3.push({registration: json.registration.registrationId, start: dropin, child: child, sport:sportData, date:dateData, location});
        
              });



            }


          });


        }
        else
        {


          $("#listDates")
            .find(":checkbox:checked")
            .each(function() {
              var element = $(this).parent().parent().parent().parent();
              var date = $(this).attr('data-date');


              if(sessionEnd != '')
              {


                var start = sessionStart;
                var end  = sessionEnd; 

                data4.push({child, person, registration: json.registration.registrationId, date, location, start, end});
                data2.push({registration: json.registration.registrationId, kind: 'dropin', start: date + ' ' + dropin, address: address,  postal: postal, sortOrder: 12, comment: '', child: child, ride: null});
                data2.push({registration: json.registration.registrationId, kind: 'dropoff', start: date + ' ' + dropoff, address: address,  postal: postal, sortOrder: 12, comment: '', child: child, ride: null});
      
                if(splitSport.length >= 1)
                {

                  splitSport.forEach(function(sportData, i=0) {

                    data3.push({registration: json.registration.registrationId, start, end, child: child, sport:sportData, date});
                     
                  });

                }

       


              }
              else
              {

                $(element)
                .find(":radio:checked")
                .each(function() {
                 
                  var start = $(this).attr('data-start') + ':00'; 
                  var end  = $(this).attr('data-end') + ':00'; 

                  data4.push({child, person, registration: json.registration.registrationId, date, location, start, end});
                  data2.push({registration: json.registration.registrationId, kind: 'dropin', start: date + ' ' + dropin, address: address,  postal: postal, sortOrder: 12, comment: '', child: child, ride: null});
                  data2.push({registration: json.registration.registrationId, kind: 'dropoff', start: date + ' ' + dropoff, address: address,  postal: postal, sortOrder: 12, comment: '', child: child, ride: null});
        
                  if(splitSport.length >= 1)
                  {

                    splitSport.forEach(function(sportData, i=0) {

                      data3.push({registration: json.registration.registrationId, start, end, child: child, sport:sportData, date});
                       
                    });

                  }

                  
                });


              }


              
            });

        }


        $(".progress .progress-meter").css('width','66%');          
                 
            
            
        $.ajax({
          type: "POST",
          url: urlRequest,
          data: { url: url3, type:'POST', data: data4 },
          dataType: "json",
          beforeSend() {
 
          },
          success(json2) {

            if(transport == 1) // Générer les pickups
            {

              let url2 = "pickup/create-multiple";
   

              $.ajax({
                type: "POST",
                url: urlRequest,
                data: { type: "POST", url:url2, data: data2 },
                dataType: "json",
                beforeSend() {  },
                success(json3) {  }
              });


            }         
         
            if(splitSport != '')
            {
              let url4 = "pickup-activity/create-multiple";
  
              $.ajax({
                type: "POST",
                url: urlRequest,
                data: { type: "POST", url:url4, data: data3 },
                dataType: "json",
                beforeSend() {  },
                success(json3) {  }
              });
            }
            


            swal({
              title: "Confirmation",
              text: "Inscription pris en compte.",
              type: "success",
              confirmButtonText: "Nouvelle inscription",
              cancelButtonText: "Annuler",
              showCancelButton: false
            }).then(result => {
              if (result.value) {
                locationRedirect();
              }
            });              

          }
        });





      },
      error(json)
      {

      }
    });





}      





