document.getElementById("signUpForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#signUpForm");
        let url = form.attr("action");
        if (url.includes("modify")) {
            modifyUser();
        }
        else
        {
            addUser();
        }


    },
    false
);



var addUser = () =>
{


    let form = $("#signUpForm");
    let username = $("[name=username]").val();
    username = username.toLowerCase();
    let plainPassword  = $("[name=plainPassword]").val();
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: {email: username, plainPassword, apiKey: sha1(username + 'LKf7*D')},
        crossDomain: true,
        dataType: "json",
        beforeSend() {
            $("#signUpForm [type=submit]")
                .attr("disabled", true)
                .attr("value", "Envoi en cours...");
        },
        success(json) {
            $("#signUpForm [type=submit]")
                .attr("disabled", false)
                .attr("value", "Envoyer");

          swal({
            title: "Confirmation",
            text: "Utilisateur créé.",
            type: "success",
            confirmButtonText: "Créer le profil de la personne",
            cancelButtonText: "Annuler",
            showCancelButton: true
          }).then(result => {  
              location.href = `${urlHost}person/add/identifier/${json.identifier}/email/${json.email}/`; 
            }); //TODO on garde ?



        },
        error(data) {
            $("#signUpForm [type=submit]")
                .attr("disabled", false)
                .attr("value", "Envoyer");

            if (data.responseJSON.error == "Invalid credentials.") {
                $(".messageInscription")
                    .addClass("animated shake")
                    .show()
                    .html("Identifiants incorrects.");
            } else {
                $(".messageInscription")
                    .show()
                    .addClass("animated shake")
                    .html("Une erreur est survenue.");
            }
        }
    });
}
