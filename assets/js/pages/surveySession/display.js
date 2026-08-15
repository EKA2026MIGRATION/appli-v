
var sendSurvey = (id, email, url, firstname, date) => {
    $.ajax({
        type: "POST",
        url: $("#urlHost").val() + 'sendMailSurvey',
        data: { email, url, firstname, date },
        dataType: "json",
        beforeSend() {
            
        },
        success(json) {
            toastr.success("L'email a bien été envoyé");
            let data = { status: 'send' };

            $.ajax({
                type: "POST",
                url: urlRequest,
                data: { type, url: 'surveySession/modify/' + id, data },
                dataType: "json",
                beforeSend() {
                },
                success(json) {
                    setTimeout(() => {
                        window.location.reload();
                      }, 2000);
                }
            });
        }
    });     
}
