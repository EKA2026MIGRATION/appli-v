<?php $title = "Importer les données"; ?>

<h2>Import des données myClub</h2>

<br/><br/>
<hr/>

<h4>Transport</h4>

Choisir une date d'import de transport
<i class="material-icons" class="calendar_change_date" id="datePickerTransportButton" style="cursor: pointer">date_range</i>
<button id="reloadImport" class="button">Relancer pour la même date</button>
<div id="datePickerTransport" style="display: none; cursor: pointer"></div>
<div id="showTransportInfo">
</div>
<input type="hidden" name="dataSearched" id="dataSearched"/>

<hr/>



<br/><br/>
<hr/>

<h4>Activités</h4>

Choisir une date d'import des activités
<i class="material-icons" class="calendar_change_date" id="datePickerActivityButton" style="cursor: pointer">date_range</i>
<button id="reloadImport2" class="button">Relancer pour la même date</button>
<div id="datePickerActivity" style="display: none; cursor: pointer"></div>
<div id="showActivityInfo">
</div>
<input type="hidden" name="dataSearched2" id="dataSearched2"/>


<br/><br/>
<hr/>

<h4>Enfants</h4>

Lancer la fonction d'import
<button id="importChild" class="button">Importer</button>
<div id="showChildInfo">
</div>
