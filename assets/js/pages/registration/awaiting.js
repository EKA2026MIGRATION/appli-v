const urlApi = $('#urlApi').val();


$('.changeStatusButton').click(function(e) {
    let x = e.pageX
    let y = e.pageY;
    let registrationid = $(this).attr('id').split('-')[1];
    let amount = $(this).attr('id').split('-')[2];
    $('#registrationId').val(registrationid);
    $('#amountPayment').val(amount);
    $('#validationForm').css({'position': 'absolute', 'top': y-100, 'left' : x-800});
    $('#validationForm').toggle();
})


$('#closeValidationForm').click(function() {
    $('#validationForm').toggle();
})



$('.validNewStatus').click(function(e) {
    e.preventDefault();

    let validationType = $('#validationType').val();
    let validationInfo = $('#validationInfo').val();
    let registrationid = $('#registrationId').val();
    let amount         = $('#amountPayment').val();
    let status         = $('#validationStatus').val();

    let url = urlApi + 'registration/updateStatus';
    let data = {registrationid : registrationid, type : validationType, info : validationInfo, amount: amount, status: status};
    data = JSON.stringify(data);

    $.ajax({
        url: url,
        type: 'POST',
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

            // remove row
            $('#liChild-'+registrationid).hide();
            $('#validationForm').toggle();

        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });
})

$('#validateAll').click(function() {
    $('#confirmationModal').show();
});

$('#confirmValidation').click(function() {
    let selectedRegistrations = [];
    $('.registration-checkbox:checked').each(function() {
        selectedRegistrations.push($(this).data('id'));
    });

    if (selectedRegistrations.length > 0) {
        let url = urlApi + 'registration/bulkUpdateStatus';
        let data = { registrationIds: selectedRegistrations, status: 'payed' };
        data = JSON.stringify(data);

        $.ajax({
            url: url,
            type: 'POST',
            contentType: "application/json",
            headers: {
                'Authorization': 'Bearer ' + tokenAuth
            },
            data,
            success(data) {
                selectedRegistrations.forEach(function(id) {
                    $('#liChild-' + id).hide();
                });
                $('#confirmationModal').hide();
            },
            error(data) {
                console.log("error");
                console.log(data);
            }
        });
    } else {
        alert("Veuillez sélectionner au moins une inscription.");
        $('#confirmationModal').hide();
    }
});
