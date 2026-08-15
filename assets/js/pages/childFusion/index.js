let childIdToKeep = null;
let childIdToDelete = null;
const urlApi = $('#urlApi').val();



$('.selectTypeFusion').change(function() {
    

    let childId = $(this).attr('id').split('-')[1];

    let childItem = $('#childFusionItem-'+childId);

    // color on div child - green <=> toKeep / red <=> toDelete
    
    childItem.removeClass();

    if( $(this).val() == "toKeep") {
        childItem.addClass('toKeep');
        childIdToKeep = childId;

          // inversion
          if(childIdToDelete == childId) {
            childIdToDelete = null;
        }

    }

    if( $(this).val() == "toDelete") {
        childItem.addClass('toDelete');
        childIdToDelete = childId;

        // inversion
        if(childIdToKeep == childId) {
            childIdToKeep = null;
        }

    }

    if( $(this).val() == "neutral") {
        childItem.addClass('neutral');
        if(childIdToDelete == childId) {
            childIdToDelete = null;
        }

        if(childIdToKeep == childId) {
            childIdToKeep = null;
        }

    }

    checkFusionAvalaible();
})


$('#doFusionButton').click(function() {
    if(childIdToKeep != null && childIdToDelete != null) {


        let url = `child/doFusion/${childIdToKeep}/${childIdToDelete}`;

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: {
                url,
                type: "GET"
            },
            dataType: "json",
            beforeSend() {
              
            },
            success(json) {

                let html = "";
                if(json.status == "fusion") {
                    toastr.success("Fusion effectuée");
                    
                    html = `
                            <b>Bilan de la fusion</b><br/>
                            Fiche de l'enfant:
                                `;
                    if(json.child_updated.length > 0) {
                            html += "<ul>";
                            for(let i = 0; i < json.child_updated.length; i++) {
                                html += `<li>${json.child_updated[i]}</li>`;
                            }
                            html += "</ul>";
                    } else {
                        html += "<ul><li>Aucune modifcation</li></ul>";
                    }


                    html += "<br/>Associations modifiées<br/>"

                    if(json.tables_updated.length > 0) {
                        html += "<ul>";
                        for(let i = 0; i < json.tables_updated.length; i++) {
                            html += `<li>${json.tables_updated[i]} : ${json.nb_tables_updated[json.tables_updated[i]]}</li>`;
                        }
                        html += "</ul>";
                    } else {
                        html += "<ul><li>Aucune</li></ul>";
                    }

                    html += "<br/><br/><hr/><br/>";

                    html += `<a href="${urlHost}/child/display/id/${childIdToKeep}/">Voir la fiche finale</a>`;
                    


                } else {

                    toastr.error("Aucune fusion effectuée");

                }

                $('#fusionToDelete').remove();
                $('#fusionDirection').html(html);
            }
        });



    } 
})

const checkFusionAvalaible = () => {

    let isAvailable = true;

    // toKeep
    if(childIdToKeep == null) {
        $('#fusionToKeep').empty();
        isAvailable = false;
    } else {
        let keepDiv = $("#childFusionItem-"+childIdToKeep).clone();
        let showKeepDiv = keepDiv.find('.childInfo');
        $('#fusionToKeep').html(showKeepDiv);
    }


    // toDelete
    if(childIdToDelete == null) {
        $('#fusionToDelete').empty();
        isAvailable = false;
    } else {
        let deleteDiv = $("#childFusionItem-"+childIdToDelete).clone();
        let showDeleteDiv = deleteDiv.find('.childInfo');
        $('#fusionToDelete').html(showDeleteDiv);
    }

    // show window fusion with sens
    if( isAvailable == false) {
        $('#fusionDirection').hide();
    } else {
        $('#fusionDirection').show();

    }

}

