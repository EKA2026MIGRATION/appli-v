<?php $title = "Liste des inscriptions"; ?>


<h1>Liste des inscriptions</h1>  

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
                            <option value="waiting">En attente de paiement</option>
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


<div class="text-center"><a href="<?= HOST ?>registration/add"><button class="button">Ajouter une inscription </button></a></div>

<section class="block-list">
  <?php $currentRegistrations = $params;?>
  <?php include('_list.php');?>
</section>

<!---
<div class="text-center margin-top-12" ><button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListRegistration"> Afficher plus </button></div>
--->
<input type="hidden" id="pageSearch">
<input type="hidden" id="lastIdRegistration">
