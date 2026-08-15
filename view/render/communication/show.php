<?php use_helper('dates, buttons');?>
<?php $title = "Liste d'envoi"; ?>
<?php $campagn = $params->campagn;?>
<?php include '_productListChild.php';?>

<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>

<style>

    main, .contactRow { display: flex; flex-wrap: wrap; justify-content: space-between}
    #mobileView { width: 35%; min-width: 350px}
    #listContact { width: 60%; min-width: 400px;  }
    #phoneNumberList {height: 80vh; overflow: auto }


    form { background-color: black; padding: 20px; border-radius: 20px; box-shadow: 5px 5px 5px black}
    textarea, input { border-radius: 6px!important}

    .contactRow { width: 90%}
    .deleteLine { cursor: pointer}

    #dialog { display : none; position: absolute; top: 0;z-index: 9999; height: 100%; width: 100%; }
    #dialogContent { margin-top: 80px; background-color: white; border: 2px solid darkred; border-radius: 20px; box-shadow: 2px 2px 2px black; max-width: 600px; position: relative}
    #closeDialogButton { font-size: 40px; color: darkred; float: right; margin-right: 25px; cursor: pointer}
    #ulDialog {min-height: 400px; margin: 0px }



    .liListName:hover { background-color: lightblue!important}
    #barButton { position: fixed; width:inherit; background-color: darkblue; padding: 20px; display: flex; width: 500px; justify-content: space-around}
    #barButton div { margin: 10px;}
    #infoChecked { background-color: white; color: black; display: inline-block; vertical-align: middle; margin: 0 0 1rem 0; padding: 0.85em 1em; border: 1px solid transparent; font-size: 0.9rem; line-height: 1; text-align: center;}
    .checkboxListChild { width: 20px; height: 20px }

    .firstLetter { color: darkblue; background-color: darkred; font-weight: bold; font-size: 18px; padding: 20px;}

</style>

<?php if(isset($params->buttons)) showFloatingActionButton($params->buttons);?>
<h2 class="text-center margin-top-20">Campagne<br/><b><?= $campagn->name;?><b></h2>

<?php if($campagn->id):?>

    <hr/>

    <section>

            <h5>Ajout de personnes dans les contacts</h5>
            <div style="display: flex">
                <input type="text" id="addManuel" placeholder="Ajout manuel d'un téléphone">
                <input type="submit" class="button" value="+" id="addManuelButton" style="margin-left: 10px; font-size: 20px; padding: 8px">
            </div>

            <div>
                <?php $currentCategory = "";?>

                <select data-type="listByProduct" class="selectListButton">
                    <option value="" disabled selected style="color: grey">Listes enfants inscrits par produit</option>
                    <?php foreach($params->listByProducts as $categoryName => $datas):?>
                        <?php foreach($datas as $data):?>
                            <?php $product = $data['product'];?>
                            <?php if($product->visibility != "personvisibility"):?> 
                                <?php if($currentCategory != $categoryName):?>
                                    <optgroup label="<?= $data['categoryPublicName']?>">
                                    <?php $currentCategory = $categoryName;?>
                                <?php endif;?>
                                <option value="<?= $product->productId;?>"><?= $product->nameFr; ?></option>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <select data-type="extractList" class="selectListButton">
                    <option value="" disabled selected style="color: grey">Listes pré-enregistrées</option>
                    <?php foreach($params->extractLists as $list):?>
                        <option value="<?= $list->id;?>"><?= $list->title;?></option>
                    <?php endforeach;?>
                </select>
            </div>
    </section>


    <br/><br/>

    <hr/>

<?php endif;?>

<main>

    <div id="mobileView">
            <form action="#" method="POST">

                <input type="hidden" id="historicSmsId" value="<?= $campagn->id;?>">
                <input type="text" id="historicSmsName" placeholder="Nom de la campagne" value="<?= $campagn->name;?>">

                <h5 style="color: white">Message à envoyer</h5>

                <textarea 
                        name="textToSend" class="contentSmsElement"
                        rows="6" 
                        placeholder="Ajouter ici votre texte"
                        id="textSms"><?= $campagn->content;?></textarea>

                <div id="textSmsLength" style="font-size: 12px; font-style: italic; color: white"></div>
                <h5 style="color: white">Signature du SMS</h5>
                <input type="text" class="contentSmsElement" id="signature" value = "<?= $campagn->signature;?>" placeholder="<?= PERSON_CONNECTED['firstname'];?> - <?= PERSON_CONNECTED['phones']['0']['phone'];?>"/>
                <div id="signatureLength" style="font-size: 12px; font-style: italic"></div>

                <div style="display: flex; justify-content: space-between">
                    <div id="totalLength" style="font-weight: bold; color: white"></div>
                    <div style="color: white">
                        Emoji <input type="checkbox" name="isUnicode" id="isUnicode" <?= $campagn->unicode == 1 ? "checked" : "";?>>
                    </div>
                </div>

            
                <hr/>

                <div class="medium-12 cell">

                    <input type="submit" class="button" value="Enregistrer" id="saveHistoricSmsName" style="margin-left: 10px; font-size: 20px; padding: 8px">

                </div>

            </form>

            <?php if($campagn->id):?>

                <div class="medium-12 cell">
                    <center><a href="#" class="button margin-top-20" style="background-color: darkblue; color: white" id="sendSmsButton">Envoyer les SMS</a></center>
                </div>

            <?php endif;?>


    </div>

    <?php if($campagn->id):?>

        <div id="listContact">

                <h5>
                    Liste des numéros de téléphones
                    <i class="material-icons" title="vider la liste" style="font-size: 20px; color: darkred; float: right; margin-right: 25px; cursor: pointer;" id="emptyPhoneNumberList">delete</i>
                </h5>

                <section class="block-list">
                    <ul id="phoneNumberList">
                        <?php foreach($campagn->phoneNumbers as $contact):?>
                            <li style="padding: 0px; padding-top: 10px; padding-bottom: 10px;" id="linePhoneNumber<?= $contact->phoneNumber;?>">
                                <div class="contactRow">
                                    <p  id="pLinePhoneNumber<?= $contact->phoneNumber;?>" class="list-header" style="font-weight: normal"> <?= $contact->phoneName;?></p>
                                    <p  class="list-subheader phoneNumber" 
                                        data-childId = "<?= $contact->childId;?>" 
                                        data-phoneid = "<?= $contact->id;?>" 
                                        data-name="<?= $contact->phoneName;?>" 
                                        data-phonenumber="<?= $contact->phoneNumber;?>"><?= $contact->phoneNumber;?>
                                    </p>
                                    <div>
                                        <i class="material-icons deleteLine" style="font-size: 30px; color: darkred" onclick="removeLine('<?= $contact->phoneNumber;?>')">close</i>
                                    </div>
                                </div>
                            </li>

                        <?php endforeach;?>
                    </ul>
                </section>

        </div>
    <?php endif;?>

</main>

