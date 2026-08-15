const urlApi = $('#urlApi').val();
let childInGroups = JSON.parse($('#childInGroupsInput').val());
let childPickups  = JSON.parse($('#childPickupInput').val());
let childGroupChildList = JSON.parse($('#childGroupChildListInput').val());
let staffPresences = JSON.parse($('#staffPresences').val());
let currentEditChild = 0;
let currentEditStatus = "";


const openDatePicker = () => {
  $('#datePickerInline').show();
  $("#datePickerInline").datepicker({
    closeText: "Fermer",
    prevText: "Précédent",
    nextText: "Suivant",
    firstDay: 1,
    yearRange: "-2:+5",
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
      jumpToDay(dateText);
    }
  });
};

// apply filter location at loading page
$(document).ready(function() {
    let savedLocationId = sessionStorage.getItem('selectedLocation');
    if (savedLocationId !== null) {
        $('#selectLocationPickup').val(savedLocationId);
        applyLocationFilter(savedLocationId);
    }
});

/*** calendrier **/
function jumpToDay(dateText) {
        currentDate = dateText;
        $('#date').val(dateText);
        $('#datePickerInline').hide();
        let url = `${urlHost}activity/dispatch-activity/date/${dateText}/`;
        locationRedirect(url);
}

$('.jumpToDayButton').click(function(e) {
    let currentDate = $('#date').val();
    let dateText;
    e.preventDefault();
    let direction = $(this).attr('id');
    if(direction == "previousDay") {
      dateText = previousDay(currentDate);
    } else {
      dateText = nextDay(currentDate);
    }
    jumpToDay(dateText);
})

function previousDay(myDate) {
  let newDate = myDate.split('-');
  let newDay = parseInt(newDate[2]) - 1;
  if(newDay < 10) {
    newDay = '0'+newDay;
  }
  return newDate[0]+'-'+newDate[1]+'-'+newDay;
}

function nextDay(myDate) {
  let newDate = myDate.split('-');
  let newDay = parseInt(newDate[2]) + 1;
  if(newDay < 10) {
    newDay = '0'+newDay;
  }
  return newDate[0]+'-'+newDate[1]+'-'+newDay;
}


/*** close panel left menu **/
$(() => {
  moveMenuLeft();
});

var moveMenuLeft = () => {

  var width = $(window).width();
  if(width > 1023)
  {
    let menuLeft = document.getElementsByClassName("menu__left")[0];

    $(menuLeft).animate(
      {
        marginLeft: "-=260px"
      },
      0
    );

    setTimeout(() => {
      $(".container__menu__left").css("width", "40px");
      $(".page__container").css("width", "calc(100% - 100px)");
      $(".closeLeftMenu i").html("arrow_forward");
    }, 0);

  }
};


/*** filter age **/
$(".slider").on("moved.zf.slider", () => {
    $('#hour1').val();
    $('#hour2').val();
});

$('.centerTitle').click(function() {
  $(this).next().toggle();
})




/*** filter location ***/
$('#selectLocationPickup').change(function() {
    let locationIdSelected = $(this).val();
    sessionStorage.setItem('selectedLocation', locationIdSelected);
    applyLocationFilter(locationIdSelected);
});

const applyLocationFilter = (locationIdSelected) => {
    $('.ulGroupItem').each(function(){
        if(locationIdSelected == "0") {
            $(this).show();
        } else {
            let currentLocationId = $(this).attr('data-location');
            if(currentLocationId == locationIdSelected) {
                $(this).show();
            } else {
                $(this).hide();
            }
        }
    })

    $('.lineChild').each(function() {
        if(locationIdSelected == "0") {
            $(this).show();
        } else {
            let currentLocationId = $(this).attr('data-location');

            if(currentLocationId == locationIdSelected) {
                $(this).show();
            } else {
                $(this).hide();
            }
        }
    })
};


/*** open modal with right information **/
const openEditPickup = (childId, childname = "demo", age = "99", status) => {

    currentEditChild = childId;

    // check if this li as style line-through
    let currentLi = $('#li-child-'+childId);
    let style = currentLi.attr('style');

    if(style === undefined) {
        style = "";
    }
    console.log(style);

    // si dans style il y a line-through
    if(style.includes('line-through')) {
        currentEditStatus = "npec";
    } else {
        currentEditStatus = "";
    }

    let html = ""; let checkedValue = "";

    // ouverture Modal
    $('#editModalDiv').show();
    let e = window.event;
    let posY = e.pageY;
    $('#editModalDiv').css({top: posY - 300});

    // hydrate form
    $('#editModalChildName').text(childname);
    $('#editModalChildAge').text(age);

    // afficher sport de l'enfant
    html = "<ul>";
    for(let i = 0; i < childPickups[childId].length; i++) {
        let pickup = childPickups[childId][i];
        html += `<li ${pickup.pickup_id}>${pickup.timePresence} : ${pickup.sport}</li>`;
    }
    html += '</ul>';

    $('#editModalPickup').html(html);

    // afficher les groupes
    html = "<ul id='editModalGroupUl'>"; let timeRef = "";
        $('.groupDataInformation').each(function(e) {

        let groupid      = this.dataset.groupid;
        let sports        = this.dataset.sport;
        let timePresence = this.dataset.time;
        let coachs       = this.dataset.coachs;
        let starttime    = this.dataset.starttime;
        let sportid      = this.dataset.sportid;
        let startTime = timePresence.split(' -  ')[0];

        if(timeRef != startTime) {
            html += `<br/><li style="text-align: center; font-weight: bold">${startTime} heure</li><hr/>`
        }
        timeRef = startTime;

        // checked group
        if(childGroupChildList[groupid][childId]) {
            checkedValue = "checked";
        } else {
            checkedValue = "";
        }


        // line group
        html += `<li>
                    <input type="checkbox" ${checkedValue} onclick='updateGroupChild(${groupid}, ${sportid}, ${childId}, "${escapeHtml(childname)}", ${age})' value="${groupid}" />&nbsp; ${timePresence} ${sports} - ${coachs} 
                </li>`
    })
    html += "</ul>";
    $('#editModalGroupList').html(html);

}

const updateGroupChild = (groupid, sportId, childId, childName, age) => {

    let valid = 0; let pickup_id_target;

    // find pickp exist with sport
    for(let i = 0; i < childPickups[childId].length; i++) {
        let pickup = childPickups[childId][i];
        if( pickup.sport_id == sportId) {
            pickup_id_target = pickup.pickup_id;
            valid = 1;
        }
    }

    if( valid == 0) { // if no good pickup founded
        // update last pickup
        pickup_id_target = childPickups[childId][0].pickup_id;
    }

    // check if add or remove
    if(childGroupChildList[groupid][childId]) { // if exist remove

        // remove from group a child
        let url = urlApi + 'pickup-activity/removeFromGroup/'+groupid+'/'+childId;
        let data = {};
        data = JSON.stringify(data);

        $.ajax({
            url: url,
            type: 'DELETE',
            contentType: "application/json",
            headers: {
                'Authorization':'Bearer ' + tokenAuth
            },
            contentLength: data.length,
            crossDomain: true,
            dataType: "json",
            data,
            beforeSend() {
                $(".loading").show();
            }, success(data) {
                $(".loading").hide();

                if(data.message == "link removed") {
                    toastr.success("Enfant retiré.e du groupe");

                    // remove child in childGroupChildList
                    delete(childGroupChildList[groupid][childId]);

                    // update group name list
                    childInGroups.forEach((child, index) => {
                        if (child.child_id == childId) {
                            child.count--;
                            if (child.count <= 0) {
                                child.count = 0;

                                // update name color
                                let currentLi = $('#li-child-'+childId);
                                currentLi.css('color', '');

                            }
                        }
                    });
                }
            }

        });

    } else { // if no exist add
        
        // update in bdd
        let url = urlApi + 'pickup-activity/addTogroup/'+pickup_id_target+'/'+groupid;
        let data = {};
        data = JSON.stringify(data);

        $.ajax({
            url: url,
            type: 'GET',
            contentType: "application/json",
            headers: {
                'Authorization':'Bearer ' + tokenAuth
            },
            contentLength: data.length,
            crossDomain: true,
            dataType: "json",
            data,
            beforeSend() {
                $(".loading").show();
            }, success(data) {
                $(".loading").hide();

                toastr.success("Activité ajoutée au groupe");

                // add child in childGroupChildList
                childGroupChildList[groupid][childId] = childId;

                // update group name list
                let htmlLi = "";
                htmlLi = `<li onclick='openEditPickup(${childId}, "${escapeHtml(childName)}", ${age})' class="li-child" id="li-child-${childId}">${childName}</li>`;
                $('#ulGroupItem-'+groupid).append(htmlLi);

                // add on in array childInGroups
                let childFound = false;
                childInGroups.forEach(child => {
                    if (child.child_id == childId) {
                        child.count++;
                        childFound = true;
                    }
                });

                // if not found create new
                if (!childFound) {
                    childInGroups.push({child_id: childId, count: 1});
                }

                // update name color
                let currentLi = $('#li-child-'+childId);
                currentLi.css('color', 'darkblue');

            }, error(data) {
                console.log("error");
                console.log(data);
            }
        });

    }

    calculMaxChild(groupid);

}


/** on group affected **/
// reaffected each pickupactivity on the same sport

$('#closeEditModalDiv').click(function() {
    $('#editModalDiv').hide();
})

$('#closeEditModalGroupDiv').click(function() {
    $('#editModalGroupDiv').hide();
})

$('#closeEditModalGroupDiv2').click(function() {
    $('#editModalGroupDiv').hide();
})


/*** load at loading page */
// change color li name child at init page
childInGroups.forEach(child => {
    if (child.count > 0) {
        $('#li-child-' + child.child_id).css('color', 'darkblue');
    } else {
        $('#li-child-' + child.child_id).css('color', '');
    }
});




const calculMaxChild = (groupId) => {

    const coachIdsList = $('#ulGroupItem-'+groupId).find('.groupDataInformation').attr('data-coachsidlist');

    let maxChild = 0;

    // Use staffPresences coachIds to get the staff maxChild capacity
    if (typeof coachIdsList === 'string' && coachIdsList.trim() !== '') {
        // Split the string into an array of coach IDs
        const coachIds = coachIdsList.split(',').map(id => id.trim());

        // Calculate the total maxChild capacity for the given coach IDs
        maxChild = coachIds.reduce((acc, coachId) => {
            const staff = staffPresences.COACH.find(staff => staff.id === parseInt(coachId, 10));
            return staff ? acc + staff.maxChild : acc;
        }, 0);
    }

    let childLi = $('#ulGroupItem-'+groupId).find('.li-child');
    let mycount = 0;
    for(let i = 0; i < childLi.length; i++) {
        let li = childLi[i];

        let style = window.getComputedStyle(li);

        if (!style.textDecoration.includes('line-through')) {
            mycount++;
        }
    }


    let html = `${mycount} / ${maxChild}`;
    $('#maxChildren-'+groupId).text(html);
}

// count capacity child by group
let allGroupItems = $('.ulGroupItem');
allGroupItems.each(function() {
    // Retrieve the .groupDataInformation inside and get the data-coachsidlist
    const groupId = $(this).find('.groupDataInformation').attr('data-groupid');
    calculMaxChild(groupId);
});



/** mass affected **/
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
          //  locationRedirect();
        },
    });
};


/** mass unaffected **/
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
// resert group fonrm
const resetGroupForm = () => {
    $('#editGroupId').val('');
    $('#editNameGroup').val('');
    $('#editStartGroup').val('');
    $('#editEndGroup').val('');
    $('#editLocationGroup').val('');
    $('#editSportGroup').val('');
    $('.editCoachName').prop('checked', false);
}

const deleteAll = () => {

    let date = $("#date").val();

    let currentUrl = `group-activity/delete-all/${date}`;


    // remove from group a child
    let url = urlApi + currentUrl;
    let data = {};
    data = JSON.stringify(data);

    $.ajax({
        url: url,
        type: 'DELETE',
        contentType: "application/json",
        headers: {
            'Authorization':'Bearer ' + tokenAuth
        },
        contentLength: data.length,
        crossDomain: true,
        dataType: "json",
        data,
        beforeSend() {
            $(".loading").show();
        }, success(data) {
            $(".loading").hide();
            locationRedirect();
        }
    });

}

/*** create group activity ***/
const createGroupActivity = () => {
    openEditModalGroupDiv();
}

const openEditModalGroupDiv = () => {
    $('#editModalGroupDiv').show();
    let e = window.event;
    let posY = e.pageY;
    $('#editModalGroupDiv').css({top: posY - 300});
}

$('#editLocationGroup').change(function() {
    let locationTextSelected = $('#editLocationGroup option:selected').text();
    filterCoachByLocation(locationTextSelected)
});

const filterCoachByLocation = (location) => {

    $('label[data-locationcoach]').each(function() {
        let coachLocation = $(this).data('locationcoach');
        if (coachLocation === location) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}


// open group activity - modal_edit_group
const openEditGroup = (element) => {

    let groupid = $(element).attr('data-groupid');
    let timePresence = $(element).attr('data-time');
    let start = timePresence.split(' - ')[0];
    let end   = timePresence.split(' - ')[1];
    let locationId = $(element).attr('data-locationId');
    let sportId = $(element).attr('data-sportid');
    let groupName = $(element).attr('data-groupName');
    let lunch = $(element).attr('data-lunch');

    // reset form
    resetGroupForm();

    // hydrate form
    $('#editNameGroup').val(groupName);
    $('#editStartGroup').val(start);
    $('#editEndGroup').val(end);
    $('#editLocationGroup').val(locationId);
    $('#editSportGroup').val(sportId);
    $('#editGroupId').val(groupid);

    if(lunch == 1) {
        $('#editLunchGroup').prop('checked', true);
    }

    let coachIdList = $(element).attr('data-coachsIdList').split(',');
    $('.editCoachName').each(function() {
        if (coachIdList.includes($(this).val())) {
            $(this).prop('checked', true);
        }
    });

    // ouverture Modal
    openEditModalGroupDiv()
    calculMaxChild(groupid);
}

$('#saveGroupButton').on('click', function(event) {
    event.preventDefault();
    saveGroupActivity();
});

// save group activity
const saveGroupActivity = () => {

    let groupId = $('#editGroupId').val();

    let data = {
        date : $('#date').val(),
        start : $('#editStartGroup').val()+':00',
        end : $('#editEndGroup').val()+':00',
        location : $('#editLocationGroup').val(),
        area : '0',
        comment : '',
        lunch : $('#editLunchGroup').is(':checked') ? 1 : 0,
        sport : $('#editSportGroup').val(),
        name :  $('#editNameGroup').val(),
    }

    // create dataStaff from checkbox
    let dataStaff = [];
    $(".editCoachName:checked").each(function(index) {
        let idStaff = $(this).val();
        dataStaff[index] = { staffId: idStaff };
    });

    let url, type;
    if(groupId) {
        url = `group-activity/modify/${groupId}`
        type = "PUT";
    } else {
        url = "group-activity/create";
        type = "POST";
    }

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type, url, data, staff: dataStaff },
        dataType: "json",
        beforeSend() {
        },
        success(json) {
            $('#editModalGroupDiv').hide();
            if(groupId) {
                toastr.success("Groupe mis à jour", "Confirmation");
                updateGroupHead(json.groupActivity);
            } else {
                toastr.success("Nouveau groupe ajouté", "Confirmation");
                addNewGroup(json.groupActivity);
            }
            resetGroupForm();
        },
    });
}

const addNewGroup = (groupActivity) => {
    const startHour = groupActivity.start.split(':')[0];

    // Trouver le conteneur de l'heure correspondante
    let ulGroupMoment = $('.ulGroupMoment[data-hour="' + startHour + '"]');
    if (ulGroupMoment.length === 0) {
        const timeLine = $('<div>').addClass('timeLine');
        timeLine.append($('<h2>').text(`${startHour} heures`));
        $('#ulGroups').append(timeLine);

        ulGroupMoment = $('<div>').addClass('ulGroupMoment').attr('data-hour', startHour).css('background-color', '#FFECB3');
        timeLine.append(ulGroupMoment);
    }
    const ulGroupItem = $('<ul>').addClass('ulGroupItem').attr('data-location', groupActivity.location_id).attr('id', 'ulGroupItem-' + groupActivity.group_activity_id);

    const groupData = $('<div>').addClass('groupDataInformation').on('click', function() {
        openEditGroup(this);
    }).attr({
        'data-groupid': groupActivity.group_activity_id,
        'data-time': groupActivity.start + ' - ' + groupActivity.end,
        'data-sport': groupActivity.sport.name,
        'data-sportid': groupActivity.sport.id,
        'data-coachsIdList': groupActivity.staff.map(staff => staff.staffId).join(','),
        'data-locationId': groupActivity.location.id,
        'data-groupName': groupActivity.name,
        'style': 'cursor: pointer'
    });

    const groupInfo = `
        <b>${groupActivity.name}</b><br/>        
        ${groupActivity.staff.map(staff => staff.person.firstname).join(", ")}<br/>
        ${groupActivity.start + ' - ' + groupActivity.end} - ${groupActivity.sport.name}<br/>
        <i style="font-weight: bold; font-variant-caps: small-caps;">${groupActivity.location.name}</i>
    `;

    groupData.html(groupInfo);
    ulGroupItem.append(groupData);
    ulGroupMoment.append(ulGroupItem);
};

$('#deleteGroupButton').on('click', function(event) {
    event.preventDefault();
    swal({
        title: "Attention",
        text: "La suppression est irréversible.",
        type: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            doDeleteGroup();
            $('#editModalGroupDiv').hide();
        }
    });
});

let doDeleteGroup = () => {

    let idGroup = $('#editGroupId').val();

    let url = `group-activity/delete/${idGroup}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {},
        success(json) {
            if (json.status == true) {
                toastr.success("Groupe supprimé", "Suppression");
                $('#ulGroupItem-'+idGroup).hide();
            } else {
                swal({
                    title: "Suppression",
                    text: "Une erreur est survenue.",
                    type: "warning",
                });
            }
        },
    });

    resetGroupForm();
};


const updateGroupHead = (groupActivity) => {

    let groupDiv = $("#ulGroupItem-" + groupActivity.groupActivityId);
    let start = groupActivity.start.split(':')[0] + ':' + groupActivity.start.split(':')[1];
    let end = groupActivity.end.split(':')[0] + ':' + groupActivity.end.split(':')[1];

    let allStaffId = "";
    groupActivity.staff.forEach(staff => {
        allStaffId += staff.staffId + ',';
    });

    let coachesNames = groupActivity.staff.map(staff => staff.person.firstname).join(", ");
    let locationName = groupActivity.location.name;

    // Update data attributes
    groupDiv.find('.groupDataInformation')
        .attr('data-time', start + ' - ' + end)
        .attr('data-sport', groupActivity.sport.name)
        .attr('data-sportId', groupActivity.sport.sportId)
        .attr('data-locationId', groupActivity.location.locationId)
        .attr('data-groupName', groupActivity.name)
        .attr('data-coachsIdList', allStaffId.trimEnd(','));

    // Create the new content HTML
    let newContentHTML = `
        <!-- name -->
        ${groupActivity.name ? `<b>${groupActivity.name}</b><br/>` : ''}
        <!-- coachs -->
        ${coachesNames}<br/>
        <!-- heure start/end -->
        ${start} - ${end}<br/>
        <!-- sport -->
        ${groupActivity.sport.name}<br/>
        <i style="font-weight: bold; font-variant-caps: small-caps;">
            ${locationName}
        </i>
    `;

    // Update the inner HTML of the groupDiv
    groupDiv.find('.groupDataInformation').html(newContentHTML);
}

// absence
const changeStatus = () => {

    let status = null;
    if(currentEditStatus == "npec") {
        status = "";
    } else {
        status = "npec";
    }

    for(let i = 0; i < childPickups[currentEditChild].length; i++) {
        let pickup = childPickups[currentEditChild][i];
        let idPickupCascade = pickup.pickup_id;

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

            },
        });

    }

    // retrieve child id li li-child-<?= $pickup->child_id ;?>
    let currentLi = $('#li-child-'+currentEditChild);

    if(status === "npec") {
        // add new style on currentLi
        currentLi.css('font-style', 'italic');
        currentLi.css('font-size', '12px');
        currentLi.css('text-decoration', 'line-through');
    } else {
        // remove style on currentLi
        currentLi.css('font-style', '');
        currentLi.css('font-size', '');
        currentLi.css('text-decoration', '');
    }
    $('#editModalDiv').hide();

};

// copy moment
const copyMoment = (groupName) => {

    let hour  = $('#selectHour-'+groupName).val();
    let min   = $('#selectMinute-'+groupName).val();
    let lunch = $('#isLunch-'+groupName+':checked').val();
    let groupsId = [];

    if(lunch != 1) {
        lunch = 0;
    }

    $('.'+groupName).each(function() {
        groupsId.push($(this).data('groupid'))
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
            $(".loading").hide();
            locationRedirect();
        },
    });
}

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, " ");
}


