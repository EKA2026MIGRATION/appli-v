$(() => {
  initMultiSelect();
});



document.getElementById("changePassWord").addEventListener(
    "submit",
    event => {
        event.preventDefault();

        let form = $("#changePassWord");
        let password = $("[name=new_password]").val();
        let data = JSON.stringify({ plainPassword: password });
        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            contentType: "application/json",
            headers: {
                'Authorization':'Bearer ' + tokenAuth
            },
            contentLength: data.length,
            crossDomain: true,
            dataType: "json",
            data,
            beforeSend() {
                $("#changePassWord [type=submit]")
                    .attr("disabled", true);
            },
            success(data) {
                $("#changePassWord [type=submit]")
                    .attr("disabled", false);

                    toastr.success('Votre mot de passe a été modifié.');


            },
            error(data) {
                $("#changePassWord [type=submit]")
                    .attr("disabled", false);
            }
        });
    },
    false
);

document.getElementById("changeEmail").addEventListener(
    "submit",
    event => {
        event.preventDefault();


        let form = $("#changeEmail");
        let email = $("[name=new_email]").val();
        let data = JSON.stringify({ email });

console.log(form.attr("method"));

        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            contentType: "application/json",
            headers: {
                'Authorization':'Bearer ' + tokenAuth
            },
            contentLength: data.length,
            crossDomain: true,
            dataType: "json",
            data,
            beforeSend() {
                $("#changeEmail [type=submit]")
                    .attr("disabled", true);
            },
            success(data) {
                $("#changeEmail [type=submit]")
                    .attr("disabled", false);

                    toastr.success('Votre email a été modifié.');


            },
            error(data) {
                $("#changeEmail [type=submit]").attr("disabled", false);
                let response = data.responseJSON;
                if (response && response.type && response.type.indexOf('UniqueConstraintViolationException') !== -1) {
                    toastr.error('Cet email est déjà utilisé par un autre compte.');
                } else {
                    toastr.error('Une erreur est survenue, impossible de modifier l\'email.');
                }
            }
        });
    },
    false
);





var initMultiSelect = () => {
  $("#rolesSelect").zmultiselect({
    filter: true,
    filterResult: true,
    selectAll: true,
    selectAllText: ["Tout cocher", "Tout décocher"],
    selectedText: ["Sélectionné : ", "/"],
    filterPlaceholder: "",
    filterResultText: "",
    filterPlaceholder: "Choisir les rôles",
    get: "zmultiselect",
    placeholder: "Choisir les rôles",
    live: "#liveResult"
  });
};




var modifyRoles = () =>
{
    var listRoles = $("#listroles").val();
    listRoles = listRoles.split(',');
    let data = '';
    listRoles.forEach(function(roleDelete) {

        $.ajax({
            url: $("#urlApi").val() + 'user/api/delete-role/' + $("#user_identifier").val() + "/" + roleDelete,
            type: 'PUT',
            contentType: "application/json",
            headers: {
                'Authorization':'Bearer ' + tokenAuth
            },
            contentLength: data.length,
            crossDomain: true,
            dataType: "json",
            data,
            beforeSend() {
            },
            success(data) {




            },
            error(data) {

            }
        });

    });



    var roles = $("#liveResult").val();
    roles = roles.split(',');
    var arrayRoles = [];
    arrayRoles = arrayRoles.concat(roles);

    arrayRoles.forEach(function(role) {

        $.ajax({
            url: $("#urlApi").val() + 'user/api/add-role/' + $("#user_identifier").val() + "/" + role,
            type: 'PUT',
            contentType: "application/json",
            headers: {
                'Authorization':'Bearer ' + tokenAuth
            },
            contentLength: data.length,
            crossDomain: true,
            dataType: "json",
            data,
            beforeSend() {
            },
            success(data) {




            },
            error(data) {

            }
        });



    });



    toastr.success('Rôle(s) modifié(s).');




}
