<?php $title = "Liste des aliments"; ?>

<h1>Liste des aliments</h1>

<div class="text-center"><a href="add"><button class="button">Ajouter un aliment </button></a></div>

<!--<input type="search" id="searchListFood" placeholder="Rechercher">-->
<h2>Aliments disponibles</h2>
<section class="block-list">
    <ul id="foodList">
        <?php foreach($params->actives as $activeFood): ?>
            <li>
                <a href="<?= HOST ?>food/display/id/<?= $activeFood->foodId; ?>/">
                    <div>
                        <p class="list-header">
                            <img src="<?= ("" !== $activeFood->photo) ? HOST.$activeFood->photo : IMG.'no_photo_2.jpg';  ?>" class="width-30 height-30" />
                            <?= $activeFood->name; ?>

                        <div class="with-icon">
                            <i class="material-icons">send</i>
                        </div>
                        </p>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<h2 class="margin-top-20">Aliments indisponibles</h2>
<section class="block-list">
    <ul id="foodList">
        <?php foreach($params->disabled as $disFood): ?>
            <li>
                <a href="<?= HOST ?>food/display/id/<?= $disFood->foodId; ?>/">
                    <div>
                        <p class="list-header">
                            <img src="<?= ("" !== $disFood->photo) ? HOST.$disFood->photo : IMG.'no_photo_2.jpg';  ?>" class="width-30 height-30" />
                            <?= $disFood->name; ?>

                        <div class="with-icon">
                            <i class="material-icons">send</i>
                        </div>
                        </p>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<h2 class="margin-top-20">Aliments archivés</h2>
<section class="block-list">
    <ul id="foodList">
        <?php foreach($params->archived as $archivedFood): ?>
            <li>
                <a href="<?= HOST ?>food/display/id/<?= $archivedFood->foodId; ?>/">
                    <div>
                        <p class="list-header">
                            <img src="<?= ("" !== $archivedFood->photo) ? HOST.$archivedFood->photo : IMG.'no_photo_2.jpg';  ?>" class="width-30 height-30" />
                            <?= $archivedFood->name; ?>

                        <div class="with-icon">
                            <i class="material-icons">send</i>
                        </div>
                        </p>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<!--<div class="text-center margin-top-12"><button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListFood"> Afficher plus </button></div>

<input type="hidden" id="pageSearch">-->

