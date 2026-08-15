document
    .getElementById("deleteMeal")
    .addEventListener("click", function(event) {
        const idMeal = $(this).attr("data-id-meal");
        console.log(idMeal);
        swal({
            title: "Attention",
            text: "La suppression est irréversible.",
            type: "warning",
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler",
            showCancelButton: true
        }).then(result => {
            if (result.value) {
                deleteMeal(idMeal);
            }
        });
    });

var deleteMeal = idMeal => {
    let url = `meal/delete/${idMeal}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
            $("#deleteMeal")
                .attr("disabled", true)
                .html("Suppression en cours..");
        },

        success(json) {
            if (json.status == true) {
                swal({
                    title: "Suppression",
                    text: json.message,
                    type: "success",
                    confirmButtonText: "Retour à la liste des repas",
                    showCancelButton: false
                }).then(result => {
                    if (result.value) {
                        location.href = `${urlHost}meal/list`; //TODO vérifier l'url
                    }
                });
            }
        }
    });
};
