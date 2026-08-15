const urlApi = $('#urlApi').val();

let allCheckbox; // check if used
let checkboxListChildHidden; // check if used

let nbChecked = 0;
let infoChecked = document.getElementById('infoChecked');
let contacts = [];

let contentText = $('#textSms').val();
let signatureText = $('#signature').val();

$('#signatureLength').html(signatureText.length);
$('#totalLength').html(contentText.length+signatureText.length+'/140');

$('#addManuelButton').click(function() {
    let phoneNumber = $('#addManuel').val();
    addLinePhoneNumber(phoneNumber);
})

$('.contentSmsElement').on('input', function(){
    let contentText = $('#textSms').val();
    let signatureText = $('#signature').val();

    $('#signatureLength').html(signatureText.length);
    $('#totalLength').html(contentText.length+signatureText.length+'/140');

});

$('.selectListButton').change(function() {
    
    let type = $(this).data('type');
    let elementId = $(this).val();
    let url;

    $('#dialog').show();
    $('#loadSpinnerDiv').show();
    
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

console.log(url);
    
    $('#nbResult').html = "";

    $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            beforeSend() {
                $("#loadSpinner").show();
            },
            success(json) {

                $("#loadSpinner").hide();

                let phoneNumberList = [];

                let nb = 0; let firstLetter = "";

                $('#nameProductFr').html(json['title']);

                let vari = 1; let liBackcolor = ""; let checkboxLiNumber = 0;

                for (const property in json['childs']) {
                    vari = vari*-1; 
                    let element = json['childs'][property][0];
                    let lineNumber = "";
                    for(const p in element.phones) {
                        checkboxLiNumber++;
                        let namePhone = element.phones[p].name;
                        let currentPhoneNumber = element.phones[p].phone;
                        let currentPhoneId    = element.phones[p].phoneId;
                        if(phoneNumberList.includes(currentPhoneNumber) || isMobilePhone(currentPhoneNumber) == false || namePhone == "Baby-sitter") {

                        } else {
                            if(element.phones[p].phone != undefined) {
                                lineNumber += `<li id="liContactNumber${currentPhoneNumber}${checkboxLiNumber}" style="display: flex; justify-content: space-between; width: 80%; border-bottom: 1px solid grey">
                                                    <div>
                                                        <b>${namePhone}</b>
                                                        <div>${currentPhoneNumber}</div>
                                                    </div>
                                                    <div class="with-icon" style="padding-top:10px">
                                                        <input type="checkbox" 
                                                                id="checkboxLiNumber${currentPhoneNumber}${checkboxLiNumber}" 
                                                                onclick="countLi('${currentPhoneNumber}${checkboxLiNumber}')" 
                                                                class="checkboxListChild" data-childId = "${element.childId}"
                                                                data-phoneid = "${currentPhoneId}" data-name="${element.fullnameReverse} - ${namePhone}"
                                                                value="${currentPhoneNumber}"/>
                                                    </div>
                                            </li>`;
                                nb++;
                            }    
                        }

                        phoneNumberList.push(currentPhoneNumber);
                      
                    }

                    if(vari == 1) {
                        liBackcolor = "background-color: #dff4ff";
                    } else {
                        liBackcolor = "";
                    }

                    let showLetter = '';
                    if(element.fullnameReverse != null) {
                        if(firstLetter != element.fullnameReverse.charAt(0)) {
                            firstLetter = element.fullnameReverse.charAt(0);
                            showLetter = `<div class="firstLetter" id="firstLetter${firstLetter}">${firstLetter}</div>`;
                        }
                    } else {
                        firstLetter = "";
                        showLetter = `<div class="firstLetter" id="firstLetter${firstLetter}">Sans nom</div>`;
                    }


                    let html = ` ${showLetter}<li class="liListName" style="list-style:none; padding: 0px 20px; ${liBackcolor}">
                                    <b style="font-size:1.2rem">${element.fullnameReverse}</b>
                                    <ul>
                                        ${lineNumber}
                                    </ul>
                                </li>`;

                    $('#ulDialog').append(html);

                }
                $('#nbResult').html(nb+" portables trouvés - hors Baby-sitter");

            }
    })
})

$('#goUpButton').click(function() {
      $("html, body").animate({
        scrollTop: 0
    }, 300)
})

$('#selectFirstLetter').change(function() {
    let letter = $(this).val();
    $("html, body").animate({ scrollTop: $("#firstLetter"+letter).offset().top }, 300);
})

const countLi = (checkboxLiNumber) => {

    let currentLi = document.getElementById("checkboxLiNumber"+checkboxLiNumber);

    let phoneId = currentLi.dataset.phoneid;
    let name = currentLi.dataset.name;
    let childId = currentLi.dataset.childid;
    let phoneNumber = currentLi.value;
    let line = phoneId+'|'+name+'|'+phoneNumber+'|'+childId+'|'+checkboxLiNumber;

    if(currentLi.checked) {
        nbChecked++;
        contacts.push(line);

    } else {
        nbChecked--;

        if(contacts.includes(line)) {
            let index = contacts.indexOf(line);
            contacts.splice(index, 1);
        }
    }
    infoChecked.innerHTML = nbChecked;
}

$('#saveButton').click(function() {
     data = JSON.stringify(contacts);
     let url = urlApi + 'historicSmsList/addContacts/'+$('#historicSmsId').val();

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
            toastr.success(data['number_added']+" numéros ajoutés");
            if(data["already_in_list"]) {
                toastr.info(data['already_in_list'].length+" numéros déjà dans la liste");
            }

            for(key in contacts) {
                let checkLiNumber = contacts[key].split('|')[4];
                $('#liContactNumber'+checkLiNumber).remove();
            }

            contacts  = [];
            nbChecked = 0;
            infoChecked.innerHTML = nbChecked;

        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });
})

$('#closeDialogButton').click(function() {
    $('#ulDialog').empty();
    $('#dialog').hide();
    $('#loadSpinnerDiv').hide();
    window.location.href = urlHost+'communication/showCampagn/id/'+$('#historicSmsId').val() +'/';


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
        let historicSmsId = $('#historicSmsId').val();
        window.location.href = urlHost+'communication/doSend/id/'+historicSmsId+'/';
     }
})

/**
 * Save the historicSms
 */
const saveHistoricSms = () => {
 
    let historicSms;

    // historicSmsIdList
    let name = $('#historicSmsName').val();
    let content = $('#textSms').val();
    let signature = $('#signature').val();
    let isUnicode = $('#isUnicode').prop('checked') ? 1 : 0;

    if(name == "" || content == "") {
        toastr.error("Vous n'avez pas rempli tous les champs", 'Error');
    } else {
        let url2 = urlHost+"communication/updateHistoricSms/";
        let historicId = $('#historicSmsId').val();
    
        $.ajax({
            type: "POST",
            url: url2,
            data: {name: name, content:content, id:historicId, signature:signature, isUnicode:isUnicode},
            dataType: "json",
            beforeSend() {
                $("#loadSpinner").show();
            },
            success(json) {
                $("#loadSpinner").hide();
                historicSms = json.HistoricSms;
                $('#historicSmsId').val(historicSms.id);
                toastr.success("Campagne sauvegardée");

                if(historicId == "") {
                        window.location.href = urlHost+'communication/showCampagn/id/'+historicSms.id+'/';
                }
            }
        })

    }
    return true;
}

const addLinePhoneNumber = (phoneNumber, personName = "", phoneId = "", childId = "") => {

    let html = `<li style="padding: 0px; padding-top: 10px; padding-bottom: 10px;" id="linePhoneNumber${phoneNumber}">
        <div>
            <p class="list-header">${personName}</p>
            <p id="pLineNumber${phoneNumber}" class="list-subheader phoneNumber" data-childId = "${childId}" data-phoneid = "${phoneId}" data-name="${personName}" data-phonenumber="${phoneNumber}">${phoneNumber}</p>
            <div class="with-icon">
                <i class="material-icons deleteLine" style="font-size: 30px; color: darkred" onclick="removeLine('${phoneNumber}')">close</i>
            </div>
        </div>
    </li>`;
    $('#phoneNumberList').append(html);


    let line = phoneId+'|'+personName+'|'+phoneNumber+'|'+childId+'|null';

    let contactline = [];
    contactline.push(line)

    data = JSON.stringify(contactline);
    let url = urlApi + 'historicSmsList/addContacts/'+$('#historicSmsId').val();

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
            toastr.success(data['number_added']+" numéros ajoutés");
            if(data["already_in_list"]) {
                toastr.info(data['already_in_list'].length+" numéros déjà dans la liste");
            }

        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });



}

const removeLine = (phoneNumber) => {
    let el = document.getElementById('linePhoneNumber'+phoneNumber);
    let pLine = document.getElementById('pLinePhoneNumber'+phoneNumber);
    let historicSmsId = $('#historicSmsId').val();

    let url = urlApi + 'historicSmsList/removeNumberFromList';
    let data = {phoneNumber : phoneNumber, historicSmsId: historicSmsId};
    data = JSON.stringify(data);

     $.ajax({
        url: url,
        type: 'DELETE',
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
            toastr.success("Contact retiré");
            el.remove();

        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });

}

const isMobilePhone = (number) => {
    if( number == null) {
        return false;
    }
    let reg_mobile_phone = '^(\\+?336|\\+?337|336|337|06|07|6|7)[0-9]{8}$';
    if (number.match(reg_mobile_phone)) {
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