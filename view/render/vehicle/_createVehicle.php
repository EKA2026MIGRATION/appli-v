
<div class="reveal" id="createVehicle" data-reveal>
  <p class="lead">Véhicules </p>

  <div class="containerLoader displayNone" id="loaderFormEditVehicle" ><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

  <form method="post" id="vehicleForm" action="vehicle/create">
    <input type="hidden" name="photo" id="photoUrl" value="" />
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
          <label>Nom du véhicule *
            <input type="text" name="name" placeholder="Nom du véhicule" required>
          </label>
        </div>
        <div class="medium-12 cell">
          <label>Immatriculation *
            <input type="text" name="matriculation" placeholder="Immatriculation" required>
          </label>
        </div>
        <div class="medium-12 cell">
          <label>Kilométrage *
            <input type="text" name="mileage" placeholder="Kilométrage" required>
          </label>
        </div>
        <div class="medium-12 cell">
          <label>Combustible
            <input type="text" name="combustible" placeholder="Combustible" > <!--TODO penser à mettre en select -->
          </label>
        </div>
        <div class="medium-12 cell">
            <label>Nombre de places max
                <input type="number" name="places" required>
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
        <div class="medium-12 cell" style="margin-top: 10px;">
          <div class="photoContainer"><img src="<?= IMG ?>no_photo_2.jpg" id="photoRender"></div>
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
  <p>* champ obligatoire</p>
</div>
