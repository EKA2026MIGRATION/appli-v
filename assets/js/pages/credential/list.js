$('.checkboxCredential').click(function() {
    let profil = $(this).attr('data-profil');
    let credentialId = $(this).val();
    let checked;
    if( $(this).is(":checked") ) {
        checked = "checked";
    }  else {
        checked = "unchecked";
    }
    
    let data = '';


    let url = $("#urlApi").val() + 'credential/updateRole/' + profil + '/'+credentialId+'/'+checked;

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
              toastr.success("Droit mis à jour");
        }, success(data) {
           console.log(data);
        }, error(data) {
            console.log("error");
        }
    });
})