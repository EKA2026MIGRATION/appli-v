let user_role = $('#user_role').val();
let credentialUpdate = JSON.parse($('#credentialUpdate').val());
let locationSportAge = JSON.parse($('#locationSportAge').val());

$(() => {
  if(user_role == "ADMIN" ) {
    initDragAndDrop();  // faire plus tard le système 
  }

  initMultiSelect();
  initLocalStorage();
  checkChildInGroup();
  colorNpec();
});


$( document ).ready(function() {
  moveMenuLeft();
});

const countGroup = () => {
  var i = 1;
  $(".column2-bis")
    .find("section")
    .each(function() {
      if (
        $(this)
          .prev()
          .is("hr")
      ) {
        i = 1;
      }
      $(this)
        .find(".numberGroup")
        .html(i);
      i++;
    });
};

var countPlaces = () => {
  const nbGroup = $(".column2-bis > section > ul").length;
  let x = 0;
  let nbGroupFull = 0;
  $(".column2-bis")
    .find("section")
    .each(function() {
      x++;
      const idGroup = $(this).attr("data-id-group");
      const nbPickUpInGroup = $(`[data-id-group=${idGroup}] ul > li`).length;
      const nbPlacesMax = $(`[data-id-group=${idGroup}] .nbPlacesMax`).html();

      $(`[data-id-group=${idGroup}] .nbChild`).html(nbPickUpInGroup);
    });
};

var checkChildInGroup = () => {
  $(".npec")
    .find(".tagLi")
    .each(function() {
      const idChild = $(this).data("id-child");
      if ($(this).hasClass("pec")) {
        $(`[data-id-child=${idChild}]`).addClass("pec");
      }

      if ($(this).hasClass("npec")) {
        $(`[data-id-child=${idChild}]`).addClass("npec");
      }

      $(".column2-bis")
        .find("section")
        .each(function() {
          $(this)
            .find("li")
            .each(function() {
              if (idChild == $(this).data("id-child")) {
                $(`[data-id-child=${idChild}]`).addClass("inGroup");
              }
            });
        });
    });

  $(".column2-bis")
    .find("section")
    .each(function() {
      $(this)
        .find("li")
        .each(function() {
          const idChild = $(this).data("id-child");
          if ($(this).hasClass("pec")) {
            $(`[data-id-child=${idChild}]`).addClass("pec");
          }

          if ($(this).hasClass("npec")) {
            $(`[data-id-child=${idChild}]`).addClass("npec");
          }
        });
    });
};

var colorNpec = () => {
  $(".npec li").each(function() {
    const sportId = $(this).attr('data-sport-id');
    const pickupId = $(this).attr('data-id-pickup');
    if($('.column2-ter').find('li[data-sport-id="' + sportId + '"][data-id-pickup="'+pickupId+'"]').length > 0) {
     $(this).css('border', '3px solid darkblue');
     $(this).parent().find('li').css('background-color', 'darkblue');
    } else {
        if($(this).hasClass('ulLineName')) {
        } else{
            $(this).css('border', '3px solid #FF4136');
        }
    }
  });
}

var colorGroups = () => {
  $(".column2-bis")
    .find("section")
    .each(function() {
      if ($(this).attr("data-sport") == 1) {
        $(this)
          .find("header")
          .css("background-color", "#35d0ba");
      }

      if ($(this).attr("data-sport") == 2) {
        $(this)
          .find("header")
          .css("background-color", "#FF9234");
      }

      if ($(this).attr("data-sport") == 3) {
        $(this)
          .find("header")
          .css("background-color", "#ffe79a");
      }

      if ($(this).attr("data-sport") == 4) {
        $(this)
          .find("header")
          .css("background-color", "#c9f658");
      }

      if ($(this).attr("data-sport") == 5) {
        $(this)
          .find("header")
          .css("background-color", "#f9f8eb");
      }

      if ($(this).attr("data-sport") == 6) {
        $(this)
          .find("header")
          .css("background-color", "#9795cf");
      }

      if ($(this).attr("data-sport") == 7) {
        $(this)
          .find("header")
          .css("background-color", "#FFDC00");
      }

      if ($(this).attr("data-sport") == 8) {
        $(this)
          .find("header")
          .css("background-color", "#ffdede");
      }

      if ($(this).attr("data-sport") == 9) {
        $(this)
          .find("header")
          .css("background-color", "#feff89");
      }

      if ($(this).attr("data-sport") == 10) {
        $(this)
          .find("header")
          .css("background-color", "#e6e6fa");
      }

      if ($(this).attr("data-sport") == 11) {
        $(this)
          .find("header")
          .css("background-color", "#FF9280");
      }

      if ($(this).attr("data-sport") == 12) {
        $(this)
          .find("header")
          .css("background-color", "#fdb44b");
      }

      if ($(this).attr("data-sport") == 13) {
        $(this)
          .find("header")
          .css("background-color", "#ccffec");
      }

      if ($(this).attr("data-sport") == 14) {
        $(this)
          .find("header")
          .css("background-color", "#c7f3ff");
      }

      if ($(this).attr("data-sport") == 15) {
        $(this)
          .find("header")
          .css("background-color", "#d6f8b8");
      }
      if ($(this).attr("data-sport") == 16) {
        $(this)
          .find("header")
          .css("background-color", "#87e0ff");
      }
    });
};

var initDragAndDrop = () => {
  $(".column1 li.inline-li").draggable({
    helper: function() {
      const idPickup = $("#lastIdPickup").val();
      const sportId = $(`#a${idPickup}`).attr("data-sport-id");
      const childId = $(`#a${idPickup}`).attr("data-child");
      const childName = $(`#a${idPickup}`).attr("data-child-name");
      const photo = $(`#a${idPickup}`).attr("data-photo");
      const age = $(`#a${idPickup}`).attr("data-age");
      var helperDrag = `
                <li data-id-pickup="${idPickup}" data-sport-id="${sportId}" style="width:auto;" data-age="${age}" data-id-child="${childId}" >
                            <a href="javascript:void(0)"  onclick="getIdPickup('${idPickup}');openRevealJS('action-pickupActivity')">
                                <div>
                                    <p class="list-header">

                                        <img src="${photo}" class="width-30 height-30" data-id-child="${childId}" alt="">
                                        ${childName} (${age})
                                        <aside class="subtitles">

                                        </aside>
                                    </p>
                                </div>
                            </a>
                            <div class="with-icon">
                                <i class="material-icons" style="cursor:pointer;" onclick="removeElement(this)">delete</i>
                            </div>
                        </li>
                `;
      return helperDrag;
      countPlaces();
    },
    zIndex: 100,
    connectToSortable: ".ul-group",
  });

  $(".column1 li.inline-li")
    .sortable({
      connectWith: ".column2-bis",
      scroll: true,
    })
    .disableSelection();

  $("li.inline-li")
    .sortable({
      connectWith: ".ul-group",
      scroll: true,
      stop(event, ui) {
        countPlaces();

        saveDispatch(
          "change",
          $(ui.item)
            .parent("ul")
            .parent("section")
            .attr("data-id-group")
        );
      },
    })
    .disableSelection();

  $(".dragDispatch ul:not(.isLocked)")
    .sortable({
      connectWith: ".ul-group",
      scroll: true,
      receive(event, ui) {
        countPlaces();

        saveDispatch(
          "change",
          $(ui.sender)
            .parent("section")
            .attr("data-id-group")
        );
      },
      stop(event, ui) {
        countPlaces();
        saveDispatch(
          "change",
          $(ui.item)
            .parent("ul")
            .parent("section")
            .attr("data-id-group")
        );
      },
    })
    .disableSelection();
};

const removeElement = (el) => {
  idGroup = $(el)
    .parent()
    .parent()
    .parent()
    .parent()
    .attr("data-id-group");

  $(el)
    .parent()
    .parent()
    .remove();
  saveDispatch("change", idGroup);
};

var moveMenuLeft = () => {
  var width = $(window).width();
  if (width > 1023) {
    let menuLeft = document.getElementsByClassName("menu__left")[0];

    $(menuLeft).animate(
      {
        marginLeft: "-=260px",
      },
      500
    );

    setTimeout(() => {
      $(".container__menu__left").css("width", "40px");
      $(".page__container").css("width", "calc(100% - 100px)");
      $(".closeLeftMenu i").html("arrow_forward");
    }, 500);
  }
};
/*--- Datepicker ---*/
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
      "Décembre",
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
      "Déc.",
    ],
    dayNames: [
      "Dimanche",
      "Lundi",
      "Mardi",
      "Mercredi",
      "Jeudi",
      "Vendredi",
      "Samedi",
    ],
    dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
    dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
    weekHeader: "Sem.",
    dateFormat: "yy-mm-dd",
    changeYear: true,
    onSelect(dateText) {
      var url = `${urlHost}activity/dispatch/date/${dateText}/`;
      locationRedirect(url);
    },
  });
};

/*--- Time filter ---*/
const numberFormat = (number, width) =>
  new Array(+width + 1 - (number + "").length).join("0") + number;

$(".slider").on("moved.zf.slider", () => {
  allFilter();
});

$("#slider2").on("moved.zf.slider", () => {
  allFilter();
});

/*--- zmultiselect ---*/

var initMultiSelect = () => {
  $("#monitorFilter").zmultiselect({
    filter: true,
    filterResult: true,
    selectAll: true,
    selectAllText: ["Tout cocher", "Tout décocher"],
    selectedText: ["Sélectionné : ", "/"],
    filterPlaceholder: "",
    filterResultText: "",
    filterPlaceholder: "Filtrer par",
    get: "zmultiselect",
    placeholder: "Filtrer les moniteurs",
    live: "#liveResultMonitorBis",
  });

  $("#monitorSelect").zmultiselect({
    filter: true,
    filterResult: true,
    selectAll: true,
    selectAllText: ["Tout cocher", "Tout décocher"],
    selectedText: ["Sélectionné : ", "/"],
    filterPlaceholder: "",
    filterResultText: "",
    filterPlaceholder: "Filtrer par",
    get: "zmultiselect",
    placeholder: "Cocher les moniteurs",
    live: "#liveResultMonitor",
  });

  $("#locationFilter").zmultiselect({
    filter: true,
    filterResult: true,
    selectAll: true,
    selectAllText: ["Tout cocher", "Tout décocher"],
    selectedText: ["Sélectionné : ", "/"],
    filterPlaceholder: "",
    filterResultText: "",
    filterPlaceholder: "Filtrer par",
    get: "zmultiselect",
    placeholder: "Filtrer les lieux",
    live: "#liveResultLocation",
  });
};

/*--- localStorage for monitor filter ---*/
const initLocalStorage = () => {
  if (typeof localStorage != "undefined") {
    if ("monitorActivity" in localStorage) {
      const myRegisteredMonitor = JSON.parse(
        localStorage.getItem("monitorActivity")
      );

      setTimeout(() => {
        myRegisteredMonitor.forEach(function(element) {
          $("#monitorFilter").zmultiselect("set", element, true);
        });

        $("#monitorFilterValidate").trigger("click");
      }, 200);
    }
  } else {
    setTimeout(() => {
      $("#monitorFilter").zmultiselect("checkAll");
      $("#monitorFilterValidate").trigger("click");
    }, 200);
  }

  /*--- localStorage for location filter ---*/

  if (typeof localStorage != "undefined") {
    if ("location" in localStorage) {
      const myRegisteredLocation = JSON.parse(localStorage.getItem("location"));

      setTimeout(() => {
        myRegisteredLocation.forEach(function(element) {
          $("#locationFilter").zmultiselect("set", element, true);
        });

        $("#locationFilterValidate").trigger("click");
      }, 200);
    }
  } else {
    setTimeout(() => {
      $("#locationFilter").zmultiselect("checkAll");
      $("#locationFilterValidate").trigger("click");
    }, 200);
  }
};

const allFilter = () => {
  setTimeout(() => {
    var monitorValue = $("#liveResultMonitorBis").val();
    var monitorValue = monitorValue.split(",");
    var locationValue = $("#liveResultLocation").val();
    var locationValue = locationValue.split(",");
    var daily = $("#daily").prop("checked");

    let age1 = $("#age1").val();
    let age2 = $("#age2").val();
    $("#ageFilter").html(`${age1} - ${age2}`);
    let hour1 = $("#hour1").val();
    let hour2 = $("#hour2").val();
    let hour1Length = hour1.length;
    let hour2Length = hour2.length;
    let last2Hours1 = hour1.slice(-2);
    let last2Hours2 = hour2.slice(-2);
    last2Hours1 = (last2Hours1 * 60) / 100;
    last2Hours2 = (last2Hours2 * 60) / 100;
    last2Hours1 = numberFormat(last2Hours1, 2);
    last2Hours2 = numberFormat(last2Hours2, 2);

    if (hour1Length == 3) {
      var firstHours1 = hour1.substring(0, 1);
    } else {
      var firstHours1 = hour1.substring(0, 2);
    }

    if (hour2Length == 3) {
      var firstHours2 = hour2.substring(0, 1);
    } else {
      var firstHours2 = hour2.substring(0, 2);
    }

    let aecrireHour1 = `${firstHours1}h${last2Hours1}`;
    let aecrireHour2 = `${firstHours2}h${last2Hours2}`;
    let reqHour1 = firstHours1 + last2Hours1;
    let reqHour2 = firstHours2 + last2Hours2;

    $("#hourFilter").html(`${aecrireHour1} - ${aecrireHour2}`);

    $(".npec")
      .find("li")
      .each(function() {
        const id = this.id;
        const startHour = $(this).attr("data-start-hour");
        const endHour = $(this).attr("data-end-hour");
        const age = $(this).attr("data-age");
        var location = $(this).attr("data-location");
        var hidePickupHour = 0;

        if (daily == false) {
          if (
            parseInt(startHour) >= parseInt(reqHour1) &&
            parseInt(endHour) <= parseInt(reqHour2)
          ) {
            hidePickupHour = 0;
          } else {
            hidePickupHour = 1;
          }
        } else {
          if (
            parseInt(startHour) <= parseInt(reqHour1) &&
            parseInt(endHour) >= parseInt(reqHour1)
          ) {
            hidePickupHour = 0;
          } else {
            hidePickupHour = 1;
          }
        }

        if (
          hidePickupHour == 0 &&
          (location == "" || jQuery.inArray(location, locationValue) != -1) &&
          parseInt(age1) <= parseInt(age) &&
          parseInt(age2) >= parseInt(age)
        ) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });

    $(".column2-bis")
      .find("section")
      .each(function() {
        const id = this.id;
        const hour = $(this).attr("data-hour");
        const hourEnd = $(this).attr("data-hour-end");

        const location = $(this).attr("data-location");
        const monitor = $(this).attr("data-monitor");

        var hideMonitor = 0;
        var hideGroupHour = 0;

        if (monitor == "") {
          var arrayMonitor = "";
        } else {
          var arrayMonitor = monitor.split("-");
        }

        if (arrayMonitor.length >= 2) {
          for (var i = 0; i < arrayMonitor.length; i++) {
            if (jQuery.inArray(arrayMonitor[i], monitorValue) == -1) {
              hideMonitor = 1;
            } else {
              hideMonitor = 0;
            }
          }
        } else {
          if (arrayMonitor == "") {
            if (jQuery.inArray("nothing", monitorValue) == -1) {
              hideMonitor = 1;
            } else {
              hideMonitor = 0;
            }
          } else {
            if (jQuery.inArray(monitor, monitorValue) == -1) {
              hideMonitor = 1;
            } else {
              hideMonitor = 0;
            }
          }
        }

        if (daily == false) {
          if (
            parseInt(hour) <= parseInt(reqHour2) &&
            parseInt(hour) >= parseInt(reqHour1)
          ) {
            hideGroupHour = 0;
          } else {
            hideGroupHour = 1;
          }
        } else {
          if (
            parseInt(hour) <= parseInt(reqHour1) &&
            parseInt(hourEnd) >= parseInt(reqHour1)
          ) {
            hideGroupHour = 0;
          } else {
            hideGroupHour = 1;
          }
        }

        if (
          hideGroupHour == 0 &&
          hideMonitor == 0 &&
          jQuery.inArray(location, locationValue) != -1
        ) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
  }, 200);
};

$("#monitorFilterValidate").click(() => {
  var myMonitor = $("#liveResultMonitorBis").val();
  var myMonitor = myMonitor.split(",");

  var monitorStorage = JSON.stringify(myMonitor);

  if (typeof localStorage != "undefined") {
    if ("monitorActivity" in localStorage) {
      localStorage.removeItem("monitorActivity");
      localStorage.setItem("monitorActivity", monitorStorage);
    } else {
      localStorage.setItem("monitorActivity", monitorStorage);
    }
  } else {
    localStorage.setItem("monitorActivity", monitorStorage);
  }
});

$("#locationFilterValidate").click(() => {
  var myLocation = $("#liveResultLocation").val();
  var myLocation = myLocation.split(",");

  var locationStorage = JSON.stringify(myLocation);

  if (typeof localStorage != "undefined") {
    if ("location" in localStorage) {
      localStorage.removeItem("location");
      localStorage.setItem("location", locationStorage);
    } else {
      localStorage.setItem("location", locationStorage);
    }
  } else {
    localStorage.setItem("location", locationStorage);
  }

  checkCredentials();

   $('.locationAll').hide();
    for(var key in myLocation) {
      for(var key2 in locationSportAge[myLocation[key]]) {
        let keySportAge = locationSportAge[myLocation[key]][key2];

        let el = keySportAge.split('-');

        $('#'+el[0]+'Title').show();
        $('#'+el[0]+el[2]+'Element').show();
        $('#'+el[0]+el[1]+'Div').show();
      }
      $('.selectLocation'+myLocation[key]).show();
   }

});

const checkCredentials = () => {

    let show = false; let no = 0; let allCurrentCredential = [];
    let myLocation = $("#liveResultLocation").val()
    myLocation = myLocation.split(",");

    // show or not button action 
    for(var key in credentialUpdate) {
        if(credentialUpdate[key] == "UpdateAll") {
            show = true;
        } 
        allCurrentCredential.push(credentialUpdate[key].split('-')[1]);
    }

    for(var key in myLocation) {
        if(allCurrentCredential.includes(myLocation[key])) {
        } else {
            no++; 
        }
    }

    if(no > 0 && show == false) {
        $('.actionGroupButton').hide();
        $('.mfb-component__button--main').hide();
    } else { // show with locationupadte all
        $('.actionGroupButton').show();
        $('.mfb-component__button--main').show();
    }
  
}


$("#start_group").change(() => {
  const time = $("#start_group").val();

  if (time.length == 5) {
    $("#start_group_2").val(`${time}:00`);
  }
});

$("#end_group").change(() => {
  const time = $("#end_group").val();

  if (time.length == 5) {
    $("#end_group_2").val(`${time}:00`);
  }
});

document.getElementById("activityGroupForm").addEventListener(
  "submit",
  (event) => {
    event.preventDefault();
    let form = $("#activityGroupForm");
    let url = form.attr("action");
    const dataStaff = [];
    const dataPickup = [];

    var i = 0;
    $(".monitorCheckBoxs")
      .find(":checkbox:checked")
      .each(function() {
        let idStaff = $(this).attr("data-id-monitor");
        dataStaff[i] = { staffId: idStaff };
        i++;
      });

    let type = "POST";
    let data = $(form).serializeToJSON();

    if (url.includes("modify")) {
      type = "PUT";
    }

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type, url, data, staff: dataStaff, links: dataPickup },
      dataType: "json",
      beforeSend() {
        $("#activityGroupForm [type=submit]")
          .attr("disabled", true)
          .attr("value", "Envoi en cours..");
      },
      success(json) {
        $("#activityGroupForm [type=submit]")
          .attr("disabled", false)
          .attr("value", "Envoyer");

        if (url.includes("modify")) {
          let date = $("#date").val();
          const url =
            urlHost +
            "/activity/loadOneGroup/date/" +
            date +
            "/idGroup/" +
            json.groupActivity.groupActivityId +
            "/";
          var content;
          $.get(url, function(data) {
            content = data;
            var dataHour = $(
              `section[data-id-group=${json.groupActivity.groupActivityId}]`
            ).attr("data-hour");
            $(
              `section[data-id-group=${json.groupActivity.groupActivityId}]`
            ).replaceWith(content);
            //$(`section[data-id-group=${json.groupActivity.groupActivityId}]`).insertAfter(prev);
            countPlaces();
            colorGroups();
            countGroup();
            const hour = $(
              `section[data-id-group=${json.groupActivity.groupActivityId}]`
            ).attr("data-hour");
            if (hour != dataHour) {
              $(".column2-bis")
                .find("h2")
                .each(function() {
                  if ($(this).attr("data-hour") <= hour) {
                    $(
                      `section[data-id-group=${json.groupActivity.groupActivityId}]`
                    ).insertAfter($(this).next("hr"));
                  }
                });
            }
          });
        } else {
          let date = $("#date").val();
          const url =
            urlHost +
            "/activity/loadOneGroup/date/" +
            date +
            "/idGroup/" +
            json.groupActivity.groupActivityId +
            "/";
          var content;
          $.get(url, function(data) {
            content = data;
            $(".column2-bis").prepend(content);
            countPlaces();
            colorGroups();
            countGroup();
            const hour = $(
              `section[data-id-group=${json.groupActivity.groupActivityId}]`
            ).attr("data-hour");

            $(".column2-bis")
              .find("h2")
              .each(function() {
                if ($(this).attr("data-hour") <= hour) {
                  $(
                    `section[data-id-group=${json.groupActivity.groupActivityId}]`
                  ).insertAfter($(this));
                }
              });
          });
        }

        if (json.status == true) {
          $("#revealCreateActivityGroup").foundation("close");
          toastr.success(json.message, "Confirmation");
        } else {
          $("#revealCreateActivityGroup").foundation("close");
          swal({
            title: "Erreur",
            text: "Une erreur est survenue.",
            type: "warning",
          });
        }
      },
    });
  },
  false
);

const changeActionGroup = () => {
  $("#activityGroupForm").attr("action", "group-activity/create");
  $("#activityGroupForm").trigger("reset");
};

const editGroup = (idGroup) => {
  let url = `group-activity/display/${idGroup}`;
  $("#activityGroupForm").attr("action", `group-activity/modify/${idGroup}`);
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {
      $("#loaderFormEditGroup").show();
    },
    success(json) {
      $("#loaderFormEditGroup").hide();

      $("[name=name]").val(json.name);
      $("[name=start]").val(json.start);
      $("[name=end]").val(json.end);
      $("[name=area]").val(json.area);

      if (json.lunch == true) {
        $("[name=lunch]").val(1);
      } else {
        $("[name=lunch]").val(0);
      }

      if (json.location.locationId != null) {
        $("[name=location]").val(json.location.locationId);
      }

      if (json.sport.sportId != null) {
        $("[name=sport]").val(json.sport.sportId);
      }
      $("#start_group").val(json.start);
      $("#end_group").val(json.end);
      
      if (json.staff != null) {
        for (var i = 0; i < json.staff.length; i++) {
          const idStaff = $(json.staff[i].staffId);
          var idValue = idStaff[0];

          $(".monitorCheckBoxs")
            .find("[data-id-monitor=" + idValue + "]")
            .attr("checked", true);
        }
      }
    },
  });
};

const deleteGroup = (idGroup) => {
  swal({
    title: "Attention",
    text: "La suppression est irréversible.",
    type: "warning",
    confirmButtonText: "Supprimer",
    cancelButtonText: "Annuler",
    showCancelButton: true,
  }).then((result) => {
    if (result.value) {
      deleteGroupSubmit(idGroup);
    }
  });
};

var deleteGroupSubmit = (idGroup) => {
  let url = `group-activity/delete/${idGroup}`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type: "DELETE" },
    dataType: "json",
    beforeSend() {},
    success(json) {
      if (json.status == true) {
        toastr.success(json.message, "Suppression");
      //  locationRedirect();
        $(`[data-id-group=${idGroup}]`)
          .addClass("animated bounceOutUp")
          .delay(750)
          .hide(0);
      } else {
        swal({
          title: "Suppression",
          text: "Une erreur est survenue.",
          type: "warning",
        });
      }
    },
  });
};

/*--- Submit/edit/delete pickup ---*/

const getIdPickup = (idPickUp, idGroup) => {
  $("#lastIdPickup").val(idPickUp);
  $("#actualGroupPickup").val(idGroup);
};

const validatePickup = () => {
  const idPickup = $("#lastIdPickup").val();
  let url = `pickup-activity/modify/${idPickup}`;

  let data = { validated: "VALIDATED" };
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "PUT", url, data },
    dataType: "json",
    success(json) {
      $(`[data-id-pickup=${idPickup}]`).addClass("VALIDATED");
    },
  });
};

const noValidatePickup = () => {
  const idPickup = $("#lastIdPickup").val();

  let url = `pickup-activity/modify/${idPickup}`;

  let data = { validated: "NO" };
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "PUT", url, data },
    dataType: "json",
    success(json) {
      $(`[data-id-pickup=${idPickup}]`).removeClass("VALIDATED");
    },
  });
};

const editPickUp = () => {
  let idPickUp = $("#lastIdPickup").val();
  let url = `pickup-activity/display/${idPickUp}`;
  $("#pickupActivityForm").attr("action", `pickup-activity/modify/${idPickUp}`);
  //$("#listChildPickUpActivity").hide();
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {
      $("#loaderFormEditPickupActivity").show();
    },
    success(json) {
      $("#loaderFormEditPickupActivity").hide();

      const inputs = $("input, textarea, select").not(
        ":input[type=button], :input[type=submit], :input[type=reset]"
      );

      $("#pickupActivityForm")
        .find(inputs)
        .each(function() {
          const name = $(this).attr("name");
          $(this).val(json[name]);
        });
      if (json.child.childId != null) {
        $("[name=child]").val(json.child.childId);
        $("#autocompleteChild").val(
          json.child.firstname + " " + json.child.lastname
        );
        $("#autocompleteChild").attr("disabled", true);
      }

      if (json.sport.sportId != null) {
        $("[name=sport]").val(json.sport.sportId);
      }
      if (json.location.locationId != null) {
        $("#selectLocationPickup").val(json.location.locationId);
      }
      $("#start_pickup").val(json.start);
      $("#end_pickup").val(json.end);

      if (json.groupActivities != null) {
        for (var i = 0; i < json.groupActivities.length; i++) {
          $(".groupsCheckBoxs")
            .find(
              "[data-id-group=" + json.groupActivities[i].groupActivityId + "]"
            )
            .attr("checked", true);

          /*$("#groupActivitySelect")
                       .find("option")
                       .each(function(){
                           const id = $(this).attr("data-id-group");
                           const idGroup = (Object.values($()));

                           if (id == idGroup[0])
                           {
                               $("#groupActivitySelect").val(idGroup[0]);
                           }
                       });*/
        }
      }
    },
  });
};

const deletePickUp = () => {
  let idPickUp = $("#lastIdPickup").val();

  swal({
    title: "Attention",
    text: "La suppression est irréversible.",
    type: "warning",
    confirmButtonText: "Supprimer",
    cancelButtonText: "Annuler",
    showCancelButton: true,
  }).then((result) => {
    if (result.value) {
      deletePickupSubmit(idPickUp);
    }
  });
};

var deletePickupSubmit = (idPickUp) => {
  let url = `pickup-activity/delete/${idPickUp}`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { url, type: "DELETE" },
    dataType: "json",
    beforeSend() {},
    success(json) {
      if (json.status == true) {
        toastr.success(json.message, "Suppression");
        $(`[data-id-pickup=${idPickUp}]`)
          .addClass("animated bounceOutUp")
          .delay(750)
          .hide(0);
      } else {
        swal({
          title: "Suppression",
          text: "Une erreur est survenue.",
          type: "warning",
        });
      }
    },
  });
};

const changeActionPickupActivity = () => {
  $("#pickupActivityForm").attr("action", "pickup-activity/create");
  $("#pickupActivityForm").trigger("reset");
  $("#autocompleteChild").attr("disabled", false);
};

function closeReveal() {
  $("#reveal-iframe")
            .find("#close-iframe-full")
            .attr("onClick", "location.reload()");
}

document.getElementById("pickupActivityForm").addEventListener(
  "submit",
  (event) => {
    event.preventDefault();
    let form = $("#pickupActivityForm");
    let url = form.attr("action");
    const dataGroup = [];

    let sportSelected = $('#selectSport').val();

    var i = 0;
    $(".groupsCheckBoxs")
      .find(":checkbox:checked")
      .each(function() {
        let idGroup = $(this).attr("data-id-group");
        dataGroup[i] = { groupActivityId: idGroup };
        i++;
      });

    let type = "POST";
    let data = $(form).serializeToJSON();

    if (url.includes("modify")) {
      type = "PUT";
    }

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type, url, data, links: dataGroup },
      dataType: "json",
      beforeSend() {
        $("#pickupActivityForm [type=submit]")
          .attr("disabled", true)
          .attr("value", "Envoi en cours..");
      },
      success(json) {


        let locationReloaded = 1;
        if ($("#updateAllRegistration").is(":checked")) {
          locationReloaded = 0;
          let idPickUp = $("#lastIdPickup").val(); 
          openRevealJS("reveal-iframe");
          /*$("#reveal-iframe")
            .find("#close-iframe-full")
            .attr("onClick", "location.reload()");*/
          $(".frameFullScreen").attr(
            "src",
            `${urlHost}activity/updateAllRegistration/pickupId/${idPickUp}/sportSelected/${sportSelected}/iframe/yes/`
          );
        }



        if ($("#addTransport").is(":checked")) {
          let child = $("#formChildId").val();
          let date = $("#date").val();

          openRevealJS("reveal-iframe");
          $("#reveal-iframe")
            .find("#close-iframe-full")
            .attr("onClick", "location.reload()");
          $(".frameFullScreen").attr(
            "src",
            `${urlHost}transport/create-pickup/date/${date}/child/${child}/iframe/yes/`
          );
        }

        if ($("#addPresence").is(":checked")) {
          let child = $("#formChildId").val();
          let person = 0;
          let registration = "";
          let date = $("#datePickupActivity").val();
          let sessionStart = $("#start_pickup_2").val();
          let sessionEnd = $("#end_pickup_2").val();
          let location = $("#selectLocationPickup").val();

          let data4 = [];
          data4.push({
            child,
            person,
            registration,
            date,
            location,
            start: sessionStart,
            end: sessionEnd,
          });
          let url3 = "child/presence/create";
          $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url: url3, type: "POST", data: data4 },
            dataType: "json",
            beforeSend() {},
            success(json2) {},
          });
        }
        if(locationReloaded == 1) {

            // update all
            location.reload()
        };
      
        $("#pickupActivityForm [type=submit]")
          .attr("disabled", false)
          .attr("value", "Envoyer");

        if (json.status == true) {
          $("#revealCreatePickupActivity").foundation("close");
          toastr.success(json.message, "Confirmation");
        } else {
          $("#revealCreatePickupActivity").foundation("close");
          swal({
            title: "Erreur",
            text: "Une erreur est survenue.",
            type: "warning",
          });
        }
      },
    });
  },
  false
);

/*--- move/duplicate pickups ---*/

var saveDispatch = (type, group) => {

  setTimeout(() => {
    colorNpec();
  }, 500);


  if (group != undefined) {
    let data = { comment: "RAS" };
    let dataPickup = { validated: "NO" };
    const idGroup = group;
    var pickups = [];
    $(`[data-id-group=${idGroup}]`)
      .find("li")
      .each(function() {
        const idPickUpActivity = $(this).attr("data-id-pickup");

        if (jQuery.inArray(pickups, idPickUpActivity) == -1) {
          pickups.push({
            pickupActivityId: idPickUpActivity,
          });
        }

        if (pickups.length == 0) {
          pickups = null;
        }
      });

    let url = `group-activity/modify/${idGroup}`;
    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "PUT", url, data, links: pickups },
      dataType: "json",

      success(json) {},
    });
  }
};

const changeStatusPickup = (status, idPickupCascade) => {
  let url = `pickup-activity/modify/${idPickupCascade}`;
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

      const date = new Date(json.pickupActivity.updatedAt);

      if (json.pickupActivity.status == "pec") {
        $(`[data-id-pickup=${idPickupCascade}] .with-icon`).html(
          '<i class="material-icons status olive">check</i>'
        );
      } else if (json.pickupActivity.status == "npec") {
        $(`[data-id-pickup=${idPickupCascade}] .with-icon`).html(
          '<i class="material-icons status red">close</i>'
        );
      } else {
        $(`[data-id-pickup=${idPickupCascade}]`)
          .removeClass("npec")
          .removeClass("pec")
          .removeClass("automatic")
          .addClass("nopec");
        $(`[data-id-pickup=${idPickupCascade}] .with-icon`).html(
          '<i class="material-icons status blue">access_time</i>'
        );
      }
    },
  });
};

const changeStatus = (status) => {
  let idPickUp = $("#lastIdPickup").val();
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

      const date = new Date(json.pickupActivity.updatedAt);
      const idChild = $(`[data-id-pickup=${idPickUp}]`).data("id-child");

      $(`[data-id-child=${idChild}]`)
        .removeClass("npec")
        .removeClass("nopec")
        .removeClass("pec")
        .removeClass("automatic")
        .addClass(json.pickupActivity.status);

      $(`[data-id-child=${idChild}]`).each(function() {
        var idPickupCascade = $(this).attr("data-id-pickup");
        changeStatusPickup(status, idPickupCascade);
      });

      if (json.pickupActivity.status == "pec") {
        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status olive">check</i>'
        );
      } else if (json.pickupActivity.status == "npec") {
        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status red">close</i>'
        );
      } else {
        $(`[data-id-pickup=${idPickUp}]`)
          .removeClass("npec")
          .removeClass("pec")
          .removeClass("automatic")
          .addClass("nopec");
        $(`[data-id-pickup=${idPickUp}] .with-icon`).html(
          '<i class="material-icons status blue">access_time</i>'
        );
      }
    },
  });
};

const placePickup = () => {
  const idPickup = $("#lastIdPickup").val();
  const idGroup = $("#groupSelect").val();

  const dataGroup = [];
  dataGroup.push({
    groupActivityId: idGroup,
  });

  let url = `pickup-activity/modify/${idPickup}`;

  let data = { validated: "NO" };
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "PUT", url, links: dataGroup, data },
    dataType: "json",

    success(json) {
      const pickups = [];
      data = { comment: "RAS" };
      $(`[data-id-group=${idGroup}]`)
        .find("li")
        .each(function() {
          const idPickUpActivity = $(this).attr("data-id-pickup");

          pickups.push({
            pickupActivityId: idPickUpActivity,
          });
        });

      let url = `group-activity/modify/${idGroup}`;
      $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "PUT", url, data, links: pickups },
        dataType: "json",

        success(json) {},
      });

      locationRedirect();
    },
  });
};

$(".groupDropDown").change(function() {

  const newGroup = $(this).val();
  const lastIdPickup = $(this)
    .parent("div")
    .parent("li")
    .attr("data-id-pickup");
  const lastGroup = $(this)
    .parent("div")
    .parent("li")
    .parent("ul")
    .parent("section")
    .attr("data-id-group");

  const lastPickUpInNewGroup = $(
    `[data-id-group=${newGroup}] ul > li:last-of-type`
  ).attr("data-id-pickup");

  if (lastPickUpInNewGroup == undefined) {
    $(`[data-id-pickup=${lastIdPickup}]`).appendTo(
      `[data-id-group=${newGroup}] ul`
    );
  } else {
    $(`[data-id-pickup=${lastIdPickup}]`).insertAfter(
      `[data-id-pickup=${lastPickUpInNewGroup}]`
    );
  }

  saveDispatch("change", newGroup);
  saveDispatch("change", lastGroup);
});

/*--- JS for pickup  ---*/

$("#start_pickup").change(() => {
  const time = $("#start_pickup").val();

  if (time.length == 5) {
    $("#start_pickup_2").val(`${time}:00`);
  }
});

$("#end_pickup").change(() => {
  const time = $("#end_pickup").val();

  if (time.length == 5) {
    $("#end_pickup_2").val(`${time}:00`);
  }
});

const goToProfilChild = () => {
  const idPickUp = $("#lastIdPickup").val();
  const idChild = $(`[data-id-pickup=${idPickUp}]`)
    .attr("data-id-child");

  openRevealJS("reveal-iframe");

  $(".frameFullScreen").attr(
    "src",
    `${urlHost}child/display/id/${idChild}/iframe/yes/`
  );
};

/*--- To open/close ---*/
const closeAll = () => {
  $(".dragDispatch")
    .find("ul")
    .each(function() {
      if (
        $(this)
          .find("li")
          .css("display") == "none"
      ) {
        $(this)
          .find("li")
          .show();
        $(this)
          .find("div")
          .show();
        $(this)
          .prev("header")
          .find("i.arrow")
          .html("keyboard_arrow_up");
      } else {
        $(this)
          .find("li")
          .hide();
        $(this)
          .find("div")
          .hide();
        $(this)
          .prev("header")
          .find("i.arrow")
          .html("keyboard_arrow_down");
      }
    });
};

$(".block-list header i.arrow").click(function() {
  let element = $(this)
    .parent()
    .next("ul");

  if (
    $(element)
      .find("li")
      .css("display") == "none"
  ) {
    $(element)
      .find("li")
      .show();
    $(element)
      .find("div")
      .show();
    $(this).html("keyboard_arrow_up");
  } else {
    $(element)
      .find("li")
      .hide();
    $(element)
      .find("div")
      .hide();
    $(this).html("keyboard_arrow_down");
  }
});

/*--- FOR AUTOCOMPLETE ---*/

/*--- autocomplete for pickupActivityForm ---*/
document.getElementById("autocompleteChild").addEventListener(
  "keyup",
  function(event) {
    let searchTerm = $(this).val();
    let url = `child/search/${searchTerm}`;

    $("#autocompleteChild").autocomplete({
      minLength: 2,
      appendTo: "#listChild",
      source(request, response) {
        $.ajax({
          type: "POST",
          url: urlRequest,
          data: { url, type: "GET" },
          dataType: "json",

          success(data) {
            response(
              $.map(data, (child) => ({
                label: `${child.firstname} ${child.lastname}`,
                value: child.childId,
              }))
            );
          },
        });
      },
      select(data, child) {
        $("#formChildId").val(child.item.value);
        $("#autocompleteChild").val(child.item.label);
        return false;
      },
    });
  },
  false
);

/*--- To change column ---*/
const changeColumn = () => {
  const f =
    ($(".dragDispatch .column2-bis section").width() /
      $(".dragDispatch .column2-bis section")
        .parent()
        .width()) *
    100;

  if (f < 90) {
    $(".dragDispatch .column2-bis section").css("max-width", "100%");
  } else if (f > 100) {
    $(".dragDispatch .column2-bis section").css("max-width", "25%");
  } else {
    $(".dragDispatch .column2-bis section").css("max-width", "100%");
  }
};

/*--- TOOLTIPS for list of groups/child ---*/
const showGroups = (idPickup, idChild) => {
  var arrayGroup = [];
  const childName = $(`#a${idPickup}`).attr("data-child-name");

  $(".column2-bis")
    .find("li")
    .each(function() {
      var childId = $(this).attr("data-id-child");

      const isInGroup = $(this)
        .parent("ul")
        .parent("section")
        .attr("data-group-for-child");

      if (idChild == childId) {
        arrayGroup.push(isInGroup);
      }
    });

  var contentTooltip = `<div>
            <h5>${childName}</h5><ul>`;

  for (var i = 0; i < arrayGroup.length; i++) {
    contentTooltip = contentTooltip + `<li> ${arrayGroup[i]} </li>`;
  }

  contentTooltip = contentTooltip + `</ul></div>`;

  $(`#a${idPickup}`).tooltip({
    position: { my: "left top+15", at: "left bottom", collision: "flipfit" },
    content: function() {
      return contentTooltip;
    },
    hide: { duration: 1000 },
  });
};

const hideTooltip = () => {
  $(".ui-tooltip")
    .delay(750)
    .fadeOut();
};

const lockGroup = (self) => {
  let element = $(self)
    .parent()
    .parent()
    .parent()
    .parent();

  var idGroup = $(element).attr("data-id-group");

  let data = { locked: 1 };
  let url = "group-activity/modify/" + idGroup;
  let type = "PUT";
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type, url, data },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(".loading").hide();

      toastr.success(json.message);
    },
  });

  $("select option[value=" + idGroup + "]").attr("disabled", "disabled");

  $(element)
    .addClass("isLocked")
    .append(
      '<button onclick="unLockGroup(this)" class="unlock button withIcon"><i class="material-icons">lock_key</i> Débloquer ce groupe </button>'
    );

  $(element)
    .find("ul")
    .sortable("disable");
};

const unLockGroup = (self) => {
  let element = $(self).parent();

  $(element).removeClass("isLocked");

  var idGroup = $(element).attr("data-id-group");
  var data = { locked: 0 };
  let url = "group-activity/modify/" + idGroup;
  let type = "PUT";
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type, url, data },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(".loading").hide();

      toastr.success("Groupe unlock");
    },
  });

  $("select option[value=" + idGroup + "]").removeAttr("disabled");

  $(element)
    .find("ul")
    .sortable("enable");

  $(self).remove();
};

const affect = () => {
  let date = $("#date").val();

  let url = `pickup-activity/affect/${date}/true`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "PUT", url },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(".loading").hide();
      locationRedirect();
    },
  });
};

const unaffect = () => {
  let date = $("#date").val();

  let url = `pickup-activity/unaffect/${date}`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "PUT", url },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      $(".loading").hide();
      locationRedirect();
    },
  });
};
/*
const copyMoment = (groupName) => {

  let hour  = $('#selectHour-'+groupName).val();
  let min   = $('#selectMinute-'+groupName).val();
  let lunch = $('#isLunch-'+groupName+':checked').val();
  let groupsId = [];

  if(lunch != 1) {
    lunch = 0;
  } 

  $('.'+groupName).each(function() {
    groupsId.push($(this).data('id-group'))
  })


  let groupsIdJson = JSON.stringify(groupsId);

  let url = `group-activity/duplicateMoment`;

  let data = { groupName: groupName, targetMoment: hour+':'+min, groupsId : groupsIdJson, lunch: lunch };
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "POST", url, data },
    dataType: "json",
    beforeSend() {
      $(".loading").show();
    },
    success(json) {
      locationRedirect();
    },
  });


}*/

const duplicateGroup = (idGroup) => {
  let url = `group-activity/display/${idGroup}`;
  $("#activityGroupForm").attr("action", `group-activity/modify/${idGroup}`);
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {},
    success(json) {
      const dataStaff = [];
      const dataPickup = [];
      const staffs = json.staff;
      const pickupActivities = json.pickupActivities;

      staffs.forEach(function(staff, i = 0) {
        dataStaff.push({ staffId: staff.staffId });
      });

      pickupActivities.forEach(function(pickup, i = 0) {
        dataPickup.push({ pickupActivityId: pickup.pickupActivityId });
      });

      $(".monitorCheckBoxs")
        .find(":checkbox:checked")
        .each(function() {
          let idStaff = $(this).attr("data-id-monitor");
          dataStaff[i] = { staffId: idStaff };
          i++;
        });

      let data = {
        date: json.date,
        name: json.name,
        start: json.start,
        end: json.end,
        area: json.area,
        location: json.location.locationId,
        sport: json.sport.sportId,
        lunch: json.lunch,
        age: json.age,
        comment: json.comment,
      };

      let url = "group-activity/create";
      let type = "POST";
      $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type, url, data, staff: dataStaff, links: dataPickup },
        dataType: "json",
        beforeSend() {},
        success(json) {
          locationRedirect();
        },
      });
    },
  });
};
