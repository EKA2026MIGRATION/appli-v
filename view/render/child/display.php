<?php $title = 'Profil '.$params->child->firstname.' '.$params->child->lastname; ?>
<?php use_helper('buttons'); ?>
<?php use_helper('age'); ?>
<?php use_helper('photo'); ?>
<style>
    .deleteRegistration { background-color: darkred; color: white; font-weight: bold; text-align: center; cursor: pointer}
    .registrationCart:hover { background-color: lightgoldenrodyellow}

</style>


<div class="actionsPage">
    <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
</div>

<?php showFloatingActionButton($params->buttons); ?>

<h1 class="text-center"><?= $params->child->firstname.' '.$params->child->lastname; ?></h1>
<div class="text-center"><?= showGender($params->child->gender);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#<?= $params->child->childId; ?></div>
<div class="text-center">créée le <?= showDate($params->child->createdAt); ?></div>

<input type="hidden" id="childId" value="<?= $params->child->childId; ?>"/>

<div id="showInvoiceDetails" class="">
</div>


<div class="page__profil" id="displayOverButtons">

    <?php include '_revealSearchAssociatedChild.php'; ?>

	<div class="profile__picture">
		<img src="<?= ('' != $params->child->photo) ? HOST.$params->child->photo : IMG.'no_photo.jpg'; ?>" />
	</div>

    <!-- cart --->
    <?php if($params->cart):?>
        <hr/>

        <div class="medium-6 cell" id="registrationCart">
            <div style="text-align: center; color: darkred"><b>PANIER EN COURS</b></div>
            <ul>
                <?php foreach($params->cart as $cart):?>

                    <?php $dates = []; foreach($cart->sessions as $session):?>
                        <?php ($session->date) ? $dates[] = showDate($session->date) : $datesString = null;?>
                    <?php endforeach?>

                    <?php (count((array) $dates) < 6) ? $datesString = implode('|', $dates) : $datesString = $dates[0].' ... '.$dates[count((array) $dates)-1]?>
                    <li id="regisrationLiId<?= $cart->registrationId;;?>"class="registrationCart">
                        <ul style="list-style-type: none">
                            <li><b><?= strip_tags($cart->product->nameFr);?></b> <i style="font-size: 14px">Faite le <?= showDate($cart->registration);?></i></li>
                            <?php if($datesString) echo '<li>Date(s) de la session : '.$datesString.'</li>';?>
                            <li class="deleteRegistration" data-registrationid="<?= $cart->registrationId;?>" >SUPPRIMER</li>
                        </ul>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>

    <hr/>

    <div class="medium-6 cell" style="display: flex; justify-content: space-around">
        <a href="<?= HOST ?>media/list/childid/<?= $params->child->childId; ?>/">Voir les photos validées</a>
        <a href="<?= HOST ?>assets/image/cards/14/card-<?= $params->child->childId; ?>.png" class="view-card" target="_blank">Voir la carte</a>
        <div>
            <?php if($params->child->frontDocument != null): ?>
                <?php $url = $params->child->frontDocument; ?>
                <a href="<?php echo $url;?>" target="_blank">Voir le justificatif de domicile</a>
                <!-- supprimer le justificatif -->
                <a href="<?= HOST ?>child/deleteJustificatif/childid/<?= $params->child->childId; ?>/type/justificatif/" style="color: darkred">x</a>
            <?php else:?>

                <form action="<?= HOST;?>child/addJustificatif" method="post" enctype="multipart/form-data" style="display: flex; justify-content: space-around">
                    <?php
                        $idsArr[] = $params->child->childId;
                        foreach($params->child->siblings as $child) {
                            $idsArr[] = $child->childId;
                        }
                        $ids = implode('|', $idsArr);
                    ;?>
                    <div>
                        <label>Justificatif de domicile</label><br/>
                        <input type="hidden" name="ids" value="<?=$ids;?>">
                        <input type="file" name="justificatif" id="justificatif">
                    </div>
                    <input type="submit" value="Envoyer" style="font-size: 12px; padding: 0 10px; margin-bottom: 20px;">
                </form>
            <?php endif;?>
        </div>
        <div>
            <?php if($params->child->frontQr != null): ?>
                <?php $url = $params->child->frontQr; ?>
                <a href="<?php echo $url;?>" target="_blank">Voir le QR Code</a>
                <!-- supprimer le justificatif -->
                <a href="<?= HOST ?>child/deleteJustificatif/childid/<?= $params->child->childId; ?>/type/qrcode/" style="color: darkred">x</a>
            <?php else:?>
                <form action="<?= HOST;?>child/addJustificatif" method="post" enctype="multipart/form-data" style="display: flex; justify-content: space-around">
                    <?php
                    $idsArr[] = $params->child->childId;
                    foreach($params->child->siblings as $child) {
                        $idsArr[] = $child->childId;
                    }
                    $ids = implode('|', $idsArr);
                    ;?>
                    <div>
                        <label>QR Code</label><br/>
                        <input type="hidden" name="ids" value="<?=$ids;?>">
                        <input type="file" name="qrcode" id="qrcode">
                    </div>
                    <input type="submit" value="Envoyer" style="font-size: 12px; padding: 0 10px; margin-bottom: 20px;">
                </form>
            <?php endif;?>
        </div>
    </div>


    <ul class="tabs margin-top-20" data-tabs id="child-tabs">
        <li class="tabs-title is-active"><a href="#panel1" aria-selected="true" class="tab-href">Informations</a></li>
        <li class="tabs-title"><a href="#panel4"  class="tab-href">Contact</a></li>
        <!--<li class="tabs-title"><a href="#panel2" class="tab-href">Personne(s) associée(s)</a></li>-->
        <li class="tabs-title"><a href="#panel5" class="tab-href">Famille</a></li>
        <li class="tabs-title"><a href="#panel8" class="tab-href">Factures</a></li>
        <li class="tabs-title"><a href="#panel6" class="tab-href">Inscriptions</a></li>
        <li class="tabs-title"><a href="#panel3" class="tab-href">Présences</a></li>
        <li class="tabs-title"><a href="#panel7" class="tab-href">Transport</a></li>
        <!--<li class="tabs-title"><a href="#panel9" class="tab-href">Sondages</a></li>-->
    </ul>



    <div class="tabs-content" data-tabs-content="child-tabs">

        <?php include '_informations.php'; ?>

        <?php include '_contact.php'; ?>

        <?php include '_siblings.php'; ?>

        <?php //include('_persons.php');?>

        <?php include '_invoice.php'; ?>

        <?php include '_registration.php'; ?>

        <?php include '_presences.php'; ?>

        <?php include '_pickup.php'; ?>

        <?php // include '_survey.php'; ?>


    </div>
</div>
<div class="space_actions_page_mobile"></div>


<script>
    document.querySelector('.view-card').addEventListener('click', function(event) {
        event.preventDefault();

        const imageUrl = event.currentTarget.href;
        const img = new Image();
        img.src = imageUrl;
        img.style.width = '400px'; // Réduit la largeur de l'image à 80%
        img.style.height = 'auto'; // Maintient le ratio d'aspect
       // img.style.maxHeight = '80%'; // Limite la hauteur de l'image à 50%

        const newWindow = window.open("", "_blank");
        newWindow.document.write('<html><head><title>Image</title><style>body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }</style></head><body>' + img.outerHTML + '</body></html>');
    });
</script>
