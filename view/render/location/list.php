<?php $title="Gestion des lieux"; ?>

<h1> Lieux </h1>

<div class="reveal mobile-ios-modal" id="action-location" data-reveal>

    <div class="mobile-ios-modal-options-stacked">
        <button data-close class="button" data-open="createLocation" onclick="editLocation()">Modifier</button>
        <button data-close class="button" onclick="deleteLocation()">Supprimer</button>
        <button data-close class="button" style="color:red;">Fermer</button>
    </div>
</div>

<div class="reveal" id="createLocation" data-reveal>
    <p class="lead">Lieux </small></p>

    <div class="containerLoader displayNone" id="loaderFormEditLocation" ><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

    <form method="post" id="locationForm" action="location/create">
        <input type="hidden" name="photo" id="photoUrl" value="">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="medium-12 cell">
                    <label>Nom du lieu *
                        <input type="text" name="name" placeholder="Nom du lieu" required>
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Adresse *
                        <input type="text" name="address" placeholder="Adresse" required>
                    </label>
                </div>

                <div class="medium-12 cell">
                    <div class="dropContainer" id="dropContainer">
                        <div class="contentDropContainer">

                            <div class="image-upload">

                                <label class="labelFileInput" for="fileInput">
                                    <a class="button withIcon"><i class="material-icons">create_new_folder</i> Parcourir mes fichiers </a>
                                </label>

                                <input type="file" id="fileInput" onchange="previewOnDiv()"/>

                            </div>
                            Glisser et déposer votre photo ici
                        </div>
                    </div>

                </div>
                <div class="medium-12 cell margin-top-10">
                    <div class="photoContainer"><img src="<?= IMG ?>no_photo_2.jpg" id="photoRender"></div>
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

<div class="text-center"><button class="button" onclick="changeActionLocation()" data-open="createLocation"> Ajouter un lieu </button></div>

<section class="block-list">
    <ul id="locationList">

        <?php foreach($params as $location):?>
            <li data-id-location="<?= $location->locationId; ?>">
                <a href="javascript:void(0)" onclick="getIdLocation('<?= $location->locationId; ?>')" data-open="action-location">
                     <div>
                        <p class="list-header">
                            <img src="<?= ("" != $location->photo) ? HOST.$location->photo : IMG.'no_photo_2.jpg';  ?>" class="width-30 height-30" >
                            <?= $location->name; ?> - <?= $location->address; ?>
                            <aside class="subtitles"></aside>
                            <div class="with-icon">
                                <i class="material-icons">edit</i>
                            </div>
                        </p>
                    </div>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</section>

<div class="text-center margin-top-12">
    <button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreLocation"> Afficher plus </button>
</div>


<input type="hidden" id="pageSearch">
<input type="hidden" id="lastIdLocation">