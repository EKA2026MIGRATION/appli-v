const urlApi = $('#urlApi').val();

$(document).on('click', '.btn-free-email', function() {
    const userId = $(this).data('user-id');
    const email    = $(this).data('email');
    const $btn     = $(this);

    swal({
        title: 'Passer en _old ?',
        text: '"' + email + '" sera renommé en "' + email + '_old".\nCette action est irréversible.',
        type: 'warning',
        confirmButtonText: 'Confirmer',
        cancelButtonText: 'Annuler',
        showCancelButton: true
    }).then(result => {
        if (!result.value) return;

        $.ajax({
            url: urlApi + 'person/free-email/' + userId,
            type: 'POST',
            contentType: 'application/json',
            headers: { 'Authorization': 'Bearer ' + tokenAuth },
            success(data) {
                if (data.success) {
                    toastr.success(data.old_email + ' → ' + data.new_email);
                    $btn.closest('tr').find('td:nth-child(5)').text(data.new_email);
                    $btn.replaceWith('<span style="color:grey; font-style:italic;">Passé en _old</span>');
                } else {
                    toastr.error(data.message);
                }
            },
            error(xhr) {
                toastr.error('Erreur : ' + xhr.status + ' - ' + (xhr.responseJSON ? JSON.stringify(xhr.responseJSON) : xhr.responseText));
            }
        });
    });
});
