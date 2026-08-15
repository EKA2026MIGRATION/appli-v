$('#chekckAllButton').click(function() {
    let value = $(this).val();
    let swap;
    let newValue;
    if( value == 0) {
        swap = true;
        newValue = 1;

    } else {
        swap = false;
        newValue = 0;
    }
    $('.activitysAssociated').each(function() {
        $(this).prop('checked', swap);
    })
    $('#chekckAllButton').val(newValue);
})