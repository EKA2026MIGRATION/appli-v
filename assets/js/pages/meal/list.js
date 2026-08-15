const openDatePicker = () => {
    $("#datePickerInline").datepicker({
        closeText: "Fermer",
        prevText: "Précédent",
        nextText: "Suivant",
        firstDay: 1,
        yearRange: "-5:+0",
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
        dateFormat: "yy-mm-dd",
        changeYear: true,
        onSelect(dateText) { //TODO mettre nouveau système reload (cf dispatch)
            $(".loading").show();
            location.href = `${urlHost}meal/list/date/${dateText}/`;
        }
    });
};

const addClass = data => {
    if ($(data).hasClass("asso-food") === true) {
        $(data).removeAttr("checked");
    } else {
        $(data).attr("checked");
    }
    $(data).toggleClass("asso-food");
};

document.getElementById("mealForm").addEventListener(
    "submit",
    event => {

        event.preventDefault();
        var form = $("#mealForm");
        var url = form.attr("action");
        const dataRelation = [];
        let i = 0;

        $(".food_associated")
            .find(".asso-food")
            .each(function() {
                const idFood = $(this).attr("value");
                dataRelation[i] = { foodId: idFood };
                i++;
            });

        var data = $(form).serializeToJSON();
        var type = "POST";

        if (url.includes("modify")) {
            type = "PUT";
        } else {
            type = "POST";
        }



        $.ajax({
            type: type,
            url: urlRequest,
            data: { url, type, data, links: dataRelation },
            dataType: "json",
            success(json) {
                if (json.status == true) {
                    swal({
                        title: "Confirmation",
                        text: json.message,
                        type: "success",
                        confirmButtonText: "Afficher le repas",
                        cancelButtonText: "Fermer",
                        showCancelButton: true
                    }).then(result => {
                        if (result.value) {
                            location.href = `${urlHost}meal/display/id/${json.meal.mealId}/`;
                        }
                    });
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
