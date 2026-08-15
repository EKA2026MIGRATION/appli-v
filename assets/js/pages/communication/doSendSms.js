$( document ).ready(function() {

    let statusMessage = [];
    statusMessage[0]  = "Le message n'a pas encore été envoyé";
    statusMessage[1]  = "Le message a été envoyé mais l'accusé de réception n'est pas encore disponible";
    statusMessage[2]  = "Le message a été envoyé mais il n'a pas été délivré";
    statusMessage[3]  = "Le message a été envoyé et délivré";
    statusMessage[4]  = "Le message a été envoyé mais n'est pas autorisé à être délivré";
    statusMessage[5]  = "La destination est invalide";
    statusMessage[6]  = "Le sender est invalide";
    statusMessage[7]  = "La route n'est pas disponible";
    statusMessage[9]  = "Le message a été rejeté";
    statusMessage[11] = "Le message n'a pas été délivré à cause d'une erreur réseau";
    statusMessage[12] = "Le message a été envoyé mais l'accusé de réception a expiré";

    const sendSms = (tel, phoneId) => {

        let message = $('#messageToSend').val();
        let signature = $('#signatureToSend').val();
        let isUnicode = $('#isUnicode').val();
        let url = urlHost+"communication/updateDoSend/";

        $.ajax({
          type: "POST",
          url: urlSendSMSFactor,
          data: {number: tel, message:message, signature:signature, isUnicode:isUnicode},
          dataType: "json",
          beforeSend() {
          },
          success(json) {
            $('#statusSent-'+phoneId).html(statusMessage[json.status]);
            if(json.message == "OK") {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {historicSmsListId: phoneId},
                    dataType: "json",
                    beforeSend() {
                    },
                    success(jsonResult) {
                        $('#iconSend-'+phoneId).show();
                    }
                })
            }
          }
        })
    };
    
    $('.phoneNumber').each(function() {
        let element = $(this);
        let phoneNumber = element.data('phonenumber');
        let phoneId = element.data('phoneid');

        if(phoneNumber != "end") {
            console.log('send sms test');
            sendSms(phoneNumber, phoneId);
        } else {
            console.log('fin de liste');
            $('#loadSpinnerSendSms').hide();
        }

    })

})







