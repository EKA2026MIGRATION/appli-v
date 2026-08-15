
$('[data-open-details]').click(function (e) {
  e.preventDefault();
  $(this).next().toggleClass('is-active');
  $(this).toggleClass('is-active');
});


const viewRapportDate = () => {
    var reportStart = $("#reportStart").val();
    var reportEnd = $("#reportEnd").val();
    let url = urlHost + `vehicle/list/date_start/${reportStart}/date_end/${reportEnd}/`;
    location.href = url;
}

const viewRapportDateIndi = () => {
    var idVehicle = $("#selectVehicle").val();
    var reportStart = $("#reportStart").val();
    var reportEnd = $("#reportEnd").val();
    let url = urlHost + `vehicle/display/date_start/${reportStart}/date_end/${reportEnd}/vehicle_id/${idVehicle}/`;
    location.href = url;
}



const previewOnDiv = () => {
    const file = document.querySelector("#fileInput").files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
        const image = document.getElementById("photoRender");
        const strImage = reader.result.replace(/^data:image\/[a-z]+;base64,/, "");
        image.src = `data:image/jpeg;base64,${strImage}`;


    
        getOrientation(file, function(orientation) {
            
            if(orientation > 2)
            {
                resetOrientation(image.src, 5, function(resetBase64Image) {
                    image.src = resetBase64Image;
                });        
            }

            
     
        });
        
        $("#photoRender").fadeIn();

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
        data: { base64: compressedSrc, folder: "vehicle" },
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

const checkVehicle = () =>
{


}

/*
document.getElementById("loadMoreVehicle").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");
        const pageSuivante = page + 1;
        const url = `vehicle/list?page=${pageSuivante}&size=${size}`;

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

                        $("#vehicleList").append(
                            `<li data-id-vehicle="${json[i].vehicleId}">
                                <a href="javascript:void(0)" onclick="getIdVehicle(\`${json[i].vehicleId}\`)" data-open="action-vehicle">
                                    <div>
                                        <p class="list-header">
                                            <img src="${photo}" class="width-30 height-30" height="" width="" alt=""> ${json[i].name} - ${json[i].matriculation} - (places : ${json[i].places})
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon">
                                                <i class="material-icons">edit</i>
                                            </div>
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
*/

const extractFuel = () => {
    $("#fuelTableExtract").find('table').find('tbody').html('');
    $(".vehicleTable")
        .find(".fuelTable")
        .find("tbody tr")
        .each(function() {
           var tr = $(this).clone();
           $("#fuelTableExtract").find('table').find('tbody').append(tr);
        });
    $("#fuelTableExtract").toggle();
}

const extractWash = () => {
    $("#washTableExtract").find('table').find('tbody').html('');
    $(".vehicleTable")
        .find(".washTable")
        .find("tbody tr")
        .each(function() {
           var tr = $(this).clone();
           $("#washTableExtract").find('table').find('tbody').append(tr);
        });
    $("#washTableExtract").toggle();
}

const extractAction = () => {
    $("#actionTableExtract").find('table').find('tbody').html('');
    $(".vehicleTable")
        .find(".actionTable")
        .find("tbody tr")
        .each(function() {
           var tr = $(this).clone();
           $("#actionTableExtract").find('table').find('tbody').append(tr);
        });
    $("#actionTableExtract").toggle();
}

const extractCheckup = () => {
    $("#checkupTableExtract").find('table').find('tbody').html('');
    $(".vehicleTable")
        .find(".checkupTable")
        .find("tbody tr")
        .each(function() {
           var tr = $(this).clone();
           $("#checkupTableExtract").find('table').find('tbody').append(tr);
        });
    $("#checkupTableExtract").toggle();
}

const editVehicle = () => {
    let idVehicle = $("#lastIdVehicle").val();
    let url = `vehicle/display/${idVehicle}`;
    $("#vehicleForm").attr("action", `vehicle/modify/${idVehicle}`);

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "GET", url },
        dataType: "json",
        beforeSend() {
            $("#loaderFormEditVehicle").show();
        },
        success(json) {
            $("#loaderFormEditVehicle").hide();

            $("#vehicleForm")
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



const getIdVehicle = (idVehicle, name, matriculation) => {
    $("#lastIdVehicle").val(idVehicle);
    $("#lastNameVehicle").val(`${name} (${matriculation})`);
    $(".nameVehicle").html(`${name} (${matriculation})`);


    $("[name=vehicle_id]").val(idVehicle);
};

const deleteVehicle = () => {
    let idVehicle = $("#lastIdVehicle").val();

    swal({
        title: "Attention",
        text: "La suppression est irréversible.",
        type: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showCancelButton: true
    }).then(result => {
        if (result.value) {
            deleteVehicleSubmit(idVehicle);
        }
    });
};

var deleteVehicleSubmit = idVehicle => {
    let url = `vehicle/delete/${idVehicle}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {},
        success(json) {
            if (json.status == true) {
                toastr.success(json.message, 'Suppression');
                        $(`[data-id-vehicle=${idVehicle}]`)
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



document.getElementById("vehicleForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#vehicleForm");
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
                $("#vehicleForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#vehicleForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {
                    /*
                    $("#createVehicle").foundation("close");
                    toastr.success(json.message, 'Confirmation');


                            let photo = noPhoto;

                            if (json.vehicle.photo != null) {
                                photo = urlHost + json.vehicle.photo;
                            }
                    const newVehicle =
                        `<a href="javascript:void(0)" onclick="getIdVehicle(\`${json.vehicle.vehicleId}\`)" data-open="action-vehicle">
                                    <div>
                                        <p class="list-header">
                                            <img src="${photo}" class="width-30 height-30" height="" width="" alt=""> 
                                            ${json.vehicle.name} - ${json.vehicle.matriculation} - (places : ${json.vehicle.places})
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon"> 
                                                <i class="material-icons">edit</i>
                                            </div> 
                                        </p>  
                                    </div> 
                                </a>`;
                    if (url.includes("modify")) {
                        $(`[data-id-vehicle=${json.vehicle.vehicleId}]`).html(newVehicle);
                    } else {
                        $("#vehicleList").append(
                            `<li data-id-vehicle="${json.vehicle.vehicleId}">
                                ${newVehicle}
                            </li>`
                        );
                    }
                    */
                    location.reload();
                } else {
                    $("#createVehicle").foundation("close");
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

const changeActionVehicle = () => {
    $("#vehicleForm").attr("action", "vehicle/create");
    $("#vehicleForm").trigger("reset");
};


$('#showAllVehicleButton').click(function() {
    $('.busNC').toggle();
})