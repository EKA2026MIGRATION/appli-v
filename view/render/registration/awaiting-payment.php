<?php use_helper('dates'); $title = "Liste des inscriptions en attente de paiement";?>

<h1>Inscriptions en attente de paiement</h1>

<style>
    .aRegistration { padding: 0px!important;}

    #validationForm { z-index: 999; position: absolute; background-color: white; border: 2px solid darkred; width: 400px; padding: 10px; border-radius: 10px}
</style>


Trier par enfant
<select id="selectChild">
    <option value="all">Tous</option>
    <?php foreach($params->childList as $id => $childName):?>
        <option value="<?= $id;?>"><?= $childName;?></option>
    <?php endforeach;;?>
</select>

<div id="validationForm" style="display: none">
    <i class="material-icons" style="color: darkred; float: right; cursor: pointer" id="closeValidationForm">close</i>

    <h6>Valider le paiement</h6>

    <input type="text" name="amountPayment" id="amountPayment" placeholder="montant payé en €"/>

    <select name="typePaiement" id="validationType">
        <option></option>
        <option value="virement">Virement</option>
        <option value="cheque">chèque</option>
    </select>


    <select name="status" id="validationStatus">
        <option value="payed">Payé</option>
        <option value="unpayed">Non payé</option>
    </select>

    <input type="text" name="info" id="validationInfo" placeholder="Informations sup."/>

    <br/><br/>

    <button class="validNewStatus" id="validNewStatus" style="background-color: darkblue; color: white; padding: 10px; ">CONFIRMER</button>

    <input type="hidden" id="registrationId" name="registrationId"/>

</div>


<ul id="">

    <?php foreach($params->registrations as $registration):?>


        <li data-id-registration="<?= $registration->registrationId; ?>" class="liChild" id="liChild-<?= $registration->registrationId;?>" style="list-style: none">
            <a class="aRegistration" href="javascript:void(0)">
                <div>
                    <p class="list-header">
                        <div style="display: flex; justify-content: space-between">
                            <div>
                                <input type="checkbox" data-id="<?= $registration->registrationId;?>" class="registration-checkbox"/>

                                <b><?= $registration->child->fullname; ?></b>
                                <span style="color: darkblue"><?= $registration->product->name;?>
                                    <i style="font-size: 12px">
                                        <?php $i = 0; $end = ''; foreach($registration->sessions as $session):?>
                                            <?php $i++; if($i > 3) { $end = ' ...'; continue; };?>
                                            <?php echo showDate($session->date).' - '.showTime($session->start).':'.showTime($session->end);?>
                                        <?php endforeach;?>
                                        <?= $end;?>
                                    </i>
                                </span>

                                <div style="color: black; font-style: italic; font-size: 12px">
                                    Effectuée le <?= showDate($registration->registration); ?>
                                    par <?= $registration->person->fullname; ?>
                                </div>
                            </div>

                            <div>
                                A payer : <?= $registration->product->priceTtc;?> €

                                &nbsp;&nbsp;

                                <button class="changeStatusButton button" id="buttonValidation-<?= $registration->registrationId;;?>-<?= $registration->product->priceTtc;;?>">Valider</button>

                            </div>

                        </div>


                        <?php ($registration->status == "payed") ? $style = "color: black; font-size: 10px" : $style = "font-size: 10px" ;?>

                    </p>
                </div>
            </a>
        </li>
    <?php endforeach; ?>

    <button id="validateAll" style="background-color: green; color: white; padding: 10px; margin-top: 10px; cursor: pointer">TOUT VALIDER</button>
    <div id="confirmationModal" style="display: none; position: fixed; z-index: 1000; left: 50%; top: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border-radius: 10px; border: 1px solid black;">
        <p>Confirmer la validation de paiement pour les inscriptions sélectionnées ?</p>
        <button id="confirmValidation" style="background-color: blue; color: white; padding: 10px;">Confirmer</button>
        <button onclick="$('#confirmationModal').hide();" style="background-color: red; color: white; padding: 10px;">Annuler</button>
    </div>

</ul>


<script>
    document.getElementById('selectChild').addEventListener('change', function(event) {

        let childId = event.target.value;

        let allLi = document.getElementsByClassName('liChild');

        for(let i = 0; i < allLi.length; i++) {
            let li = allLi[i];

            let currentId = li.id.split('-')[1];

            if( currentId == childId || childId == "all") {
                li.style.display = "block"
            } else {
                li.style.display = "none";
            }

        }

    })

</script>