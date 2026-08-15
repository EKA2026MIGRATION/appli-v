/*** REGISTRATION */

var monthsName = {
                    '01' : 'Janvier',
                    '02' : 'Février',
                    '03' : 'Mars',
                    '04' : 'Avril',
                    '05' : 'Mai',
                    '06' : 'Juin',
                    '07' : 'Juillet',
                    '08' : 'Aout',
                    '09' : 'Septembre',
                    '10' : 'Octobre',
                    '11' : 'Novembre',
                    '12' : 'Décembre',
                };

Date.prototype.getWeek = function () {
    var onejan = new Date(this.getFullYear(), 0, 1);
    return Math.ceil((((this - onejan) / 86400000) + onejan.getDay() + 1) / 7);
};
                

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

const getIdRegistration = (idRegistration, invoiceId) => {
    $("#lastIdRegistration").val(idRegistration);
    $('#lastIdInvoice').val(invoiceId);
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

        
                    const newRegistration =
                        `<a href="javascript:void(0)" onclick="getIdRegistration(\`${json.registration.registrationId}\`)" data-open="action-registration">
                             <div style="background-color: lightblue" id="idRegistration${json.registration.registrationId}">
                                  <p class="list-header> 
                                       <span style="color: darkblue">${json.registration.product.nameFr} </span> <b>${json.registration.child.lastname} ${json.registration.child.firstname}</b><br/>
                                         <span style="color: black; font-size: 12px">
                                            ${json.registration.location.name} -
                                        </span>
                                        <br/>
                                        <span style="color: black; font-style: italic; font-size: 10px">
                                            Effectuée le ${json.registration.registration}
                                            par ${json.registration.person.firstname}  ${json.registration.person.lastname}
                                        </span>
                                        <span style="color: black; font-size: 10px">
                                            - ${json.registration.status} - ${json.registration.payed} €
                                        </span>
                                       <div class="with-icon"> 
                                            <i class="material-icons">edit</i>
                                       </div> 
                                  </p>
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

                    $('html, body').animate({
                        scrollTop: $('#idRegistration'+json.registration.registrationId).offset().top
                    }, 0);

                    
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
    let invoiceId = $("#lastIdInvoice").val();

    $('#showInvoice').show('slow');

    let url = `${urlHost}invoice/display/id/${invoiceId}/`;

    $('#showInvoice').load(url);

    let topPos = (window.pageYOffset);
    $('#showInvoice').css({top:topPos});


};

const closeInvoice = () => {
    $('#showInvoice').hide();
    console.log('hide');
}


/*** UPDATE REGISTRATION, CHILDPRESENCE, TRANSPORT **/

const updateData = (partData) => {
    
    let from = $('#'+partData+'From').val();
    let to = $('#'+partData+'To').val();
    let childId = $('#childId').val();

    let url = urlHost+"child/reloadAjax/partData/"+partData+"/childId/"+childId+"/from/"+from+"/to/"+to+"/";

    $("#"+partData+"List").load(url);

}


