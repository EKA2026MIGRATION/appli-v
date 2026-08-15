
<div class="tabs-panel" id="panel3">
        <section class="block-list">
            <div class="vehicle flexEvenly">
                <section>
                    Du <br/>
                    <input type="date" id="presenceFrom" name="presenceFrom" value="<?= $params->from2; ?>">
                </section>

                <section>
                    Au <br/>
                    <input type="date" id="presenceTo" name="presenceTo" value="<?= $params->to2; ?>">
                </section>

                <section>
                    <button class="button" style="margin-top: 20px;" onclick="updateData('presence')">Afficher</button>
                </section>
            </div>
        </section>

        <div id="presenceContent">
            <section class="block-list">   
                <section class="block-list">
                    <div id="presenceList">
                       <?php include('_presencesList.php');?>
                    </div>
                </section>
            </section>
        </div>

</div>

<script>

    let elements = document.getElementsByClassName('liPresenceElement');
    var groupLiPresenceRegistrations = [];
    for(let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("mouseover", function(e) {
            let groupIdRegistration = elements[i].getAttribute('data-registration-group');
            showGroupLi(groupIdRegistration);
        });

        elements[i].addEventListener("mouseout", function(e) {
            let groupIdRegistration = elements[i].getAttribute('data-registration-group');
            unshowGroupLi(groupIdRegistration);
        });

        elements[i].addEventListener("click", function(e) {

            let childPresenceId = elements[i].id;

            // add show windows actions
            showActionMenun(childPresenceId);
        });
    }

    function showGroupLi(groupId) {   
        let liElements = document.querySelectorAll('.'+groupId);
        for (let i = 0; i < liElements.length; i++) {
            liElements[i].style.border = "1px solid darkred";
        }
    }

    function unshowGroupLi(groupId) {
        let liElements = document.querySelectorAll('.'+groupId);
        for (let i = 0; i < liElements.length; i++) {
            liElements[i].style.border = "0px solid white";
        }
    }

    function showActionMenun(childPresenceId) {
        console.log(childPresenceId);
        // show the window action
    }

</script>