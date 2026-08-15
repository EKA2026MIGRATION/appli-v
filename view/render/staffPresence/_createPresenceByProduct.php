<div class="reveal" id="reveal-product" style="position: relative;" data-reveal>
  <h2> Produits </h2>
  <select id="productsFilters">
      <optgroup label="Catégories de produits">
          <?php foreach($params->categories as $category):?>
              <option value="category<?= $category->categoryId; ?>" data-selected><?php echo $category->name; ?></option>
          <?php endforeach; ?>
      </optgroup>
  </select>
  <button class="button" style="display: block; position: absolute; right:46px; height:45px; top:25px;" id="productsFiltersValidate"> OK </button>
  <input type="hidden" id="liveResult" />
  <div class="dragDispatch">
    <section class="block-list">
        <div id="productList">
          <div class="margin-top-10">
              <p>Horaires pour la sélection</p>
              <input type="time" id="start-hour-product" placeholder="Heure de début" value="<?= $hour_start_value;?>"/>
              <input type="time" id="end-hour-product" placeholder="Heure de fin" value="<?= $hour_end_value;?>">
          </div>
            <div class="margin-top-10">
                <p>Lieu</p>

                <select name="location-product" id="location-product">
                    <?php foreach($params->locations as $location):?>
                        <option value="<?= $location->locationId;?>" <?php if($location->locationId == 6) echo ' selected="selected" ';?>><?= $location->name;?></option>
                    <?php endforeach;?>
                </select>
            </div>
          <?php foreach($params->products as $product): ?>
            <?php if(!empty($product->dates)): ?>
              <section id="category<?php echo $product->categories[0]->categoryId; ?>">
                <header class="headerProduct">
                  <i class="material-icons arrow">keyboard_arrow_down</i>  <?= strip_tags($product->nameFr); ?>
                  <div class="switch" style="float:right; position: absolute; right:5px; top:1px; ">
                    <input class="switch-input" data-product="<?= $product->productId ;?>" type="checkbox"  id="product<?= $product->productId ;?>">
                    <label class="switch-paddle" for="product<?= $product->productId ;?>"></label>
                  </div>
                </header>
                <ul style="max-height: 350px; overflow: auto;" id="ulproduct<?= $product->productId ;?>">
                  <?php $i=0; foreach($product->dates as $date): $i++; ?>
                  <li style="display: none;">
                    <a href="javascript:void(0)">
                      <div>
                        <p class="list-header second-row">
                          <?= $date ;?>
                          <aside class="subtitles"></aside>
                          <div class="with-icon">
                            <div class="switch">
                              <input class="switch-input" data-date="<?= $date ;?>" type="checkbox"  id="date<?= $product->productId ;?><?= $i;?>" name="date<?= $product->productId ;?><?= $i;?>" checked>
                              <label class="switch-paddle" for="date<?= $product->productId ;?><?= $i;?>"></label>
                            </div>
                          </div>
                        </p>
                      </div>
                    </a>
                  </li>
                  <?php endforeach ?>
                </ul>
              </section>
            <?php endif; ?>
          <?php endforeach; ?>
          <div class="text-center">
            <p><button class="button" id="createPresenceProduct">Créer les présences</button></p>
          </div>
        </div>
    </section>
  </div>
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>