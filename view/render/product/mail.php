<?php $title = "Emails liés aux produits"; ?>

<h1> Emails liés aux produits </h1>

<div class="text-center">
  <a href="<?= HOST; ?>product/mailCreate"> Créer un email </a>
</div>
<section class="block-list">
  <ul id="mailList">
    <?php foreach ($params->mails as $mail) : ?>
      <li>
        <a href="<?= HOST; ?>product/mailDisplay/id/<?= $mail->mailId; ?>/">
          <div>
            <p style="padding: 0; margin: 0;" class="list-header">
              <?= $mail->subjectFr; ?> 
            <div class="with-icon">
              <i class="material-icons">send</i>
            </div>
            </p>
          </div>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>

