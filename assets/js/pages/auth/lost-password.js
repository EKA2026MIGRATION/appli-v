document.getElementById("lostPassWordForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();

        let form = $("#lostPassWordForm");
        let email = $("[name=email]").val();
        let data = JSON.stringify({ email });

        
        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            contentType: "application/json",
            contentLength: data.length,
            crossDomain: true,
            dataType: "json",
            data,
            beforeSend() {
                $("#lostPassWordForm [type=submit]")
                    .attr("disabled", true);
            },
            success(data) {
                $("#lostPassWordForm [type=submit]")
                    .attr("disabled", false);
                if(data.token != null)
                {


                      $.ajax({
                        type: "POST",
                        url: $("#urlHost").val() + 'sendMailLostPassword',
                        data: { token: data.token, validity: data.validity, email },
                        dataType: "json",
                        beforeSend() {
                            
                        },
                        success(json) {
                            toastr.success('Un email vous a été envoyé.');
                        }
                    });       
                 }
                 else
                 {
                    toastr.error('Une erreur est survenue.');
                 }


            },
            error(data) {
                $("#lostPassWordForm [type=submit]")
                    .attr("disabled", false);

            }
        }); 
    },
    false
);
