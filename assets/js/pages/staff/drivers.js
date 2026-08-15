$(() => {
    initDragDrop();
});

document.getElementById("loadMoreDriver").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");
        const pageSuivante = page + 1;
        const url = `staff/list/driver?page=${pageSuivante}&size=${size}`;

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

                        $("#driverList").append(
                            `<li data-id-driver="${
                                json[i].driverId
                                }"><a href="javascript:void(0)" onclick="getIdDriver(\`${
                                json[i].driverId
                                }\`);openRevealJS(\`action-driver\`)"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt=""> ${
                                json[i].person.firstname
                                } - ${
                                json[i].person.lastname
                                }<aside class="subtitles"></aside><div class="with-icon"> <i class="material-icons">send</i></div> </p>  </div> </a></li>`
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

$("#modal-full").change(function() {

    if($('#modal-full').is(':checked'))
    {

    }
    else
    {
        var lastIdDriver = $("#lastIdDriver").val();
        editDriver(lastIdDriver);
    }


});

const iframePerson = () =>
{
 $("#modal-full").trigger('click');
 const idPerson = $('[name=person]').val();
  $("#frameFullScreen").attr(
    "src",
    `${urlHost}person/display/id/${idPerson}/iframe/yes/`
  );
}


const editDriver = () => {
    $("#resultZone").html("");
    let idDriver = $("#lastIdDriver").val();
    let url = `staff/display/${idDriver}`;
    $("#driverForm").attr("action", `staff/modify/${idDriver}`);
    $("#listPerson").hide();
    $(".editAdress").removeClass('displayNone');

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

            $("[name=person]").val(json.person.personId);
            if(json.vehicle != null)
            {
                $("[data-id-vehicle=" + json.vehicle.vehicleId + "]").find('.switch').find('input').attr('checked', true);
            }

            if(json.address != null)
            {
                loadAdressesDriver(json.person.personId, json.address.addressId);
            }
            else
            {
               loadAdressesDriver(json.person.personId, ''); 
            }
            

            $("#titleReveal").html(
                `Driver ${json.person.firstname} ${json.person.lastname}`
            );

            const driverZones = json.driverZones;

            const numberOfElements = driverZones.length;

            if (numberOfElements > 0) {
                for (i = 0; i < numberOfElements; i++) {
                    $("#resultZone").append(
                        `<div style="position:relative; width:270px;" data-priority=${
                            driverZones[i].priority
                            } data-postal=${driverZones[i].postal}>Code postal : ${
                            driverZones[i].postal
                            } | Priorité : ${
                            driverZones[i].priority
                            } <a href="javascript:void(0)" onclick="deletePostal(this)" style="top: -1px; right: 0px; position: absolute;"><i class="material-icons">close</i></a> </div>`
                    );
                }
            }
        }
    });
};

const getIdDriver = idDriver => {
    $("#lastIdDriver").val(idDriver);
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
        const dataLinks = [];
        let i = 0;
        $("#resultZone")
            .find("div")
            .each(function() {
                const postal = $(this).attr("data-postal");
                const priority = $(this).attr("data-priority");
                dataLinks[i] = { postal, priority };

                i++;
            });

        if (url.includes("modify")) {
            type = "PUT";
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data, links: dataLinks },
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
    $("#titleReveal").html("Ajouter un driver");
    $(".editAdress").addClass('displayNone');
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
                                `<li id="li${
                                    json[i].personId
                                    }"><a href="javascript:void(0)" onclick="addThisPerson(\`${
                                    json[i].personId
                                    }\`, this)"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${
                                    json[i].firstname
                                    } ${
                                    json[i].lastname
                                    }<div class="with-icon">AJOUTER</div> </p>  </div> </a></li>`
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
    loadAdressesDriver(idPerson, '');
};

const addZone = () => {
    const postal = $("#postal").val();
    const priority = $("#priority").val();

    if (postal != "" && priority != "") {
        $("#resultZone").append(
            `<div style="position:relative; width:270px;" data-priority=${priority} data-postal=${postal}>Code postal : ${postal} | Priorité : ${priority} <a href="javascript:void(0)" onclick="deletePostal(this)" style="top: -1px; right: 0px; position: absolute;"><i class="material-icons">close</i></a> </div>`
        );
    } else { //TODO vérifier le swal >>> plutôt en toast
        swal({
            title: "Attention",
            text: "Le formulaire est incomplet.",
            type: "warning",
            showCancelButton: false
        }).then(result => {});
    }
};

const deletePostal = element => {
    $(element)
        .parent("div")
        .addClass("animated flipOutY")
        .delay(750)
        .remove(0);
};

const initDragDrop = () => {

  $("#driverList")
    .sortable({
      connectWith: "ul",
      scroll: true,
      receive(event, ui) {},
      stop(event, ui) {}
    })
    .disableSelection();

};


document.getElementById("saveOrder").addEventListener(
  "click",
  event => {

   var priority = 0;
   var driverPriority = [];

    $("#driverList")
      .find("li")
      .each(function() {
        priority++;
        const staff = $(this).attr("data-id-driver");

        driverPriority.push({ staff, priority });
      });

    let url = "staff/priority";

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: { type: "PUT", url, data: driverPriority },
      dataType: "json",
      beforeSend() {
        $(".loading").show();
      },
      success(json) {
        $(".loading").hide();
        toastr.success('Ordre sauvegardé');
      }
    });

  },
  false
);

var loadAdressesDriver = (idDriver, idAddress) => {
  let url = `person/display/${idDriver}`;
  $("#resultAdressDriver").html("");

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {
      $("#loaderLoadAdressDriver").show();
    },
    success(json) {
      $("#loaderLoadAdressDriver").hide();

      const numberOfElements = json.addresses.length;

      if (numberOfElements > 0) {
        for (z = 0; z < numberOfElements; z++) {
            if(idAddress != '')
            {
                if(idAddress == json.addresses[z].addressId)
                {
                  $("#resultAdressDriver").append(
                    `<label data-address="${json.addresses[z].address}, ${json.addresses[z].postal}, ${json.addresses[z].town}, ${json.addresses[z].country}"><input type="radio" value="${json.addresses[z].addressId}"  name="address" checked> ${json.addresses[z].name} => ${json.addresses[z].address}, ${json.addresses[z].postal}, ${json.addresses[z].town}, ${json.addresses[z].country}</label>`
                  );                    
                }
                else
                {
                  $("#resultAdressDriver").append(
                    `<label data-address="${json.addresses[z].address}, ${json.addresses[z].postal}, ${json.addresses[z].town}, ${json.addresses[z].country}"><input type="radio" value="${json.addresses[z].addressId}"  name="address"> ${json.addresses[z].name} => ${json.addresses[z].address}, ${json.addresses[z].postal}, ${json.addresses[z].town}, ${json.addresses[z].country}</label>`
                  );                     
                }
            }
            else
            {
              $("#resultAdressDriver").append(
                `<label data-address="${json.addresses[z].address}, ${json.addresses[z].postal}, ${json.addresses[z].town}, ${json.addresses[z].country}"><input type="radio" value="${json.addresses[z].addressId}"  name="address"> ${json.addresses[z].name} => ${json.addresses[z].address}, ${json.addresses[z].postal}, ${json.addresses[z].town}, ${json.addresses[z].country}</label>`
              );                
            }

        }
      } else {
        $("#resultAdressDriver").html("Aucune adresse associée.");
      }
    }
  });
};

$(".block-list label i.arrow").click(function() {
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