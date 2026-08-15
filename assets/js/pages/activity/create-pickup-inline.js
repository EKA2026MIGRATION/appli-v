const changeActionPickupActivity = () => {
    $("#pickupActivityForm").attr("action", "pickup-activity/create");
    $("#pickupActivityForm").trigger("reset");
    $("#autocompleteChild").attr('disabled', false);
};

document.getElementById("pickupActivityForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#pickupActivityForm");
        let url = form.attr("action");
        const idGroup = $("#groupActivitySelect").val();
        const dataGroup = [];

        let type = "POST";
        let data = $(form).serializeToJSON();

        if (url.includes("modify")) {
            type = "PUT";
        }

        if (null != idGroup){
                dataGroup.push({ groupActivityId: idGroup });
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data, links: dataGroup },
            dataType: "json",
            beforeSend() {
                $("#pickupActivityForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {


                if($('#addPresence').is(':checked')) {
                  let child = $("#formChildId").val();
                  let person = 0;
                  let registration = '';
                  let date = $("#datePickupActivity").val();
                  let sessionStart = $("#start_pickup_2").val();
                  let sessionEnd = $("#end_pickup_2").val();
                  let location = $("#selectLocationPickup").val();


                  let data4 = [];
                  data4.push({child, person, registration, date, location, start: sessionStart, end: sessionEnd});  
                  let url3 = "child/presence/create";
                  $.ajax({
                    type: "POST",
                    url: urlRequest,
                    data: { url: url3, type:'POST', data: data4 },
                    dataType: "json",
                    beforeSend() {

                    },
                    success(json2) {

                    }
                  });


                }

                location.reload();
                $("#pickupActivityForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {
                    toastr.success(json.message, 'Confirmation');


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



/*--- JS for pickup  ---*/

$("#start_pickup").change(() => {
    const time = $("#start_pickup").val();

    if (time.length == 5) {
        $("#start_pickup_2").val(`${time}:00`);
    }
});

$("#end_pickup").change(() => {
    const time = $("#end_pickup").val();

    if (time.length == 5) {
        $("#end_pickup_2").val(`${time}:00`);
    }
});

const goToProfilChild = () => {
    const idPickUp = $("#lastIdPickup").val();
    const idChild = $(`[data-id-pickup=${idPickUp}]`)
        .find("img")
        .attr("data-id-child");

    openRevealJS('reveal-iframe');

    $(".frameFullScreen").attr(
        "src",
        `${urlHost}child/display/id/${idChild}/iframe/yes/`
    );
};


