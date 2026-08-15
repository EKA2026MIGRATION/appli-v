document.getElementById("loadMoreListComponent").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");

        if ($("#searchListComponent").val() != "") {
            const searchTerm = $("#searchListComponent").val();
            var pageSuivante = parseInt($("#pageSearch").val()) + 1;
            var url = `component/search/${searchTerm}?size=${size}&page=${pageSuivante}`;
            $("#pageSearch").val(pageSuivante);
        } else {
            var pageSuivante = page + 1;
            var url = `component/list?page=${pageSuivante}&size=${size}`;
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type: "GET" },
            dataType: "json",
            beforeSend() {
                $(element)
                    .attr("disabled", true)
                    .html("Chargement en cours..");
            },
            success(json) {
                $(element)
                    .attr("disabled", false)
                    .html("Afficher plus");
                const numberOfElements = json.length;

                if (numberOfElements > 0) {
                    for (i = 0; i < numberOfElements; i++) {
                        let photo = photoProfilDefault;

                        if (json[i].photo != null) {
                            photo = urlHost + json[i].photo;
                        }

                        $("#componentList").append(
                            `<li data-id-component="${
                                json[i].componentId
                                }"><a href="javascript:void(0)" onclick="getIdComponent(\`${
                                json[i].componentId
                                }\`)" data-open="action-component"><div><p class="list-header"> ${
                                json[i].nameFr
                                }<aside class="subtitles"></aside><div class="with-icon"> <i class="material-icons">edit</i></div> </p>  </div> </a></li>`
                        );
                    }

                    $(element).attr("data-page", pageSuivante);
                } else {
                    $(element)
                        .attr("disabled", true)
                        .html("Liste terminée.");
                }
            }
        });
    },
    false
);


const editComponent = () => {
    let idComponent = $("#lastIdComponent").val();
    let url = `component/display/${idComponent}`;
    $("#componentForm").attr("action", `component/modify/${idComponent}`);

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "GET", url },
        dataType: "json",
        beforeSend() {
            $("#loaderFormEditComponent").show();
        },
        success(json) {
            $("#loaderFormEditComponent").hide();

            const inputs = $("input, select").not(
                ":input[type=button], :input[type=submit], :input[type=reset]"
            );

            $("#componentForm")
                .find(inputs)
                .each(function() {
                    const name = $(this).attr("name");
                    $(this).val(json[name]);
                });

        }
    });
};

const getIdComponent = idComponent => {
    $("#lastIdComponent").val(idComponent);
};

const deleteComponent = () => {
    let idComponent = $("#lastIdComponent").val();

    swal({
        title: "Attention",
        text: "La suppression est irréversible.",
        type: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showCancelButton: true
    }).then(result => {
        if (result.value) {
            deleteComponentSubmit(idComponent);
        }
    });
};


var deleteComponentSubmit = idComponent => {
    let url = `component/delete/${idComponent}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {},
        success(json) {
            if (json.status == true) {
                toastr.success(json.message, 'Suppression');
                $(`[data-id-component=${idComponent}]`)
                    .addClass("animated bounceOutUp")
                    .delay(750)
                    .hide(0);
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

document.getElementById("componentForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#componentForm");
        let url = form.attr("action");
        const i = 0;

        let data = $(form).serializeToJSON();
        let type = "POST";

        if (url.includes("modify")) {
            type = "PUT";
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type, data },
            dataType: "json",
            beforeSend() {
                $("#componentForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#componentForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {

                $("#createComponent").foundation("close");
                toastr.success(json.message, 'Confirmation');

                const newComponent =
                    `<a href="javascript:void(0)" onclick="getIdComponent('${json.component.componentId}')" data-open="action-component">
                                    <div>
                                        <p class="list-header">                     
                                            ${json.component.nameFr} 
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon"> 
                                                <i class="material-icons">edit</i>
                                            </div>                                                
                                        </p>
                                    </div>
                                </a>`;

                if (url.includes("modify")) {
                    $(`[data-id-component=${json.component.componentId}]`).html(newComponent);
                } else {
                    $("#componentList").append(
                        `<li data-id-component="${json.component.componentId}">                               
                                 ${newComponent}                             
                            </li>`);
                }
                } else {
                    swal({
                        title: "Erreur",
                        text: "Une erreur est survenue.",
                        type: "warning"
                    });
                }
            }
        });
    },
    false
);

const changeActionComponent = () => {
    $("#componentForm").attr("action", "component/create");
    $("#componentForm").trigger("reset");
};

document.getElementById("searchListComponent").addEventListener(
    "keyup",
    function(event) {
        let searchTerm = $(this).val();
        let size = $("#loadMoreListComponent").attr("data-size");
        let url = `component/search/${searchTerm}?size=${size}&page=1`;
        $("#componentList").html("");
        $("#pageSearch").val(1);
        $("#loadMoreListComponent").attr("disabled", false);

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type: "GET" },
            dataType: "json",
            beforeSend() {
                $("#componentList").html(showLoader);
            },
            success(json) {
                const numberOfElements = json.length;

                if (numberOfElements > 0) {
                    $("#componentList").html("");

                    for (i = 0; i < numberOfElements; i++) {
                        let photo = photoProfilDefault;

                        if (json[i].photo != null) {
                            photo = urlHost + json[i].photo;
                        }

                        $("#componentList").append(
                            `<li data-id-component="${
                                json[i].componentId
                                }"><a href="javascript:void(0)" onclick="getIdComponent(\`${
                                json[i].componentId
                                }\`)" data-open="action-component"><div><p class="list-header"> ${
                                json[i].nameFr
                                }<aside class="subtitles"></aside><div class="with-icon"> <i class="material-icons">edit</i></div> </p>  </div> </a></li>`
                        );
                    }
                } else {
                    $("#componentList").html(
                        "<p><strong><center>Aucun résultat.</center></strong></p>"
                    );
                }
            }
        });
    },
    false
);