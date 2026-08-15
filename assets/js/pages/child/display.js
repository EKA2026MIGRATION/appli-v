
document
    .getElementById("deleteChild")
    .addEventListener("click", function(event) {
        const idChild = $(this).attr("data-id-child");

        swal({
            title: "Attention",
            text: "La suppression est irréversible.",
            type: "warning",
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler",
            showCancelButton: true
        }).then(result => {
            if (result.value) {
                deleteChild(idChild);
            }
        });
    });

var deleteChild = idChild => {
    let url = `child/delete/${idChild}`;


    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {
            $("#deleteChild")
                .attr("disabled", true)
                .html("Suppression en cours..");
        },
        success(json) {
            if (json.status == true) {
                swal({
                    title: "Suppression",
                    text: json.message,
                    type: "success",
                    confirmButtonText: "Retour à la liste",
                    showCancelButton: false
                }).then(result => {
                    if (result.value) {
                        location.href = `${urlHost}child/list`;
                    }
                });
            }
        }
    });
};

$('.removeLink').click(function(e) {

    e.preventDefault();
    const link = $(this).attr("data-link");
    const personId = $(this).attr('data-personId');
    let url = "child/removePerson/"+link;
    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "GET" },
        dataType: "json",
        beforeSend() {
            $("#deleteChild")
                .attr("disabled", true)
                .html("Suppression en cours..");
        },
        success(json) {
           $('#cardPerson-'+personId).remove();
        }
    });
})

$( document ).ready(function() {

    // check if there is a prefered tab in session
    let currentTab = sessionStorage.getItem('child-tab');    
    if(currentTab != null) {
       openTheTargetTab(currentTab);    
    }

    // follow the event onclick tab and set in sessio 
    $('.tab-href').click(function() {
        let target = $(this).attr('href');
        sessionStorage.setItem('child-tab', target);
    })

    function openTheTargetTab(targetTab) {
        $('.tabs-panel').each(function() {
            $(this).removeClass('is-active');
            let idTabPanel = $(this).attr('id');
            if(targetTab == "#"+idTabPanel) {
                $(this).addClass("is-active");
            }
        })

        $('.tabs-title').each(function() {
            $(this).removeClass('is-active');
            let tabHref = $(this).find('a');
            tabHref.attr('aria-selected', false);

            if( targetTab == tabHref.attr('href')) {
                tabHref.attr('aria-selected', true);
                $(this).addClass('is-active');
            }                  
        })
    }

});
$('.deleteRegistration').click(function() {


    let idRegistration = $(this).data('registrationid');
    console.log(idRegistration);

    let url = `registration/delete/${idRegistration}`;

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { url, type: "DELETE" },
        dataType: "json",
        beforeSend() {

        },
        success(json) {
            $('#regisrationLiId'+idRegistration).remove();
        }
    });

})
