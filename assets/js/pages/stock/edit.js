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
    let quantity = document.getElementById('currentStock'+id).textContent;
    let url = urlApi + 'stockProduct/modify/'+id;
    let data = {currentStock: quantity};


    data = JSON.stringify(data);

    updateData(url, data, id);

    let element = $('#stockProductInfo_modifier_'+id);

    element.data('currentstock', quantity);

})

const cleanForm = () => {
    $('#stockProduct_id').val("");
    $('#stockProduct_name').val("");
    $('#stockProduct_unity').val("");
    $('#stockProduct_currentStock').val("");
    $('#stockProduct_minimumStock').val("");
    $('#stockProduct_restockLevel').val("");
    $('#stockProduct_conditioning').val("");
    $('#stockProduct_price').val("");
    $('#stockProduct_categoryid').val("");
}
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
            console.log(data);
            $('#validButton'+id).removeClass('needToSave');

        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });
};


$('#addNewStockProduct').click(function(e) {
    e.preventDefault();
    cleanForm();
    $('#editStockProduct').show();
    let topPos = (window.pageYOffset);
    $('#editStockProduct').css({top:topPos});

    $('#stockProduct_id').val(0);

    $('.page__container').addClass('mask');
})

$('#closeEditStockProduct').click(function() {
    $('#editStockProduct').hide();
})


$('.openDeleteStockProduct').click(function (e) {

    e.preventDefault();
    let id = $(this).data('id');
    let url = urlApi + 'stockProduct/modify/'+id;
    let data = {suppressed:1};
    data = JSON.stringify(data);
    updateData(url, data, id);




    $('#stockProductRow-'+id).hide();


});


$('.openEditStockProduct').click(function (e) {
    e.preventDefault();
    cleanForm();
    $('#editStockProduct').show();
    let topPos = (window.pageYOffset);
    $('#editStockProduct').css({top:topPos+20})


    let id = $(this).data('id');
    let name = $(this).data('name');
    let unity = $(this).data('unity');
    let currentstock = $(this).data('currentstock');
    let minimumstock = $(this).data('minimumstock');
    let conditioning = $(this).data('conditioning');
    let categoryid = $(this).data('categoryid');
    let price = $(this).data('price');
    let restocklevel = $(this).data('restocklevel');

    console.log(restocklevel);

    $('#stockProduct_id').val(id);
    $('#stockProduct_name').val(name);
    $('#stockProduct_unity').val(unity);
    $('#stockProduct_currentStock').val(currentstock);
    $('#stockProduct_minimumStock').val(minimumstock);
    $('#stockProduct_conditioning').val(conditioning);
    $('#stockProduct_price').val(price);
    $('#stockProduct_categoryid').val(categoryid);
    $('#stockProduct_restockLevel').val(restocklevel);


})

$('#submitStockProductForm').click(function(e) {
    e.preventDefault();


    let id = $('#stockProduct_id').val();
    let name = $('#stockProduct_name').val();
    let unity = $('#stockProduct_unity').val();
    let currentStock = $('#stockProduct_currentStock').val();
    let minimumStock = $('#stockProduct_minimumStock').val();
    let conditioning = $('#stockProduct_conditioning').val();
    let price = $('#stockProduct_price').val();
    let categoryid = $('#stockProduct_categoryid').val();
    let restocklevel = $("#stockProduct_restockLevel").val();



    let url = urlApi + 'stockProduct/modify/'+id;

    let data = {name: name, unity: unity, categoryid: categoryid, restockLevel: restocklevel, currentStock: currentStock, minimumStock: minimumStock, conditioning: conditioning, price: price};



    data = JSON.stringify(data);


    console.log(data);

    updateData(url, data, id);


    // update show
    $("#stockProductInfo_name_"+id).text(name);
    $("#stockProductInfo_conditioning_"+id).text(conditioning);
    $("#stockProductInfo_currentStock_"+id).text(currentStock);

    $("#stockProductInfo_unity_"+id).text(unity);

    // update modifier button
    let element = $('#stockProductInfo_modifier_'+id);

    element.data('name', name);
    element.data('unity', unity);
    element.data('currentstock', currentStock);
    element.data('minimumstock', minimumStock);
    element.data('conditioning', conditioning);
    element.data('price', price);
    element.data('restocklevel', restocklevel);


    $('#editStockProduct').hide();

})