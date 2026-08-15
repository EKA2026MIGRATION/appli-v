<?php
$title = "Créer un email";
?>
<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>
<br/><br/>
<h1> Créer un email </h1>

<form method="post" id="mailForm" action="mail/create">

  <div class="medium-12 cell">
    <label>Titre (FR)
      <input type="text" id="subjectFr" name="subjectFr" required>
    </label>
  </div>

  <div class="medium-12 cell">
    <label>Titre (EN)
      <input type="text" id="subjectEn" name="subjectEn"  required>
    </label>
  </div>

  <div class="medium-12 cell">
    <label>Contenu (FR)
      <textarea name="contentFr" id="contentFr"></textarea>
    </label>
  </div>

  <div class="medium-12 cell" style="margin-top: 30px;">
    <label>Contenu (EN)
      <textarea name="contentEn" id="contentEn"></textarea>
    </label>
  </div>
  <div class="medium-12 cell" style="margin-top: 20px;">
    <button type="submit" class="button-add">Créer l'email </button>
  </div>
</form>

<script src="https://cdn.tiny.cloud/1/rh94623y86575qrj04nyduzxsrhx2n6v9hi1pwz2c4idlt9i/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>