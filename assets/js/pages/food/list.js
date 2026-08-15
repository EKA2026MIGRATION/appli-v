document.getElementById("loadMoreListFood").addEventListener(
    "click",
    function(event) {
        const element = $(this);
        let page = parseInt($(element).attr("data-page"));
        const size = $(element).attr("data-size");

        if ($("#searchListFood").val() != "") {
            const searchTerm = $("#searchListFood").val();
            var pageSuivante = parseInt($("#pageSearch").val()) + 1;
            var url = `food/search/${searchTerm}?size=${size}&page=${pageSuivante}`;
            $("#pageSearch").val(pageSuivante);
        } else {
            var pageSuivante = page + 1;
            var url = `food/list?page=${pageSuivante}&size=${size}`;
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

                        $("#foodList").append(
                            `<li><a href="display/id/${
                                json[i].foodId
                                }/"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${
                                json[i].name
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

document.getElementById("searchListFood").addEventListener(
    "keyup",
    function(event) {
        let searchTerm = $(this).val();
        let size = $("#loadMoreListFood").attr("data-size");
        let url = `food/search/${searchTerm}?size=${size}&page=1`;
        $("#foodList").html("");
        $("#pageSearch").val(1);
        $("#loadMoreListFood").attr("disabled", false);

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type: "GET" },
            dataType: "json",
            beforeSend() {
                $("#foodList").html(showLoader);
            },
            success(json) {
                const numberOfElements = json.length;

                if (numberOfElements > 0) {
                    $("#foodList").html("");

                    for (i = 0; i < numberOfElements; i++) {
                        let photo = photoProfilDefault;

                        if (json[i].photo != null) {
                            photo = urlHost + json[i].photo;
                        }

                        $("#foodList").append(
                            `<li><a href="display/id/${
                                json[i].foodId
                                }/"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${
                                json[i].name
                                }<div class="with-icon"> <i class="material-icons">send</i></div> </p>  </div> </a> <a href=""</li>`
                        );
                    }
                } else {
                    $("#foodList").html(
                        "<p><strong><center>Aucun résultat.</center></strong></p>"
                    );
                }
            }
        });
    },
    false
);