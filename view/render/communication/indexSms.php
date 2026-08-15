<?php use_helper('dates');?>
<?php $title = "Campagne de communication SMS"; ?>
<style>
    .infoCreation { font-style: italic; font-size: 12px}
    .sent { color: darkblue!important}
    .created { color: red}
</style>

<h2 class="text-center margin-top-20">Campagnes de communication SMS</h2>
<center>
  <a href="<?= HOST; ?>communication/showCampagn/id/0/" class="button">
    CREER UNE NOUVELLE CAMPAGNE
  </a>
</center>

<section class="block-list">
  <ul id="">    
    <?php foreach($params->campagns as $campagn):?>
      <li style="position:relative">
        <!-- view full -->
        <a href='<?= HOST; ?>communication/showCampagn/id/<?= $campagn->id;?>/' class="<?= $campagn->status;?>">
          <div id="invoiceList">
            <p class="list-header">
              <div>
                <span style="color: black">#<?= $campagn->id;?></span> - <?= $campagn->name;?>
              </div>
            
              <div class="infoCreation">
                  Créée le <?= showDate($campagn->createdAt->date, 'l j/m Y'). ' '.showTime($campagn->createdAt->date);?><br/>
              
                  <?php if($campagn->status == "sent"):?>

                    <span style="color: black">Envoyé le <?= $campagn->dateSended;?></span>

                  <?php endif;?>
              
              </div>

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