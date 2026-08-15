<?php $title = "Ajouter / Modifier un produit"; ?>
<?php use_helper('translation');?>


<div style="text-align: center">
    #<?= $params->product->productId ;?>
</div>

<?php $update = 0; if(isset($params->product)):  $update = 1; endif ?>
<?php $duplicate = 0; if(isset($params->duplicate)):  $duplicate = 1; endif ?>


<h1 class="text-center"><?= (1 === $update) ? 'Modifier' : 'Ajouter';  ?> un produit </h1>

<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>

</div>
<?php //echo '<pre>'; var_dump($params->product->sports); echo '</pre>'; ?>
<form method="post" id="productForm" action="product/<?= (1 === $update AND $duplicate == 0) ? 'modify/'.$params->product->productId : 'create';  ?>">

    <input type="hidden" name="photo" id="photoUrl" value="<?= (1 === $update) ?  $params->product->photo: '';  ?>">


    <div class="grid-container">
        <div class="grid-x grid-padding-x">

            <h2 class=" medium-12 cell">Description </h2>
            <div class="medium-6 cell">
                <label>Nom du produit *
                    <input class="visibleInFront inputNameProductTiny" type="text" name="nameFr" placeholder="Nom du produit" value="<?= (1 === $update) ?  $params->product->nameFr: '';  ?> <?= (1 === $duplicate) ? 'COPIE': '';  ?>" required>
                </label>
            </div>
            <div class="medium-6 cell">
                <label>Product Name
                    <input class="visibleInFront inputNameProductTiny" type="text" name="nameEn" placeholder="Product name" value="<?= (1 === $update) ?  $params->product->nameEn: '';  ?> <?= (1 === $duplicate) ? 'COPY': '';  ?>" >
                </label>
            </div>
            <div class="medium-6 cell">
                <label> Famille * <i>Liée à la comptabilité</i>
                    <select id="familySelect" required>
                        <?php foreach ($params->families as $family): ?>
                            <option value="<?= $family->familyId; ?>" <?= (1 === $update && $family->familyId === $params->product->family->familyId) ? 'selected': '';  ?>><?= $family->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <input type="hidden" id="family" name="family" value="<?= (1 === $update) ? $params->product->family->familyId: '';  ?>">
            </div>
            <div class="medium-6 cell">
                <label> Catégorie * <i>Classement pour le client</i>
                    <select class="visibleInFront" id="categorySelect" required>
                        <?php if (1 === $update):
                            $categoryLength = sizeof($params->product->categories);
                            for ($i=0; $i<$categoryLength ; $i++):
                                foreach ($params->categories as $category): ?>
                                    <option value="<?= $category->categoryId; ?>"<?= ($category->categoryId === $params->product->categories[$i]->categoryId) ? 'selected': '';  ?>><?= trans($category->name); ?></option>
                                <?php endforeach;
                            endfor;
                        else:
                            foreach ($params->categories as $category): ?>
                                <option value="<?= $category->categoryId; ?>"><?= trans($category->name); ?></option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </label>
                <input type="hidden"  id="category" value="<?= (1 === $update) ? $params->product->category: '';  ?>">
            </div>

            <div class="medium-6 cell ">
                <label>Produit spécial
                    <select name="isOffered">
                            <option value ="0">Non</value>
                            <option value="1" <?= (1 === $update && $params->product->isOffered === 1)? 'selected' : '';  ?>>PRODUIT OFFERT</option>
                    </select>
                </label>
            </div>


            <div class="medium-6 cell ">
                <label>Saison *
                    <select id="seasonSelect" required>
                        <?php foreach ($params->seasons as $season): ?>
                            <option value="<?= $season->seasonId; ?>" <?= (1 === $update && $season->seasonId === $params->product->season->seasonId)? 'selected' : '';  ?>><?= $season->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <input type="hidden" id="season" name="season" value="<?= (1 === $update) ? $params->product->season->seasonId: '';  ?>">
            </div>

            <div class="medium-6 cell">
                <label> Visibilité du produit * 
                    <select id="visibilitySelect" required>
                        <option value="frontVisibility" <?= (1 === $update && 'frontvisibility' === strtolower($params->product->visibility))? 'selected' : '';  ?>>Visibilité Interface Client</option>
                        <option value="backVisibility" <?= (1 === $update && 'backvisibility' === strtolower($params->product->visibility))? 'selected' : '';  ?>>Visibilité en back</option>
                        <option value="personVisibility" <?= (1 === $update && 'personvisibility' === strtolower($params->product->visibility))? 'selected' : '';  ?>>Visibilité par un Client unique</option>
                        <option value="archived" <?= (1 === $update && 'archived' === $params->product->visibility)? 'selected' : '';  ?>>Archivé</option>
                    </select>
                </label>
                <input type="hidden" id="visibility" name="visibility" value="<?= (1 === $update) ? $params->product->visibility: '';  ?>">
            </div>

            <h2 class=" medium-12 cell margin-top-20 showPersonVisibility" style="display: none">Associer un enfant </h2>
           <div class="medium-12 cell showPersonVisibility" style="display: none">
                <label>Nom de l'enfant
                    <input type="search" id="autocompleteListChild" class="visibleInFront"  placeholder="Nom de l'enfant" value="<?= (1 === $update && null != $params->product->child ) ?  $params->product->child->firstname . ' ' . $params->product->child->lastname: '';  ?>" >
                    <input type="hidden" id="childId" name="child" value="<?= (1 === $update && null != $params->product->child) ?  $params->product->child->childId: '';  ?>">
                </label>
            </div>

            <div class="cell medium-6 forMultiSelectBorder forMultiselectWidth notPersonVisibility">
                <label>Lieux </label>
                    <select id="locationSelect">
                        <?php if (1 === $update):
                            $locationsLength = sizeof($params->product->locations);
                            foreach($params->locations as $location):
                                $selected = false;
                                for ($i=0; $i<$locationsLength; $i++):
                                    $selected = ($location->locationId === $params->product->locations[$i]->locationId) ? 'data-selected': false;
                                    if ($selected):
                                        break;
                                    endif;
                                endfor; ?>
                                    <option data-id="<?= $location->locationId; ?>" id="location<?= $location->name; ?>" value="<?= $location->locationId; ?>"<?= $selected; ?>><?= $location->name; ?></option>
                            <?php endforeach;
                        else:
                            foreach ($params->locations as $location): ?>
                                <option data-id="<?= $location->locationId; ?>" data-name="<?= $location->name; ?>" value="<?= $location->locationId; ?>"><?= $location->name; ?></option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                <input type="hidden" id="liveResultLocation" />
            </div>

            <div class="cell medium-6 notPersonVisibility">
                <label>Lieux sélectionnables *</label>
                <select id="locationSelectable" name="isLocationSelectable" required>
                    <option value="0" <?= (1 === $update && false === $params->product->isLocationSelectable)? 'selected' : '';  ?>>non</option>
                    <option value="1" <?= (1 === $update && true === $params->product->isLocationSelectable)? 'selected' : '';  ?>>oui</option>
                </select>
            </div>

            <div class="medium-6 cell">
                <label> Description *
                    <textarea class="visibleInFront" rows="3" name="descriptionFr" required><?= (1 === $update) ?  $params->product->descriptionFr: '';  ?></textarea>
                </label>
            </div>
            <div class="medium-6 cell">
                <label> English description
                    <textarea class="visibleInFront" rows="3" name="descriptionEn"><?= (1 === $update) ?  $params->product->descriptionEn: '';  ?></textarea>
                </label>
            </div>

            <div class="medium-6 cell">
                <label> Email envoyé au client</label>
                    <select class="visibleInFront" id="letterSelect" name="mail">
                        <?php foreach ($params->mails as $mail): ?>
                            <option data-id="<?= $mail->mailId; ?>"
                                data-name="<?= $mail->subjectFr; ?>"
                                value="<?= $mail->mailId; ?>"
                                <?php if( $mail->mailId == $params->product->mail->mailId) echo 'selected';?>
                                >
                                <?= $mail->subjectFr; ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </label>
            </div>
            <div class="medium-6 cell">
               
            </div>



            <div class="medium-6 cell margin-bottom-16">
                <div class="dropContainer" id="dropContainer">
                    <div class="contentDropContainer">
                        <div class="image-upload">
                            <label class="labelFileInput" for="fileInput">
                                <a class="button withIcon"><i class="material-icons">create_new_folder</i> Parcourir mes fichiers </a>
                            </label>
                            <input type="file" id="fileInput" onchange="previewOnDiv()"/>
                        </div>
                        Glisser et déposer votre photo ici
                    </div>
                </div>

            </div>
            <div class="medium-6 cell">
                <div class="photoContainer" style="height: 250px;"><img src="<?php if(1 === $update): echo ("" != $params->product->photo) ? HOST.$params->product->photo : IMG.'no_photo_2.jpg'; else:  IMG.'no_photo_2.jpg'; endif ?>" id="photoRender"></div>
            </div>

            <h2 class=" medium-12 cell margin-top-20 notPersonVisibility">Dates et heures </h2>
            <div class="large-6 medium-12 cell notPersonVisibility">
                <p><a data-toggle="panel" style="color: #2ECC40;"> Date(s) de disponibilité *</a></p>

                <div class="callout visibleInFront" id="panel" data-toggler data-animate="hinge-in-from-top spin-out" style="display: none">
                    <div id="dateCalendar"> </div>
                </div>
            </div>

            <div class="large-6 medium-12 cell notPersonVisibility">
                <p><a data-toggle="panel_bis" onclick="loadHourCalendar()" style="color: #2ECC40;"> Plages horaires *</a></p>

                <div class="callout visibleInFront" id="panel_bis" data-toggler data-animate="hinge-in-from-top spin-out" style="display: none">
                    <div  id="hourCalendar"> </div>
                </div>
            </div>

            <div class="large-6 medium-12 cell notPersonVisibility">
                <p><a data-toggle="panel_3" style="color: #2ECC40;">Afficher les dates</a></p>

                <div class="callout visibleInFront" id="panel_3" data-toggler data-animate="hinge-in-from-top spin-out" style="display: none">
                    <div class="block-list ">
                        <ul id="dateList">
                            <?php if($update === 1):
                                foreach($params->product->dates as $date):
                                    echo '<li data-date="'. date('d/m/Y', strtotime($date)).'" > 
                                            <div>
                                                <p class="list-header">'
                                                    . date('d/m/Y', strtotime($date)) .
                                                '</p>
                                            </div>
                                        </li>';
                                    endforeach;
                            endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="large-6 medium-12 cell notPersonVisibility">
                <p><a data-toggle="panel_4" style="color: #2ECC40;">Afficher les plages horaire</a></p>

                <div class="callout visibleInFront" id="panel_4" data-toggler data-animate="hinge-in-from-top spin-out" style="display: none">
                    <div class="block-list ">
                        <ul id="hourList">
                            <?php if($update === 1):
                               $i = 0;
                               foreach ($params->product->hours as $hour):
                                    if($hour->is_full == 1) {
                                        $style = 'style="text-decoration: line-through;"';
                                    }
                                    else
                                    {
                                        $style = '';
                                    }
                                    echo '<li data-id="event'.$i.'" '.$style.' data-custom-id="event'.$i.'" data-date="2018-10-17" data-start="'.$hour->start.'" data-end="'. $hour->end .'" data-is-full="'.$hour->is_full.'" data-message-fr="'. $hour->message_fr .'" data-message-en="'. $hour->message_en .'">
                                               <div>
                                                    <p class="list-header">'
                                                        . $hour->start . ' - ' . $hour->end . 
                                                    ' - <a href="javascript:void(0)" onclick="getEventHour(this)" data-open="addIndisponibility">Gérer la dispo</a> </p>
                                              </div>
                                          </li>';
                                          $i++;
                                endforeach;
                            endif; ?>
                        </ul>
                    </div>
                </div>
            </div>



            <div class="reveal" id="addIndisponibility" data-reveal>
              <p class="lead"> Ajouter une indisponibilité </p>

              <form>

                <div class="grid-container">
                  <div class="grid-x grid-padding-x">
                      <section class="block-list" id="list_checkup">
                          <div>
                            <ul>
                                 <li>
                                    <a href="javascript:void(0)">
                                        <div>
                                            <p class="list-header" style="margin-left: -0.25rem; padding-left: 0px !important;">
                                                Complet
                                                <aside class="subtitles"></aside>
                                                <div class="with-icon">
                                                   <div class="switch">
                                                          <input class="switch-input"  id="is_full" type="checkbox" >
                                                          <label class="switch-paddle" for="is_full"></label>
                                                    </div>
                                                </div>
                                            </p>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                          </div>
                      </section>
                    <div class="medium-12 cell">
                      <label>Message fr
                        <input type="text" id="message_fr_indisponibility">
                      </label>
                    </div>
                    <div class="medium-12 cell">
                      <label>Message en
                        <input type="text" id="message_en_indisponibility" >
                      </label>
                    </div>
     

                    <div class="medium-12 cell" style="margin-top: 10px;">
                      <center><button type="button" data-close  onclick="sendIndisponibility()" class="button">Envoyer </button></center>
                    </div>
                  </div>
                </div>
              </form>

              <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
              </button>
              <p>* champ obligatoire</p>
            </div>



            <div class="cell medium-6 notPersonVisibility">
                <label>Dates sélectionnables *</label>
                <select id="dateSelectable" name="isDateSelectable" required>
                    <option value="0" <?= (1 === $update && false === $params->product->isDateSelectable)? 'selected' : '';  ?>>non</option>
                    <option value="1" <?= (1 === $update && true === $params->product->isDateSelectable)? 'selected' : '';  ?>>oui</option>
                </select>
            </div>

            <div class="cell medium-6 notPersonVisibility">
                <label>Heures sélectionnables *</label>
                <select id="hourSelectable" name="isHourSelectable" required>
                    <option value="0" <?= (1 === $update && false === $params->product->isHourSelectable)? 'selected' : '';  ?>>non</option>
                    <option value="1" <?= (1 === $update && true === $params->product->isHourSelectable)? 'selected' : '';  ?>>oui</option>
                </select>
            </div>

            <h2 class=" medium-12 cell margin-top-20 notPersonVisibility">Repas </h2>
            <div class="medium-4 cell notPersonVisibility">
                <label> Repas *
                    <select id="mealSelectable" name="lunch" required>
                        <option value="0" <?= (1 === $update && false === $params->product->lunch)? 'selected' : '';  ?>>non</option>
                        <option value="1" <?= (1 === $update && true === $params->product->lunch)? 'selected' : '';  ?>>oui</option>
                    </select>
                </label>
            </div>


            <h2 class=" medium-12 cell margin-top-20 notPersonVisibility">Transport </h2>
            <div class="medium-4 cell notPersonVisibility">
                <label> Transport *
                    <select id="transportSelect" name="transport" required>
                        <option value="0" <?= (1 === $update && false === $params->product->transport)? 'selected' : '';  ?>>non</option>
                        <option value="1" <?= (1 === $update && true === $params->product->transport)? 'selected' : '';  ?>>oui</option>
                    </select>
                </label>
            </div>
            <div class="medium-4 cell notPersonVisibility">
                <label> Heure du dropIn
                    <input type="time"  id="hourDropIn"  placeholder="Heure de départ" value="<?= (1 === $update && null !== $params->product->hourDropin)? $params->product->hourDropin : '';  ?>">
                    <input type="hidden"  id="hourDropinInput" name="hourDropin" value="<?= (1 === $update && null !== $params->product->hourDropin)? date('H:i:s', strtotime($params->product->hourDropin )): '';  ?>">
                </label>
            </div>

            <div class="medium-4 cell notPersonVisibility">
                <label> Heure du dropOff
                    <input type="time" id="hourDropOff"  placeholder="Heure de retour" value="<?= (1 === $update && null !== $params->product->hourDropoff)? $params->product->hourDropoff : '';  ?>">
                    <input type="hidden" id="hourDropoffInput"  name="hourDropoff" value="<?= (1 === $update && null !== $params->product->hourDropoff)? date('H:i:s', strtotime($params->product->hourDropoff)): '';  ?>">
                </label>
            </div>

            <h2 class=" medium-12 cell margin-top-20 notPersonVisibility">Sports associés </h2>
            <div class="medium-6 cell forMultiSelectBorder forMultiselectWidth notPersonVisibility">
                <label> Sports associés *</label>
                <select  id="sportSelect">
                    <?php if (1 === $update):

                        $sportsLength = sizeof($params->product->sports);
                        foreach ($params->sports as $sport):
                            $selected = false;
                            for ($i=0; $i<$sportsLength ; $i++):
                                $selected = ($sport->sportId === $params->product->sports[$i]->sportId) ? 'data-selected': false;
                                if ($selected):
                                    break;
                                endif;
                            endfor; ?>
                        <option data-id="<?= $sport->sportId; ?>" id="sport<?= $sport->name; ?>" value="<?= $sport->sportId; ?>" <?= $selected; ?>><?= $sport->name; ?></option>
                    <?php endforeach;
                    else:
                        foreach ($params->sports as $sport): ?>
                            <option data-id="<?= $sport->sportId; ?>" data-name="<?= $sport->name; ?>" value="<?= $sport->sportId; ?>"><?= $sport->name; ?></option>
                        <?php endforeach;
                    endif; ?>
                </select>
                <input type="hidden" id="liveResultSport" />
            </div>

            <div class="cell medium-6 notPersonVisibility">
                <label>Activités sélectionnables *</label>
                <select id="isSportSelectable" name="isSportSelectable" required>
                    <option value="0" <?= (1 === $update && false === $params->product->isSportSelectable)? 'selected' : '';  ?>>non</option>
                    <option value="1" <?= (1 === $update && true === $params->product->isSportSelectable)? 'selected' : '';  ?>>oui</option>
                </select>
            </div>


            <h2 class=" medium-12 cell margin-top-20 ">Composants </h2>
            
            <div class="tableScrollable">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix U/TTC</th>
                            <th>Prix U/HT</th>
                            <th>Quantité</th>
                            <th>TVA</th>
                            <th>Total TTC</th>
                            <th>Total HT</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="9">TOTAL TTC</th>
                        </tr>
                        <tr >
                            <th class="text-right" id="totalProductTTC" colspan="9"><?= (1 === $update) ? number_format($params->product->priceTtc, 2, ',', ' '): '';  ?></th>
                        </tr>
                        <tr></tr>
                    </tfoot>
                    <tbody class="componentTable">
                    <?php if($update == 1): ?>

                    <?php foreach($params->product->components as $component):?>
                        <tr class="componentTr" data-id-component="<?= $component->productComponentId; ?>" data-vat="<?= $component->vat; ?>" data-name-fr="<?= $component->nameFr; ?>" data-name-en="<?= $component->nameEn; ?>" >
                            <td><?= $component->nameFr; ?></td>
                            <td></td>
                            <td>
                                <input data-id="<?= $component->productComponentId;; ?>" data-vat="<?= $component->vat; ?>" id="priceTTC<?= $component->productComponentId;; ?>" type="number" step=".01" onchange="calculateHT(this)" value="<?= $component->priceTtc; ?>" >
                            </td>
                            <td>
                                <input data-id="<?= $component->productComponentId;; ?>" id="priceHT<?= $component->productComponentId;; ?>" type="text"  value="<?= $component->priceHt; ?>" disabled>
                            </td>
                            <td>
                                <input data-id="<?= $component->productComponentId;; ?>" id="quantity<?= $component->productComponentId;; ?>" type="number" step=".01" onchange="calculateTotal(this)" value="<?= $component->quantity; ?>">
                            </td>
                            <td "><?= $component->vat; ?></td>
                            <td class="totalTTC" id="totalTTC<?= $component->productComponentId;; ?>"><?= number_format($component->totalTtc, 2, '.', ''); ?></td>
                            <td id="totalHT<?= $component->productComponentId;; ?>"><?= number_format($component->totalHt, 2, '.', ''); ?></td>
                            <td><a href="javascript:void(0)" data-id="<?= $component->productComponentId;; ?>" onclick="deleteComponent(this)"><i class="material-icons">close</i> </a></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
            <input type="hidden" name="priceTtc" id="productTotalPriceTtc" value="<?= (1 === $update) ? $params->product->priceTtc: '';  ?>"/>


            <div class="medium-6 cell" style="display: flex; margin-top: 20px;">
                <div>
                    <select id="componentSelect" >
                    <?php foreach ($params->components as $component): ?>
                            <option id="option<?= $component->componentId; ?>" value="<?= $component->componentId; ?>" data-vat="<?= $component->vat; ?>" data-name-fr="<?= $component->nameFr; ?>" data-name-en="<?= $component->nameEn; ?> "><?= $component->nameFr; ?></option>
                        <?php endforeach;?>

                    </select>
                </div>
                <a type=button href="javascript:void(0)" class="button" style="display: block" id="componentFilterValidate"> OK </a>
                <input type="hidden" id="liveResultComponent" />
            </div>
            <div class="medium-12 cell">
                <center><input type="submit" class="button large margin-top-20 margin-bottom-20"  value="Envoyer" /></center>
            </div>
        </div>
    </div>
</form>
<p>* champ obligatoire</p>

<input type="hidden" id="pageSearch">
<input type="hidden" id="lastEventId">
<input type="hidden" id="updatedPage" value="<?=(1 === $update)? 'updated' : ''; ?>">
<?php
        $dates = '[]' ;
        $hours = '[]' ;
?>

<script src="https://cdn.tiny.cloud/1/rh94623y86575qrj04nyduzxsrhx2n6v9hi1pwz2c4idlt9i/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script type="text/javascript">
   // var generateDates = <?=  $dates; ?>;
    //var generateHours = <?=  $hours; ?>;

</script>

<div class="space_actions_page_mobile"></div>