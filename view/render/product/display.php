<?php use_helper('translation');?>
<?php $title = "Produit ".strip_tags($params->nameFr); ?>

<h1 class="text-center"><?= strip_tags($params->nameFr); ?></h1>

<?php //echo '<pre>'; var_dump($params->hours); echo '</pre>'; ?>
<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
    <button id="deleteProduct" data-id-product="<?= $params->productId ?>" class="button"><i class="material-icons">delete</i> </button>
    <a href="<?= HOST ?>product/add/id/<?= $params->productId ?>/"> <button class="button"><i class="material-icons">edit</i> </button></a>
    <a href="<?= HOST ?>product/add/duplicate/<?= $params->productId ?>/"> <button class="button"><i class="material-icons">file_copy</i> </button></a>
</div>

<div class="page__profil" id="displayOverButtons">

    <div class="profile__picture">

        <img src="<?= ("" != $params->photo) ? HOST.$params->photo : IMG.'no_photo_2.jpg';  ?>" />

    </div>

    #<?= $params->productId;?>

    <h2>Informations</h2>

    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">info</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Nom</p>
                    <p><?= strip_tags($params->nameFr); ?></p>
                    <p><?= (null !==$params->nameEn)? strip_tags($params->nameEn) : '-' ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">description</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Description</p>
                    <p><?= $params->descriptionFr; ?></p>
                    <p><?= $params->descriptionEn; ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">info</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Infos diverses</p>
                    <p><strong><?= $params->season->name; ?></strong></p>
                    <p>Visibilité :
                        <?php  if ('frontVisibility' === $params->visibility OR 'frontvisibility' === $params->visibility ):
                            echo ' Interface Client';
                        elseif ('backVisibility' === $params->visibility):
                            echo ' Interface back';
                        elseif ('personVisibility' === $params->visibility):
                                echo 'Visible par une personne';
                        else:
                            echo ' produit archivé';
                        endif ?>
                    </p>
                    <p>Famille : <?= $params->family->name; ?> </p>
                    <p>Catégorie :
                        <?php foreach ($params->categories as $category):
                            echo '<strong>'.trans($category->name).'</strong>';
                        endforeach;?>
                    </p>
                   
                    <?php if($params->lunch == true):?>
                        <p>
                            <b>Repas compris</b>
                        </p>
                    <?php endif;?>
                </figure>
            </div>
        </div>
    </div>


    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">place</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Lieu(x)</p>
                    <?php if (null !== $params->locations):
                        foreach ($params->locations as $location):
                            echo  '<strong>'. $location->name . '</strong><br/>';
                        endforeach;
                    else :
                        echo 'aucun lieu sélectionné';
                    endif ;?>                    
                    <p>Lieu(x) sélectionnables :
                        <?php  if (false === $params->isLocationSelectable):
                            echo ' non';
                        elseif (true === $params->isLocationSelectable):
                            echo ' oui';
                        else:
                            echo ' - ';
                        endif ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal hight" >
        <div class="card-img-container">
            <figure>
                <i class="material-icons">date_range</i>
            </figure>
        </div>
        <div class="card-info" >
            <div class="card-primary">
                <figure>
                    <p class="card-title">Dates de disponibilité</p>
                        <?php if (null !== $params->dates):
                            foreach ($params->dates as $date):
                                $arr[] = date('d-m-Y', strtotime($date));
                            endforeach;
                            echo implode(' / ', $arr);
                        else :
                            echo 'aucune date sélectionnée';
                        endif ;?>
                    <p>Dates sélectionnables :
                        <?php  if (false === $params->isDateSelectable):
                            echo ' non';
                        elseif (true === $params->isDateSelectable):
                            echo ' oui';
                        else:
                            echo ' - ';
                        endif ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal hight" >
        <div class="card-img-container">
            <figure>
                <i class="material-icons">event</i>
            </figure>
        </div>
        <div class="card-info" >
            <div class="card-primary">
                <figure>
                    <p class="card-title">Plages horaires</p>
                        <?php if (null !== $params->hours):
                            foreach ($params->hours as $hour):
                                ?>
                                    <p>
                                        <strong>
                                            <?= $hour->start.' - '.$hour->end; ?>
                                        </strong> <br/>
                                        <?php if($hour->is_full == 1): ?>
                                            Complet <br/>
                                            Message FR : <?= $hour->message_fr; ?> <br/>
                                            Message EN : <?= $hour->message_en; ?>
                                        <?php endif; ?>
                                    </p>
                                <?php
                            endforeach;
                        else:
                            echo 'aucune plage horaire sélectionnée';
                        endif; ?>
                    <p>Plages horaire sélectionnables :
                        <?php  if (false === $params->isHourSelectable):
                            echo ' non';
                        elseif (true === $params->isHourSelectable):
                            echo ' oui';
                        else:
                            echo ' - ';
                        endif ?></p>
                </figure>
            </div>
        </div>
    </div>

    <div class="card-wrap horizontal hight">
        <div class="card-img-container">
            <figure>
                <i class="material-icons">directions_bus</i>
            </figure>
        </div>
        <div class="card-info">
            <div class="card-primary">
                <figure>
                    <p class="card-title">Transport</p>
                    <p> Transport associé :
                        <?php  if (false === $params->transport):
                            echo ' non';
                        elseif (true === $params->transport):
                            echo ' oui';
                        else:
                            echo ' - ';
                        endif ?>
                    </p>
                    <?php if(true === $params->transport):?>
                        <p>Heures Prise en charge / Dépose : <?= $params->hourDropin ?> / <?= $params->hourDropoff ?></p>
                    <?php endif;?>
                </figure>
            </div>
        </div>
    </div>

</div>



<h2> Activités associées
<?php if($params->isSportSelectable == true):?>
        sélectionnables        
    <?php endif;?>
</h2>
<div class="flex space-arround">

  

    <?php foreach($params->sports as $sport):?>
        <div  class="card-ea-profil" style="height: 370px;">
            <div class="card-banner">
                <div class="card-profile" style="background-image: url('<?= ($sport->photo != "") ? HOST.$sport->photo :  IMG.'no_photo_2.jpg';  ?>');"></div>

                <h3><?=  $sport->name ?> </h3>

            </div>
        </div>
    <?php endforeach ?>
</div>

<h2> Composants </h2>

<div class="tableScrollable">
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix U/TTC</th>
                <th>Prix U/HT</th>
                <th>Quantité</th>
                <th>TVA</th>
                <th>Total TTC</th>
                <th>Total HT</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th class="text-right" colspan="8"><hr>TOTAL TTC</th>
            </tr>
            <tr >
                <th class="text-right" id="totalProductTTC" colspan="8"><?= number_format($params->priceTtc, 2, ',', ' ') ?></th>
            </tr>
        </tfoot>
        <tbody class="componentTable">
            <?php foreach ($params->components as $component): ?>
                <tr >
                    <td><?= $component->nameFr; ?></td>
                    <td><?= number_format($component->priceTtc, 2, ',', ' '); ?></td>
                    <td><?= number_format($component->priceHt, 2, ',', ' '); ?></td>
                    <td><?= $component->quantity; ?></td>
                    <td ><?= $component->vat; ?></td>
                    <td><?= number_format($component->totalTtc, 2, ',', ' '); ?></td>
                    <td><?= number_format($component->totalHt, 2, ',', ' '); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="space_actions_page_mobile"></div>