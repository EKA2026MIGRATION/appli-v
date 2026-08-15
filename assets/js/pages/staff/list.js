let isAdmin = $('#isAdmin').val();


$('#selectKind').change(function() {
    let kind = $(this).val();
    let url = urlHost+'staff/list/kind/'+kind+'/';
    window.location.href = url;
})

document.getElementById("loadMoreDriver").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");
        const pageSuivante = page + 1;
        const url = `staff/list?page=${pageSuivante}&size=${size}`;

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
                        let photo = noPhoto;

                        if (json[i].person.photo != null) {
                            photo = urlHost + json[i].person.photo;
                        }

                        let kind = json[i].kind;
                        if (json[i].kind === 'trainee') {
                            kind = 'stagiaire';
                        }

                        let maxChildren = json[i].maxChildren;
                        if (json[i].maxChildren == null) {
                            maxChildren = 'nc';
                        }

                        $("#driverList").append(
                            `<li data-id-driver="${json[i].driverId}">
                                <a href="javascript:void(0)" onclick="getIdDriver(\`${json[i].driverId}\`);openRevealJS(\`action-driver\`)">
                                    <div>
                                        <p class="list-header">
                                            <img src="${photo}" class="width-30 height-30" height="" width="" alt="">
                                            ${json[i].person.firstname} - ${json[i].person.lastname} ${kind} - Nb max d'enfants: ${maxChildren}
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon"> <i class="material-icons">edit</i></div>
                                        </p>
                                    </div>
                                </a>
                            </li>`
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


// update role by user

$('.updateRoleSelect').change(function() {
    let myIdentifier = $(this).attr('id').split('-')[2];
    let role_value = $(this).val();
    let staffId = $(this).attr('id').split('-')[3];
    let data = '';

    let url = $("#urlApi").val() + 'user/api/add-role/' + myIdentifier + "/"+role_value;

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
            let roleLine = '<span title="Click to delete" class="roleStaffUserToDelete" onclick="deleteRole(this)" id="roleStaffUserToDelete-'+myIdentifier+'-'+role_value+'-'+staffId+'">';
            roleLine += role_value;
            roleLine += '</span>';
            $('#listRoleUser-'+myIdentifier).append(roleLine);
            $(".updateRoleSelect").val('');
            $(".updateRoleSelect option[value=" + role_value + "]").attr('disabled', 'disabled');

            console.log(role_value);

            if(role_value == "ROLE_DRIVER") {
                console.log('update');
                updateStaffKind(staffId, "driver");
            }




        }, error(data) {
            console.log("error");
            console.log(url);
        }
    });

})

const updateStaffKind = (staffId, kind) => {

    let url = `staff/modify/${staffId}/`;
    let data = {'kind' : kind};
    let type = "PUT";

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type, data },
        dataType: "json",
        beforeSend() {
        },
        success(json) {
           console.log(json)
        }


    });

}

const deleteRole = el =>
{
    deleteRoleRun(el);
}


const deleteRoleRun = el =>
{
    let myIdentifier = $(el).attr('id').split('-')[1];
    let role_value = $(el).attr('id').split('-')[2];
    let staffId = $(el).attr('id').split('-')[3];


    let data = '';

    let url = $("#urlApi").val() + 'user/api/delete-role/' + myIdentifier + "/"+role_value;

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
            $('#roleStaffUserToDelete-'+myIdentifier+'-'+role_value+'-'+staffId).remove();
            $("#selectRole-id-" + myIdentifier + " option[value=" + role_value + "]").removeAttr('disabled');

             if(role_value == "ROLE_DRIVER") {
                updateStaffKind(staffId, "coach");
            }


        }, error(data) {
            console.log("error");
            console.log(url);
        }
    });
}

// delete role by user
$('.roleStaffUserToDelete').click(function() {
    deleteRoleRun(this);
})

$('.criteriaCheckboxStaff').click(function() {
    let criteriaId = $(this).attr('data-id');
    let staffId = $('#lastIdDriver').val();
     let checked;
    if( $(this).is(":checked") ) {
        checked = "checked";
    }  else {
        checked = "unchecked";
    }

    let data = '';

    let url = $("#urlApi").val() + 'credential/updateStaff/' + staffId + '/'+criteriaId+'/'+checked;

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
              toastr.success("Droit mis à jour");
        }, success(data) {
           console.log(data);
        }, error(data) {
            console.log("error");
        }
    });


})

// autocomplete addUserEmail

$('.addUserEmail').keyup(function(){
    let search = $(this).val();

    let staffId = $(this).attr('id').split('-')[1];

    if(search.length > 3) {
        let data = '';
        let url = $("#urlApi").val() + 'staff/nostaff/' + search;
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

            }, success(data) {
                let personList = "<ul>";
                personList = "<div style='text-align: right; color: red; cursor: pointer' id='closeModalShowList'>x</div>";
                for (i = 0; i < data.length; i++) {
                    let person = data[i].email+' : '+data[i].person.firstname+' '+data[i].person.lastname;
                    personList += "<li style='cursor: pointer'>"+person+"</li>";
                }
                personList += "<ul>";
                personList += "<script>$('#closeModalShowList').click(function(){ $('#showUserList-"+staffId+"').empty(); $('#showUserList-"+staffId+"').hide()})</script>"
                $('#showUserList-'+staffId).show();
                $('#showUserList-'+staffId).html(personList);

            }, error(data) {
                console.log("error");
            }
        });
    }
})

const editDriver = (idDriver) => {

    $("#lastIdDriver").val(idDriver);

    $("#resultZone").html("");
    let url = `staff/display/${idDriver}`;
    $("#driverForm").attr("action", `staff/modify/${idDriver}`);
    $("#listPerson").hide();

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "GET", url },
        dataType: "json",
        beforeSend() {
            $("#loaderFormEditDriver").show();
        },
        success(json) {
            $("#loaderFormEditDriver").hide();

            let content = '<button class="button small" style="margin-right: 10px;"><a style="color: white; font-weight; bold; font-size: 12px" href="'+urlHost+'person/display/id/'+json.person.personId+'/">Profil détaillé</a></button>';
            content += '<button class="button small" style="margin-right: 10px;"><a style="color: white; font-weight; bold; font-size: 12px" href="'+urlHost+'staff/resume/id/'+idDriver+'/">Résumé activité</a></button>';

            $('#linkToPersonPage').html(content);


            $("[name=person]").val(json.person.personId);
            $("[name=kind]").val(json.kind);
            $("[name=maxChildren]").val(json.maxChildren);

            $("#titleReveal").html(
                ` ${json.person.firstname} ${json.person.lastname}`
            );

            // show Credentials

            $('#editStaffCredentials').show();

            url = `credential/user/${json.person.myIdentifier}`;

            url = $("#urlApi").val() + url.trim();

            let data = '';


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

                }, success(data) {
                    for(let i = 0; i<data.length; i++) {
                        let target = "criteria-"+data[i].name.replace('::', '-');
                        if(data[i].role != null) {
                            document.getElementById(target).disabled = true;
                        }
                        $("#"+target).prop('checked', true);
                    }

                }, error(data) {
                    console.log("error");
                    console.log(url);
                }





            });

        }
    });

   


};


const deleteDriver = () => {
    let idDriver = $("#lastIdDriver").val();

    swal({
        title: "Attention",
        text: "La suppression est irréversible.",
        type: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showCancelButton: true
    }).then(result => {
        if (result.value) {
            deleteDriverSubmit(idDriver);
        }
    });
};

var deleteDriverSubmit = idDriver => {
    let url = `staff/delete/${idDriver}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {},
        success(json) {
            if (json.status == true) {
                toastr.success(json.message, 'Suppression');
                $(`[data-id-driver=${idDriver}]`)
                        .addClass("animated bounceOutUp")
                        .delay(750)
                        .hide(0);
            } else {
                swal({
                    title: "Suppression",
                    text: "Une erreur est survenue.",
                    type: "warning"
                });
            }
        }
    });
};

document.getElementById("driverForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#driverForm");
        let url = form.attr("action");
        let type = "POST";
        let data = $(form).serializeToJSON();

        if (url.includes("modify")) {
            type = "PUT";
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data },
            dataType: "json",
            beforeSend() {
                $("#driverForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#driverForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {
                    $("#createDriver").foundation("close");

                    toastr.success(json.message, 'Confirmation');
                    locationRedirect();

                } else {
                    $("#createDriver").foundation("close");
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


const changerActionDriver = () => {
    $("#driverForm").attr("action", "staff/create");
    $("#driverForm").trigger("reset");
    $("#listPerson").show();
    $("#resultZone").html("");
    $("#titleReveal").html("Ajouter une personne au Staff");
    $(".editAdress").addClass('displayNone');
    $('#editStaffCredentials').hide();
};

document.getElementById("loadMoreListPerson").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");
        const idPersons = returnIdPersons();

        if ($("#searchListPerson").val() != "") {
            const searchTerm = $("#searchListPerson").val();
            var pageSuivante = parseInt($("#pageSearch").val()) + 1;
            var url = `person/search/${searchTerm}?size=${size}&page=${pageSuivante}`;
            $("#pageSearch").val(pageSuivante);
        } else {
            var pageSuivante = page + 1;
            var url = `person/list?page=${pageSuivante}&size=${size}`;
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

                        if(!idPersons.includes(json[i].personId))
                        {

                            let photo = photoProfilDefault;

                            if (json.photo != null) {
                                photo = json.photo;
                            }

                            $("#personList").append(
                                `<li id="li${json[i].personId}">
                                    <a href="javascript:void(0)" onclick="addThisPerson(\`${json[i].personId}\`, this)">
                                        <div>
                                            <p class="list-header">
                                                <img src="${photo}" class="width-30 height-30" height="" width="" alt="">
                                                ${json[i].firstname} ${json[i].lastname}
                                                <div class="with-icon">AJOUTER</div>
                                            </p>
                                        </div>
                                    </a>
                                </li>`
                            );

                        }
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


$('.checkboxIsActive').click(function() {
    let staffId = $(this).attr('id').split('-')[1];

    let isActive;

    if($(this).is(':checked')) {
        isActive = 1;
    } else {
        isActive = 0
    }

    let url = `staff/update-is-active/${staffId}/`;
    let data = {'isActive' : isActive};
    let type = "PUT";


    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type, data },
        dataType: "json",
        beforeSend() {
            $(".loading").show();
        },
        success(json) {
            let status;
            if(json.staff.isActive == 1) {
                status = "activé";
                $('#li-driver-'+json.staff.staffId).css('background-color', 'white');
            } else {
                status = "désactivé";
                $('#li-driver-'+json.staff.staffId).css('background-color', 'lightgrey');
            }
            toastr.success("Le compte de "+json.staff.fullname+" a été "+status, 'Confirmation');
            $(".loading").hide();
            console.log(json);
        }


    });

    

})

const returnIdPersons = () =>
{
    const idPersons = [];
    var i = 0;

    $("#driverList")
    .find("li")
    .each(function() {

        idPersons[i] = $(this).attr('data-id-person');

        i++;
    });

    return idPersons;

}


document.getElementById("searchListPerson").addEventListener(
    "keyup",
    function(event) {
        $("#loadMoreListPerson").show();

        let searchTerm = $(this).val();
        let size = $("#loadMoreListPerson").attr("data-size");
        let url = `person/search/${searchTerm}?size=${size}&page=1`;
        $("#personList").html("");
        $("#pageSearch").val(1);
        $("#loadMoreListPerson").attr("disabled", false);
        const idPersons = returnIdPersons();



        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type: "GET" },
            dataType: "json",
            beforeSend() {
                $("#personList").html(showLoader);
            },
            success(json) {
                const numberOfElements = json.length;

                if (numberOfElements > 0) {
                    $("#personList").html("");

                    for (i = 0; i < numberOfElements; i++) {

                        if(!idPersons.includes(json[i].personId))
                        {

                            let photo = photoProfilDefault;

                            if (json.photo != null) {
                                photo = json.photo;
                            }


                            $("#personList").append(
                                `<li id="li${
                                    json[i].personId
                                    }"><a href="javascript:void(0)" onclick="addThisPerson(\`${
                                    json[i].personId
                                    }\`, this)"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${
                                    json[i].firstname
                                    } ${
                                    json[i].lastname
                                    }<div class="with-icon"> AJOUTER</div> </p>  </div> </a></li>`
                            );

                        }
                    }
                } else {
                    $("#personList").html(
                        "<p><strong><center>Aucun résultat.</center></strong></p>"
                    );
                }
            }
        });
    },
    false
);

const addThisPerson = (idPerson, data) => {
    const li = $(data).parent("li");
    $(li).css("background-color", "#dcedc8");
    const idLi = $(li).attr("id");
    $(`#personList li:not(#${idLi})`).hide();
    $("[name=person]").val(idPerson);
    $("#loadMoreListPerson").hide();

};



//editDriver(168);
//openRevealJS('createDriver');