<div class="reveal" id="createDriver" data-reveal>
  <p class="lead" id="titleReveal" >Staff </small></p>
  <div class="containerLoader displayNone" id="loaderFormEditDriver" <!--style="display: none;-->"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

  <form method="post" id="driverForm" action="staff/create">

    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
            <input type="hidden" name="person" required>
        </div>

        <div class="medium-12 cell" id="linkToPersonPage">
        </div>

        <div class="medium-12 cell" id="listPerson" >
          <label>Associer une personne
            <input type="search" id="searchListPerson" placeholder="Rechercher une personne ">
          </label>
          <section class="block-list">
            <ul id="personList"></ul>
          </section>

          <div class="text-center" style="margin-top: 12px;"><button class="button" style="display: none;" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListPerson"> Afficher plus </button></div>
        </div>

        <div class="medium-12 cell">
            <label>Enfant pris en charge par coach
                <input type="number" name="maxChildren" required>
            </label>
        </div>
        <div class="medium-12 cell">

          <div class="containerLoader" id="loaderLoadAdressDriver">
            <div class="lds-roller">
              <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
            </div>
          </div>

          <div id="resultAdressDriver" class="padding-top-5 padding-bottom-5"></div>

        </div>


        <div class="medium-12 cell" style="margin-top: 20px;">
          <center><button type="submit" class="button large">Envoyer </button></center>
        </div>
      </div>
    </div>
  </form>


  <div id="editStaffCredentials">
    <h4>Liste des droits</h4>
    <div>
        <?php $partRef = ""; foreach($params->criterias as $criteria):?>

            <?php $part = explode('::', $criteria->name)[0]; ?>
            <?php if($part != $partRef) echo '<div class="partTitle"><b>'.ucfirst($part).'</b></div>'; $partRef = $part?>

            <div>
              <input 
                  type="checkbox"
                  class="criteriaCheckboxStaff"
                  id="criteria-<?= str_replace(['::', '(', ')'], '-', $criteria->name);?>"
                  data-id="<?= $criteria->id;?>"
                  />
              &nbsp;<?= ucfirst(explode('::', $criteria->name)[1]);?>&nbsp;&nbsp;
              <i style="font-size:11px"><?= $criteria->description;?></i>
              <br/>
          </div>
        <?php endforeach;?>
    </div>
  </div>
  
  <br/><br/><br/>
  <div class="medium-12 cell" style="margin-top: 20px;">
    <center><button data-close class="button small" style="background-color: darkblue" onclick="deleteDriver()">Supprimer le profil</button></center>
  </div>

  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>