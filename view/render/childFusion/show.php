<?php $title = 'Fusion de fiches enfants'?>
<?php use_helper('buttons'); ?>
<?php use_helper('age'); ?>
<?php use_helper('photo'); ?>

<style>
    .neutral { border: 3px solid white}
    .toKeep { border: 3px solid green}
    .toDelete { border: 3px solid red}
    .childInfo {text-align: center}
    .fusionElement { width: 300px; text-align: center}
    #fusionDirection i { font-size: 100px; color: darkblue}
</style>


<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>

<h1 class="text-center">Fusion de fiche enfants</h1>

<div class="flexAround">
    <?php $i = 0; foreach($params->childs as $child):?>
        <?php $i++;?>
        <div id="childFusionItem-<?= $child->childId;?>" class="neutral" style="width: 200px">
            <div class="childInfo">
                <h6><?= $child->fullname;?></h6>
                <div class="text-center">#<?= $child->childId; ?></div>
                <div class="text-center">créée le <?= showDate($child->createdAt); ?></div>

                <img src="<?= ('' != $child->photo) ? HOST.$child->photo : IMG.'no_photo.jpg'; ?>" style/>

            </div>


            <select id="childId-<?= $child->childId;?>" name="typeFusion" class="selectTypeFusion">
                <option value="neutral"/>
                <option value="toKeep">Fiche à garder</option>
                <option value="toDelete">Fiche à fusionner</option>

            </select>

        </div>
    <?php endforeach;?>
</div>

<br/><br/>

<div class="flexAround" id="showFusion">
        <div id="fusionToKeep" class="fusionElement"></div>
        <div id="fusionDirection" class="fusionElement" style="display: none;">
    
            <i class="material-icons">
                arrow_back
            </i>

            <div style="text-align: left">
                <b>AUCUN RETOUR en arrière n'est possible.</b>

                Les éléments suivants seront fusionnées vers la fiche à garder.

                <ul>
                    <li>Les informations de la fiche de l'enfant</li>
                    <li>Les personnes / enfants associés</li>
                    <li>Les inscriptions</li>
                    <li>Les produits </li>
                    <li>Les présences</li>
                    <li>Les transports</li>
                    <li>Les activités</li>
                    <li>Les repas</li>
                    <li>Les factures</li>
                    <li>Les livrets</li>
                    <li>Les sondages</li>
                    <li>Les listes SMS</li>
                </ul>


                En cas de conflit,<br/>
                la donnée sur la fiche <b>A GARDER</b> sera conservée.<br/>
                <i style="font-size: 12px">Ex: sur la fiche de l'enfant, l'école ou le profil sportif.</i>

                <br/>

                <span style="color: red">La fiche à fusionner sera supprimée au terme de la fusion</span>
            </div>

           <button class="button" style="width: 100%" id="doFusionButton">FUSIONNER</button>

    
        </div>
        <div id="fusionToDelete" class="fusionElement"></div>

</div>