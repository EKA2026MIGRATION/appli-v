document
    .getElementById("deleteProduct")
    .addEventListener("click", function(event) {
        const idProduct = $(this).attr("data-id-product");

        swal({
            title: "Attention",
            text: "La suppression est irréversible.",
            type: "warning",
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler",
            showCancelButton: true
        }).then(result => {
            if (result.value) {
                deleteProduct(idProduct);
            }
        });
    });

var deleteProduct = idProduct => {
    let url = `product/delete/${idProduct}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
            $("#deleteProduct")
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
                        location.href = `${urlHost}product/list`;
                    }
                });
            }
        }
    });
};