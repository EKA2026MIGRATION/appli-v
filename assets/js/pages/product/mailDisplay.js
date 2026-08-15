tinymce.init({
    selector: '#contentFr',
    menubar: false,
    height: 480,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | link preview'
});

tinymce.init({
    selector: '#contentEn',
    menubar: false,
    height: 480,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | link preview'
});

const deleteMail = (mailId) => {
    swal({
        title: "Attention",
        text: "La suppression est irréversible.",
        type: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showCancelButton: true
    }).then(result => {
        if (result.value) {
            deleteMailSubmit(mailId);
        }
    });
}


var deleteMailSubmit = mailId => {
    let url = `mail/delete/${mailId}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {},
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
                        location.href = `${urlHost}mail/list`;
                    }
                });
            }
        }
    });
};

document.getElementById("mailForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#mailForm");
        let url = form.attr("action");
        let type = "PUT";
        let subjectFr = $("#subjectFr").val();
        let subjectEn = $("#subjectEn").val();
        //let contentFr = $("#contentFr").val();
        //let contentEn = $("#contentEn").val();
        let contentFr = tinymce.get("contentFr").getContent();
        let contentEn = tinymce.get("contentEn").getContent();

        let data = { subjectFr, subjectEn, contentFr, contentEn };

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data },
            dataType: "json",
            beforeSend() {
                $("#mailForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#mailForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                    swal({
                        title: "Email modifié",
                        text: "L'email a bien été modifié",
                        type: "success",
                        confirmButtonText: "Retour à la liste",
                        showCancelButton: false
                    }).then(result => {
                        if (result.value) {
                            location.href = `${urlHost}product/mail`;
                        }
                    });
            }
        });
    },
    false
);