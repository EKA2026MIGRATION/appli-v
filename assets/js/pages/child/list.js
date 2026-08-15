var childIdFusionList = [];
document.getElementById("loadMoreListChild").addEventListener(
    "click",
    function (event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");

        if ($("#searchListChild").val() != "") {
            const searchTerm = $("#searchListChild").val();
            var pageSuivante = parseInt($("#pageSearch").val()) + 1;
            var url = `child/search/${searchTerm}?size=${size}&page=${pageSuivante}`;
            $("#pageSearch").val(pageSuivante);
        } else {
            var pageSuivante = page + 1;
            var url = `child/list?page=${pageSuivante}&size=${size}`;
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type: "GET" },
            dataType: "json",
            beforeSend() {
                $(element)
                    .attr("disabled", true)
                    .html("Chargement en cours..");
            },
            success(json) {
                $(element)
                    .attr("disabled", false)
                    .html("Afficher plus");
                const numberOfElements = json.length;

                if (numberOfElements > 0) {
                    $("#childList").append('<li><br/>&nbsp;<hr/><br/></li>');
                    for (i = 0; i < numberOfElements; i++) {
                        let photo = photoProfilDefault;

                        if (json[i].photo != null) {
                            photo = urlHost + json[i].photo;
                        }

                        $("#childList").append(
                            `<li><a href="display/id/${
                            json[i].childId
                            }/"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">
                                ${json[i].lastname} ${json[i].firstname}
                                <div class="with-icon"> <i class="material-icons">send</i></div> </p>  </div> </a>
                            </li>`
                        );
                    }

                    $(element).attr("data-page", pageSuivante);
                } else {
                    $(element)
                        .attr("disabled", true)
                        .html("Liste terminée.");
                }

            }
        });
    },
    false
);

document.getElementById("searchListChild").addEventListener(
    "keyup",
    function (event) {
        let searchTerm = $(this).val();
        let size = $("#loadMoreListChild").attr("data-size");

        const regex = /'/gi;
        searchTerm = searchTerm.replace(regex, '27');
        let url = `child/fastsearch/${searchTerm}`;
        $("#childList").html("");
        $("#pageSearch").val(1);
       // $("#loadMoreListChild").attr("disabled", false);


        if (searchTerm.length > 2) {

            $('#childList').html('');
            $.ajax({
                type: "POST",
                url: urlRequest,
                data: { url, type: "GET" },
                dataType: "json",
                beforeSend() {
                    $(".loading").show();
                    $('#childList').html('');
                  //  $('#searchListChild').prop( "disabled", true );
                },
                success(json) {
                    $(".loading").hide();
                   // $('#searchListChild').prop( "disabled", false );
                    const numberOfElements = json.length;

                    if (numberOfElements > 0) {
                        $("#childList").html("");

                        for (i = 0; i < numberOfElements; i++) {
                            let photo = photoProfilDefault;

                            if (json[i].photo != null) {
                                photo = urlHost + json[i].photo;
                            }

                            $("#childList").append(
                                `<li><a href="display/id/${
                                json[i].id
                                }/"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">
                                                <input type="checkbox" class="selectedChild" onchange="addToFusion(${json[i].id})"/>
                                                <span style="font-style: italic; font-size:12px">#${json[i].id}</span>  

                                                ${json[i].fullname}
                                            <div class="with-icon"> <i class="material-icons">send</i></div> </p>  </div> </a></li>`
                            );
                        }
                        let fusionButton = "<div class='text-center'><button class='button' onclick='goToFusion()'>Fusionner les éléments sélectionner</button></div>";
                        $("#childList").append(fusionButton);
                    } else {
                        $("#childList").html(
                            "<p><strong><center>Aucun résultat.</center></strong></p>"
                        );
                    }
                }
            });

        }


    },
    false
);

const addToFusion = childId => {
    // check if child is in array
    let test = childIdFusionList.includes(childId);
    if(test == true) {
        // if in array delete
        let filtered = childIdFusionList.filter(function(value, index, arr){ 
            return value != childId;
        });
        childIdFusionList = filtered;
    } else {
        // if not in array push
        childIdFusionList.push(childId);
    }
 }

const goToFusion = () => {
    let url = `${urlHost}child/showFusion/listId/${childIdFusionList}/`;
    locationRedirect(url);
}
