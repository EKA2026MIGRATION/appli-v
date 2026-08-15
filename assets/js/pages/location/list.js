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

function proceedCompressedImage(compressedSrc) {
    $.ajax({
        type: "POST",
        url: urlPhoto,
        data: { base64: compressedSrc, folder: "location" },
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

document.getElementById("loadMoreLocation").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");
        const pageSuivante = page + 1;
        const url = `location/list?page=${pageSuivante}&size=${size}`;

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

                        if (json[i].photo != null) {
                            photo = urlHost + json[i].photo;
                        }

                        $("#locationList").append(
                            `<li data-id-location="${
                                json[i].locationId
                                }"><a href="javascript:void(0)" onclick="getIdLocation(\`${
                                json[i].locationId
                                }\`)" data-open="action-location"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt=""> ${
                                json[i].name
                                } - ${
                                json[i].address
                                }<aside class="subtitles"></aside><div class="with-icon"> <i class="material-icons">edit</i></div> </p>  </div> </a></li>`
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

const editLocation = () => {
    let idLocation = $("#lastIdLocation").val();
    let url = `location/display/${idLocation}`;
    $("#locationForm").attr("action", `location/modify/${idLocation}`);

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "GET", url },
        dataType: "json",
        beforeSend() {
            $("#loaderFormEditLocation").show();
        },
        success(json) {
            $("#loaderFormEditLocation").hide();

            $("#locationForm")
                .find("input")
                .each(function() {
                    const name = $(this).attr("name");
                    $(this).val(json[name]);
                });

            if (json.photo != null) {
                photo = urlHost + json.photo;
                $("#photoRender").attr("src", photo);
            }
        }
    });
};

const getIdLocation = idLocation => {
    $("#lastIdLocation").val(idLocation);
};

const deleteLocation = () => {
    let idLocation = $("#lastIdLocation").val();

    swal({
        title: "Attention",
        text: "La suppression est irréversible.",
        type: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showCancelButton: true
    }).then(result => {
        if (result.value) {
            deleteLocationSubmit(idLocation);
        }
    });
};

var deleteLocationSubmit = idLocation => {
    let url = `location/delete/${idLocation}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {},
        success(json) {
            if (json.status == true) {
                toastr.success(json.message, 'Suppression');
                $(`[data-id-location=${idLocation}]`)
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



document.getElementById("locationForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#locationForm");
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
                $("#locationForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#locationForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {
                    $("#createLocation").foundation("close");
                    toastr.success(json.message, 'Confirmation');

                            let photo = noPhoto;

                            if (json.location.photo != null) {
                                photo = urlHost + json.location.photo;
                            }
                            const newLocation =
                                `<a href="javascript:void(0)" onclick="getIdLocation('${json.location.locationId}')" data-open="action-location">
                                    <div>
                                        <p class="list-header">
                                            <img src="${photo}" class="width-30 height-30" height="" width="" alt=""> 
                                            ${json.location.name} - ${json.location.address} 
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon"> 
                                                <i class="material-icons">edit</i>
                                            </div>                                                
                                        </p>
                                    </div>
                                </a>`;
                    if (url.includes("modify")) {
                        $(`[data-id-location=${json.location.locationId}]`).html(newLocation);
                    } else {
                        $("#locationList").append(
                            `<li data-id-location="${json.location.locationId}">                               
                                 ${newLocation}                             
                            </li>`);
                    }

                } else {
                    $("#createLocation").foundation("close");
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

const changeActionLocation = () => {
    $("#locationForm").attr("action", "location/create");
    $("#locationForm").trigger("reset");
};