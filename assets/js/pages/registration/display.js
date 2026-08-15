const deleleteRegistration = idRegistration =>
{
        swal({
            title: "Attention",
            text: "La suppression d'une inscription engendrera la suppressions des pickups et présences liées à cette inscription.",
            type: "warning",
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler",
            showCancelButton: true
        }).then(result => {
            if (result.value) {
                deleleteRegistrationSubmit(idRegistration);
                deleletePickUps(idRegistration);
                deletePickUpsActivity(idRegistration);
                deleteChildPresence(idRegistration);                
            }
        });
}


var deleleteRegistrationSubmit = idRegistration => {
    let url = `registration/delete/${idRegistration}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
            $("#deletePerson")
                .attr("disabled", true)
                .html("Suppression en cours..");
        },
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
                        location.href = `${urlHost}registration/list`;
                    }
                });
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

const deleletePickUps = idRegistration =>
{
    let url = `pickup/delete-registration/${idRegistration}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
            $("#deletePerson")
                .attr("disabled", true)
                .html("Suppression en cours..");
        },
        success(json) {
            if (json.status == true) {

                toastr.success(json.message);

            } else {
               toastr.success('Aucun pickup transport à supprimer.');
            }
        }
    });
}

const deletePickUpsActivity = idRegistration =>
{
    let url = `pickup-activity/delete-registration/${idRegistration}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
            $("#deletePerson")
                .attr("disabled", true)
                .html("Suppression en cours..");
        },
        success(json) {
            if (json.status == true) {

                toastr.success(json.message);
                
            } else {
                toastr.success('Aucun pickup activity à supprimer.');
            }
        }
    });
}

const deleteChildPresence = idRegistration =>
{
    let url = `child/presence/delete-registration/${idRegistration}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
            $("#deletePerson")
                .attr("disabled", true)
                .html("Suppression en cours..");
        },
        success(json) {
            if (json.status == true) {

                toastr.success(json.message);
                
            } else {
                toastr.success('Aucune présence à supprimer.');
            }
        }
    });
}
