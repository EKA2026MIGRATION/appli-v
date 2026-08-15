<div class="reveal" id="addInscriptionClosed" data-reveal>
  <p class="lead">Ajouter une date de fermerture</p>

  <form method="post" id="inscriptionClosedForm" action="product-cancelled-date/create-by-category">
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
	  	<div class="medium-6 cell">
			Du <br/>
			<input type="date" id="dateClosedFrom" name="dateClosedFrom" value="">
		</div>
		<div class="medium-6 cell">
			Au <br/>
			<input type="date" id="dateClosedTo" name="dateClosedTo" value="">
		</div>
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