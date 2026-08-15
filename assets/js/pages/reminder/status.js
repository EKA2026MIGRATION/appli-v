/*********** REMINDER */

$('.tagReminder').click(function() {
    let status = $(this).attr('data-status');
    let reminderId = $(this).attr('data-id');

    let oldTag = colorTag[status];

    let data = '';

    let url = $("#urlApi").val() + 'reminder/nextStatus/' + reminderId;

    $.ajax({
        url: url,
        type: 'GET',
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
              toastr.success("Rappel mis à jour");

              let newStatus = data.status;

              let newTag  = colorTag[data.status];
              let newText = colorText[data.status];

              $('#reminderTag-'+reminderId).removeClass(oldTag);
              $('#reminderTag-'+reminderId).addClass(newTag);

              $('#reminderTag-'+reminderId).attr('data-status', data.status);

              $('#reminderTag-'+reminderId).text(newText);

        }, error(data) {
            console.log("error");
        }
    });

})