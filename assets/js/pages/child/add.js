dropContainer.ondragover = dropContainer.ondragenter = evt => {
    evt.preventDefault();
};

dropContainer.ondrop = evt => {
    fileInput.files = evt.dataTransfer.files;
    evt.preventDefault();
};




const previewOnDiv = () => {
    const file = document.querySelector("#fileInput").files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
        const image = document.getElementById("photoRender");
        const strImage = reader.result.replace(/^data:image\/[a-z]+;base64,/, "");
        image.src = `data:image/jpeg;base64,${strImage}`;

        $(".rotate").fadeOut();
        $("#photoRender").fadeIn();


        getOrientation(file, function(orientation) {

            if(orientation > 2)
            {
                resetOrientation(image.src, 5, function(resetBase64Image) {
                    image.src = resetBase64Image;
                });
            }



        });


        const imageCompressor = new ImageCompressor();

        const compressorSettings = {
            toWidth: 400,
            toHeight: 400,
            mimeType: "image/png",
            mode: "strict",
            quality: 0.6,
            speed: "low"
        };

        imageCompressor.run(image.src, compressorSettings, proceedCompressedImage);

    };
};


function rotatePhoto(urlOfImage) {
    $.ajax({
        type: "POST",
        url: '/rotatePhoto',
        data: { urlOfImage },
        dataType: "json",
        beforeSend() {
            $(".loading").show();
        },
        success(json) {
            location.reload(true);
            $(".loading").hide();
        }
    });
}

function proceedCompressedImage(compressedSrc) {
    $.ajax({
        type: "POST",
        url: urlPhoto,
        data: { base64: compressedSrc, folder: "child" },
        dataType: "json",
        beforeSend() {
            $(".loading").show();
        },
        success(json) {
            $(".loading").hide();
            $("#photoUrl").val(json.url);
        }
    });
}

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

                    var postal = place.address_components[i].long_name;
                }

                if (place.address_components[i].types[j] == "street_number") {

                    var street_number = place.address_components[i].long_name;
                }

                if (place.address_components[i].types[j] == "route") {

                    var route = place.address_components[i].long_name;
                }

                if (place.address_components[i].types[j] == "locality") {

                    var town = place.address_components[i].long_name;
                }

                if (place.address_components[i].types[j] == "country") {

                    var country = place.address_components[i].long_name;
                }

            }
        }

        console.log(place.geometry);
        let name = place.name;
        let address = street_number + ' ' + route;
        let latitude = place.geometry.location.lat();
        let longitude = place.geometry.location.lng();

        let googlePlaceId = place.place_id;
        let photo;
        if(place.photos != undefined) photo = place.photos[0].getUrl();

        let data = {name, address, postal, town, country, latitude, longitude, googlePlaceId, photo};

        let url = "school/create";
        let type = "POST";
        $.ajax({
          type: "POST",
          url: urlRequest,
          data: {type, url, data},
          dataType: "json",
          beforeSend() {

          },
          success(json) {

            $("#school").val(json.school.schoolId);

          }
        });


    });


    $("#birthdate").datepicker({
        altField: "#datepicker",
        altFormat: "yy-mm-dd",
        closeText: "Fermer",
        prevText: "Précédent",
        nextText: "Suivant",
        firstDay: 1,
        yearRange: "-20:+0",
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
        dateFormat: "dd/mm/yy",
        changeYear: true,
        maxDate: new Date()
    });
});

document.getElementById("childForm").addEventListener(
    "submit",
    event => {

        event.preventDefault();
        let form = $("#childForm");
        let url = form.attr("action");
        const dataRelation = [];
        let i = 0;
        $(".user__associated")
            .find(".card-ea-profil")
            .each(function() {
                const idPerson = $(this).attr("data-id-person");
                const relationData = $(this).attr("data-relation");
                dataRelation[i] = { personId: idPerson, relation: relationData };
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
            beforeSend() {
                $(".loading").show();
            },
            success(json) {
                $(".loading").hide();
                if (json.status == true) {
                    swal({
                        title: "Confirmation",
                        text: json.message,
                        type: "success",
                        confirmButtonText: "Afficher le profil",
                        cancelButtonText: "Fermer",
                        showCancelButton: true
                    }).then(result => {
                        if (result.value) {
                            location.href = `${urlHost}child/display/id/${json.child.childId}/`;
                        }
                    });
                } else {

                    console.log(json);
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

document.getElementById("loadMoreListPerson").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");

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
                        let photo = photoProfilDefault;

                        if (json[i].photo != null) {
                            photo = urlHost + json[i].photo;
                        }
                        $("#personList").append(
                            `<li>
                                <a href="javascript:void(0)" data-open="relationPerson" data-photo="${photo}" data-nom="${json[i].firstname} ${json[i].lastname}" onclick="addPerson(this)" id="${json[i].personId}">
                                    <div>
                                        <p class="list-header">
                                            <img src="${photo}" class="width-30 height-30" height="" width="" alt="">
                                            ${json[i].firstname} ${json[i].lastname}
                                            <div class="with-icon"> AJOUTER </div>
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

document.getElementById("searchListPerson").addEventListener(
    "keyup",
    function(event) {
        let searchTerm = $(this).val();
        let size = $("#loadMoreListPerson").attr("data-size");
        let url = `person/search/${searchTerm}?size=${size}?page=1`;
        $("#personList").html("");
        $("#pageSearch").val(1);
        $("#loadMoreListPerson").attr("disabled", false);

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
                        let photo = photoProfilDefault;

                        if (json[i].photo != null) {
                            photo = urlHost + json[i].photo;
                        }

                        $("#personList").append(
                            `<li><a href="javascript:void(0)" data-open="relationPerson" data-photo="${photo}" data-nom="${
                                json[i].firstname
                                } ${json[i].lastname}" onclick="addPerson(this)" id="${
                                json[i].personId
                                }"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${
                                json[i].firstname
                                } ${
                                json[i].lastname
                                }<div class="with-icon"> AJOUTER </div> </p>  </div> </a></li>`
                        );
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

const addPerson = data => {
    let id = data.id;
    let nom = $(data).attr("data-nom");
    let photo = $(data).attr("data-photo");
    $("#idPerson").val(id);
    $("#nomPerson").val(nom);
    $("#photoPerson").val(photo);
};

const addPersonStep2 = () => {
    let idPerson = $("#idPerson").val();
    let relation = $("#relationInput").val();
    let nom = $("#nomPerson").val();
    let photo = $("#photoPerson").val();

    $(".user__associated").append(
        `<div  class="card-ea-profil" data-relation="${relation}" data-id-person="${idPerson}">
            <div class="card-banner">
                <div class="card-profile" style="background-image: url('${photo}');"></div>
                     <h3>${nom}</h3>
                     <h4>${relation}</h4>
                     <aside>
                         <a href="javascript:void(0)" data-id="${idPerson}" onclick="deletePerson(this)"> Supprimer </a>
                     </aside>
                </div>
            </div>
        </div>`
    );
};

const deletePerson = data => {
    let id = $(data).attr("data-id");
    $(`[data-id-person='${id}']`)
        .addClass("animated bounceOutUp")
        .delay(750)
        .hide(0);
};


