<?php $title = "Gestion de site client"; ?>
<?php use_helper('dates');?>
<h1>Gestion des dates de fermeture</h1>


<hr/>
<div class="text-center"><a href="javascript:void(0)" data-open="addInscriptionClosed" class="button" target="_self" >Fermer tous les produits à la carte</a></div>

<?php include('_formALaCarteClosed.php');?>




<hr/>
<div class="text-center"><a href="javascript:void(0)" data-open="addDateCancelled" class="button" target="_self" >Fermer un produit sur une date </a></div>

<?php include('_formDateCancelled.php');?>


<?php if(count((array) $params->product_cancelled_date)>0):?>
<section class="block-list">
  <ul id="productDateCancelledList">    
    <?php foreach($params->product_cancelled_date as $date_cancelled):?>

      <li>
        <a href="javascript:void(0)" data-id="<?= $date_cancelled->productCancelledDateId; ?>" onclick="deleteDate(this)">
          <div>
            <p class="list-header" style="padding-left: 0; margin-left: -15px;">
              <?= showDate($date_cancelled->date); ?> -  <?=  strip_tags($date_cancelled->product->nameFr); ?><br/>
			  <i style="color: darkblue; font-size: 12px"><?=  $date_cancelled->messageFr; ?></i>
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
<?php else:?>
  <div style="text-align: center">Aucun produit n'est pour l'instant bloqué à la vente sur une date</div>
<?php endif;?>