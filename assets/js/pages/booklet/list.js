var currentDate = $('#date').val();

function loadBooklet(book, button) {
    $(".loading").show();

    let myUrl = urlHost+'booklet/show/type/'+book+'/date/'+currentDate+'/';
    
    $('#bookletContent').load(myUrl, function() {
        $(".loading").hide();
        $('#bookletMenuLi .liButtonMenu').removeClass('selected');
        $(button).addClass("selected");
    });

}

if(localStorage.getItem('defaultBooklet')!='undefined' && localStorage.getItem('defaultBooklet') != null) {
  let defaultBooklet = localStorage.getItem('defaultBooklet');
  book = defaultBooklet;
  button = "#button"+book;
} else {
  book = "Draft";
  button = "#button"+book;
}

loadBooklet(book, button);
$('#addBookletButton').trigger('click');

// navigation onglet menu
$('#bookletMenuLi .liButtonMenu').click(function() {
    let book = $(this).data('book');
    localStorage.setItem('defaultBooklet', book);
    button = "#button"+book;
    loadBooklet(book, button)
})

// fast Search in form 
const closeFastSearchResultBooklet = () => {
    $('#fastSearchResultBooklet').hide();
}


const deleteBookChild = (bookletchildid) => {

    if (confirm("Vous allez supprimer ce carnet. Voulez-vous continuer ?") == true) {

            let data = '';

            let url = $("#urlApi").val() + 'bookletchild/delete/' + bookletchildid;

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
                    toastr.success("livret supprimé");
                }, success(data) {
                console.log(data);
                }, error(data) {
                    console.log("error");
                }
            });
            $('#bookletChildRow'+bookletchildid).hide();
    } 


}

const addToInput = (childId, fullname) => {
    $('#fastSearchResultBooklet').hide();
    $('#fastSearchBooklet').val('');
    $('#createBookletChildId').val(childId);
    $('#showChildName').html(fullname);
}


$('#createBooklet').click(function() {

    console.log('save');
    // récupeer l'id du child
    let childId = $('#createBookletChildId').val();

    // récuprer l'id du livret
    let bookletId = $('#createBookletBookletId').val();

    // récuprer l'id du staff
    let staffId = $('#createBookletStaffId').val();


    let url = `${urlHost}booklet/createBookletChild/childId/${childId}/bookletId/${bookletId}/staffId/${staffId}/`;

    $('#resultSaved').load(url);
    location.reload(true);

})


$('#updateDateValidationButton').click(function() {

    let dateEvaluation = $('#updateDateValidation').val();

    let url = $("#urlApi").val() + 'bookletchild/change/evaluation/date/' + dateEvaluation;

    $.ajax({
        url: url,
        type: 'GET',
        contentType: "application/json",
        headers: {
            'Authorization': 'Bearer ' + tokenAuth
        },
        crossDomain: true,
        dataType: "json",
        beforeSend() {
        }, success() {
            toastr.success("Date d'évaluation modifiée");
        }, error() {
            toastr.error("Problème sur la date");
        }
    });

    location.reload(true);

});




$('#fastSearchBooklet').keyup(function() {
    let search = $(this).val();

    if (search.length > 2) {

        const regex = /'/gi;
        search = search.replace(regex, '27');

        let url = `child/fastsearch/${search}`;

        $.ajax({
        type: "POST",
        url: urlRequest,
        data: {
            url,
            type: "GET"
        },
        dataType: "json",
        beforeSend() {
            $('#fastSearchResultBooklet').show();
            $('#fastSearchResultContentBooklet').empty();
        },
        success(json) {

            const numberOfElements = json.length;

            if (numberOfElements > 0) {
            let line = "<ul>";
            for (i = 0; i < numberOfElements; i++) {
                line += `<li style="list-style: none; border-bottom: 1px solid lightgrey; width: 100%;"> 
                                    
                                    <div style="padding-top: 10px; color: darkblue; cursor: pointer;" onclick="addToInput(${json[i].id}, '${json[i].fullname}')">
                                        #${json[i].id} - ${json[i].fullname}
                                    </div>
                                </li>`;
            }
            line += "</ul>";
            $("#fastSearchResultContentBooklet").html(line);
            } else {
            $("#fastSearchResultContentBooklet").html(
                "<p><strong><center>Aucun résultat.</center></strong></p>"
            );
            }
        }
        });
    }
});

