<?php $title = "Booklet - Energy Academy"; ?>
<style>
  .bookletChildList { 
    width: 100%;
    border-collapse: collapse;
    }

    tr:nth-child(odd) {background: lightgrey}
    th {background: darkred; color: white}
    

</style>
<script>
    var staffList;
    var bookletList;
    var html;
    var hideAll, showAll, showElements, resetSelect, filterList,selects;
</script>
<?php (isset($params->currentBooklet)) ? $currentBook = $params->currentBooklet : $currentBook = "Draft"?>
<input type="hidden" id="currentBooklet" value="<?= $currentBook;?>"/>
<input type="hidden" id="date" value="<?= $params->date;?>"/>
<?php include_once(HELPER.'dates.php');?>


<h1>Livrets enfants</h1>

<div class="reveal" id="action-open-associated" data-reveal>
    <?php include('_associatedChild.php');?>
</div>

<div class="flexRow" style="justify-content: space-between">
    <div class="flexRow" style="justify-content: initial">
        <input type="date" name="dateValidation" id="updateDateValidation" style="width: 200px "/>
        &nbsp;&nbsp;<button id="updateDateValidationButton" class="button">Changer la date d'évaluation</button>
    </div>
    <button class="button" data-open="action-open-associated" id="addBookletButton">Ajouter un livret à un enfant</button>
</div>

<hr/>

<ul id="bookletMenuLi">
  <li data-book="Draft" class="liButtonMenu" id="buttonDraft">
    <i class="material-icons">edit_note</i>
    <div class="textButtonMenu">&nbsp;En cours</div>
  </li>
  <li data-book="Published" class="liButtonMenu" id="buttonPublished">
    <i class="material-icons">done_all</i>
    <div class="textButtonMenu">&nbsp;Publié sur la saison</div>
  </li>
</ul>

<div id="bookletContent"></div>
