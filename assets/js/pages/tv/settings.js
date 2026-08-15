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

        const imageCompressor = new ImageCompressor();

        const compressorSettings = {
            toWidth: 1920,
            toHeight: 1080,
            mimeType: "image/jpg",
            mode: "stretch",
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
        data: { base64: compressedSrc, folder: "tv" },
        dataType: "json",
        beforeSend() {
            $(".loading").show();
        },
        success(json) {
            $(".loading").hide();
            locationRedirect();
        }
    });
}


dropContainer2.ondragover = dropContainer2.ondragenter = evt => {
  evt.preventDefault();
};

dropContainer2.ondrop = evt => {
  fileInput2.files = evt.dataTransfer.files;
  evt.preventDefault();
};

const previewOnDiv2 = () => {
  const file = document.querySelector("#fileInput2").files[0];
  const reader = new FileReader();
  reader.readAsDataURL(file);
  reader.onload = () => {

      const image = document.getElementById("photoRender2");
      const strImage = reader.result.replace(/^data:image\/[a-z]+;base64,/, "");
      image.src = `data:image/jpeg;base64,${strImage}`;

      $("#photoRender2").fadeIn();

      const imageCompressor = new ImageCompressor();

      const compressorSettings = {
          toWidth: 1920,
          toHeight: 1080,
          mimeType: "image/jpg",
          mode: "stretch",
          quality: 0.6,
          speed: "low"
      };

      imageCompressor.run(image.src, compressorSettings, proceedCompressedImage2);
  };
};

function proceedCompressedImage2(compressedSrc) {

  $.ajax({
      type: "POST",
      url: urlPhoto,
      data: { base64: compressedSrc, folder: "tv/background" },
      dataType: "json",
      beforeSend() {
          $(".loading").show();
      },
      success(json) {
          $(".loading").hide();
          locationRedirect();
      }
  });
}



const removeThisModule = (id, element) =>
{

	let url = "television/delete/" + id;
	let type = "DELETE";

	$.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type },
      dataType: "json",
      beforeSend() {
        $(".loading").show();
      },
      success(json) {
        $(".loading").hide();
        $(element).parent().parent().parent().parent().hide();
 
      }
    });
}


const addModule = () =>
{

	let start = $("#start").val() + ':00';
	let end = $("#end").val() + ':00';
	let module = $("#module").val();
	let data = {start, end, module};
	let url = "television/create";
	let type = "POST";


	$.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type, data },
      dataType: "json",
      beforeSend() {
        $(".loading").show();
      },
      success(json) {
        $(".loading").hide();

        if (json.status == true) {
          toastr.success('Module ajouté');
          locationRedirect();

        } else {
          swal({
            title: "Erreur",
            text: "Une erreur est survenue.",
            type: "warning"
          });
        }
      }
    });



}

const removeThisImg = (pic, data) =>
{
    $.ajax({
    type: "POST",
    url: `${urlHost}tv/removeImg`,
    data: { pic },
    dataType: "json",
    beforeSend() {
        $(".loading").show();
    },
    success(json) {
        $(".loading").hide();
        $(data).parent().parent().parent().parent().hide();
    }
});
}