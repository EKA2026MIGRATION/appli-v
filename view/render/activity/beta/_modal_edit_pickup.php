<div id="editModalDiv">

    <button class="close-button"data-close aria-label="Close modal"type="button" id="closeEditModalDiv">
        <span aria-hidden="true">&times;</span>
    </button>

    <div id="editModalChildName"></div>
    <div><span id="editModalChildAge"></span> ans</div>

    <div>
        <b>Sport(s) prévu(s) - Horaires</b>
        <div id="editModalPickup">
        </div>
    </div>

    <form method="post"id="pickupActivityForm"action="pickup-activity/create">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">

                <div id="editModalGroupList"></div>

                <section class="block-list" id="create_pickup" style="display:none">
                    <div>
                        <ul>
                            <li style="padding-left: 0;">
                                <div>
                                    <p class="list-header second-row" style="padding-left: 0; margin-left: 1rem !important;">
                                        <span style="color: darkred">Voulez-vous modifier les inscriptions liées ?</span>
                                        <aside class="subtitles"></aside>
                                    <div class="with-icon">
                                        <div class="switch">
                                            <input class="switch-input"  id="updateAllRegistration" type="checkbox" >
                                            <label class="switch-paddle" for=updateAllRegistration></label>
                                        </div>
                                    </div>
                                    </p>
                                </div>
                            </li>
                            <li style="padding-left: 0;">
                                <a href="javascript:void(0)">
                                    <div>
                                        <p class="list-header second-row" style="padding-left: 0; margin-left: 1rem !important;">
                                            Souhaitez-vous créer une présence ?
                                            <aside class="subtitles"></aside>
                                        <div class="with-icon">
                                            <div class="switch">
                                                <input class="switch-input"  id="addPresence" type="checkbox" >
                                                <label class="switch-paddle" for=addPresence></label>
                                            </div>
                                        </div>
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <li style="padding-left: 0;">
                                <a href="javascript:void(0)">
                                    <div>
                                        <p class="list-header second-row" style="padding-left: 0; margin-left: 1rem !important;">
                                            Souhaitez-vous créer un transport ?
                                            <aside class="subtitles"></aside>
                                        <div class="with-icon">
                                            <div class="switch">
                                                <input class="switch-input"  id="addTransport" type="checkbox" >
                                                <label class="switch-paddle" for=addTransport></label>
                                            </div>
                                        </div>
                                        </p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </form>

    <div class="medium-12 cell text-center">
        <a href="javascript:void(0)"  class="button large"  onclick="changeStatus()">
            Passer présent / absent
        </a>
    </div>
</div>
