/*
Autocomplete for child
 */

let autoreturn = $('#autoreturn').val();
let returnUrl;
if(autoreturn == 1) {
  returnUrl = $('#autoreturnUrl').val();
}


document.getElementById("autocompleteListChild").addEventListener(
    "keyup",
    function(event) {
        let searchTerm = $(this).val();
        let url = `child/search/${searchTerm}`;

        $("#autocompleteListChild").autocomplete({
            minLength: 2,
            source(request, response) {
                $.ajax({
                    type: "POST",
                    url: urlRequest,
                    data: { url, type: "GET" },
                    dataType: "json",

                    success(data) {
                        response(
                            $.map(data, child => ({
                                label: `${child.firstname} ${child.lastname}`,
                                value: child.childId
                            }))
                        );
                    }
                });
            },
            select(data, child) {
                $("#childId").val(child.item.value);
                $("#autocompleteListChild").val(child.item.label);
                $("#autocompleteListPerson").val('');
                $("#personId").val('');
                $("#selectStaff").val('');
                $("#freeName").val('');

                return false;
            },
            change(data, child) {
                 //TODO essayer de trouver système plus fluide pour affichage du nom
            }
        });
    },
    false
);

/*
Autocomplete for person
 */
document.getElementById("autocompleteListPerson").addEventListener(
    "keyup",
    function(event) {
        let searchTerm = $(this).val();
        let url = `person/search/${searchTerm}`;

        $("#autocompleteListPerson").autocomplete({
            minLength: 2,
            source(request, response) {
                $.ajax({
                    type: "POST",
                    url: urlRequest,
                    data: { url, type: "GET" },
                    dataType: "json",

                    success(data) {
                        response(
                            $.map(data, person => ({
                                label: `${person.firstname} ${person.lastname}`,
                                value: person.personId
                            }))
                        );
                    }
                });
            },
            select(data, person) {
                $("#personId").val(person.item.value);
                $("#autocompleteListPerson").val(person.item.label);
                $("#autocompleteListChild").val('');
                $("#childId").val('');
                $("#selectStaff").val('');
                $("#freeName").val('');


                return false;
            },
            change(data, person) {

            }
        });
    },
    false
);

document.getElementById("freeName").addEventListener(
    "click",
    event => {

        $("#personId").val('');
        $("#autocompleteListPerson").val('');
        $("#autocompleteListChild").val('');
        $("#childId").val('');
        $("#selectStaff").val('');

    },
    false
);

const changeStaff = () => {
    if($('#useStaff').is(':checked')) {
        var idPerson = $("#selectStaff").find(':selected').val();
        $("#personId").val(idPerson);
        $("#autocompleteListPerson").val('');
        $("#autocompleteListChild").val('');
        $("#childId").val('');      
    } else {
        $("#personId").val('');
        $("#autocompleteListPerson").val('');
        $("#autocompleteListChild").val('');
        $("#childId").val('');
    }

}
/*
$("#selectStaff").change(() => {
    var idPerson = $("#selectStaff").find(':selected').val();
    $("#personId").val(idPerson);
    $("#autocompleteListPerson").val('');
    $("#autocompleteListChild").val('');
    $("#childId").val('');
});
*/


$(() => {
    $("#datepicker").datepicker({
        altField: "#date",
        altFormat: "yy-mm-dd",
        closeText: "Fermer",
        firstDay: 1,
        yearRange: "-5:+0",
        prevText: "Précédent",
        nextText: "Suivant",
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
        gotoCurrent: true,
        changeYear: true,
        minDate: new Date()
    });
});

document.getElementById("mealForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#mealForm");
        let url = form.attr("action");
        const dataRelation = [];
        let i = 0;

        $(".food_associated")
            .find(".asso-food")
            .each(function() {
                const idFood = $(this).attr("value");
                dataRelation[i] = { foodId: idFood };
                i++;
            });

        let data = $(form).serializeToJSON();
        let type = "POST";

        if (url.includes("modify")) {
            type = "PUT";
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type, data, links: dataRelation },
            dataType: "json",

            success(json) {

                if (json.status == true) {

                  if(autoreturn == 1) {
                      
                      swal({
                          title: "Confirmation",
                          text: json.message,
                          type: "success",
                          confirmButtonText: "Retour",
                          cancelButtonText: "Fermer",
                          showCancelButton: true
                      }).then(result => {
                          if (result.value) {
                              location.href = returnUrl;
                          }
                      });
                  } else {
                      swal({
                          title: "Confirmation",
                          text: json.message,
                          type: "success",
                          confirmButtonText: "Afficher le repas",
                          cancelButtonText: "Fermer",
                          showCancelButton: true
                      }).then(result => {
                          if (result.value) {
                              //location.href = `${urlHost}meal/display/id/${json.meal.mealId}/`;
                          }
                      });
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

const deleteMeal = data => {
    let id = $(data).attr("data-id");
    $(`[data-id-meal='${id}']`)
        .addClass("animated bounceOutUp")
        .delay(750)
        .hide(0);
};

const addClass = data => {
    if ($(data).hasClass("asso-food") === true) {
        $(data).removeAttr("checked");
    } else {
        $(data).attr("checked");
    }
    $(data).toggleClass("asso-food");
};
