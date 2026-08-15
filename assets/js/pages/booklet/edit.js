const urlApi = $('#urlApi').val();
const tokenAuth = $("#tokenAuth").val();
const bookletChildId = $('#bookletChilId').val();
const childId = $('#childId').val();
const totalItemForm = $('#totalItemForm').val();
const totalChildForm = $('#totalChildForm').val();

$('.bookletChildForm').change(function() {
    let val = $(this).val();
    let name = $(this).attr('name');
    let url = urlApi + 'bookletchild/modify/' + bookletChildId;
    let data = {};
    data[name] = val;
    data = JSON.stringify(data);
    updateData(url, data);
})

$('.childForm').change(function() {
    let val = $(this).val();
    let name = $(this).attr('name');
    let url = urlApi + 'child/modify/' + childId;

    let data = {};

    data[name] = val;

    data = JSON.stringify(data);
    updateData(url, data);
})

$('.rateIcon').mouseover(function() {
    let answerId = $(this).attr('data-answer');
    let val      = $(this).attr('data-value');
    $('.answer-'+answerId).each(function() {
        if($(this).attr('data-value') <= val) {
            $(this).addClass('hoverIconRate');
        }
    })
});

$('.rateIcon').mouseout(function() {
    let answerId = $(this).attr('data-answer');
    let val      = $(this).attr('data-value');

    $('.answer-'+answerId).removeClass('hoverIconRate');
});

$('.resetIcon').click(function() {
    let answerId = $(this).attr('data-answer');
    let val =  0;
    let url = urlApi + 'bookletchild/updateAnswer/' + answerId;

    let data = {answer : val};
    data = JSON.stringify(data);
    $('.answer-'+answerId).removeClass('hoverIconRate');
    $('.answer-'+answerId).removeClass('rateChecked');

    updateData(url, data, 'item');

    $('.answer-'+answerId).each(function() {
        if($(this).attr('data-value') <= val) {
            $(this).addClass('rateChecked');
        }
    })

});


$('.rateIcon').click(function() {

    if( $(this).parent().hasClass('responsePrev') ) {
        console.log("class");
    } else {
        let answerId = $(this).attr('data-answer');
        let val      = $(this).attr('data-value');
        let url = urlApi + 'bookletchild/updateAnswer/' + answerId;

        let data = {answer : val};

        data = JSON.stringify(data);

        $('.answer-'+answerId).removeClass('hoverIconRate');
        $('.answer-'+answerId).removeClass('rateChecked');

        updateData(url, data, 'item');

        $('.answer-'+answerId).each(function() {
            if($(this).attr('data-value') <= val) {
                $(this).addClass('rateChecked');
            }
        })
    }
});

$('#finalValidation').click(function() {

   // let status = $(this).attr('data-to');
    let status = document.getElementById('finalValidation').getAttribute('data-to');
    let url = urlApi + 'bookletchild/modify/' + bookletChildId;
    let data = {status : status};
    data = JSON.stringify(data);
    updateData(url, data);
    location.reload();
});


$('#returnDraft').click(function() {
    let status = $(this).attr('data-to');
    let url = urlApi + 'bookletchild/modify/' + bookletChildId;
    let data = {status : status};
    data = JSON.stringify(data);
    updateData(url, data);
    location.reload();
});

const updateData = (url, data) => {
 $.ajax({
        url: url,
        type: 'PUT',
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
            toastr.success("Saved");
            console.log(data);
        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });
};


const checkFinalValidation = () => {
    if ($('#validationPass').is(':checked')) {
        $('#finalValidation').show();
    } else {
        $('#finalValidation').hide();
    }
}

$('#validationPass').click(function() {
    checkFinalValidation();
});


$('#showPreviousResultButton').click(function() {
    $('.responsePrev').toggle();
})


checkFinalValidation();