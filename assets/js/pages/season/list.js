let lastIdWeek;
document.getElementById("loadMoreSeason").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");
        const pageSuivante = page + 1;
        const url = `season/list?page=${pageSuivante}&size=${size}`;

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

                        $("#seasonList").append(
                                `<header data-id-season="${json[i].seasonId}">
                                        <i class="material-icons arrow">keyboard_arrow_up</i>  ${
                                    json[i].name}
                                        <div class="icons_trajet">
                                            <a href="javascript:void(0)" onclick="getIdSeason(\'${
                                    json[i].seasonId}\')" data-open="action-season" >
                                                <i class="material-icons">edit</i>
                                            </a>
                                        </div>
                                    </header>`
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


const format = date => {
  var date_string = date.split('-').join('-');
  var date = new Date(date_string);
  return ((date.getDate()).toString().length > 1 ? date.getDate()  : '0'+ (date.getDate()) )+'/'+ ((date.getMonth()) > 8 ? date.getMonth() + 1 : '0'+ (date.getMonth() + 1 ) ) + '/' + date.getFullYear()  ;
}



const editSeason = () => {

    let idSeason = $("#lastIdSeason").val();
    let url = `season/display/${idSeason}`;


    $("#seasonForm").attr("action", `season/modify/${idSeason}`);

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "GET", url },
        dataType: "json",
        beforeSend() {
            $("#loaderFormEditSeason").show();
        },
        success(json) {
            $("#loaderFormEditSeason").hide();

            $("#seasonForm")
                .find("input")
                .each(function() {
                    const name = $(this).attr("name");
                    $(this).val(json[name]);
                });

            $("#datepickerStart").val(format(json.dateStart));
            $("#datepickerEnd").val(format(json.dateEnd));
        }
    });
};


const getIdSeason = idSeason => {
    $("#lastIdSeason").val(idSeason);
};

const deleteSeason = () => {
    let idSeason = $("#lastIdSeason").val();

    swal({
        title: "Attention",
        text: "La suppression est irréversible.",
        type: "warning",
        confirmButtonText: "Supprimer",
        cancelButtonText: "Annuler",
        showCancelButton: true
    }).then(result => {
        if (result.value) {
            deleteSeasonSubmit(idSeason);
        }
    });
};

var deleteSeasonSubmit = idSeason => {
    let url = `season/delete/${idSeason}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {},
        success(json) {
            if (json.status == true) {
                toastr.success(json.message, 'Suppression');

                $(`[data-id-season=${idSeason}]`)
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



document.getElementById("seasonForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#seasonForm");
        let url = form.attr("action");
        let type = "POST";
        let data = $(form).serializeToJSON();

        if (url.includes("modify")) {
            type = "PUT";
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data },
            dataType: "json",
            beforeSend() {
                $("#seasonForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#seasonForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {
                    $("#createSeason").foundation("close");
                    toastr.success(json.message, 'Confirmation');
                        if (url.includes("modify")) {
                            $(`[data-id-season=${json.season.seasonId}]`).html(`<i class="material-icons arrow">keyboard_arrow_up</i>  ${
                                json.season.name}
                                <div class="icons_trajet">
                                    <a href="javascript:void(0)" onclick="getIdSeason(\'${
                                    json.season.seasonId}\')" data-open="action-season" >
                                        <i class="material-icons">edit</i>
                                    </a>
                                </div>`
                            )
                        }
                        else {
                            $(`[data-id-season=${json.season.seasonId}]`).remove();
                            $("#seasonList").append(
                                `<header data-id-season="${json.season.seasonId}">
                                    <i class="material-icons arrow">keyboard_arrow_up</i>  ${
                                    json.season.name}
                                    <div class="icons_trajet">
                                        <a href="javascript:void(0)" onclick="getIdSeason(\'${
                                        json.season.seasonId}\')" data-open="action-season" >
                                            <i class="material-icons">edit</i>
                                        </a>
                                    </div>
                                </header>`
                            );
                        }
                } else {
                    $("#createSeason").foundation("close");
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

const changeActionSeason = () => {
    $("#seasonForm").attr("action", "season/create");
    $("#seasonForm").trigger("reset");
};
$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
$.datepicker.setDefaults({
    gotoCurrent: true,
    changeYear: true,
    firstDay: 1,
    closeText: "Fermer",
    currentText: "Aujourd'hui",
    prevText: "Précédent",
    nextText: "Suivant",
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
    altFormat: "yy-mm-dd",
});
$(() => {
    $("#datepickerStart").datepicker({
        altField: "#dateStart",
    });
});

$(() => {
    $("#datepickerEnd").datepicker({
        altField: "#dateEnd",
        altFormat: "yy-mm-dd",
    });
});

$(() => {
    $("#weekDatepickerStart").datepicker({
        altField: "#weekDateStart",
    });
});

$(".block-list div header i.arrow").click(function() {
    let element = $(this)
        .parent()
        .next("ul");

    if (
        $(element)
            .find("li")
            .css("display") == "none"
    ) {
        $(element)
            .find("li")
            .show();
        $(element)
            .find("div")
            .show();
        $(this).html("keyboard_arrow_up");
    } else {
        $(element)
            .find("li")
            .hide();
        $(element)
            .find("div")
            .hide();
        $(this).html("keyboard_arrow_down");
    }
});

/* PART FOR WEEKS */


const formatName = () => {
    var name_string = $("#weekName").val().split(' ');
    return name_string[0];
}

const formatNumber = () => {
    var name_string = $("#weekName").val().split(' ');
    return name_string[1];
}


const editWeek = idWeeks => {

    $("#lastIdWeek").val(idWeeks);
    let idWeek = $("#lastIdWeek").val();
    let url = `week/display/${idWeeks}`;

    $("#weekForm").attr("action", `week/modify/${idWeeks}`);

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type: "GET", url },
        dataType: "json",
        beforeSend() {
            $("#loaderFormEditWeek").show();
        },
        success(json) {
            $("#loaderFormEditWeek").hide();


            console.log(json);

            const inputs = $("input, select").not(
                ":input[type=button], :input[type=submit], :input[type=reset]"
            );

            $("#weekForm")
                .find(inputs)
                .each(function() {
                    const name = $(this).attr("name");
                    $(this).val(json[name]);
                    if ('season' === name){
                        $(this).val(json.season.name);
                    }
                })

            $("#weekDatepickerStart").val(format(json.dateStart));
            $("#weekNameSelect").val(formatName(json.name));
            $("#weekNumber").val(formatNumber(json.name));
        }
    });
};


const getIdWeek = idWeek => {
    $("#lastIdWeek").val(idWeek);

    lastIdWeek = idWeek;
};


document.getElementById("weekForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();

        var name_string = $("#weekName").val().split(' ');
        let weekNameSelect = $("#weekNameSelect").val();
        let weekNumber = $("#weekNumber").val();
        let newWeekName = weekNameSelect.concat(' ', weekNumber);

        if (name_string !== newWeekName) {
            $("#weekName").val(newWeekName);
        }

        let form = $("#weekForm");
        let url = form.attr("action");
        let type = "POST";
        let data = $(form).serializeToJSON();

        if (url.includes("modify")) {
            type = "PUT";
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data },
            dataType: "json",
            beforeSend() {
                $("#weekForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#weekForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {
                    $("#createWeek").foundation("close");
                        toastr.success(json.message, 'Confirmation');


                        $(`[data-id-week=${json.week.weekId}]`).html(`<a href="javascript:void(0)" onclick="editWeek(\`${
                            json.week.weekId
                            }\`)" data-open="createWeek"><div><p class="list-header second-row">${
                            json.week.code
                            } - ${json.week.name}<aside class="subtitles"></aside><div class="with-icon"> <i class="material-icons">edit</i></div> </p>  </div> </a>`);

                } else {
                    $("#createWeek").foundation("close");
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


