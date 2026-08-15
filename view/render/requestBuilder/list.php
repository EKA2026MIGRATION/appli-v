<?php use_helper('dates, translation, buttons');?>
<?php showFloatingActionButton($params->buttons); ?>

<style>

  .listeA {
    width: 100%;
    padding-top: 1rem;
    padding-bottom: 1rem;
    color: #98061a;
  }

  .infoCreation { font-size: 12px; font-style: italic; color: darkblue}
 
  .flexBoxList {
    display: flex; justify-content: space-between
  }

  .flexBoxList a {
      margin-left: 30px
  }

</style>

<h1 class="text-center">Listes enregistrées </h1>


<section class="block-list">
  <ul id="">    
    <?php foreach($params->extractLists as $list):?>
       
        <?php if($list->elements == "") continue;?>

      <li class="listeA" style="display: block">
          <!-- view full -->
          <div class="flexBoxList"> 
              <div>
                  <span style="color: black">#<?= $list->id;?></span> - <?= $list->title;?>
              </div>
              <div>
                  <a href="<?=  HOST;?>requestBuilder/create/id/<?= $list->id;?>/"><i class="material-icons">edit</i></a>
                  <a href="<?=  HOST;?>requestBuilder/show/id/<?= $list->id;?>/"><i class="material-icons">view_list</i></a>
              </div>
          </div>
          <div class="infoCreation">
                  <?php if($list->createdAt != ""):?>
                    Créée le <?= showDate($list->createdAt->date, 'l j/m Y'). ' '.showTime($list->createdAt->date);?><br/>
                  <?php endif;?>
                  
          </div>
      </li>
    <?php endforeach; ?>

  </ul>
</section>