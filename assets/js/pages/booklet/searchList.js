$("#refDate").datepicker({
    altField: "#datepicker",
    altFormat: "yy-mm-dd",
    closeText: "Fermer",
    prevText: "Précédent",
    nextText: "Suivant",
    firstDay: 1,
    yearRange: "-20:+0",
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
    changeYear: true,
    maxDate: "+6m"
});


$('#refDate').change(function() {
    let refDate = $('#datepicker').val();
    location.href = `${urlHost}booklet/searchList/date/${refDate}/`;

})

$('.spanValidButton').click(function() {
    let refid = $(this).attr('data-refid');

    let childId = $(this).attr('data-childid');
    let bookletId = $('#select-booklet-'+refid).val();
    let staffId = $('#select-staff-'+refid).val();

    if( staffId != "" && bookletId != "" && childId != "") {
        let url = `${urlHost}booklet/createBookletChild/childId/${childId}/bookletId/${bookletId}/staffId/${staffId}/`;
        $('#test').load(url, function() {
            toastr.success("Livret créé");
        });

    }

})