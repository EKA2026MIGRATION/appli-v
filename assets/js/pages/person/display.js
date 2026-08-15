var personId;
$(() => {
    let autocomplete;
    let geocoder;
    const input = document.getElementById("autocomplete");
      const options = {
        componentRestrictions: { country: "fr" }
      };


    autocomplete = new google.maps.places.Autocomplete(input, options);

    google.maps.event.addListener(autocomplete, "place_changed", () => {
        const place = autocomplete.getPlace();
        for (let i = 0; i < place.address_components.length; i++) {
            for (let j = 0; j < place.address_components[i].types.length; j++) {
                if (place.address_components[i].types[j] == "postal_code") {


                }
            }
        }



    });
});

document
    .getElementById("deletePerson")
    .addEventListener("click", function(event) {
        const idPerson = $(this).attr("data-id-person");

        swal({
            title: "Attention",
            text: "La suppression est irréversible.",
            type: "warning",
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler",
            showCancelButton: true
        }).then(result => {
            if (result.value) {
                deletePerson(idPerson);
            }
        });
    });


var deletePerson = idPerson => {
    let url = `person/delete/${idPerson}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
            $("#deletePerson")
                .attr("disabled", true)
                .html("Suppression en cours..");
        },
        success(json) {
            if (json.status == true) {
                swal({
                    title: "Suppression",
                    text: json.message,
                    type: "success",
                    confirmButtonText: "Retour à la liste",
                    showCancelButton: false
                }).then(result => {
                    if (result.value) {
                        location.href = `${urlHost}person/list`;
                    }
                });
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

const editPhone = idPhone => {
    let url = `phone/display/${idPhone}`;
    $("#phoneForm").attr("action", `phone/modify/${idPhone}`);

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "GET", url },
        dataType: "json",
        beforeSend() {
            $("#loaderFormEditPhone").show();
        },
        success(json) {
            $("#loaderFormEditPhone").hide();

            $("#phoneForm")
                .find("input")
                .each(function() {
                    const name = $(this).attr("name");
                    $(this).val(json[name]);
                });
        }
    });
};

const editAddress = idAddress => {
    let url = `address/display/${idAddress}`;
    $("#adresseForm").attr("action", `address/modify/${idAddress}`);

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "GET", url },
        dataType: "json",
        beforeSend() {
            $("#loaderFormEditAddress").show();
        },
        success(json) {
            $("#loaderFormEditAddress").hide();

            $("#adresseForm")
                .find("input")
                .each(function() {
                    const name = $(this).attr("name");
                    $(this).val(json[name]);
                });
        }
    });
};

const deletePhone = idPhone => {
    swal({
        title: "Attention",
        text: "La suppression est irréversible.",
        type: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showCancelButton: true
    }).then(result => {
        if (result.value) {
            deletePhoneSubmit(idPhone);
        }
    });
};

const deleteAddress = idAddress => {
    swal({
        title: "Attention",
        text: "La suppression est irréversible.",
        type: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showCancelButton: true
    }).then(result => {
        if (result.value) {
            deleteAddressSubmit(idAddress);
        }
    });
};

var deletePhoneSubmit = idPhone => {
    let url = `phone/delete/${idPhone}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
            $("#deleteAddress").attr("disabled", true);
        },
        success(json) {
            if (json.status == true) {

                toastr.success(json.message, 'Suppression');

                $(`#blockPhone${idPhone}`)
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

var deleteAddressSubmit = idAddress => {
    let url = `address/delete/${idAddress}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
            $("#deleteAddress").attr("disabled", true);
        },
        success(json) {
            if (json.status == true) {

            toastr.success(json.message, 'Suppression');

            $(`#blockAdress${idAddress}`)
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

document.getElementById("adresseForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#adresseForm");
        let url = form.attr("action");
        let idPerson = $("#idPersonInput").val();
        let persons = { personId: idPerson };
        let type = "POST";
        let data = $(form).serializeToJSON();

        if (url.includes("modify")) {
            type = "PUT";
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data, links: persons },
            dataType: "json",
            beforeSend() {
                $("#adresseForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#adresseForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {
                    $("#revealAddress").foundation("close");
                    toastr.success(json.message, 'confirmation');

                            const newBlockAdress =
                                `<div class="card-img-container">
                                        <figure>
                                            <i class="material-icons">location_on</i>
                                        </figure>
                                    </div>
                                    <div class="card-info">
                                        <div class="card-primary">
                                            <figure>
                                                <p class="card-title">${json.address.name}</p>
                                                ${json.address.address}
                                                <?= ( null != ${json.address.address2})? ${json.address.address2}: ''; ?>
                                                <br/> ${json.address.postal} - ${json.address.town}
                                            </figure>
                                        </div>

                                        <div class="card-secondary">
                                            <a href="javascript:void(0)" onclick="openRevealJS('revealAddress');editAddress('${json.address.addressId}')" ><span><i class="material-icons">mode_edit</i></span> Modifier</a>
                                            <a href="javascript:void(0)" onclick="deleteAddress('${json.address.addressId}')"  ><span><i class="material-icons">delete</i></span> Supprimer</a>
                                        </div>
                                    </div>`;
                    if (url.includes("modify")){
                        $(`#blockAdress${json.address.addressId}`).html(newBlockAdress);
                    } else {
                        $(".person_adresses").append(
                            `<div class="card-wrap horizontal"  id="blockAdress${json.address.addressId}">
                                    ${newBlockAdress}
                                </div>`);
                    }

                } else {
                    $("#revealAddress").foundation("close");
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

document.getElementById("phoneForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#phoneForm");
        let url = form.attr("action");
        let idPerson = $("#idPersonInput").val();
        let persons = { personId: idPerson };
        let type = "POST";
        let data = $(form).serializeToJSON();

        if (url.includes("modify")) {
            type = "PUT";
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data, links: persons },
            dataType: "json",
            beforeSend() {
                $("#phoneForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#phoneForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {
                    $("#revealPhone").foundation("close");
                    toastr.success(json.message, 'Confirmation');

                            const newBlockPhone =
                                `
                                        <div class="card-img-container">
                                            <figure>
                                                <i class="material-icons">phone</i>
                                            </figure>
                                        </div>

                                        <div class="card-info">
                                            <div class="card-primary">
                                                <figure>
                                                    <p class="card-title">${json.phone.name}</p>
                                                    <p>${json.phone.phone} </p>
                                                </figure>
                                            </div>

                                            <div class="card-secondary">
                                                <a href="javascript:void(0)" onclick="openRevealJS('revealPhone');editPhone('${json.phone.phoneId}')"><span><i class="material-icons">mode_edit</i></span> Modifier</a>
                                                <a href="javascript:void(0)" onclick="deletePhone('${json.phone.phoneId}')"><span><i class="material-icons">delete</i></span> Supprimer</a>
                                            </div>
                                        </div>
                                    `;
                    if (url.includes("modify")){
                        $(`#blockPhone${json.phone.phoneId}`).html(newBlockPhone);
                    } else {
                        $("#person_phone").append(
                            `<div class="card-wrap horizontal" id="blockPhone${json.phone.phoneId}">
                                ${newBlockPhone}
                            </div>`);
                    }
                } else {
                    $("#revealPhone").foundation("close");
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

const changeActionAdress = () => {
    $("#adresseForm").attr("action", "address/create");
    $('#adresseForm')[0].reset();
};

const changeActionPhone = () => {
    $("#phoneForm").attr("action", "phone/create");
    $('#phoneForm')[0].reset();
};


function associateChild(currentPersonId){
  personId = currentPersonId;
};



var getPresence = staffId => {
    const date = new Date();
    const year = date.getFullYear();
    let url = `staff/presence/display/${staffId}/${year}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: {type: "GET", url},
        dataType: "json",

        success(json) {
            if (json.length > 0){
                for (var i=0; i < json.length; i++){
                    const dayDate = json[i].date;
                    const date = new Date(dayDate);
                    const formattedDate = ((date.getDate()).toString().length > 1 ? date.getDate()  : '0'+ (date.getDate()) )+'/'+ ((date.getMonth()) > 8 ? date.getMonth() + 1 : '0'+ (date.getMonth() + 1 ) ) + '/' + date.getFullYear()  ;
                    $("#displayPresences").append(
                        `<li>
                            <p class="list-header">
                                ${formattedDate}
                            </p>
                        </li>`);
                    i++;
                };
            } else {
                $("#displayPresences").append(
                    `<li>
                            <p class="list-header">
                                Aucune présence enregistrée
                            </p>
                        </li>`);
            }
        }
    });
}

function associatedChildToPerson(childId, currentPersonId) {
  console.log(childId+' '+currentPersonId);

  let url = urlHost+"person/associateChild/personId/"+personId+"/childId/"+childId+"/";

  $('#showMessagePerson').load(url);
  $("#revealSearchAssociatedChild").foundation("close");

  console.log(url);


  return false;
}


document.getElementById("searchListChild").addEventListener(
    "keyup",
    function(event) {
        let searchTerm = $(this).val();
        let url = `child/search/${searchTerm}?size=100&page=1`;
        $("#childList").html("");
        $("#pageSearch").val(1);
        $("#loadMoreListChild").attr("disabled", false);


        if(searchTerm.length > 2) {

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

                                      if (json[i].photo != null) {
                                          photo = urlHost + json[i].photo;
                                      }

                                      $("#childList").append(
                                          `<li><a onclick="associatedChildToPerson(${json[i].childId}, ${personId})"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${
                                              json[i].firstname
                                              } ${
                                              json[i].lastname
                                              }<div class="with-icon"> <i class="material-icons">send</i></div> </p>  </div> </a></li>`
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
