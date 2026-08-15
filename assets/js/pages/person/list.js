document.getElementById("loadMoreListPerson").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");

        if ($("#searchListPerson").val() != "") {
            const searchTerm = $("#searchListPerson").val();
            var pageSuivante = parseInt($("#pageSearch").val()) + 1;
            var url = `person/searchTerm/${searchTerm}`;
            $("#pageSearch").val(pageSuivante);
        } else {
            var pageSuivante = page + 1;
            var url = `person/list?page=${pageSuivante}&size=${size}`;
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
                    for (i = 0; i < numberOfElements; i++) {
                        let photo = photoProfilDefault;

                        if (json[i].photo != null) {
                            photo = urlHost + json[i].photo;
                        }
                        $("#personList").append(
                            `<li><a href="display/id/${
                                json[i].personId
                                }/"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${
                                json[i].lastname.toUpperCase()
                                } ${
                                json[i].firstname
                                }<div class="with-icon"> <i class="material-icons">send</i></div> </p>  </div> </a></li>`
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

document.getElementById("searchListPerson").addEventListener(
    "keyup",
    function(event) {
        let searchTerm = $(this).val();
        let size = $("#loadMoreListPerson").attr("data-size");
        let url = `person/searchTerm/${searchTerm}`;
        $("#personList").html("");
        $("#pageSearch").val(1);
        $("#loadMoreListPerson").attr("disabled", false);

        let user_info = "";

        console.log(searchTerm);

        if(searchTerm.length > 1)
        {

                    $.ajax({
                        type: "POST",
                        url: urlRequest,
                        data: { url, type: "GET" },
                        dataType: "json",
                        beforeSend() {
                            $("#personList").html(showLoader);
                        },
                        success(json) {
                            const numberOfElements = json.length;
                            let relatives = "";
                            if (numberOfElements > 0) {
                                let html = '';
                                for (i = 0; i < numberOfElements; i++) {
                                    
                                    // if person is a user and email
                                    if(json[i].user_id !== undefined) {
                                        user_info = "<i class='material-icons' style='color: darkblue; font-size: 13px'>verified_user</i><span style='color: black'>"+json[i].user_id+
                                        " - "+json[i].email+"</span>";
                                    } else {
                                       user_info = "";
                                    }

                                    html += 
                                        `<li>
                                            <a href="display/id/${json[i].personId}/">
                                                <div>
                                                    <p class="list-header">
                                                        ${json[i].lastname.toUpperCase()}
                                                        &nbsp; 
                                                        ${json[i].firstname} ${user_info}
                                                        <div class="with-icon"> <i class="material-icons">send</i></div>
                                                    </p>
                                                </div>
                                            </a>
                                        </li>`
                                    ;
                                }

                                $("#personList").html(html);

                            } else {
                                $("#personList").html(
                                    "<p><strong><center>Aucun résultat.</center></strong></p>"
                                );
                            }
                        }
                    });
            }

    },
    false
);
