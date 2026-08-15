<?php $title = "Liste des composants"; ?>

<h1>Liste des composants</h1>

<div class="reveal mobile-ios-modal" id="action-component" data-reveal>

    <div class="mobile-ios-modal-options-stacked">
        <button data-close class="button" data-open="createComponent" onclick="editComponent()">Modifier</button>
        <button data-close class="button" onclick="deleteComponent()">Supprimer</button>
        <button data-close class="button" style="color:red;">Fermer</button>
    </div>
</div>

<div class="reveal" id="createComponent" data-reveal>
    <p class="lead">Composant </small></p>

    <div class="containerLoader displayNone" id="loaderFormEditComponent" ><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

    <form method="post" id="componentForm" action="component/create">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="medium-12 cell">
                    <label>Nom du composant *
                        <input type="text" name="nameFr" placeholder="Nom du composant" value="" required>
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Component name *
                        <input type="text" name="nameEn" placeholder="Name in english please" value="" required>
                    </label>
                </div>

                <div class="medium-12 cell">
                    <label> TVA *
                        <select id="vat" name="vat" required>
                            <option value="10">10%</option>
                            <option value="20">20%</option>
                        </select>
                    </label>
                </div>

                <div class="medium-12 cell margin-top-10">
                    <center><button type="submit" class="button">Envoyer </button></center>
                </div>
            </div>
        </div>
    </form>

    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>

    <p>* champ obligatoire</p>
</div>

<div class="text-center"><button class="button" onclick="changeActionComponent()" data-open="createComponent"> Ajouter un composant </button></div>

<input type="search" id="searchListComponent" placeholder="Rechercher">

<section class="block-list">
    <ul id="componentList">
        <?php foreach($params as $component): ?>

            <li data-id-component="<?= $component->componentId; ?>">
                <a href="javascript:void(0)" onclick="getIdComponent('<?= $component->componentId; ?>')" data-open="action-component">
                    <div>
                        <p class="list-header" style="padding-left: 0; margin-left: -15px;">
                            <?= $component->nameFr ?>
                            <aside class="subtitles"></aside>
                            <div class="with-icon">
                                <i class="material-icons">edit</i>
                            </div>
                        </p>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<div class="text-center margin-top-12"><button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListComponent"> Afficher plus </button></div>

<input type="hidden" id="pageSearch">
<input type="hidden" id="lastIdComponent">