<?php use_helper('photo, translation');?>

<?php $title = "Les produits"; ?>

<h1> Produits </h1>

<div class="text-center"><a href="<?= HOST ?>product/add"><button class="button">Ajouter un produit </button></a></div>

    <!--<input type="search" id="searchListProduct" placeholder="Rechercher">-->

    <br/><br/>

    <div style="text-align: center; padding: 20px; border: 1px solid darkblue; width: 400px; margin: auto">
        Modification les éléments sélectionnés<br/><br/>
        Visibilité&nbsp;&nbsp;
        <select id="visibilitySelect" style="display: inline; width: 150px; padding: 0px; margin: 0px; height: auto">
            <option/>
            <option value="frontVisibility">Visibilité Interface Client</option>
            <option value="backVisibility">Visibilité en back</option>
            <option value="personVisibility">Visibilité par une personne</option>
            <option value="full">Complet</option>
            <option value="archived">Archivé</option>
        </select>
        &nbsp;&nbsp;
        <span id="submitMasseButton" style="border-radius: 10px; padding: 10px; background-color: darkblue; color: white; font-size: 12px; cursor: pointer">MODIFIER</span>
    
        <br/>
        <br/>

        <select id="selectShowComponent">
            <option value="hide">Masquer les composants</option>
            <option value="show">Afficher les composants</option>
        </select>
    
    </div>

    <section class="block-list">
        <ul id="productList">
            <?php $currentCategory = "";?>
            <?php foreach($params as $categoryName => $datas):?>
                <?php foreach($datas as $data):?>
                        <?php $product = $data['product'];?>
                        <?php if($currentCategory != $categoryName):?>
                            <br/><br/>
                            <h5 style="font-weight: bold; margin-top: 40px; display: inline">
                                <?= showIcon($categoryName);?>
                                <input type="checkbox" value="<?= $categoryName;?>" class="checkboxCategory"/>
                                <i class="material-icons">south</i>
                                <?= $data['categoryPublicName']?>
                            </h5>
                            
                            <?php $currentCategory = $categoryName;?>
                        <?php endif;?>


                        <?php (strtolower($product->visibility) == "frontvisibility") ? $back = "background-color: #e6ffe6" : $back = "";?>
                        <li style="<?= $back;?>">

                            <a href="<?= HOST ?>product/display/id/<?= $product->productId; ?>/">
                                <div>
                                    <p class="list-header">
                                        <img src="<?= ("" != $product->photo) ? HOST.$product->photo : IMG.'no_photo_2.jpg';  ?>" class="width-30 height-30" />
                                        
                                        <input type="checkbox" value="<?= $product->productId;?>" class="checkboxProduct checkbox<?= $categoryName;?>"/>

                                        <?= strip_tags($product->nameFr); ?>
                        
                                        <span style="float: right; margin-right: 20px;">
                                            <?= $product->visibility;?>
                                        </span>

                                        <div class="with-icon">
                                            <i class="material-icons">send</i>
                                        </div>
                                    </p>
                                </div>
                            </a>

                            <div data-url="<?= HOST;?>product/listChild/id/<?= $product->productId;?>/" class="productListChildButton">
                                Liste des inscrits
                            </div>
                        </li>
                        <div style="padding-left: 100px; font-size: 12px; display: none" class="showComponent">
                            <ul>
                                <li style="width: 100%">
                                    <b style="width: 200px">Prix total TTC : <?= $product->priceTtc;?> €</b>
                                    &nbsp;&nbsp;<a href="<?= HOST ?>product/add/id/<?= $product->productId ?>/">Modifier</a>
                                </li>
                                <?php foreach($product->components as $component):?>
                                    <li style="display: flex;">
                                        <span style="width: 250px"><?= $component->nameFr;?></span>
                                        <span>Taux de TVA : <?= $component->vat;?>%</span>
                                        <span>Prix HT : <?= $component->priceHt;?> €</span>
                                        <span>Qtté :<?= $component->quantity;?></span> 
                                        <span>Total HT <?= $component->totalHt;?> €</span>
                                        <span>Total TTC <?= $component->totalTtc;?> €</span>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    
                <?php endforeach;?>
            <?php endforeach; ?>

        </ul>
    </section>

    <div id="showNone"></div>

<!--
    <div class="text-center margin-top-12" ><button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreListProduct"> Afficher plus </button></div>

    <input type="hidden" id="pageSearch">-->
