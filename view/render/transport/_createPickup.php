
<div class="reveal" id="revealPickUp" data-reveal>
    <p class="lead">Créer / Modifier un pickup</p>


    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>

    <div class="containerLoader" id="loaderFormEditPickUp" style="display: none;"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

    <form method="post" id="pickUpForm" action="pickup/create">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="medium-12 cell">

                    <?php $date = date('Y-m-d'); ?>
                    <input type="hidden" name="child" id="formChildId" value="">

                    <input type="hidden" name="sortOrder" value="12">
                    <label>Prise en charge/Dépose
                        <select name="kind" id="kindPickup" required>
                            <option value="dropin">Prise en charge</option>
                            <option value="dropoff">Dépose</option>
                        </select>
                    </label>
                    <div class="medium-12 cell">
                        <label>Heure de prise en charge
                            <input type="time"  onkeyup="changeDateStart()" onchange="changeDateStart()" id="start_not" value="08:00" placeholder="Heure de prise en charge">
                        </label>
                    </div>
                    <div class="medium-12 cell" id="listChildPickUp" >
                        <label>Associer un enfant
                            <input type="search" id="searchListChild" placeholder="Rechercher un enfant ">
                        </label>

                        <section class="block-list">
                            <ul id="childList"></ul>
                        </section>

                        <div class="text-center" style="margin-top: 12px;"><button class="button" style="display: none;" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListChild"> Afficher plus </button></div>
                    </div>


                    <label>Adresse
                        <input type="text" name="address" id="autocomplete3" placeholder="Adresse de prise en charge">
                    </label>
                    <label>Code postal (auto-dispatch)
                        <input type="text" id="postal_pickup" name="postal" value="">
                    </label>
                    <label>Montant à faire payer
                        <input type="number" id="payment_due" name="payment_due" value="">
                    </label>
                    <label>Montant payé
                        <input type="number" id="payment_done" name="payment_done" value="">
                    </label>

                    <div class="containerLoader" id="loaderLoadAdress" style="display: none;"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

                    <div id="resultAdress" style="padding-top: 5px; padding-bottom: 5px;"></div>

                </div>
                <input type="hidden" id="start_note_2" name="start" value="<?php echo $params->date; ?> 08:00">
                <div class="medium-12 cell">
                    <label>Commentaire (facultatif)
                        <input type="text" name="comment" placeholder="Commentaire" value="">
                    </label>
                </div>
                  <section class="block-list" id="create_pickup">
                      <div>
                        <ul>
                             <li style="padding-left: 0;">
                                <a href="javascript:void(0)">
                                    <div>
                                        <p class="list-header second-row" style="padding-left: 0; margin-left: 1rem !important;">
                                            Souhaitez-vous créer une activité ?
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon">
                                               <div class="switch">
                                                      <input class="switch-input"  id="addActivity" type="checkbox" >
                                                      <label class="switch-paddle" for=addActivity></label>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                      </div>
                  </section>


                <input type="hidden" id="pageSearch">


                <div class="medium-12 cell">
                    <center><input type="submit" class="button" value="Envoyer" />
                </div>
            </div>
        </div>
    </form>

</div>
