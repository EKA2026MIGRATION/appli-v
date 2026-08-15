document.getElementById("addReminder").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#addReminder");
        let url = form.attr("action");
        let type = "POST";
        let data = $(form).serializeToJSON();


        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data },
            dataType: "json",
            beforeSend() {
                $("#addReminder [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                toastr.success(json.message, 'Essence ajoutée');
                $("#addReminder [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");
            }
        });
    },
    false
);

$("#name").change(() => {
    const name = $("#name").val();
  
    if (name == 'Effectuer le contrôle technique') {
        $("#criteria").val('date');
        $("#criteria").change();
    } else {
        $("#criteria").val('km');
        $("#criteria").change();
    }
  });

  $("#criteria").change(() => {
    const criteria = $("#criteria").val();
    if (criteria == 'km') {
        $("#labelCriteriaValue").html('Kilométrage du rappel');
        $("#criteriaValue").attr('type', 'number');
    } else {
        $("#labelCriteriaValue").html('Date du rappel');
        $("#criteriaValue").attr('type', 'date');
    }
  });
  