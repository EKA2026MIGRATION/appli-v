document.getElementById("loadMoreListRegistration").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");
        var pageSuivante = page + 1;
        var url = `registration/list?page=${pageSuivante}&size=${size}`;


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

                        if (json[i].child.photo != null) {
                            photo = urlHost + json[i].child.photo;
                        }

                        $("#registrationList").append(
                            `<li data-id-registration="${json[i].registrationId}">
                                <a href="javascript:void(0)" onclick="getIdRegistration(\`${json[i].registrationId}\`)" data-open="action-registration">
                                    <div>
                                        <p class="list-header">
                                        <img src="${photo}" class="width-30 height-30" />
                                         ${json[i].registration} - ${json[i].status} - Commande par ${json[i].person.firstname} ${json[i].person.lastname} pour ${json[i].child.firstname} ${json[i].child.lastname}
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon"> 
                                                <i class="material-icons">edit</i>
                                            </div> 
                                        </p>
                                    </div>
                                </a>
                            </li>`
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

const editRegistration = () => {
    let idRegistration = $("#lastIdRegistration").val();
    let url = `registration/display/${idRegistration}`;

    $("#registrationForm").attr("action", `registration/modify/${idRegistration}`);

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "GET", url },
        dataType: "json",
        beforeSend() {
            $("#loaderFormEditRegistration").show();
        },
        success(json) {
            $("#loaderFormEditRegistration").hide();

            const inputs = $("input, select").not(
                ":input[type=button], :input[type=submit], :input[type=reset]"
            );

            $("#registrationForm")
                .find(inputs)
                .each(function() {
                    const name = $(this).attr("name");
                    $(this).val(json[name]);
                });

            if (json.photo != null) {
                photo = urlHost + json.photo;
                $("#photoRender").attr("src", photo);
            }
        }
    });
};

const getIdRegistration = idRegistration => {
    $("#lastIdRegistration").val(idRegistration);
};

document.getElementById("registrationForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#registrationForm");
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
                $("#registrationForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#registrationForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {

                    $("#modifyRegistration").foundation("close");
                    toastr.success(json.message, 'Confirmation');

                    let photo = noPhoto;

                    if (json.registration.photo != null) {
                        photo = urlHost + json.registration.photo;
                    }
                    const newRegistration =
                        `<a href="javascript:void(0)" onclick="getIdRegistration(\`${json.registration.registrationId}\`)" data-open="action-registration">
                             <div>
                                  <p class="list-header"> 
                                       <img src="${photo}" class="width-30 height-30" height="" width="" alt="">    
                                       ${json.registration.registration} - ${json.registration.status} - Commande par ${json.registration.person.firstname} ${json.registration.person.lastname} pour ${json.registration.child.firstname} ${json.registration.child.lastname}
                                       <aside class="subtitles">Montant payé : ${json.registration.payed}€</aside>
                                       <div class="with-icon"> 
                                            <i class="material-icons">edit</i>
                                       </div> 
                                  <
                             </div>
                        </a>`;

                    if (url.includes("modify")) {
                        $(`[data-id-registration=${json.registration.registrationId}]`).html(newRegistration);
                    } else {
                        $("#registrationList").append(
                            `<li data-id-registration="${json.registration.registrationId}">                               
                                 ${newRegistration}                             
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

const viewRegistration = () => {
    let idRegistration = $("#lastIdRegistration").val();
    let url = `${urlHost}/registration/display/id/${idRegistration}/`;
    locationRedirect(url);
};

const viewInvoice = () => {
    let idRegistration = $("#lastIdRegistration").val();

    let invoiceId = $(this).attr('id').split('-')[1];
    var version   = $(this).attr('id').split('-')[0];

    $('#showInvoiceDetails').show('slow');

    let url = `${urlHost}invoice/display/id/${invoiceId}/`;

    $('#showInvoiceDetails').load(url);

    let topPos = (window.pageYOffset);
    $('#showInvoiceDetails').css({top:topPos});




};
