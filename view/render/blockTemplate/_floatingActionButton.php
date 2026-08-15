<ul class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
  <li class="mfb-component__wrap">
    <a href="javascript:void(0)" class="mfb-component__button--main">
      <i class="mfb-component__main-icon--resting material-icons">menu</i>
      <i class="mfb-component__main-icon--active material-icons">close</i>
    </a>
    <ul class="mfb-component__list">

      <?php foreach($buttons as $button):?>
        <li>
          <?php $attributes = "";?>
          <?php if(isset($button['attributes'])):?>
              <?php foreach($button['attributes'] as $key => $value):?>
                  <?php $attributes .= " ".$key." = '".$value."' ";?>
              <?php endforeach; ?>
          <?php endif;?>
          <a  <?= $attributes ;?> href="<?= $button['href']; ?>" onclick="<?= $button['onclick']; ?>" data-mfb-label="<?= $button['label']; ?>" class="mfb-component__button--child">
            <i class="mfb-component__child-icon material-icons"><?= $button['icon']; ?></i>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </li>
</ul>
