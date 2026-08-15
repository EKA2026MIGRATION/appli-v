<?php use_helper('translation');?>
<?php $title = "Liste des tickets"; ?>

<h1>Tickets </h1>

<div class="masonry-css">

  <div class="masonry-css-item">
    <section class="title bg-silver black">Liste des tickets</section>
    <section class="block-list expandable">
      <?php $day = null;?>
      <?php foreach($params->tickets as $ticket):?>
        <?php if($day != date('d/m/Y', strtotime($ticket->dateCall))):?>
            <?php if($day != null) echo "</ul>";?>
            <?php $day = date('d/m/Y', strtotime($ticket->dateCall));?>
            <h5><?= $day;?></h5>
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
          <?php if($ticket->receivedBy != ""):?>
            <div style="">
              Appel pris par : <?= $ticket->receivedBy;?>
            </div>
          <?php endif;?>
        </li>
      <?php endforeach;?>
      </ul>

    </section>
  </div>

  <div class="masonry-css-item">
    <section class="title bg-silver black">Liste des RDV</section>
    <section class="block-list expandable">

      <?php // print_r($params->rdv); ?>

    </section>
  </div>


</div>
