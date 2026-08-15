<div style="position: absolute; display: none" id="editStockProduct">
    <i class="material-icons" id="closeEditStockProduct">close</i><br/>
    <div style="text-align: center"><b>MODIFIER LA FICHE PRODUIT</b></div>
    <br/>

    <input type="hidden" name="stockProduct_id" id="stockProduct_id"/>
    <div>
        Nom
        <input class="form" type="text" placeholder="Nom" name="stockProduct_name" id="stockProduct_name"/>
    </div>

    Catégorie
    <select name="categoryid" id="stockProduct_categoryid">
        <option></option>
        <?php foreach($categoryArray as $catId => $catName):?>
            <option value="<?= $catId ;?>"><?= $catName;?></option>
        <?php endforeach;?>
    </select>


    <div class="flex">
        <div>
            Stock Minimum
            <input class="form inputNumber" type="number" placeholder="Stock minimum" min="0" value="0" step="1" name="stockProduct_minimumStock" id="stockProduct_minimumStock"/>
        </div>
        <div>
            Quantité cible
            <input class="form inputNumber" type="number" placeholder="Quantité cible" min="0" value="0" step="1" name="stockProduct_restockLevel" id="stockProduct_restockLevel"/>
        </div>
        <div>
            Stock Actuel
            <input class="form inputNumber" type="number" placeholder="Stock actuel" min="0" value="0" step="1" name="stockProduct_currentStock" id="stockProduct_currentStock"/>
        </div>

    </div>

    Unité
    <select name="unity" id="stockProduct_unity">
        <option></option>
        <option value="pièce">Pièce</option>
        <option value="paquet">Paquet</option>
        <option value="gr">Gramme</option>
        <option value="kg">Kilogramme</option>
        <option value="litre">Litre</option>
    </select>

    Prix en €uros
    <input class="form" type="number" placeholder="Prix" step="0.01" min="0" name="stockProduct_price" id="stockProduct_price"/>
    <textarea class="form" placeholder="Conditionnement" rows="5" name="stockProduct_conditioning" id="stockProduct_conditioning"></textarea>
    <input type="submit" name="VALIDER" class="button" id="submitStockProductForm"/>
</div>