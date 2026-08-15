<?php $title = "Liste des enfants"; ?>

<h1>Liste des enfants</h1>  

<div class="text-center"><a href="<?= HOST ?>child/add" class="button" target="_self" >Ajouter un enfant </a></div>


<input type="search" id="searchListChild" placeholder="Rechercher">

<section class="block-list">
  <ul id="childList">    
    <?php foreach($params as $child):?>
      <li>
        <a href="<?= HOST ?>child/display/id/<?= $child->childId; ?>/">
          <div>
            <p class="list-header">
              <img src="<?= ("" != $child->photo) ? HOST.$child->photo : IMG.'no_photo.jpg';  ?>" class="width-30 height-30" />

              <?= $child->firstname." ".$child->lastname; ?>
              
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

<div class="text-center margin-top-12" ><button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListChild"> Afficher plus </button></div>

<input type="hidden" id="pageSearch">
