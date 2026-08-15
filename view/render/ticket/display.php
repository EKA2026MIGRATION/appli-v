<?php use_helper('translation');?>
<?php $title = "Affiche d'un ticket"; ?>
<?php $ticket = $params->ticket; ?>

<h1>Afficher d'un ticket </h1>
<div class="masonry-css">
  <div class="masonry-css-item">
    <section class="title bg-silver black">Ticket</section>
    <section class="block-list expandable">
      <?php $day = null;?>
        <?php if($day != date('d/m/Y', strtotime($ticket->dateCall))):?>
            <?php if($day != null) echo "</ul>";?>
            <?php $day = date('d/m/Y', strtotime($ticket->dateCall));?>
            <h5 class="text-center"><?= $day;?></h5>
            <ul style="border-bottom: 1px solid darkred">
        <?php endif;?>
        <li style="display: block">
          <div class="ticket-type">
              <div><?= date('H:i:s', strtotime($ticket->dateCall));?></div>
              <div>Type : <?= ($ticket->type != "") ? $ticket->type : "<i>inconnu</i>";?></div>
          </div>
          <div class="ticker-info">
              <div>
                <?= trans($ticket->persona);?>
              </div>
              <div>
                <b><?= ($ticket->category) ? ucfirst(trans($ticket->category->name)) : 'pas de catégorie';?></b>
              </div>
          </div>
          <div class="ticket-tel">
              <div>
                <a href="tel:<?= $ticket->tel;?>"> <?= $ticket->tel;?> </a>
              </div>
              <div>
                <?= ($ticket->location) ? $ticket->location->name : "";?>
              </div>
          </div>
          <div class="ticket-content">
            <?= $ticket->content;?>
          </div>
        </li>
      </ul>
    </section>
  </div>
</div>
