<?php $title = "Ajouter / Modifier un aliment"; ?>

<?php $update = 0; if(isset($params->name)):  $update = 1; endif ?>

<h1 class="text-center"><?= (1 === $update) ? 'Modifier' : 'Ajouter';  ?> un aliment </h1>

<form method="post" id="foodForm" action="food/<?= (1 === $update) ? 'modify/'.$params->foodId : 'create';  ?>">
    <input type="hidden" name="photo" id="photoUrl" value="<?= (1 === $update) ?  $params->photo: '';  ?>">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="medium-6 cell">
                <label>Nom de l'aliment *
                    <input type="text" name="name" placeholder="Nom de l'aliment" value="<?= (1 === $update) ?  $params->name: '';  ?>" required>
                </label>
            </div>
            <div class="medium-6 cell">
                <label>Type *
                    <select id="foodKind" name="kind" required>
                        <option <?= (1 === $update && 'starchy' === $params->kind) ?  'selected': '';  ?> value="starchy">Féculents</option>
                        <option <?= (1 === $update && 'accompaniment' === $params->kind) ?  'selected': '';  ?> value="accompaniment">Accompagnement</option>
                        <option <?= (1 === $update && 'condiment' === $params->kind) ?  'selected': '';  ?> value="condiment">Condiment</option>
                        <option <?= (1 === $update && 'vegetables' === $params->kind) ?  'selected': '';  ?> value="vegetables">Légumes</option>
                        <option <?= (1 === $update && 'sandwich' === $params->kind) ?  'selected': '';  ?> value="sandwich">Sandwich</option>
                        <!--<option <?php //(1 === $update && 'dessert' === $params->kind) ?  'selected': '';  ?> value="dessert">Dessert</option>-->
                    </select>
                </label>
            </div>
            <div class="medium-6 cell">
                <label> Description *
                    <textarea rows="3" name="description"><?= (1 === $update) ?  $params->description: '';  ?></textarea>
                </label>
            </div>
            <div class="medium-6 cell">
                <fieldset class="fieldset">
                    <legend>Disponibilité * </legend>
                    <div class="radioImg">
                        <label>
                            <input type="radio" name="status" value="active" <?= (1 === $update && 'active' === $params->status) ?  'checked': '';  ?>>
                            <i class="material-icons green md-36">check_circle_outline</i>
                        </label>
                        <label>
                            <input type="radio" name="status" value="disabled" <?= (1 === $update && 'disabled' === $params->status) ?  'checked': '';  ?>>
                            <i class="material-icons red md-36">highlight_off</i>
                        </label>

                        <label>
                            <input type="radio" name="status" value="archived" <?= (1 === $update && 'archived' === $params->status) ?  'checked': '';  ?>>
                            <i class="icon-outline-archive"></i>
                        </label>

                    </div>
                </fieldset>
            </div>

            <div class="medium-6 cell">
                <div class="dropContainer" id="dropContainer">
                    <div class="contentDropContainer">

                        <div class="image-upload">

                            <label class="labelFileInput" for="fileInput">
                                <a class="button withIcon"><i class="material-icons">create_new_folder</i> Parcourir mes fichiers </a>
                            </label>

                            <input type="file" id="fileInput" onchange="previewOnDiv()"/>

                        </div>
                        Glisser et déposer votre photo ici
                    </div>
                </div>

            </div>
            <div class="medium-6 cell">
                <div class="photoContainer"><img src="<?php if(1 === $update): echo ("" !== $params->photo) ? HOST.$params->photo : IMG.'no_photo_2.jpg'; else: echo IMG.'no_photo_2.jpg'; endif ?>" id="photoRender"></div>
            </div>

            <div class="medium-12 cell">
                <!-- <?php //if($update == 1) { ?>
                    <a href="javascript:void(0)" class="button" data-id="<?php //echo $food->foodId; ?>" onclick="deleteFood(this)"> Supprimer </a>
                <?php // } ?>-->
                <center><input type="submit" class="button large margin-top-20" value="Envoyer" /></center>
            </div>
        </div>
    </div>
</form>