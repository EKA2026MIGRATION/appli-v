<?php
$title = "Statistiques listes";
?>

<h1>Liste des statistiques</h1>


<section class="block-list">
  <ul>
      <li>
        <a href="<?= HOST; ?>statistique/index/type/ca/">
          <div>
            <p style="padding: 0; margin: 0;" class="list-header">
              Analyse comparative du CA / Présences par semaine (base : présences) 
            <div class="with-icon">
              <i class="material-icons">send</i>
            </div>
            </p>
          </div>
        </a>
      </li>
       <li>
        <a href="<?= HOST; ?>statistique/index/type/repartition/">
          <div>
            <p style="padding: 0; margin: 0;" class="list-header">
              Répartition du CA par produit par période (base : factures)
            <div class="with-icon">
              <i class="material-icons">send</i>
            </div>
            </p>
          </div>
        </a>
      </li>
      <li>
          <a href="<?= HOST; ?>statistique/index/type/analyse/">
              <div>
                  <p style="padding: 0; margin: 0;" class="list-header">
                      Analyse Stratégique des Performances et Potentiels des Produits Sportifs
                  <div class="with-icon">
                      <i class="material-icons">send</i>
                  </div>
                  </p>
              </div>
          </a>
      </li>
  </ul>
</section>


<input type="hidden" id="lastIdVehicle">