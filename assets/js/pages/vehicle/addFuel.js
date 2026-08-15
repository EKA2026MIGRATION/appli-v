/*dropContainer.ondragover = dropContainer.ondragenter = evt => {
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
        data: { base64: compressedSrc, folder: "vehicle/fuel" },
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
*/

document.getElementById("addEssence").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#addEssence");
        let url = form.attr("action");
        let type = "POST";
        let data = $(form).serializeToJSON();

        $('#mileage').val('');
        $('#quantity').val('');
        $('#amount').val('');


        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data },
            dataType: "json",
            beforeSend() {
                $("#addEssence [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                toastr.success(json.message, 'Essence ajoutée');
                $("#addEssence [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");
            }
        });
    },
    false
);
