<?php use_helper("dates");?>
<?php $title = "Inscrire un enfant"; ?>
<?php $update = 0; if(isset($params->firstname)):  $update = 1; endif ?>
<?php (isset($params->child)) ?  $child = $params->child : $child = null?>

<style>
    #registrationCart { border-radius: 20px; max-width: 600px;  width: auto; margin: 0 auto; border: 2px solid darkred; color: darkblue; padding: 20px }
    .deleteRegistration { background-color: darkred; color: white; font-weight: bold; text-align: center; cursor: pointer}
    .registrationCart:hover { background-color: lightgoldenrodyellow}

</style>

<div class="actionsPage">
    <a href="<?= HOST ?>registration/list"> <button class="button"><i class="material-icons">arrow_back</i> </button> </a>
</div>

<h1 class="text-center"><?= (1 === $update) ? 'Modifier' : 'Ajouter';  ?> une inscription </h1>



<?php if($params->message != ""):?>
	<div style="border-radius: 10px; background-color: pink; color: black; padding: 10px">
		Inscription échouée : <?= $params->message;?>
	</div>
	<br/>
<?php endif;?>

<form action="<?= HOST;?>registration/update" method="post">

	<input type="hidden" name="childId" value="<?= $child->childId;?>"/>


	<?php if($child):?>
		<?php if(isset($child->sports)):?>
			<?php foreach($child->sports as $sport):?>
				<?php $arr[] = $sport->sportId;?> 
			<?php endforeach;?>
		<?php else:?>
			<?php $arr = [];?>
		<?php endif;?>
		<input type="hidden" name="latestSports" id="latestSports" value="<?= implode(',', $arr);?>"/>
	<?php endif;?>

	<div class="grid-container">
		<div class="grid-x grid-padding-x">

			<div class="medium-6 cell">
				<label>
					<input type="text" name="fastSearch" placeholder="Cherche un enfant"/>
				</label>
	      	</div>
	      	<div class="medium-6 cell">
	        	<?php if($child):?>
					<h3 style="font-weight: bold; text-align: center"><?= $child->fullname;?></h3>
				<?php endif;?>
	      	</div>
            <!-- cart --->
            <?php if($params->cart):?>
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

			<hr style="height: 1px; background-color: black; width: 100%"/>


			<!--- INSCRIPTION --->
			<?php if(isset($params->presences)):?>
				<?php $presences = $params->presences;?>
				<?php if(count((array) $presences) > 0):?>
					<div class="medium-12 cell" id="listChildRegistration" style="background-color: lightgrey; padding: 30px">		
						<h4>Dernières inscriptions</h4>
						<div>
							<?php $week = 0;?>
							<?php $hideElement = 1;?>
							<?php include(VIEW.'render/child/_presencesListDetails.php');?>
						</div>
					</div>
				<?php endif;?>
			<?php endif;?>
			<hr style="height: 1px; background-color: black; width: 100%"/>


			<!---- ADDRESSE ---->
			<h4>Choix de l'adresse de prise en charge</h4>


			<div class="medium-12 cell">
				<select name="address" id="selectAddress">
					<option></option>
					<?php foreach($child->persons as $person):?>
						<optgroup label="<?= $person->firstname.' '.$person->lastname;?>">
							<?php foreach($person->addresses as $address):?>
								<option value="<?= $address->addressId;?>"><?= '<b>'.$address->name.'</b> : '.$address->address.' - '.$address->postal.', '.$address->town;?></option>
							<?php endforeach;?> 
						</optgroup>
					<?php endforeach;?>
				</select>
			</div>

			<div class="medium-6 cell">
				<input type="text" name="freeAddress" id="freeAddress" placeholder="Entrez une adresse alternative"/>
			</div>
			<div class="medium-3 cell">
				<input type="text" name="freePostal" id="freePostal" placeholder="Code postal"/>
			</div>
			<div class="medium-3 cell">
				<input type="text" name="freeTown" id="freeTown" placeholder="Ville"/>
			</div>

			<hr style="height: 1px; background-color: black; width: 100%"/>


			<h4>Choix du produit</h4>
			<div class="medium-12 cell">
				<select name="product" id="selectProduct">
					<option value="0" disabled selected></option>
					<?php foreach($params->categories as $category):?>
						<?php if(count((array) $category->products) > 0):?>
								<optgroup label="<?= $category->publicName; ?>">
									<?php if($category->publicName != "A la carte" && $category->publicName != "Anniversaire"): ?>
										<?php foreach($category->products as $product):?>
											<option value="<?= $product->productId; ?>"  data-category='PRODUCT'><?= $product->nameFr; ?></option>
										<?php endforeach; ?>
									<?php else: ?>
											<?php $y = 0; ?>
											<?php foreach($category->products as $product):?>
												<?php $alacarte[$product->productId] = ['name' => $product->nameFr, 'start' => $product->hours[0]->start.':00', 'end' => $product->hours[0]->end.':00', 'priceTtc' => $product->priceTtc];?>
												<?php if($y != 0) { continue; }?>
												<option value="<?= $product->productId; ?>" data-category='EKA-DAYCAMP'>Sélection des dates</option>
												<?php $y++;?>
											<?php endforeach; ?>
									<?php endif; ?>
								</optgroup>
						<?php endif;?>
					<?php endforeach; ?>
				</select>
			</div>
		

			<!----- PRODDUCT DAYCAMP ------>
			<div class="medium-12 cell" id="EKA-DAYCAMP-PRODUCTS" style="display: none">
				<?php include('_addRegistrationProductALaCarte.php');?>
			</div>

			<!--- PRODUT DETAILS --->
			<?php include('_addRegistrationProduct.php');?>

			<hr class="partial" style="height: 1px; background-color: black; width: 100%; display: none"/>

			<div class="medium-12 cell partial" style="padding-left: 0px; display: none">
				<h4>Etat du paiement</h4>
			</div>
			<div class="medium-6 cell partial" style="display: none">
				<label>Statut
				<select name="status" id="changePayedStatus">
					<option value="payed">Payé</option>	   
					<option value="waiting">En attente de paiement</option>
					<option value="unpayed">Non payé</option>
       		          	
				</select>
				</label>
			</div>
			<div class="medium-6 cell partial" style="display: none">
				<label>Montant déjà payé 
					<input type="number" name="payed" step="any" placeholder="Montant payé">
				</label>
	      	</div>

			<div id="pickupDateDiv" class="medium-12 cell partial" style="display: none">
				<section class="block-list">
					<header>Affecter un paiement par date de prise en charge</header>
					<ul id="pickupDateUl"> </ul>
				</section>
			</div>

			<div class="medium-12 cell partial" style="display: none">
				<br/><br/>
       			<center><input type="submit" id="submitButton" class="button large" style="width: 100%" value="Envoyer" /></center>
	  		</div>

		</div>
	</div>

	<input type="hidden" id="isTransport" name="isTransport">
	<input type="hidden" id="dropIn" name="dropIn">
	<input type="hidden" id="dropOff" name="dropOff">
	<input type="hidden" id="locationId" name="locationId">
	<input type="hidden" id="sportId" name="sportId">
	<input type="hidden" id="sessionStart" name="sessionStart">
	<input type="hidden" id="sessionEnd" name="sessionEnd">
	<input type="hidden" id="pickupDatePaiement" name="pickupDatePaiement">
	<div id="inputDateHourSession">
	</div>
</form>



<input type="hidden" id="inputProductALaCarte" value='<?php echo json_encode($alacarte, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);?>'/>

