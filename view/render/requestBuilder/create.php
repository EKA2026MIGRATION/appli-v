<?php use_helper('dates, translation, buttons');?>

<style>

    .checkboxList, .flexList { display: flex; justify-content: space-between; flex-wrap: wrap}
    .checkboxList div, .flexList div { margin-right: 10px}

    .horizontalCard { 
        display: flex;
        background-color: #fff;
        box-shadow: 0 0 15px 9px rgb(0 0 0 / 5%);
        font-family: Montserrat, sans-serif;
        padding: 20px;
        box-sizing: border-box;
        width: 100%;
    }

    .horizontalCard .cardIcon {
        width: 200px; text-align: center;
    }

    .horizontalCard .cardIcon i{
        font-size: 100px;
    }

    .cardInfo {
        padding: 20px;
    }

    .cartTitle {
        font-weight: bold;
    }

    select { width: 200px}

    .typeCriteria, .inputCriteriaValue, #addButtonCriteria { display: none}

    .inputCriteriaValue { width: 200px}

    #showSqlRequest { border: 1px solid black; border-radius: 20px; padding: 20px; margin: 20px;}

    .liFlexBox { display: flex; justify-content: space-between; padding: 0px 20px; border-bottom: 1px solid black }

    #whereCriteriaElements { margin-left: 0px }

    .deleteLiWhere { color: black; font-weight: bold; font-size: 12px; cursor: pointer}


</style>

<?php $hastList = $params->hastList;?>
<?php if($hastList):?>
    <?php 
        $list = $params->extractList; $listId = $list->id;
        foreach($list->elements->whereRequest as $line) {
            if($line != "GROUP BY keyFilter") {
                $arr[] = $line;
            }
        }
    
    ?>
    <script>
        let haslist = true;
        let listId = "<?= $list->id;?>";
        let listWhereRequest = '<?php echo implode(',', $arr) ?>';
    </script>
<?php else:?>
    <?php $list = null; $listId = 0 ?>
    <script>
        let haslist = false;
        let listId = 0;
    </script>
<?php endif;?>

<?php
function checkBoxFunction($groupName, $fiedKey, $list ) {
    $checked = "";
    if($groupName == "checked") $checked = "checked";

    if(isset($list->id)) {

            $selectRequest = $list->elements->selectRequest;

            if(in_array($fiedKey, $selectRequest)) {
                $checked = "checked";
            } else {
                $checked = "";
            }
    } 

    return $checked;
};
?>

<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>

<h1 class="text-center">Création de liste</h1>

<input type="text" name="listName" id="listName" placeholder="Entrez le nom de la liste" value="<?php if($hastList) echo $list->title;?>"/>

<div class="horizontalCard">
    <div class="cardIcon">
            <i class="material-icons">list</i>
    </div>
    <div class="cardInfo flexList">

        <div>
            <p class="cartTitle">CHOIX DE LA LISTE</p>
            <p>
                Sélectionner le type de liste que vous recherchez
                <select name="tableSearch" id="tableSearchSelect">
                    <option/>
                    <option value="child as c" <?php if($hastList ) { if($list->elements->fromRequest == "child as c") { echo 'selected';}} else { echo '';};?>>Enfant</name>
                    <option value="call_twilio as clt" <?php if($hastList ) { if($list->elements->fromRequest == "call_twilio as clt") { echo 'selected';}} else { echo '';};?>>Appel standard</name>
                </select>
            </p>
        </div>

        <div>
            <p class="cartTitle">AFFICHAGE DES RESULTATS</p>
            <p>
                Destination de sortie de la liste
                <select id="destinationType" name="destinationType">
                    <option value="sms" <?php if($hastList) { if($list->elements->destinationType == "sms") { echo 'selected';}};?>>Par SMS</name>
                    <option value="excel" <?php if($hastList) { if($list->elements->destinationType == "excel") { echo 'selected';}};?>>Fichier Excel</name>
                </select>
            </p>
        </div>
    
    </div>
</div>


<div class="horizontalCard">
    <div class="cardIcon">
            <i class="material-icons">done_all</i>
    </div>
    <div class="cardInfo">
        <div id="paramsDataChild" style="display: none">
            <p class="cartTitle">DONNEES AFFICHEES PAR ENFANT</p>
            <?php foreach($params->child['fields'] as $group => $lists):?>
                <div class="checkboxList">
                    <?php foreach($lists as $fiedKey => $fieldName):?>
                        <div>
                            <input type="checkbox" class="fieldSelected" name="<?= $fiedKey;?>" <?= checkBoxFunction($group, $fiedKey, $list);?>/> <?= $fieldName;?>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
        </div>

        <div id="paramsDataCallTwilio" style="display: none">
            <p class="cartTitle">DONNEES AFFICHEES PAR APPEL STANDARD</p>
            <?php foreach($params->call_twilio['fields'] as $group => $lists):?>
                <div class="checkboxList">
                    <?php foreach($lists as $fiedKey => $fieldName):?>
                        <div>
                            <input type="checkbox" class="fieldSelected" name="<?= $fiedKey;?>" <?= checkBoxFunction($group, $fiedKey, $list);?>/> <?= $fieldName;?>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
        </div>


    </div>
</div>

<div class="horizontalCard">
    <div class="cardIcon">
            <i class="material-icons">settings_ethernet</i>
    </div>
    <div style="width: 100%">
            <div class="cardInfo flexList">
                
                <div>
                    <p class="cartTitle">CRITERES DE RECHERCHE</p>
                    <p>
                        <select id="selectCriteriaChild" name="criteria" class="selectCriteria" style="display: none">
                            <option/>
                            <?php foreach($params->child['criterias'] as $criteria => $e):?>
                                <option value="<?= $criteria;?>" data-type="<?= $e['typage'];?>"><?= $params->conversion[$criteria];?></option>
                            <?php endforeach;?>
                        </select>

                        <select id="selectCriteriaCallTwilio" class="selectCriteria" name="criteria" style="display: none">
                            <option/>
                            <?php foreach($params->call_twilio['criterias'] as $criteria => $e):?>
                                <option value="<?= $criteria;?>" data-type="<?= $e['typage'];?>"><?= $params->conversion[$criteria];?></option>
                            <?php endforeach;?>
                        </select>

                    </p>
                </div>

                <?php foreach($params->typeCriterias as $typeCriteria => $elements):?>
                    <div id="<?= $typeCriteria;?>Criteria" class="typeCriteria">
                        <p class="cartTitle">Comparatif</p>
                        <p>
                            <select class="typeCriteriaSelect" name="<?= $typeCriteria;?>CriteriaSelect">
                                <option/>
                                <?php foreach($elements as $element):?>
                                    <option 
                                    value="<?= $element;?>" 
                                    data-vars= "<?= $params->typeCriteriaName[$element]['vars'];?>" 
                                    data-comparator="<?= $element;?>"><?= $params->typeCriteriaName[$element]['name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </p>
                    </div>
                <?php endforeach;?>

                <div>
                    <p>&nbsp;</p>
                        <p>
                            <input type="text" data-type="text" id="valInput"  class="inputCriteriaValue"/>
                            <input type="text" data-type="text" id="fromInput" class="inputCriteriaValue"/>
                            <input type="text" data-type="text" id="toInput"   class="inputCriteriaValue"/>
                        </p>
                    </p>
                </div>

                <div>
                    <p>&nbsp;</p>
                        <p>
                            <button id="addButtonCriteria" class="button">AJOUTER</button>
                        </p>
                    </p>
                </div>
            </div>

            <div>
                <ul id="whereCriteriaElements">
                </ul>
            </div>
    </div>
</div>




<div id="showSqlRequest">
    <code>                           
        <div id="selectRequest"></div>
        <div id="fromRequest"></div>
        <div id="joinRequest"></div>
        <div id="whereRequest"></div>
        <div id="groupByRequest"></div>
        <div id="orderRequest"></div>
        <div id="limitRequest"></div>
    </code>
</div>

<div style="display: flex; justify-content: space-around">
    <input type="submit" class="button" value="Sauvegarder" id="validExtractList"/>
    <?php if($hastList):?>
        <a href="<?= HOST; ?>requestBuilder/show/id/<?= $list->id;?>/" class="button" target="_blank">Voir</a>

        <a href="<?= HOST; ?>requestBuilder/exportExcel/id/<?= $list->id;?>/" class="button" target="_blank">Export XLS</a>



        <hr/>
        <div style="text-align: center;">
            <a href="<?= HOST; ?>requestBuilder/show/id/<?= $list->id;?>/" class="button" style="background-color: darkblue">Supprimer</a>
        </div>

    <?php endif?>
</div>


