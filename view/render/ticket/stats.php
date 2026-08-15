<?php use_helper('translation');?>
<?php $title = "Statistiques des tickets"; ?>

<h1>Tickets statistiques </h1>
<div class="grid-container">
  <div class="grid-x grid-padding-x">
    <div class="cell medium-6 large-4 small-12 margin-top-20 flexCenter">
      <div>
          <input type="date" id="dateStart" />
      </div>
    </div>
    <div class="cell medium-6 large-4 small-12 margin-top-20 flexCenter">
      <div>
          <input type="date" id="dateEnd" />
      </div>
    </div>    
    <div class="cell medium-6 large-4 small-12 margin-top-20 flexCenter">
      <div>
          <select id="type">
            <option value="">Type</option>
            <option value="info">Informations</option>
            <option value="change">Changement</option>
            <option value="problem">Problème</option>
            <option value="other">Autre</option>
          </select>
      </div>
    </div>
    <div class="cell medium-3 large-4 small-12 margin-top-20 flexCenter">
      <div>
          <select id="persona">
            <option value="">Persona</option>
            <option value="prospect">Prospect</option>
            <option value="customer">Client</option>
            <option value="old_customer">Ancien client</option>
            <option value="new_customer">Nouveau client</option>
            <option value="human_ressources">RH</option>
            <option value="providers">Prestataire</option>
            <option value="other">Autre</option>
          </select>
      </div>
    </div>
    <div class="cell medium-3 large-4 small-12 margin-top-20 flexCenter">
      <div>
          <select id="origin">
            <option value="">Origine de l'appel</option>
            <option value="flyer">Flyer</option>
            <option value="internet">Internet</option>
            <option value="newspaper">Journaux</option>
            <option value="relatives">Relations</option>
            <option value="bus">Bus</option>
            <option value="other">Autre</option>
          </select>
      </div>
    </div>
    <div class="cell medium-3 large-4 small-12 margin-top-20 flexCenter">
      <div>
          <select id="recall">
            <option value="">Rappeler</option>
            <option value="true">Oui</option>
            <option value="false">Non</option>
          </select>
      </div>
    </div>
    <div class="cell medium-3 large-4 small-12 margin-top-20 flexCenter">
      <div>
          <select id="has_been_treated">
            <option value="">A été traité</option>
            <option value="true">Oui</option>
            <option value="false">Non</option>
          </select>
      </div>
    </div>
    <div class="cell medium-3 large-4 small-12 margin-top-20 flexCenter">
      <div>
          <select id="location">
            <option value="">Lieu</option>
            <?php foreach($params->location as $loc):?>
              <option value="<?= $loc->locationId; ?>"><?= $loc->name; ?></option>
            <?php endforeach; ?>
          </select>
      </div>
    </div>
    <div class="cell medium-3 large-4 small-12 margin-top-20 flexCenter">
      <div>
          <select id="category">
            <option value="">Catégorie de produit</option>
            <?php foreach($params->categories as $cat):?>
              <option value="<?= $cat->categoryId; ?>"><?= $cat->name; ?></option>
            <?php endforeach; ?>
          </select>
      </div>
    </div>
  </div>
</div>
<center><button class="button" onclick="filter()">Filtrer les tickets</button></center>

<div class="resultTicket displayNone">
<h3>Nombre de tickets : <span id="nbTickets"></span> </h3>

<div class="flexGraph">
  <div class="text-center">
    <H4> Répartition par numéro </H4>
    <canvas id="myChart"></canvas>
  </div>
  <div class="text-center">
    <H4> Répartition par catégorie </H4>
    <canvas id="myChart2"></canvas>
  </div>
  <div class="text-center">
    <H4> Répartition par lieu </H4>
    <canvas id="myChart3"></canvas>
  </div>
  <div class="text-center">
    <H4> Répartition par "a été traité" </H4>
    <canvas id="myChart4"></canvas>
  </div>
  <div class="text-center">
    <H4> Répartition par "rappeler" </H4>
    <canvas id="myChart5"></canvas>
  </div>
  <div class="text-center">
    <H4> Répartition par persona </H4>
    <canvas id="myChart6"></canvas>
  </div>
  <div class="text-center">
    <H4> Répartition par type </H4>
    <canvas id="myChart7"></canvas>
  </div>
  <div class="text-center">
    <H4> Répartition par origine </H4>
    <canvas id="myChart8"></canvas>
  </div>
</div>

<section class="block-list" id="ticketList"></section>

<style type="text/css">
select {
  width: 100%;
}

.grid-padding-x > .cell {
  margin-top: 0;
} 

.grid-padding-x > .cell > div {
  width: 100%;
}

.block-list li {
    position: relative;
    min-height: 50px;
    display: flex;
    align-items: center;
    padding-left: 0;
    border-bottom: 1px solid #e6e6e6;
}

.flexGraph {
  display: flex; 
  justify-content: space-around; 
  flex-wrap: wrap; 
  margin-top: 30px;
  width: 100%;
}

.flexGraph canvas {
  width: 100%;
  margin-bottom: 30px;
}

.flexGraph div {
  width: 49%;
}

.block-list li p {
  padding-left: 0;
  margin-left: 0;
}
</style>