let allCheckbox;
let checkboxListChildHidden;

$('#addManuelButton').click(function() {
    let phoneNumber = $('#addManuel').val();
    addLinePhoneNumber(phoneNumber);
})

$('.contentSmsElement').on('input', function(){
    let contentText = $('#textSms').val();
    let signatureText = $('#signature').val();

    $('#textSmsLength').html(contentText.length);
    $('#signatureLength').html(signatureText.length);
    $('#totalLength').html(contentText.length+signatureText.length+'/140');

});

$('.selectListButton').change(function() {
    
    let type = $(this).data('type');
    let elementId = $(this).val();
    let url;

    $('#dialog').show();
    
    if(type == "listByProduct") {
        url = urlHost+"product/listChild/id/"+elementId+'/mode/json/';
    };

    if(type == "extractList") {
        url = urlHost+"communication/extractListDisplay/id/"+elementId+'/mode/json/';
    }

    if(type == "historicSms") {
        url = urlHost+"communication/historicSmsList/id/"+elementId+'/mode/json/';
    }


    if(type == "historicSmsCreate") {
        url = urlHost+"communication/historicSmsList/id/"+elementId+'/mode/json/';
        $('#historicSmsId').val(elementId);
        $('#historicSmsName').val($(this).children("option:selected").data('name'));
        $('#historicSmsCreateList').hide();
        $('#textSms').text($(this).children("option:selected").data('content'));

    }


    
    $('#nbResult').html = "";

    $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            beforeSend() {
                $("#loadSpinner").show();
            },
            success(json) {



                console.log(json);


                $("#loadSpinner").hide();

                let phoneNumberList = [];

                let nb = 0;

                $('#nameProductFr').html(json['title']);

                for (const property in json['childs']) {
                    let element = json['childs'][property][0];
                    let lineNumber = "";
                    for(const p in element.phones) {

                        let namePhone = element.phones[p].name;
                        let currentPhoneNumber = element.phones[p].phone;
                        let currentPhoneId    = element.phones[p].phoneId;
                        if(phoneNumberList.includes(currentPhoneNumber) || isMobilePhone(currentPhoneNumber) == false || namePhone == "Baby-sitter") {

                        } else {
                            if(element.phones[p].phone != undefined) {
                                lineNumber += `<li style="display: flex; justify-content: space-between; width: 80%; border-bottom: 1px solid grey">
                                                    <div>
                                                        <b>${namePhone}</b>
                                                        <div>${currentPhoneNumber}</div>
                                                    </div>
                                                    <div class="with-icon" style="padding-top:10px">
                                                        <input type="checkbox" style="width: 20px; height: 20px" class="checkboxListChild" data-childId = "${element.childId}" data-phoneid = "${currentPhoneId}" data-name="${element.fullnameReverse} - ${namePhone}" value="${currentPhoneNumber}"/>
                                                    </div>
                                            </li>`;
                                nb++;
                            }    
                        }

                        phoneNumberList.push(currentPhoneNumber);
                      
                    }

                    let html = ` <li style="list-style:none">
                                    <b style="font-size:1.3rem">${element.fullnameReverse}</b>
                                    <ul>
                                        ${lineNumber}
                                    </ul>
                                </li>`;

                    $('#ulDialog').append(html);

                }
                $('#nbResult').html(nb+" portables trouvés - hors Baby-sitter");
                console.log(nb);

            }
    })

})

$('#checkboxListChildButton').click(function() {

    checkboxListChildHidden = document.getElementById('checkboxListChildHidden').value;
    if( checkboxListChildHidden == 0) {
        checkboxListChildHidden = 1;
    } else {
        checkboxListChildHidden = 0;
    }
    allCheckbox = document.getElementsByClassName('checkboxListChild');
    for(let i = 0; i < allCheckbox.length; i++) {
        allCheckbox[i].checked = checkboxListChildHidden;
    }
    document.getElementById('checkboxListChildHidden').value = checkboxListChildHidden;
})

$('#addToListChildButton').click(function() {

    let checkedButton = document.getElementsByClassName('checkboxListChild');

    for(let i = 0 ; i < checkedButton.length; i++) {
        let line = checkedButton[i];

        if(line.checked) {
            addLinePhoneNumber(line.value, line.dataset.name, line.dataset.phoneid, line.dataset.childid);
        }
    }
    $('#ulDialog').empty();
    $('#dialog').hide();
})

$('#closeDialogButton').click(function() {
    $('#ulDialog').empty();
    $('#dialog').hide();
})


$('#closeDialogButtonSendSms').click(function() {
    $('#ulDialogSendSms').empty();
    $('#dialogSendSms').hide();
})

$('#emptyPhoneNumberList').click(function() {
    $('#phoneNumberList').empty();
})


$('#saveHistoricSmsName').click(function(e) {
    e.preventDefault();
    saveHistoricSms();
})

$('#textSms').change(function() {
    swapToSaveButton("needToSave");
})


$('#sendSmsButton').click(function() {

    saveHistoricSms();

     // historicSmsIdList
     let name = $('#historicSmsName').val();
     let content = $('#textSms').val();
     
     if(name != "" && content != "") {
        
        if( $('#saveHistoricSmsName').val() == 'Enregistrer') {
            toastr.error("Attendez la mise à jour des données", 'Error');
        } else {
            let historicSmsId = $('#historicSmsId').val();
            window.location.href = urlHost+'communication/doSend/id/'+historicSmsId+'/';
        }
     }


})

const saveHistoricSms = () => {
 
    let historicSms;

    // historicSmsIdList
    let name = $('#historicSmsName').val();
    let content = $('#textSms').val();
    let signature = $('#signature').val();

    if(name == "" || content == "") {
        toastr.error("Vous n'avez pas rempli tous les champs", 'Error');
    } else {
        let url2 = urlHost+"communication/updateHistoricSms/";
        let historicId = $('#historicSmsId').val();
    
        $.ajax({
            type: "POST",
            url: url2,
            data: {name: name, content:content, id:historicId, signature:signature},
            dataType: "json",
            beforeSend() {
                $("#loadSpinner").show();
            },
            success(json) {
                $("#loadSpinner").hide();
                historicSms = json.HistoricSms;
                $('#historicSmsId').val(historicSms.id);

                toastr.success("Campagne sauvegardée");

    
                // update NumberList

                /*
                $('.phoneNumber').each(function() {
                    let element = $(this);
                    let phoneNumber = element.data('phonenumber');
                    let personName = element.data('name');
                    let phoneId = element.data('phoneid');
                    let childid = element.data('childid');

                    
                    let url3 = urlHost+"communication/updateHistoricSmsList/";
                    $.ajax({
                        type: "POST",
                        url: url3,
                        data: {historicSmsId: historicSms.id, phoneNumber:phoneNumber, phoneName:personName, phoneId:phoneId, childId:childid },
                        dataType: "json",
                        beforeSend() {
                            $("#loadSpinner").show();
                        },
                        success(jsonResult) {
                            console.log(jsonResult);
                            element.removeClass('phoneNumber');
                            element.parent().parent().css('background-color', 'lightgreen');
                        }
                    })
                })

                swapToSaveButton("upToDate")*/
            }
        })

    }
    return true;
}
const addLinePhoneNumber = (phoneNumber, personName = "", phoneId = "", childId = "") => {

    console.log(childId)

    let html = `<li style="padding: 0px; padding-top: 10px; padding-bottom: 10px;" id="linePhoneNumber${phoneNumber}">
        <div>
            <p class="list-header">${personName}</p>
            <p class="list-subheader phoneNumber" data-childId = "${childId}" data-phoneid = "${phoneId}" data-name="${personName}" data-phonenumber="${phoneNumber}">${phoneNumber}</p>
            <div class="with-icon">
                <i class="material-icons deleteLine" style="font-size: 30px; color: darkred" onclick="removeLine('${phoneNumber}')">close</i>
            </div>
        </div>
    </li>`;
    $('#phoneNumberList').append(html);

  //  delete line in bdd

  // 
}


const removeLine = (phoneNumber) => {
    let el = document.getElementById('linePhoneNumber'+phoneNumber);
    el.remove();
}


const isMobilePhone = (number) => {
    if( number == null) {
        return false;
    }
    let reg_mobile_phone = '^(06|07)[0-9]{8}$';
	if( number.match(reg_mobile_phone) ){
		return true;
	} else {
		return false;
	}
}

const swapToSaveButton = (status) => {
    if(status == "needToSave") {
        $('#saveHistoricSmsName').val('Enregistrer');
        $('#saveHistoricSmsName').css('background-color', 'darkred');
        $('#saveHistoricSmsName').css('color', 'white');
    } else {
        $('#saveHistoricSmsName').val('Données à jour');
        $('#saveHistoricSmsName').css('background-color', 'darkblue');
        $('#saveHistoricSmsName').css('color', 'white');
    }
}