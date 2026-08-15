document.getElementById("signInForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();

        let form = $("#signInForm");
        let username = $("[name=username]").val();
        let password = $("[name=password]").val();
        let data = JSON.stringify({ username, password });

        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            contentType: "application/json",
            contentLength: data.length,
            crossDomain: true,
            dataType: "json",
            data,
            beforeSend() {
                $("#signInForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours...");
            },
            success(data) {
                $("#signInForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");
                sendToServer(data);
            },
            error(data) {
                $("#signInForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (data.responseJSON.error == "Invalid credentials.") {
                    $(".messageConnexion")
                        .addClass("animated shake")
                        .show()
                        .html("Identifiants incorrects.");
                } else {
                    $(".messageConnexion")
                        .show()
                        .addClass("animated shake")
                        .html("Une erreur est survenue.");
                }
            }
        });
    },
    false
);

var sendToServer = dataJson => {
    $.ajax({
        url: "../auth/check",
        type: "POST",
        dataType: "json",
        data: dataJson,
        beforeSend() {
            $("#signInForm [type=submit]")
                .attr("disabled", true)
                .attr("value", "Envoi en cours...");
        },
        success(data) {
            if (data.msg == "ok") {
                location.href = "../app/home";
            } else {
                $(".messageConnexion")
                    .show()
                    .addClass("animated shake")
                    .html("Une erreur est survenue.");
            }
        }
    });
};
