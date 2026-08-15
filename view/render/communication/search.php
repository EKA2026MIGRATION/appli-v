<?php $title = "Liste d'envoi"; ?>
<h3 class="text-center margin-top-20">Récupérer une liste</h3>

<div class="medium-12 cell">
    <center><a href="#" class="button margin-top-20">Liste déjà existante</a></center>
</div>


<h3 class="text-center margin-top-20">Nouvelle liste</h3>


<form method="post" id="searchForm" action="food/<?= (1 === $update) ? 'modify/'.$params->foodId : 'create';  ?>">
    <input type="hidden" name="photo" id="photoUrl" value="<?= (1 === $update) ?  $params->photo: '';  ?>">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="medium-4 cell">
                <label>Requête *
                   <select id="request">
                        <option value="school">école</option>
                        <option value="age">âge</option>
                        <option value="country">pays</option>
                    </select>
                </label>
            </div>
            <div class="medium-4 cell">
                <label>Opérateur logique *
                    <select id="operateur">
                        <option value="like">contient</option>
                        <option value="=">est égale à</option>
                        <option value="!=">n'est pas égale à</option>
                    </select>
                </label>
            </div>
            <div class="medium-4 cell">
                <label>Valeur *
                    <input type="text" id="value" placeholder="Valeur" required>
                </label>
            </div>
        
            <div class="medium-12 cell">
                <center><a href="#" class="button margin-top-20">Ajouter cette condition</a></center>
            </div>

        
            <div class="medium-12 cell">
                <center><input type="submit" class="button large margin-top-20" value="Rechercher" /></center>
            </div>
        </div>
    </div>
</form>

<h3 class="text-center margin-top-20">Choix d'un sondage</h3>

<section class="block-list">
  <ul id="surveyList">    
      <li>
        <a href="#">
          <div>
            <p class="list-header">
                <img src="<?= IMG.'no_photo_2.jpg';  ?>" class="width-30 height-30" />

                Sondage sur la qualité des cours d'anglais

                <div class="with-icon">
                    <input class="switch-input" id="test" type="checkbox" name="test" checked>
                    <label class="switch-paddle" for="test"></label>
                </div>

            </p> 
          </div>
        </a>
      </li>
  </ul>
</section>


<h3 class="text-center margin-top-20">SMS et/ou Email </h3>


<form method="post" id="foodForm" class="margin-top-20">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="medium-12 cell">
                <textarea placeholder="Envoyer un e-mail (VOIR TINYMCE)"></textarea>
            </div>
            <div class="medium-12 cell">
                <textarea placeholder="Envoyer un SMS"></textarea>
            </div>

            <div class="medium-12 cell">
                <center><input type="submit" class="button large margin-top-20" value="Envoyer" /></center>
            </div>
        </div>
    </div>
</form>

<section class="block-list">
  <header style="display: flex; align-items: center; justify-content: flex-start;">
     <a href="javascript:void(0)" style="width: auto;"><i class="material-icons arrow">keyboard_arrow_down</i> </a> <span> Liste génerée </span>
  </header>
  <ul id="childList">    
    <?php foreach($params->childs as $child):?>
      <li style="display: none;">
        <a href="#">
          <div>
            <p class="list-header">
                <img src="<?= ("" != $child->photo) ? HOST.$child->photo : IMG.'no_photo.jpg';  ?>" class="width-30 height-30" />

                <?= $child->firstname." ".$child->lastname; ?>

                <div class="with-icon">
                    <input class="switch-input" id="<?= $child->childId; ?>" type="checkbox" name="<?= $child->childId; ?>" checked>
                    <label class="switch-paddle" for="<?= $child->childId; ?>"></label>
                </div>

            </p> 
            <p>

               <input type="checkbox" checked> admin@energyacademy.fr <br/>

               <input type="checkbox" checked> 06 06 06 06 06 <br/>

               <input type="checkbox" checked> 06 06 06 06 06 <br/>

               <input type="checkbox" checked> 06 06 06 06 06 <br/>

               <input type="checkbox" checked> 06 06 06 06 06

            </p>
          </div>
        </a>
      </li>
    <?php endforeach; ?>

  </ul>
</section>

