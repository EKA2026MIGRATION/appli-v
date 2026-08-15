<div class="reveal" id="addDateCancelled" data-reveal>
  <p class="lead">Ajouter une date </p>

  <form method="post" id="dateForm" action="product-cancelled-date/create">
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
	      <div class="medium-12 cell">
	        <label> Date à annuler *
	          <input type="text" id="date_cancelled"  placeholder="Date" required>
	        </label>
	          <input type="hidden" id="datepicker" name="date">
	      </div>
		  <div class="medium-12 cell">
			<label> Associer un produit*
				<select name="product" id="selectProduct">
					<option value="0" disabled selected>Choisir un produit </option>
					<?php foreach($params->categories as $category):?>
                    <?php if($category->name !== "EKA-DAYCAMP") continue;?>
				    	<?php foreach($category->products as $product):?>
					  		<option value="<?= $product->productId; ?>"><?= $product->nameFr; ?></option>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</select>
			</label>
		 </div>
		 <input type="hidden" id="category" name="category">
	      <div class="medium-12 cell">
	        <label> Message (français)*
	          <input type="text" name="messageFr" placeholder="Message en français" required>
	        </label>
	      </div>
	      <div class="medium-12 cell">
	        <label> Message (anglais)*
	          <input type="text" name="messageEn" placeholder="Message en anglais" required>
	        </label>
	      </div>

		   <div class="medium-12 cell" style="margin-top: 10px;">
			<center><button type="submit" class="button">Envoyer </button></center>
		   </div>
      </div>
    </div>
  </form>

  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
  <p>* champ obligatoire</p>
</div>