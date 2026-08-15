<?php $title = "TV Settings"; ?>

<h1> Paramètres de la EA TV </h1>

<div data-closable class="callout alert-callout-subtle info">
  <strong>Information !<br></strong> 
  La TV possède trois modules. Un module transport, un module activités et un module personnalisable qui est un diaporama d'une ou plusieurs images. Veuillez définir les heures de diffusion pour chaques modules.
  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
    <span aria-hidden="true">⊗</span>
  </button>
</div>

<div class="reveal mobile-ios-modal" id="action-tv" data-reveal>
  <div class="mobile-ios-modal-inner">
    <p>Définir un module TV</p>
    <label>
      Heure de début
      <input type="time" id="start">
    </label>
    <label>
      Heure de fin
      <input type="time" id="end">
    </label>
    <label>
      Choix du module 
      <select name="module" id="module">
        <option value="gallery">Diaporama</option>
        <option value="transport">Transports</option>
        <option value="activity">Activités </option>
      </select>
    </label>
  </div>
  <div class="mobile-ios-modal-options">
    <button data-close class="button">Fermer</button>
    <button class="button" onclick="addModule()">Ok</button>
  </div>
</div>


<div class="text-center margin-top-10">
  <button class="button" data-open="action-tv">Ajouter une plage horaire </button> 
</div>

<section class="block-list">
  <header>Définition des heures de diffusion </header>
  <ul id="hoursList">
    <?php foreach($params->tv as $tv): ?>
    <li>
      <span class="content">
        <div>
          <p class="list-header">
            <img src="<?= IMG ?>module-<?= $tv->module; ?>.png" class="width-30 height-30" />
            <?= ucfirst($tv->start); ?> à <?= ucfirst($tv->end); ?>  
            <aside class="subtitles">
              Module 1 : <?= ucfirst($tv->module); ?>
            </aside>
            <div class="with-icon">
              <a href="#" onclick="removeThisModule('<?= $tv->televisionId; ?>', this)"> 
                <i class="material-icons">delete</i>
              </a>
            </div>
          </p>
        </div>
      </span>
    </li>
    <?php endforeach; ?>
  </ul>
</section>

<h2 class="text-center margin-top-20"> Diaporama </h2>
  <div class="grid-container margin-top-20">
    <div class="grid-x grid-padding-x">
      <div class="medium-6 cell margin-bottom-16">
        <div class="dropContainer" id="dropContainer">
          <div class="contentDropContainer">
            <div class="image-upload">
              <label class="labelFileInput" for="fileInput">
                <a class="button withIcon"><i class="material-icons">create_new_folder</i> Parcourir mes fichiers </a>
              </label>
              <input type="file" id="fileInput" onchange="previewOnDiv2()"/>
            </div>
            Glisser et déposer votre photo ici
          </div>
        </div>
      </div>
      <div class="medium-6 cell">
        <div class="photoContainer"><img src="<?= IMG ?>no_photo_2.jpg" id="photoRender"></div>
      </div>
  </div>
</div>

<section class="block-list">
	<header>Définition des images du module "Diaporama" </header>
  <ul id="picList">
  	<?php foreach($params->pic as $pic):
        if(strlen($pic) > 3): ?>
        <li>
          <span class="content">
            <div>
              <p class="list-header">
              	 <img src="<?= HOST ?>uploads/tv/<?= $pic ?>" class="width-30 height-30" />
                Image dans diaporama
                <div class="with-icon"  >
                  <a href="#" onclick="removeThisImg('uploads/tv/<?= $pic ?>', this)"> <i class="material-icons">delete</i></a>
                </div>
              </p>
            </div>
          </span>
        </li>
    <?php endif;
    endforeach ;?>
  </ul>
</section>

<h2 class="text-center margin-top-20"> Image de background </h2>
  <div class="grid-container margin-top-20">
    <div class="grid-x grid-padding-x">
      <div class="medium-6 cell margin-bottom-16">
        <div class="dropContainer" id="dropContainer2">
          <div class="contentDropContainer">
            <div class="image-upload">
              <label class="labelFileInput" for="fileInput2">
                <a class="button withIcon"><i class="material-icons">create_new_folder</i> Parcourir mes fichiers </a>
              </label>
              <input type="file" id="fileInput2" onchange="previewOnDiv2()"/>
            </div>
            Glisser et déposer votre photo ici
          </div>
        </div>
      </div>
      <div class="medium-6 cell">
        <div class="photoContainer2 photoContainer"><img src="<?= IMG ?>no_photo_2.jpg" id="photoRender2"></div>
      </div>
  </div>
</div>

<section class="block-list">
	<header>Image de fond de la TV </header>
  <ul id="picList">
  	<?php foreach($params->picBackground as $picBackground):
        if(strlen($picBackground) > 3): ?>
        <li>
          <span class="content">
            <div>
              <p class="list-header">
              	<a href="<?= HOST ?>uploads/tv/background/<?= $picBackground ?>" target="_blank"> 
                  <img src="<?= HOST ?>uploads/tv/background/<?= $picBackground ?>" class="width-30 height-30" />
                </a>
                Image de background
                <div class="with-icon"  >
                  <a href="#" onclick="removeThisImg('uploads/tv/background/<?= $picBackground ?>', this)"> <i class="material-icons">delete</i></a>
                </div>
              </p>
            </div>
          </span>
        </li>
    <?php endif;
    endforeach ;?>
  </ul>
</section>