$(() => {
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

      array.push(dateText);
      var listHours = $("#listHours").html();
      const randomId = makeid();

      $("#listHours")
      .find(":radio")
      .each(function() {
       
        $(this).attr('name', randomId);
        
      });
      
      var selectALaCarte = $("#selectALaCarte").html();

      $("#listDates").append(`<li data-date="${dateText}">
                    <a href="javascript:void(0)">
                        <div>
                            <p class="list-header second-row" style="display: flex; align-items: center;">
                                ${formatDate(dateText)}  ${selectALaCarte} 
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

const formatDate = date => {
  var date_string = date.split('-').join('-');
  var date = new Date(date_string);
  return ((date.getDate()).toString().length > 1 ? date.getDate()  : '0'+ (date.getDate()) )+'/'+ ((date.getMonth()) > 8 ? date.getMonth() + 1 : '0'+ (date.getMonth() + 1 ) ) + '/' + date.getFullYear()  ;
}


document.getElementById("searchListChild").addEventListener(
  "keyup",
  function(event) {
   // $("#loadMoreListChild").show();

    let searchTerm = $(this).val(); 
    let size = $("#loadMoreListChild").attr("data-size");
    size = 300;

    const regex = /'/gi;
    searchTerm = searchTerm.replace(regex, '27');
    let url = `child/fastsearch/${searchTerm}`;
    $('#childList').show();
    $("#pageSearch").val(1);
    $("#loadMoreListChild").attr("disabled", false);

    if(searchTerm.length > 2) {
    
              $.ajax({
                type: "POST",
                url: urlRequest,
                data: { url, type: "GET" },
                dataType: "json",
                beforeSend() {
                  $(".loading").show();
                  $('#childList').html('');
                },
                success(json) {

                  $(".loading").hide();
                  const numberOfElements = json.length;

                  if (numberOfElements > 0) {
                    $("#childList").html("");
                    for (i = 0; i < numberOfElements; i++) {
                      let photo = photoProfilDefault;

          
                      if (json[i].photo != null) {
                        photo = json[i].photo;
                      }

                      $("#childList").append(
                        `<li id="li${json[i].id}"><a href="javascript:void(0)" onclick="addThisChild(\`${json[i].id}\`, this)"><div><p class="list-header"><img src="https://appli-v.net/${photo}" class="width-30 height-30"><span style="font-size: 12px; font-style: italic">#${json[i].id}</span> ${json[i].fullname}<div class="with-icon"> AJOUTER</div> </p>  </div> </a></li>`
                      );
                    }
                  } else {
                    $("#childList").html(
                      "<p><strong><center>Aucun résultat.</center></strong></p>"
                    );
                  }
                }
              });
    }
  },
  false
);

const addThisChild = (idChild, data) => {
  const li = $(data).parent("li");
  $(li).css("background-color", "#dcedc8");
  const idLi = $(li).attr("id");

  $(`#childList li:not(#${idLi})`).hide();
  $("[name=child]").val(idChild);
  $("#loadMoreListChild").hide();

  let url = `child/display/${idChild}`;

  let line = "";

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type: "GET" },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
      $('#childAddr').empty();
    },
    success(json) {
      $(".loading").hide();

      let persons = json.persons;
      let style = "height: 40px; cursor: pointer";

      $('#childAddr').append("<br/><h4>Choisissez l'adresse de prise en charge</h4>");
      
      for (let i = 0; i < persons.length; i++) {
          for(let j = 0; j < persons[i].addresses.length; j++) {
              let add = persons[i].addresses[j];
              line = "<li style='"+style+"' id='addr-child-"+add.addressId+"' onclick='addThisAddress("+add.addressId+", this)'    ><span=>"+add.name+"</span>: "+add.address+" "+add.postal+"  "+add.country+"</li>";
              $('#childAddr').append(line);
          }
      }

      $('#childAddr').append('<br/><br/>');

    }
  });

};

let addThisAddress = (addressId, el) => 
{
      $('#childAddr li').each(function() {
          $(this).css("background-color", "white");
      })

      $("#addressId").val(addressId);
      $('#addr-child-'+addressId).css("background-color", "rgb(220, 237, 200)");
}

var changeDate = (data) =>
{
  $('#sessionDate').val($(data).attr('data-date'));
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

const changeALaCarte = (e) => {
  $(e).parent().parent().parent().parent().attr('data-product-id', $(e).val());

  let option = $(e).find(':selected');

  let start = option.data('start');
  let end = option.data('end');

  $(e).parent().parent().parent().parent().attr('data-start', start);
  $(e).parent().parent().parent().parent().attr('data-end', end);

}

$("#selectProduct").change(() => {
  
  let idProduct = $("#selectProduct").find(':selected').val();
  let categoryProduct = $('#selectProduct').find(':selected').attr('data-category');

  if(categoryProduct == "EKA-DAYCAMP") {
    $(".aLaCarteProduct").show();
    $(".normalProduct").hide();
  } else {
    $(".aLaCarteProduct").hide();
    $(".normalProduct").show();    
  }

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
      } else {
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

    	} else {
        $(".isDateSelectable").hide();
      
        let myDatesString = "";
        for(let z = 0; z < json.dates.length; z++) {
            if(z == 0) {
                myDatesString = json.dates[z];
            }
            myDatesString = myDatesString+","+json.dates[z];
        }
        $("#sessionDate").val(myDatesString); // ajout des dates
    	}

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
    	} else if(json.isHourSelectable == false) {
    		$(".isHourSelectable").hide()
        $("#sessionStart").val(json.hours[0].start + ':00');
        $("#sessionEnd").val(json.hours[0].end + ':00');
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

const submitProductRegistrationALaCarte = () => {

  let registrations = [];

  $("#idProductALaCarte")
  .find('div')
  .each(function() {
    let productId = $(this).html();

    var dateArray = [];
    var i = 0;
    $("#listDates")
      .find('[data-product-id="' + productId + '"]')
      .find(":checkbox:checked")
      .each(function() {
        let date = $(this).attr('data-date');
        let el =  $("#listDates").find('[data-date="' + date + '"]');
        let start = $(el).attr('data-start');
        let end = $(el).attr('data-end');
        dateArray.push({date, start, end});
        i++;
      });
      if(i != 0) {
        saveALaCarte(productId, dateArray);
      }
  })

}




const saveALaCarte = (product, sessions) => {
 
  let child = $("[name=child]").val();
  let payed = $("[name=payed]").val();
  let status = $("[name=status]").val();
  let person = $("#personId").val();;
  let location = $("#locationId").val();
  let sport = $("#sportId").val();
  let dropin = $("#dropIn").val();
  let dropoff =  $("#dropOff").val();
  let transport = $("#isTransport").val();
  let address = $("#addressChild").val();
  let postal = $("#postalChild").val();
  let alacarte = $("#alacarte").val();
  address = $('#addressId').val();


 
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

  let data = {child, product, person, payed, status, location, sports, sessions, address};

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
      swal({
            title: "Confirmation",
            text: "Inscription pris en compte.",
            type: "success",
            confirmButtonText: "Nouvelle inscription",
            cancelButtonText: "Annuler",
            showCancelButton: false
          }).then(result => {
            if (result.value) {
              
              console.log(json);
              
              let myTargetUrl = urlHost+'registration/add/id/'+child+'/';
              //locationRedirect(myTargetUrl);
              console.log(registrations);

              console.log("hello");
            }
      });
    }              
  });

  
}

const verifiyRegistration = (constant) => {
  let child = $("[name=child]").val();
  let sport = $("#sportId").val();
  let addressId = $('#addressId').val();

  if(sport == '' || child == '' || addressId == '') {

    let endMessage = '';
    if(sport == '') endMessage = endMessage + ' sport manquant'; 
    if(addressId == '') endMessage = endMessage + ' addresse manquante';
    toastr.error('Formulaire incomplet: '+endMessage);
  } else {
    if(constant == 'normal') {
      submitProductRegistration();
    } else {
      submitProductRegistrationALaCarte();
    }
  }
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
    address = $('#addressId').val();

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
            for(let y = 1; y <splitDate.length; y++) {
              date = splitDate[y];
              dateArray.push({date, start:sessionStart, end:sessionEnd});
            }
            sessions = dateArray;
   }

    
    let data = {child, product, person, payed, status, location, sports, sessions, address};

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
        swal({
              title: "Confirmation",
              text: "Inscription pris en compte.",
              type: "success",
              confirmButtonText: "Nouvelle inscription",
              cancelButtonText: "Annuler",
              showCancelButton: false
            }).then(result => {
              if (result.value) {
                let myTargetUrl = urlHost+'registration/add/id/'+child+'/';
                locationRedirect(myTargetUrl);
              }
        });
      }              
    });
    
}





