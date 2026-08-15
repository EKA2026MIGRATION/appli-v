const urlApi = $('#urlApi').val();


$('.chevron').click(function() {

    let id = $(this).data('id');
    let sens = $(this).data('direction');
    let currentStock = document.getElementById('currentStock'+id).textContent;
    let newCurrentStock = 0;

    if(sens == "less") {
        newCurrentStock = parseInt(currentStock) - 1;
    } else {
        newCurrentStock = parseInt(currentStock) + 1;
    }

    if( currentStock != newCurrentStock) {
        $('#validButton'+id).addClass('needToSave');
    }


    document.getElementById('currentStock'+id).textContent = newCurrentStock;

})

$('.microButton').click(function(e) {

    e.preventDefault();

    let id = $(this).data('id');

    // quantity, quantity-target
    let quantity = $('#quantityProduct-'+id).val();
    let quantityTarget = $('#quantityTarget-'+id).val();

    let url = urlApi + 'stockOrder/update/'+id;
    let data = {quantity: quantity, quantityTarget: quantityTarget};


    data = JSON.stringify(data);

    updateData(url, data, id);

    // update line color

})


const updateData = (url, data, id) => {
    $.ajax({
        url: url,
        type: 'PUT',
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
            toastr.success("Saved");
            $('#validButton'+id).addClass('saved');

        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });
};
