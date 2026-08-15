<?php $title = "Liste des users"; ?>

<h1>Liste des users </h1>



<div class="text-center"><a href="<?= HOST ?>user/add"><button class="button">Ajouter un user </button></a></div>

<input type="search" id="searchListUser" placeholder="Rechercher (par email)">
 
<section class="block-list">
  <ul id="userList">    
    <?php foreach($params as $user):?>
      <li onclick="openProfil(this)" data-id="<?= $user->identifier ?>">
        <a href="#">
          <div>
            <p class="list-header">

              <img src="<?= IMG.'no_photo.jpg';  ?>" class="width-30 height-30" />

              <?= $user->email ?>
              
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

<div class="text-center margin-top-12"><button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListUser"> Afficher plus </button></div>

<input type="hidden" id="pageSearch">
