$('.locationBarButton').click(function() {
    $('.locationInformation').hide();
    let locationId = $(this).attr('id').split('-')[1];
    $(".locationBarButton").removeClass('locationIsActive');
    $(this).addClass('locationIsActive');
    $('.location'+locationId).show();


    // show line location


    // update total location



})