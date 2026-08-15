<?php $currentRegistrations = $params->registrations; ?>
<?php $noChild = 1; ?>

<div class="tabs-panel" id="panel6">

        <div class="reveal mobile-ios-modal" id="action-registration" data-reveal>
            <div class="mobile-ios-modal-options-stacked">
                <button data-close class="button" onclick="viewRegistration()">Afficher l'inscription</button>
                <button data-close class="button" onclick="viewInvoice()">Afficher la facture</button>
                <button data-close class="button" data-open="modifyRegistration" onclick="editRegistration()">Modifier le montant / le statut</button>
                <button data-close class="button" style="color:red;">Fermer</button>
            </div>
        </div>


        <div class="reveal" id="modifyRegistration" data-reveal>
            <p class="lead">Inscription</small></p>

            <div class="containerLoader displayNone" id="loaderFormEditRegistration" ><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

            <form method="post" id="registrationForm" action="registration/create">
                <div class="grid-container">
                    <div class="grid-x grid-padding-x">

                        <div class="medium-12 cell">
                            <label>Montant déjà payé
                                <input type="number" name="payed" step="any" placeholder="Montant payé" required>
                            </label>
                        </div>

                        <div class="medium-12 cell">
                            <label>Statut
                                <select name="status">
                                    <option value="unpayed">Non payé</option>
                                    <option value="waiting">En attente paiement</option>
                                    <option value="payed">Payé</option>
                                </select>
                            </label>
                        </div>
                        <div class="medium-12 cell" style="margin-top: 10px;">
                            <center><button type="submit" class="button">Envoyer </button></center>
                        </div>
                    </div>
                </div>
            </form>

            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>

        <section class="block-list">
                        

            <div class="vehicle flexEvenly">
            <section>
                Du <br/>
                <input type="date" id="registrationFrom" name="registrationFrom" value="<?= $params->from;?>">
            </section>

            <section>
                Au <br/>
                <input type="date" id="registrationTo" name="registrationTo" value="<?= $params->to;?>">
            </section>

            <section>
                <button class="button" style="margin-top: 20px;" onclick="updateData('registration')">Afficher</button>
            </section>
            </div>
        </section>



        <div id="registrationContent">
            <section class="block-list">
                <?php include VIEW.'render/registration/_list.php'; ?>
                <input id="lastIdRegistration" type="hidden"/>
                <input id="lastIdInvoice" type="hidden"/>
            </section>
        </div>

</div>
