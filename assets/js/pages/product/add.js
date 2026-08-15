$(() => {
    initMultiSelect();
});

dropContainer.ondragover = dropContainer.ondragenter = evt => {
    evt.preventDefault();
};

dropContainer.ondrop = evt => {
    fileInput.files = evt.dataTransfer.files;
    evt.preventDefault();
};

const previewOnDiv = () => {
    const file = document.querySelector("#fileInput").files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
        const image = document.getElementById("photoRender");
        const strImage = reader.result.replace(/^data:image\/[a-z]+;base64,/, "");
        image.src = `data:image/jpeg;base64,${strImage}`;

        $("#photoRender").fadeIn();
    
        getOrientation(file, function(orientation) {
            
            if(orientation > 2)
            {
                resetOrientation(image.src, 5, function(resetBase64Image) {
                    image.src = resetBase64Image;
                });        
            }

            
     
        });


        const imageCompressor = new ImageCompressor();

        const compressorSettings = {
            toWidth: 400,
            toHeight: 400,
            mimeType: "image/png",
            mode: "strict",
            quality: 0.6,
            speed: "low"
        };

        imageCompressor.run(image.src, compressorSettings, proceedCompressedImage);
    };
};


tinymce.init({
    selector: '.inputNameProductTiny',
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | link'
});


const makeid = () => {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 5; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}

function proceedCompressedImage(compressedSrc) {
    $.ajax({
        type: "POST",
        url: urlPhoto,
        data: { base64: compressedSrc, folder: "product" },
        dataType: "json",
        beforeSend() {
            $(".loading").show();
        },
        success(json) {
            $(".loading").hide();
            $("#photoUrl").val(json.url);
        }
    });
}

/*
Autocomplete for child
 */
document.getElementById("autocompleteListChild").addEventListener(
    "keyup",
    function(event) {
        let searchTerm = $(this).val();
        let url = `child/search/${searchTerm}`;

        $("#autocompleteListChild").autocomplete({
            minLength: 2,
            source(request, response) {
                $.ajax({
                    type: "POST",
                    url: urlRequest,
                    data: { url, type: "GET" },
                    dataType: "json",

                    success(data) {
                        response(
                            $.map(data, child => ({
                                label: `${child.lastname} ${child.firstname}`,
                                value: child.childId
                            }))
                        );
                    }
                });
            },
            select(data, child) {
                $("#childId").val(child.item.value);
                $("#autocompleteListChild").val(child.item.label);
                return false;
            },
        });
    },
    false
);


$("#hourDropIn").change(() => {
  const time = $("#hourDropIn").val();

  if (time.length == 5) {
    $("#hourDropinInput").val(`${time}:00`);
  }
});

$("#hourDropOff").change(() => {
  const time = $("#hourDropOff").val();

  if (time.length == 5) {
    $("#hourDropoffInput").val(`${time}:00`);
  }
});


var initMultiSelect = () => {
    $("#locationSelect").zmultiselect({
        filter: true,
        filterResult: true,
        selectAll: true,
        selectAllText: ["Tout cocher", "Tout décocher"],
        selectedText: ["Sélectionné : ", "/"],
        filterPlaceholder: "",
        filterResultText: "",
        filterPlaceholder: "Filtrer par",
        get: "zmultiselect",
        placeholder: "Sélectionner les lieux ",
        live: "#liveResultLocation"
    });

    $("#sportSelect").zmultiselect({
        filter: true,
        filterResult: true,
        selectAll: true,
        selectAllText: ["Tout cocher", "Tout décocher"],
        selectedText: ["Sélectionné : ", "/"],
        filterPlaceholder: "",
        filterResultText: "",
        filterPlaceholder: "Filtrer par",
        get: "zmultiselect",
        placeholder: "Choisir un\/des sport(s) ",
        live: "#liveResultSport"
    });

    $("#componentSelect").zmultiselect({
        filter: true,
        filterResult: true,
        selectAll: true,
        selectAllText: ["Tout cocher", "Tout décocher"],
        selectedText: ["Sélectionné : ", "/"],
        filterPlaceholder: "",
        filterResultText: "",
        filterPlaceholder: "Filtrer par",
        get: "zmultiselect",
        placeholder: "Choisir les composants ",
        live: "#liveResultComponent",
        /*plugins: {
            popperjs: 'top'
        }*/
    });
};

function getFamily(){
    var familyValue = $("select#familySelect").val();
    $("#family").val(familyValue);
}
$("select#familySelect").change(getFamily), getFamily();


function getCategory(){
    var categoryValue = $("select#categorySelect").val();
    $("#category").val(categoryValue);
}
$("select#categorySelect").change(getCategory), getCategory();


function getSeason(){
    var seasonValue = $("select#seasonSelect").val();
    $("#season").val(seasonValue);
}
$("select#seasonSelect").change(getSeason), getSeason();


function getVisibility(){
    var visibilityValue = $("select#visibilitySelect").val();
    $("#visibility").val(visibilityValue);

    if(visibilityValue == "personVisibility") {
        $('.notPersonVisibility').hide();
        $('.showPersonVisibility').show();
    } else {
        $('.notPersonVisibility').show();
        $('.showPersonVisibility').hide();
    }

}
$("select#visibilitySelect").change(getVisibility), getVisibility();



$("#componentFilterValidate").click(() => {
    var myValue = $("#liveResultComponent").val();
    var myValue = myValue.split(",");

    $("#componentSelect")
        .find("option")
        .each(function() {
            const id = $(this).val();
            const vat = $(this).attr("data-vat");
            const name = $(this).attr("data-name-fr");
            const nameEn = $(this).attr("data-name-en");


            if (jQuery.inArray(id, myValue) == -1) {

            } else {
                $(".componentTable").append(
                    `<tr class="componentTr" data-id-component="${id}" data-vat="${vat}" data-name-fr="${name}" data-name-en="${nameEn}">
                    <td>${name}</td>
                    <td></td>
                    <td>
                        <input data-id="${id}" data-vat="${vat}" id="priceTTC${id}" type="number" onchange="calculateHT(this)" value="" >
                    </td>
                    <td>
                        <input data-id="${id}" id="priceHT${id}" type="text"  value="" disabled>
                    </td>
                    <td>
                        <input data-id="${id}" id="quantity${id}" type="number" onchange="calculateTotal(this)" value="">
                    </td>
                    <td ">${vat}</td>
                    <td class="totalTTC" id="totalTTC${id}"></td>
                    <td id="totalHT${id}"></td>
                    <td><a href="javascript:void(0)" data-id="${id}" onclick="deleteComponent(this)"><i class="material-icons">close</i> </a></td>
                    </tr>`
                );
            }
        });
});

const calculateHT = data => {
    let id = $(data).attr("data-id");
    let priceTTC = $(data).val();
    let vat = $(data).attr("data-vat");
    let priceHT = priceTTC / (1 + vat/100 );
    $("#priceHT" + id).val(priceHT.toFixed(2));

    const quantity = $("#quantity" + id).val();

    if (null != quantity){
        $("#totalTTC" + id).html('');
        $("#totalHT" + id).html('');
        let newPriceTTC = $("#priceTTC" + id).val();
        let newPriceHT = $("#priceHT" + id).val();

        const totalTTC = newPriceTTC * quantity;
        const totalHT = newPriceHT * quantity;
        $("#totalTTC" + id).html(totalTTC.toFixed(2));
        $("#totalHT" + id).html(totalHT.toFixed(2));

        var priceTTCTotal = 0;

        $(".componentTable")
            .find("td.totalTTC")
            .each(function() {
                if($(this).html() != "")
                {
                    priceTTCTotal += parseInt($(this).html()); // On passe la variable en nombre car sinon il interprète comme une string
                    $("#totalProductTTC").html(priceTTCTotal.toFixed(2));
                    $("#productTotalPriceTtc").val(priceTTCTotal.toFixed(2));
                }

            });
    }

};


const calculateTotal = data => {
    let id = $(data).attr("data-id");
    let quantity = $(data).val();
    let priceTTC = $("#priceTTC" + id).val();
    let priceHT = $("#priceHT" + id).val();

    const totalTTC = priceTTC * quantity;
    const totalHT = priceHT * quantity;
    $("#totalTTC" + id).html(totalTTC.toFixed(2));
    $("#totalHT" + id).html(totalHT.toFixed(2));

    var priceTTCTotal = 0;

    const nbComponents = $(".componentTable").find("td.totalTTC").length;

    if(nbComponents == 0)
    {
        $("#totalProductTTC").html(0);
        $("#productTotalPriceTtc").val(0);
    }
    else
    {

        $(".componentTable")
            .find("td.totalTTC")
            .each(function() {
                if($(this).html() != "")
                {
                    priceTTCTotal += parseInt($(this).html()); // On passe la variable en nombre car sinon il interprète comme une string
                    $("#totalProductTTC").html(priceTTCTotal.toFixed(2));
                    $("#productTotalPriceTtc").val(priceTTCTotal.toFixed(2));
                }

            });

    }



};
const format = date => {
    var date_string = date.split('-').join('-');
    var date = new Date(date_string);
    return ((date.getDate()).toString().length > 1 ? date.getDate()  : '0'+ (date.getDate()) )+'/'+ ((date.getMonth()) > 8 ? date.getMonth() + 1 : '0'+ (date.getMonth() + 1 ) ) + '/' + date.getFullYear()  ;
}

//tests sur fullcalendar
$(() => {
    if ($("#updatedPage").val() === 'updated') {
        generateDates = [];
        var i = 0;
        $("#dateList")
            .find('li')
            .each(function () {

                let dateValue = $(this).attr("data-date").split('/');
                let dateFormat = dateValue[2] + '-' + dateValue[1] + '-' + dateValue[0];

                generateDates.push({start:dateFormat});



                i++;
            });

    } else {
        generateDates = [];
    }

    $("#dateCalendar").fullCalendar({
        defaultView: "month",
        header: {
            left: "prev",
            center: "title",
            right: "next"
        },
        locale: "fr",
        schedulerLicenseKey: "CC-Attribution-NonCommercial-NoDerivatives",
        selectable: true,
        editable: true,
        eventLimit: true,
        events: generateDates,
        select(start) {
            var event = {
                start: start,
            };

            $("#dateCalendar").fullCalendar(
                "renderEvent"
                , event,
                true
            );
            const dateFormat = start.format("DD/MM/YYYY");
            $("#dateList").append(
                `<li data-date="${dateFormat}">
                    <div>
                        <p class="list-header">
                            ${dateFormat}
                        </p>
                    </div>
                </li>`
            );
            generateDates.push(event);

            $("#dateCalendar").fullCalendar("unselect");
        },
        eventRender: function (event, element) {
            element.append("<i class='material-icons removebtn'>close</i>");
            element.find(".removebtn").click(function () {

                let dateFormat = event.start.format("DD/MM/YYYY");

                $('#dateCalendar').fullCalendar('removeEvents', event._id);
                $(`[data-date="${dateFormat}"]`)
                    .addClass("animated bounceOutUp")
                    .delay(750)
                    .hide(0);

                $(`[data-date="${dateFormat}"]`).remove(); // remove li

                for (var i = 0; i < generateDates.length; i++) {

                    if(generateDates[i].start ==  event.start.format("YYYY-MM-DD")) {
                        generateDates.splice(i, 1);
                    }

                }


            });
        },
    });


});


$(() => {
    if ($("#updatedPage").val() === 'updated') {
        generateHours = [];
        var i = 0;
        $("#hourList")
            .find('li')
            .each(function () {
                let id = $(this).attr("data-id");
                let dateValue = $(this).attr("data-date");
                let startValue = $(this).attr("data-start");
                let endValue = $(this).attr("data-end");
                let dateStartFormat = dateValue + 'T' + startValue + ':00';
                let dateEndFormat = dateValue + 'T' + endValue + ':00';

                generateHours.push({start: dateStartFormat, end: dateEndFormat, id: id, allDay: false});

                i++;
            });

    } else {
        generateHours = [];
    }

    $("#hourCalendar").fullCalendar({
        defaultView: "agendaDay",
        defaultDate: "2018-10-17",
        header: {
            left: "",
            center: "",
            right: ""
        },
        locale: "fr",
        editable: true,
        schedulerLicenseKey: "CC-Attribution-NonCommercial-NoDerivatives",
        allDaySlot: false,
        allDayDefault: false,
        displayEventTime: true,
        columnHeader: false,
        selectable: true,
        eventStartEditable: true,
        contentHeight: "auto",
        eventDurationEditable: true,
        //minTime: "06:00:00",
        //maxTime : "20:00:00",
        events: generateHours,
        select(start, end, id, jsEvent, view, resource) {
            const randomId = makeid();
            var event = {
                start: start,
                end: end,
                id: randomId,
            };
            $("#hourCalendar").fullCalendar(
                "renderEvent"
                , event,
                true
            );
            const hourStartFormat = start.format("HH:mm");
            const hourEndFormat = end.format("HH:mm");
            const eventId = event.id;
            

            $("#hourList").append(
                `<li data-id="${eventId}" data-message-fr="" data-message-en="" data-is-full="" data-custom-id="${randomId}" data-date="2018-10-17" data-start="${hourStartFormat}" data-end="${hourEndFormat}"> 
                    <div>
                        <p class="list-header">
                            ${hourStartFormat} - ${hourEndFormat} - <a href="javascript:void(0)" onclick="getEventHour(this)" data-open="addIndisponibility">Gérer la dispo</a>
                        </p>
                    </div>
                </li>`
            );
            generateHours.push(event);
            console.log(generateHours);
            $("#hourCalendar").fullCalendar("unselect");
        },
        eventRender: function(event, element) {


            element.append("<i class='material-icons removebtn'>close</i>");
            element.find(".removebtn").click(function() {
                let id = event.id;
                $('#hourCalendar').fullCalendar('removeEvents',event.id);
                $(`[data-id="${id}"]`)
                    .addClass("animated bounceOutUp")
                    .delay(750)
                    .hide(0);
            
                for (var i = 0; i < generateHours.length; i++) {
                    if (generateHours[i].id === event.id) {
                        console.log('delete');
                        generateHours.splice(i, 1);
                    }
                }

            });



        },
        eventDrop(event, delta, revertFunc, jsEvent, ui, view){
            let id = event.id;
            $('#hourCalendar').fullCalendar('updateEvent', event);
            let newTimeFormat = event.start.format("HH:mm");
            let hourEndFormat = event.end.format("HH:mm");


            $(`[data-id="${id}"]`).replaceWith(
                `<li data-id="${id}" data-date="2018-10-17" data-start="${newTimeFormat}" data-end="${hourEndFormat}">
                    <div>
                        <p class="list-header">
                            ${newTimeFormat} - ${hourEndFormat}
                        </p>
                    </div>
                </li>`
            );
            for (var i = 0; i < generateHours.length; i++) {

                if (generateHours[i].id === id) {
                    generateHours.splice(i, 1, event);
                }
            }

        },
        eventResize(event, delta, revertFunc, jsEvent, ui, view){
            let id = event.id;
            $('#hourCalendar').fullCalendar('updateEvent', event);

            let hourEndFormat = event.end.format("HH:mm");
            let hourStartFormat = event.start.format("HH:mm");
            $(`[data-id="${id}"]`).replaceWith(
                `<li data-id="${id}" data-date="2018-10-17" data-start="${hourStartFormat}" data-end="${hourEndFormat}">
                    <div>
                        <p class="list-header">
                            ${hourStartFormat} - ${hourEndFormat}
                        </p>
                    </div>
                </li>`
            );
            for (var i = 0; i < generateHours.length; i++) {

                if (generateHours[i].id === id) {
                    generateHours.splice(i, 1, event);
                }
            }

        },
    });
});

const getEventHour = el =>
{
    var parent = $(el).parent().parent().parent();
    var eventId = $(parent).attr('data-custom-id');
    var isFullPre = $("[data-custom-id=" + eventId + "]").attr('data-is-full');
    var messageFrPre = $("[data-custom-id=" + eventId + "]").attr('data-message-fr');
    var messageEnPre = $("[data-custom-id=" + eventId + "]").attr('data-message-en');

    if(isFullPre == 1) {
       $("#is_full").attr('checked', 'checked');   
    }
    
    $("#message_fr_indisponibility").val(messageFrPre);
    $("#message_en_indisponibility").val(messageEnPre);

    $("#lastEventId").val(eventId);
}


const sendIndisponibility = () =>
{

    var eventId = $("#lastEventId").val();
    var messageFr = $("#message_fr_indisponibility").val();
    var messageEn = $("#message_en_indisponibility").val();

    var isFull = 0;
    if ($("#is_full").is(":checked")) {
        isFull = 1;
    }
    $("[data-custom-id=" + eventId + "]").attr('data-is-full', isFull);
    $("[data-custom-id=" + eventId + "]").attr('data-message-fr', messageFr);
    $("[data-custom-id=" + eventId + "]").attr('data-message-en', messageEn);

    if(isFull == 1)
    {
        $("[data-custom-id=" + eventId + "]").css('text-decoration', 'line-through');
    }
    else
    {
        $("[data-custom-id=" + eventId + "]").css('text-decoration', 'normal');        
    }
}

const loadHourCalendar = () =>
{

    setTimeout(() => {
    $("#hourCalendar").fullCalendar( 'refetchEvents' );
    $("#hourCalendar").fullCalendar( 'rerenderEvents' );
    }, 1000);


}

document.getElementById("productForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        tinyMCE.triggerSave(true, true);
        let form = $("#productForm");
        let url = form.attr("action");
        const dataSport = [];
        const dataComponent = [];
        const dataLocation = [];
        const dataCategory = [];
        const dataHour = [];
        const dataDate = [];
        let i = 0;


        $(".componentTable")
            .find(".componentTr")
            .each(function() {
                let id = $(this).attr("data-id-component");
                const nameFrComponent = $(this).attr("data-name-fr");
                const nameEnComponent = $(this).attr("data-name-en");
                const vatComponent = $(this).attr("data-vat");
                const quantityComponent = $('#quantity'+id).val();
                const priceHtComponent = $("#priceHT" + id).val();
                const priceTtcComponent = $("#priceTTC" + id).val();
                const totalTtcComponent = $("#totalTTC" + id).html();
                const totalHtComponent = $("#totalHT" + id).html();
                const priceVatComponent = (priceTtcComponent) - (priceHtComponent);
                const totalVatComponent = parseInt(totalTtcComponent) - parseInt(totalHtComponent);
                dataComponent[i] = {
                    nameFr: nameFrComponent,
                    nameEn: nameEnComponent,
                    vat: vatComponent,
                    quantity: quantityComponent,
                    priceHt: priceHtComponent,
                    priceTtc: priceTtcComponent,
                    priceVat: priceVatComponent,
                    totalHt: totalHtComponent,
                    totalTtc: totalTtcComponent,
                    totalVat: totalVatComponent
                };
                i++;
            });

        var categories = $("#category").val().split(',');
        categories.forEach(function(category, i=0) {
            const idCategory = category;
            dataCategory[i] = { category: idCategory };
            i++;
        });

        var locations = $("#liveResultLocation").val().split(',');
        locations.forEach(function(location, i=0) {
            const idLocation = location;
            dataLocation[i] = { location: idLocation };
            i++;
        });

        var sports = $("#liveResultSport").val().split(',');
        sports.forEach(function(sport, i=0) {
            const idSport = sport;
            dataSport[i] = { sport: idSport };
            i++;
        });

        console.log(generateDates);

        generateDates.forEach(function(date, i=0){
            if ( undefined ===  date.start._d){
                 var  dateValue = date.start;
            } else {
                const dateYear = date.start._d.getFullYear();
                const dateDay = date.start._d.getDate();
                const dateMonth = date.start._d.getMonth() + 1;

                dateValue = dateYear + '-' + dateMonth + '-' + dateDay;
            }
                dataDate[i] = {date: dateValue};
                i++;
        });


        generateHours.forEach(function(hour, i=0) {

            if (undefined === hour.start._i) {
                let getHourStart = hour.start.split('T');
                let getHourEnd = hour.end.split('T');
                var timeStartValue = getHourStart[1];
                var timeEndValue = getHourEnd[1];
            } else {
            const hourStartValue = hour.start._i[3];
            const minuteStartValue = hour.start._i[4];
            const secondStartValue = hour.start._i[5];
            timeStartValue = hourStartValue + ':' + minuteStartValue + ':' + secondStartValue;

            const hourEndValue = hour.end._i[3];
            const minuteEndValue = hour.end._i[4];
            const secondEndValue = hour.end._i[5];
            timeEndValue = hourEndValue + ':' + minuteEndValue + ':' + secondEndValue;
            }

            const isFull = $("[data-custom-id=" + hour.id + "]").attr('data-is-full');
            const messageFr = $("[data-custom-id=" + hour.id + "]").attr('data-message-fr');
            const messageEn = $("[data-custom-id=" + hour.id + "]").attr('data-message-en');

            dataHour[i] = {start: timeStartValue, end: timeEndValue, isFull, messageFr, messageEn};
            i++;
        });

        let data = $(form).serializeToJSON();
        let type = "POST";

        if (url.includes("modify")) {
            type = "PUT";
        }


        console.log(data);

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type, data, components: dataComponent, categories: dataCategory, locations: dataLocation, sports: dataSport, dates: dataDate, hours: dataHour },
            dataType: "json",
            beforeSend() {
                $(".loading").show();
            },
            success(json) {
                $(".loading").hide();
                console.log(json);

                if (json.status == true) {
                    swal({
                        title: "Confirmation",
                        text: json.message,
                        type: "success",
                        confirmButtonText: "Afficher le produit",
                        cancelButtonText: "Fermer",
                        showCancelButton: true
                    }).then(result => {
                        if (result.value) {
                            location.href = `${urlHost}product/display/id/${json.product.productId}/`;
                        }
                    });
                } else {
                    swal({
                        title: "Erreur",
                        text: "Une erreur est survenue.",
                        type: "warning"
                    });
                }
            }
        });
    },
    false
);


const deleteComponent = data => {
    let id = $(data).attr("data-id");

   $(`[data-id-component='${id}']`)
        .addClass("animated bounceOutUp")
        .delay(750)
        .remove();

    calculateTotal();

    let optionName = $("#option" + id).val();

    $("#componentSelect").zmultiselect('set', optionName, false);



};

