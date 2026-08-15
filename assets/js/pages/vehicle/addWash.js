
document.getElementById("addWashForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#addWashForm");
        let url = form.attr("action");
        let type = "POST";
        let data = $(form).serializeToJSON();


        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data },
            dataType: "json",
            beforeSend() {
                $("#addWashForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                toastr.success(json.message, 'Lavage ajouté');
                $("#addWashForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");
            }
        });
    },
    false
);
