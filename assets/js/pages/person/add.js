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
let rotateUrl = urlHost+'rotatePhoto';
function rotatePhoto(urlOfImage) {
    $.ajax({
        type: "POST",
        url: rotateUrl,
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
        data: { base64: compressedSrc, folder: "person" },
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

document.getElementById("personForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#personForm");
        let url = form.attr("action");
        let type = "POST";
        let data = $(form).serializeToJSON();
        const relations = [];

        if (url.includes("modify")) {
            type = "PUT";
        }
        else
        {

            if($("#personLink").length != 0)
            {
                relations[0] = {related: $("#personLink").val(), relation: $("#relation").val()};
            }

        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data, relations},
            dataType: "json",
            beforeSend() {
                $("#personForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#personForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");
                $("#personForm")[0].reset();

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
                            location.href = `${urlHost}person/display/id/${json.person.personId}/`;
                        }
                    });
                } else {
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

/*
Autocomplete for child
 *
document.getElementById("autocompleteUser").addEventListener(
    "keyup",
    function(event) {
        let searchTerm = $(this).val();
        let url = `user/api/search/${searchTerm}`;

        $("#autocompleteUser").autocomplete({
            minLength: 2,
            source(request, response) {
                $.ajax({
                    type: "POST",
                    url: urlRequest,
                    data: { url, type: "GET" },
                    dataType: "json",

                    success(data) {
                        response(
                            $.map(data, user => ({
                                label: user.email,
                                value: user.id,
                                id: user.identifier
                            }))
                        );
                    }
                });
            },
            select(data, user) {
                $("#autocompleteUser").val(user.item.label);
                $("[name=identifier]").val(user.item.id);
            },
            change(data, user) {

            }
        });
    },
    false
);
*/