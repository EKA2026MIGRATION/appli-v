<?php
$title = "Modifier un email";
?>

<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>
<br/><br/>

<h1> <?= $params->subjectFr; ?> </h1>

<div class="medium-12 cell" style="margin: 20px 0px;">
  <button type="button" onclick="deleteMail('<?= $params->mailId; ?>')" class="button-add">Supprimer l'email </button>
</div>

<form method="post" id="mailForm" action="mail/modify/<?= $params->mailId; ?>">

  <div class="medium-12 cell">
    <label>Titre (FR)
      <input type="text" id="subjectFr" name="subjectFr" value="<?= $params->subjectFr; ?>" required>
    </label>
  </div>

  <div class="medium-12 cell">
    <label>Titre (EN)
      <input type="text" id="subjectEn" name="subjectEn" value="<?= $params->subjectEn; ?>" required>
    </label>
  </div>

  <div class="medium-12 cell">
    <label>Contenu (FR)
      <textarea name="contentFr" id="contentFr"><?= $params->contentFr; ?></textarea>
    </label>
  </div>

  <div class="medium-12 cell" style="margin-top: 30px;">
    <label>Contenu (EN)
      <textarea name="contentEn" id="contentEn"><?= $params->contentEn; ?></textarea>
    </label>
  </div>
  <div class="medium-12 cell" style="margin-top: 20px;">
    <button type="submit" class="button-add">Modifier l'email </button>
  </div>
</form>

<script src="https://cdn.tiny.cloud/1/rh94623y86575qrj04nyduzxsrhx2n6v9hi1pwz2c4idlt9i/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>