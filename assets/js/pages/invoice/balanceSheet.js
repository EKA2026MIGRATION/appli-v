$("#date_invoice1").datepicker({
    altField: "#datepicker1",
    altFormat: "yy-mm-dd",
    firstDay: 1,
    yearRange: "-5:+0",
    closeText: "Fermer",
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
    changeYear: true
});


$("#date_invoice2").datepicker({
    altField: "#datepicker2",
    altFormat: "yy-mm-dd",
    closeText: "Fermer",
    firstDay: 1,
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
    changeYear: true
});

let dateStart, dateEnd, modePayment;


$('#exportPdf').click(function(e) {
    e.preventDefault();
    dateStart   = $('#datepicker1').val();
    dateEnd     = $('#datepicker2').val();
    modePayment = $('#modePayment').val();
    url = $(this).attr('href');
    url = url+`/dateStart/${dateStart}/dateEnd/${dateEnd}/modePayement/${modePayment}/`;
    window.open(url, "_blank");
})

$('#exportExcel').click(function(e) {
    e.preventDefault();
    dateStart   = $('#datepicker1').val();
    dateEnd     = $('#datepicker2').val();
    modePayment = $('#modePayment').val();
    url = $(this).attr('href');
    url = url+`/dateStart/${dateStart}/dateEnd/${dateEnd}/modePayement/${modePayment}/`;
    window.open(url, '_blank');
})