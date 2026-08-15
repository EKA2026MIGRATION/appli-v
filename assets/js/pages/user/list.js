document.getElementById("loadMoreListUser").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");

        if ($("#searchListUser").val() != "") {
            const searchTerm = $("#searchListUser").val();
            var pageSuivante = parseInt($("#pageSearch").val()) + 1;
            var url = `user/api/search/${searchTerm}?size=${size}&page=${pageSuivante}`;
            $("#pageSearch").val(pageSuivante);
        } else {
            var pageSuivante = page + 1;
            var url = `user/api/list?page=${pageSuivante}&size=${size}`;
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


                        $("#userList").append(
                            `<li onclick="openProfil(this)" data-id="${json[i].identifier}"><a href="#" ><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${
                                json[i].email
                                } <div class="with-icon"> <i class="material-icons">send</i></div> </p>  </div> </a></li>`
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

document.getElementById("searchListUser").addEventListener(
    "keyup",
    function(event) {
        let searchTerm = $(this).val();
        let size = $("#loadMoreListUser").attr("data-size");
        let url = `user/api/search/${searchTerm}?size=${size}?page=1`;
        $("#userList").html("");
        $("#pageSearch").val(1);
        $("#loadMoreListUser").attr("disabled", false);

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type: "GET" },
            dataType: "json",
            beforeSend() {
                $(".loading").show();
            },
            success(json) {
                const numberOfElements = json.length;
                $(".loading").hide();
                if (numberOfElements > 0) {
                    $("#userList").html("");
                    for (i = 0; i < numberOfElements; i++) {
                        let photo = photoProfilDefault;

                        $("#userList").append(
                            `<li onclick="openProfil(this)" data-id="${json[i].identifier}"><a href="#"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${
                                json[i].email
                                } <div class="with-icon"> <i class="material-icons">send</i></div> </p>  </div> </a></li>`
                        );
                    }
                } else {
                    $("#userList").html(
                        "<p><strong><center>Aucun résultat.</center></strong></p>"
                    );
                }
            }
        });
    },
    false
);

var openProfil = data =>
{
    location.href = urlHost + "user/display/id/" + $(data).attr('data-id') + "/";
}

