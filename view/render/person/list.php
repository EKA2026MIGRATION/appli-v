<?php $title = "Liste des personnes"; ?>

<h1>Liste des personnes </h1>

<input type="search"  id="searchListPerson" placeholder="Rechercher">

<section class="block-list">
  <ul id="personList">
    <?php foreach($params as $person):?>
      <li>
        <a href="<?= HOST ?>person/display/id/<?= $person->personId; ?>/">
          <div>
            <p class="list-header">

              <img src="<?= ($person->photo != "") ? $person->photo : IMG.'no_photo.jpg';  ?>" class="width-30 height-30" />

              <?= $person->firstname." ".$person->lastname; ?>

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

<div class="text-center margin-top-12"><button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListPerson"> Afficher plus </button></div>

<input type="hidden" id="pageSearch">
