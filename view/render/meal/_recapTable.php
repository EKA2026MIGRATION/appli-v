<table id="recapFoodTable">
    <thead>
    <tr>
        <th></th>
        <?php foreach($params->foodCategories as $categorie=>$value):
            foreach($params->foods as $food):
                $stringify = $food->foodId;
                if ($categorie === $food->kind && 'active'=== $food->status && isset($params->counts->food->$stringify)): ?>
                    <td><div><section><img src="<?= ("" != $food->photo ) ? HOST.$food->photo : IMG.'no_photo_2.jpg';  ?>"></section></div></td>
                <?php endif;
            endforeach ;
        endforeach ?>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>Enfants</th>
        <?php foreach($params->foodCategories as $categorie=>$value):
            foreach($params->foods as $food): $stringify = $food->foodId;
                if ($categorie === $food->kind && 'active'=== $food->status && isset($params->counts->food->$stringify)):?>
                    <td><div><section><?=  ($stringify === $food->foodId && isset($params->counts->food->child->$stringify)) ? $params->counts->food->child->$stringify: '-';  ?></section></div></td>
                <?php endif;
            endforeach;
        endforeach; ?>
    </tr>

    <tr>
        <th>Encadrants</th>
        <?php foreach($params->foodCategories as $categorie=>$value):
            foreach($params->foods as $food): $stringify = $food->foodId;
                if ($categorie === $food->kind && 'active'=== $food->status && isset($params->counts->food->$stringify)):?>
                    <td><div><section><?=  ($stringify === $food->foodId && isset($params->counts->food->person->$stringify)) ? $params->counts->food->person->$stringify: '-';  ?></section></div></td>
                <?php endif;
            endforeach;
        endforeach; ?>
    </tr>

    <tr>
        <th>Autres</th>
        <?php foreach($params->foodCategories as $categorie=>$value):
            foreach($params->foods as $food): $stringify = $food->foodId;
                if ($categorie === $food->kind && 'active'=== $food->status && isset($params->counts->food->$stringify)):?>
                    <td><div><section><?=  ($stringify === $food->foodId && isset($params->counts->food->freeName->$stringify)) ? $params->counts->food->freeName->$stringify: '-';  ?></section></div></td>
                <?php endif;
            endforeach;
        endforeach; ?>
    </tr>

    <tr class="totalRecap">
        <th>Total</th>
        <?php foreach($params->foodCategories as $categorie=>$value):
            foreach($params->foods as $food): $stringify = $food->foodId;
                if ($categorie === $food->kind && 'active'=== $food->status && isset($params->counts->food->$stringify)):?>
                    <td><div><section><?=  ($stringify === $food->foodId) ? $params->counts->food->$stringify: '';  ?></section></div></td>
                <?php endif;
            endforeach;
        endforeach; ?>
    </tr>
    </tbody>

</table>

Nombre de total de repas : <?= $totalMeals['total'];?><br/>
dont <?= $totalMeals['child'];?> enfant et <?= $totalMeals['adult'];?> adulte.<br/>
<?= $totalMeals['other'];?> non identifié
