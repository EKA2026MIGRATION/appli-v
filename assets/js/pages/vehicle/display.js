$('.deleteElementButton').click(function() {
    let type      = $(this).attr('data-type');
    let elementid = $(this).attr('data-elementid');

    let data = '';

    let url = $("#urlApi").val() + 'vehicle/remove/' + type + '/' +elementid;

    $.ajax({
        url: url,
        type: 'DELETE',
        contentType: "application/json",
        headers: {
            'Authorization':'Bearer ' + tokenAuth
        },
        contentLength: data.length,
        crossDomain: true,
        dataType: "json",
        data,
        beforeSend() {

        }, success(data) {
           $('#'+type+'-'+elementid).remove();
        }, error(data) {
          
        }
    });


})


// deleteVehicleButton

$('.deleteVehicleButton').click(function() {
    let vehicleid = $(this).attr('data-vehicleid');

    let data = '';

    let url = $("#urlApi").val() + 'vehicle/delete/' +vehicleid;

    // add confirmation dialog
    if (!confirm('Voulez-vous supprimer ce véhicule ?')) {
        return
    } else {
        $.ajax({
            url: url,
            type: 'DELETE',
            contentType: "application/json",
            headers: {
                'Authorization':'Bearer ' + tokenAuth
            },
            contentLength: data.length,
            crossDomain: true,
            dataType: "json",
            data,
            beforeSend() {

            }, success(data) {
                // redirect to vehicle list with relative url "vehicle/list" with the base urlHost
                window.location.href = $("#urlHost").val() + 'vehicle/list';
            }, error(data) {
                console.log(data);
            }
        });
    }
})