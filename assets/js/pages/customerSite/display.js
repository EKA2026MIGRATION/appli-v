const deleteDate = data => {
    let idDate = $(data).data('id');

    swal({
        title: "Attention",
        text: "La suppression est irréversible.",
        type: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showCancelButton: true
    }).then(result => {
        if (result.value) {
            deleteDateSubmit(idDate);
        }
    });
};


var deleteDateSubmit = idDate => {
    let url = `product-cancelled-date/delete/${idDate}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {},
        success(json) {
            if (json.status == true) {
                toastr.success(json.message, 'Suppression');
                        $(`[data-id=${idDate}]`)
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


$(() => {

    $("#date_cancelled").datepicker({
        altField: "#datepicker",
        altFormat: "yy-mm-dd",
        closeText: "Fermer",
        prevText: "Précédent",
        nextText: "Suivant",
        firstDay: 1,
        yearRange: "-2:+2",
        currentText: "Aujourd'hui",
        monthNames: [
            "Janvier",
            "Février",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Août",
            "Septembre",
            "Octobre",
            "Novembre",
            "Décembre"
        ],
        monthNamesShort: [
            "Janv.",
            "Févr.",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juil.",
            "Août",
            "Sept.",
            "Oct.",
            "Nov.",
            "Déc."
        ],
        dayNames: [
            "Dimanche",
            "Lundi",
            "Mardi",
            "Mercredi",
            "Jeudi",
            "Vendredi",
            "Samedi"
        ],
        dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
        dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
        weekHeader: "Sem.",
        dateFormat: "dd/mm/yy",
        changeYear: true
    });

});


$("#selectProduct").change(() => {
  
  let idProduct = $("#selectProduct").find(':selected').val();

  let url = `product/display/${idProduct}`;

  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type: "GET", url },
    dataType: "json",
    beforeSend() {},
    success(json) {

        $("#category").val(json.categories[0].categoryId);

    }
  });

});


document.getElementById('inscriptionClosedForm').addEventListener('submit', event => {

    event.preventDefault();
    let form = $("#inscriptionClosedForm");
    let url = form.attr("action");
    let data = $(form).serializeToJSON();
    let type = "POST";

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: {type, url, data},
        dataType: "json",
        beforeSend() {
            $("#dateForm [type=submit]")
                .attr("disabled", true)
                .attr("value", "Envoi en cours..");
        },
        success(json) {
            if (json.status == true) {
                $("#addDateCancelled").foundation("close");
                toastr.success(json.message, 'Confirmation');
            }
        }
    })



});


document.getElementById("dateForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#dateForm");
        let url = form.attr("action");
        let data = $(form).serializeToJSON();
        let type = "POST";
        
        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data },
            dataType: "json",
            beforeSend() {
                $("#dateForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#dateForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {
                    $("#addDateCancelled").foundation("close");
                    toastr.success(json.message, 'Confirmation');

                    const newDate =
                            `    
                                    <a href="javascript:void(0)" data-id="${json.productCancelledDate.productCancelledDateId}" onclick="deleteDate(this)">
                                      <div>
                                        <p class="list-header"  style="padding-left: 0; margin-left: -15px;">
                                       
                                          ${json.productCancelledDate.date} -  - ${json.productCancelledDate.messageFr}
                                          
                                          <div class="with-icon">
                                            <i class="material-icons">send</i>
                                          </div>
                                        </p> 
                                      </div>
                                    </a>
                                  `;
               
                        $("#productDateCancelledList").append(
                            `<li>
                                ${newDate}
                            </li>`
                        );
                    

                } else {
                    $("#createVehicle").foundation("close");
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