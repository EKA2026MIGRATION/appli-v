
document.addEventListener("DOMContentLoaded", function(event) {
    const urlApi = $('#urlApi').val();
    const tokenAuth = $("#tokenAuth").val();

    let photos = document.querySelectorAll(".photo");
    let fullscreen = document.getElementById("fullscreen");
    let fullscreenImg = fullscreen.querySelector("img");
    let fullscreenTitle = fullscreen.querySelector("#fullscreenTitle");
    let fullscreenDesc = fullscreen.querySelector("#fullscreenDesc");
    let fullscreenStatus = fullscreen.querySelector("#fullscreenStatus");
    let fullscreenChildName = fullscreen.querySelector("#fullscreenChildName");
    let fullscreenChildId = fullscreen.querySelector("#fullscreenChildId");

    let previousBtn = fullscreen.querySelector(".previous");
    let awaitingValidationBtn = fullscreen.querySelector(".awaiting-validation");
    let onlineBtn = fullscreen.querySelector(".online");
    let deleteBtn = fullscreen.querySelector(".delete");
    let nextBtn = fullscreen.querySelector(".next");
    let currentIndex = 0;

    photos.forEach(function(photo, index) {
        photo.addEventListener("click", function(event) {

            if (!event.target.closest('.selectGroupAction')) {

                let media_id = this.dataset.id;
                let img = this.querySelector("img");
                let title = this.querySelector("h4").textContent;
                let desc = this.querySelector(".description").textContent;
                let status = this.querySelector(".status").textContent;
                let child_name = this.querySelector(".child_name").textContent;
                let child_id = this.querySelector(".child_id").value;

                fullscreenImg.src = img.src;
                fullscreenTitle.value = title;
                fullscreenDesc.value = desc;
                fullscreenStatus.textContent = "Status: " + status;
                fullscreenChildName.value = child_name;
                fullscreen.style.display = "block";
                fullscreenChildId.value = child_id;

                document.getElementById("media_id").value = media_id;
                currentIndex = index;
                updateNavigationButtons();
            }
        });
    });

    previousBtn.addEventListener("click", function() {
        currentIndex = (currentIndex - 1 + photos.length) % photos.length;
        simulateClick(photos[currentIndex]);
        updateNavigationButtons();
        updateFullscreenStatus();

    });

    nextBtn.addEventListener("click", function() {
        currentIndex = (currentIndex + 1) % photos.length;
        simulateClick(photos[currentIndex]);
        updateNavigationButtons();
        updateFullscreenStatus();

    });

    fullscreen.querySelector(".close").addEventListener("click", function() {
        fullscreen.style.display = "none";
    });

    awaitingValidationBtn.addEventListener("click", function() {
        let childId = document.getElementById('fullscreenChildId').value;
        if(childId == "") {
            alert('Attention, ajouter un enfant à la photo pour modifier le statut');
        } else {
            let mediaId = document.getElementById("media_id").value;
            updateStatus(mediaId, "awaiting");
            updatePhotoStatus(mediaId, "awaiting");
        }

    });

    onlineBtn.addEventListener("click", function() {
        let childId = document.getElementById('fullscreenChildId').value;
        if(childId == "") {
            alert('Attention, ajouter un enfant à la photo pour modifier le statut');
        } else {
            let mediaId = document.getElementById("media_id").value;
            updateStatus(mediaId, "online");
            updatePhotoStatus(mediaId, "online");
        }
    });

    deleteBtn.addEventListener("click", function() {
        let childId = document.getElementById('fullscreenChildId').value;

        let mediaId = document.getElementById("media_id").value;
        updateStatus(mediaId, "deleted");
        updatePhotoStatus(mediaId, "deleted");

    });

    const simulateClick = (element) => {
        const event = new MouseEvent("click", {
            bubbles: true,
            cancelable: true,
            view: window
        });
        element.dispatchEvent(event);
    };

    const updateNavigationButtons = () => {
        previousBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === photos.length - 1;
    };

    const updateStatus = (mediaId, newStatus, massive = false) => {
        let title = document.getElementById('fullscreenTitle').value;
        let description = document.getElementById('fullscreenDesc').value;
        let childId = document.getElementById('fullscreenChildId').value;
        
        if(newStatus == "awaiting-validation") {
            newStatus = "awaiting";
        }

        if(childId == "" || massive == true)  {
            let element = document.getElementById('child-name'+mediaId);
            if(element != null) {
                let newChildId = element.dataset.childid;
                if(newChildId != "") {
                    childId = newChildId;
                }
            }
        }

        if(childId == "" && newStatus != "deleted")  {
            alert('Attention, ajouter un enfant à la photo pour modifier le statut');
        } else {
            let data = { 'title' : title, 'description' : description, 'child_id' : childId, 'status' : newStatus}
            console.log("Update status of media with ID " + mediaId + " to " + newStatus);

            data = JSON.stringify(data);
            let url = `${urlApi}media/modify/${mediaId}`;

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
        }
    };

    const updatePhotoStatus = (mediaId, newStatus) => {
        let photo = document.querySelector(`.photo[data-id="${mediaId}"]`);
        if (photo) {
            photo.dataset.status = newStatus;

            // Mettre à jour la classe de l'élément fullscreen.overlay correspondant au nouveau statut
            let fullscreenOverlay = document.querySelector("#fullscreen .overlay");
            if (fullscreenOverlay) {
                fullscreenOverlay.dataset.status = newStatus;
            }
        }
    };

    const updateFullscreenStatus = () => {
        let mediaId = document.getElementById("media_id").value;
        let photo = document.querySelector(`.photo[data-id="${mediaId}"]`);

        if (photo) {
            let newStatus = photo.dataset.status;
            fullscreenStatus.textContent = "Status: " + newStatus;

            // Mettre à jour la classe de l'élément fullscreen.overlay correspondant au nouveau statut
            let fullscreenOverlay = document.querySelector("#fullscreen .overlay");
            if (fullscreenOverlay) {
                fullscreenOverlay.dataset.status = newStatus;
            }
        }
    };

// Gestion des checkbox
    const checkboxes = document.querySelectorAll('.selectGroup');
    const imgChecked = [];
    const updateCheckedValues = (event)=> {
        const checkbox = event.target;
        const valeur = checkbox.value;

        // Vérifiez si la case à cocher est cochée ou décochée et mettez à jour le tableau en conséquence
        if (checkbox.checked) {
            imgChecked.push(valeur);
        } else {
            const index = imgChecked.indexOf(valeur);
            if (index !== -1) {
                imgChecked.splice(index, 1);
            }
        }
    }
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateCheckedValues);
    });

    let groupButtons = document.getElementsByClassName('groupButton');

    for(let i = 0; i < groupButtons.length; i++) {

        let button = groupButtons[i];
        let status = button.dataset.status;
        button.addEventListener('click', function () {
            for(let j = 0; j < imgChecked.length; j++) {
                let mediaId = imgChecked[j];
                updateStatus(mediaId, status, true);
                updatePhotoStatus(mediaId, status);
            }
        });
    };
});




// fast search child
$('#fullscreenChildName').keyup(function () {
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
                $('#searchChildPhotoContent').show();
                $('#searchChildPhotoContent').empty();
            },
            success(json) {

                const numberOfElements = json.length;

                if (numberOfElements > 0) {
                    let line = "<ul>";
                    for (i = 0; i < numberOfElements; i++) {
                        line += `<li style="list-style: none; border-bottom: 1px solid lightgrey; display: flex; justify-content: space-between;">

                                            <div data-childid="${json[i].id}" class="childPhotoLiResult" style="padding-top: 10px; color: darkblue">
                                                #${json[i].id} - ${json[i].fullname}
                                            </div>
                                      </li>`;
                    }
                    line += "</ul>";
                    $("#searchChildPhotoContent").html(line);
                    $('.childPhotoLiResult').click(function() {
                        let child_id = $(this).attr('data-childid');
                        let string = $(this).text();
                        $('#searchChildPhotoContent').empty();
                        $('#searchChildPhotoContent').hide();
                        $('#fullscreenChildName').val(string);
                        $('#fullscreenChildId').val(child_id);
                    })


                } else {
                    $("#searchChildPhotoContent").html(
                        "<p><strong><center>Aucun résultat.</center></strong></p>"
                    );
                }
            }
        });
    }
})
