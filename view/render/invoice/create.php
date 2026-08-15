<style>
.required { border: 2px solid red}
input::placeholder {
  color: grey;
}
</style>
<?php $title = "Créer une facture"; ?>

<h1 class="text-center">Créer une facture</h1>

<div class="actionsPage">
    <a href="<?= HOST ?>invoice/list"> <button class="button"><i class="material-icons">arrow_back</i> </button> </a>
    <a href="#"> <button class="button"><i class="material-icons">picture_as_pdf</i> </button> </a>

</div>

<form method="post" id="invoiceForm" action="update">

  <?php if(!hasCredential('invoice::mode-full')):?>
    <input type="hidden" name="status" value="payed-draft">
  <?php endif;?>



  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="medium-6 cell">
        <label>Nom de l'enfant *
          <?php if(isset($params->child)):?>
            <input type="search" id="searchListChild" name="child_name" value="<?= $params->child->fullname;?>" disabled>
            <input type="hidden" name="child" id="child_id" value="<?= $params->child->childId;?>">

            <ul id="childList" style="display: inline-block">
                <div onClick='closeChildList()' style='color: red; cursor: pointer; float: left'>X</div><hr style='clear: both'/>
                <i>Sélectionnez l'intitulé et l'adresse de facturation</i><br/><br/>

                <?php foreach($params->child->persons as $person):?>
                  <ul>
                      <li style='font-weight: bold; cursor: pointer' onClick='updateFamilyName("<?= $person->lastname;?>", this)'>Mme/M. <?= $person->lastname;?></li>
                      <ul>
                          <?php foreach($person->addresses as $address):?>
                            <li style='cursor: pointer' onClick='updateAddressElement("<?= str_replace(["'"]," ",$address->address);?>", "<?= $address->postal;?>", "<?= $address->town;?>", this)'><?= str_replace(["'"]," ",$address->address)." - ".$address->postal.", ".$address->town;?></li>
                          <?php endforeach;?>
                      </ul>
                  </ul>
                <?php endforeach;?>
            </ul>

          <?php else:?>
            <input type="search" id="searchListChild" name="child_name" placeholder="Nom de l'enfant">
            <input type="hidden" name="child" id="child_id">
            <ul id="childList"></ul>
          <?php endif;?>

        </label>
      </div>
      <div class="medium-6 cell">
        <label>Saisie libre
          <input type="text" name="nameFr" placeholder="Saisie libre"  class="required" id="freename" class="required" required>
        </label>
      </div>
      <div class="medium-6 cell">
        <label> Date de facturation *
          <input type="text" id="date_invoice" class="required" value="<?= date('d/m/Y');?>" placeholder="Date de facturation" required>
        </label>
          <input type="hidden" id="datepicker" name="date" value="<?= date('Y-m-d');?>">
      </div>
      <div class="medium-6 cell"></div>
      <div class="medium-6 cell">
        <label>Adresse
          <input type="text" name="address" placeholder="Addresse" id="invoiceAddress" class="required">
        </label>
      </div>
      <div class="medium-3 cell">
        <label>Code postal
          <input type="text" name="postal" placeholder="Code postal" id="invoicePostal" class="required">
        </label>
      </div>
      <div class="medium-3 cell">
        <label>Ville
          <input type="text" name="town" placeholder="Ville" id="invoiceTown" class="required">
        </label>
      </div>

      <div class="medium-12 cell">
        <label> Objet de la facture FR
          <input type="text" name="descriptionFr"  placeholder="Description FR" >
        </label>
      </div>

      <div class="medium-12 cell">
        <label> Objet de la facture EN
          <input type="text" name="descriptionEn"  placeholder="Description EN" >
        </label>
      </div>

      <div class="medium-6 cell">
        <label>Numéro de facture
          <input type="text" name="number"  placeholder="Laisser vide pour automatique">
        </label>
      </div>
      <div class="medium-6 cell">
        <label>Mode de paiement
          <select name="paymentMethod">
            <option value="cheque">Chèque</option>
            <option value="virement">Virement</option>
            <option value="cb">CB</option>
          </select>
        </label>
      </div>

      <div class="medium-12 cell">
        <label> Ajouter un produit
          <select name="product" id="selectProduct">
            <option value="0" disabled selected>Choisir un produit </option>
            <?php foreach($params->categories as $category):?>
                  <optgroup label="<?= $category->name; ?>">
                      <?php foreach($category->products as $product):?>
                        <?php if($product->visibility != "archived"):?>
                          <option value="<?= $product->productId; ?>">
                            <?= $product->nameFr; ?>
                          </option>
                        <?php endif;?>
                    <?php endforeach; ?>
                  </optgroup>
            <?php endforeach; ?>
          </select>
        </label>
      </div>

      <div class="medium-12 cell">
          <label> Ajouter un composant</label>
            <div style="width: 80%; float: left">
                <select id="componentSelect" >
                    <?php foreach ($params->components as $component): ?>
                        <option id="option<?= $component->componentId; ?>" value="<?= $component->componentId; ?>" data-vat="<?= $component->vat; ?>" data-name-fr="<?= $component->nameFr; ?>" data-name-en="<?= $component->nameEn; ?> ">
                            <?= $component->nameFr; ?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
            <a  style="width: 15%; float: right; height:39px; padding-top: 5px;" href="javascript:void(0)" class="button" id="addCompontent"> <i class="material-icons">add</i> </a>
          <input type="hidden" id="liveResultComponent" />
      </div>


      <h2 class=" medium-12 cell margin-top-20 ">Contenu</h2>
      <div class="tableScrollable">
        <table id="tableContentInvoice">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix U/TTC</th>
                    <th>Prix U/HT</th>
                    <th>Quantité</th>
                    <th>Total TTC</th>
                    <th>Total HT</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="tableContentBody">
            </tbody>

            <tfooter>
                <th colspan="5" style="text-align: right">TOTAL</th>
                <th id="invoice-totalTtc" style="text-align: left"></th>
                <th id="invoice-totalHt" style="text-align: left"></th>
                <th></th>
            </tfooter>

          </table>
        </div>

      <div class="medium-12 cell">

        <input type="hidden" name="priceTtc" id="invoicePriceTtc"/>
        <input type="hidden" name="prices" value="unknown"/>

       	<center><input type="submit" class="button large" id="displayOverButtons" value="Envoyer" /></center>
      </div>
    </div>
  </div>
</form>
<div id="hiddenComponent" style="display:block"></div>
<p>* champ obligatoire</p>
