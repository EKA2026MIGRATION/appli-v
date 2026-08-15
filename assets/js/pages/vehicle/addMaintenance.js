const addActionMaintenance = () => {
    const action = $("#action").val();
    const prix = $("#prix_m").val();
    const action_qty = $("#action_qty").val();
    const action_type = $("#action_type").val();
    if (prix != "" && action != ""  && action_qty != ""  && action_type != "") {
        $("#resultActionMaintenance").append(
            `<div style="position:relative; width:100%;" data-prix=${prix} data-action_qty=${action_qty} data-action_type=${action_type} data-action=${action}>Quantité : ${action_qty} | Action type : ${action_type} | Action : ${action} | Prix : ${prix} <a href="javascript:void(0)" onclick="deleteActionMaintenance(this)" style="top: -1px; right: 0px; position: absolute;"><i class="material-icons">close</i></a> </div>`
        );

        $("#prix_total").val(parseInt($("#prix_total").val()) + parseInt(prix));
    } else { //TODO vérifier le swal >>> plutôt en toast
        swal({
            title: "Attention",
            text: "Le formulaire est incomplet.",
            type: "warning",
            showCancelButton: false
        }).then(result => {});
    }
};

const deleteActionMaintenance = element => {

    const prix = $(element).parent("div").attr('data-prix');
    $("#prix_total").val(parseInt($("#prix_total").val()) - parseInt(prix));

    $(element)
        .parent("div")
        .addClass("animated flipOutY")
        .delay(750)
        .remove(0);
};

document.getElementById("addMaintenanceForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#addMaintenanceForm");
        let url = form.attr("action");
        let type = "POST";
        var staff_id = $("#staff_id_maintenance").val();  
        var vehicle_id = $("#vehicule_id_maintenance").val();
        var date_action = $("#date_maintenance").val(); 
        var mileage = $("#km_maintenance").val(); 
        

        $("#resultActionMaintenance")
          .find("div")
          .each(function() {

            let action_type = $(this).attr('data-action_type');
            let action_name = $(this).attr('data-action');
            let amount = $(this).attr('data-prix');
            let quantity = $(this).attr('data-action_qty');
            
            let data = {staff_id, vehicle_id, mileage, date_action, action_type, action_name, amount, quantity};

            $.ajax({
                type: "POST",
                url: urlRequest,
                data: { type, url, data},
                dataType: "json",
                beforeSend() {
                    $("#checkVehicleForm [type=submit]")
                        .attr("disabled", true)
                        .attr("value", "Envoyer");
                },
                success(json) {
                    toastr.success(json.message, 'Actions de maintenance ajoutées');
                    $("#checkVehicleForm [type=submit]")
                        .attr("disabled", false)
                        .attr("value", "Envoyer");

                }
            });


          });


    },
    false
);