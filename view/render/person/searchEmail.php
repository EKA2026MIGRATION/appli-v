<?php $title = "Débloquer email doublon"; ?>

<h2 class="text-center margin-top-20">Débloquer un email doublon</h2>
<p class="text-center" style="color: grey; font-style: italic;">
    Recherche une personne par email (supprimées incluses). L'action "Passer en _old" renomme l'email en <strong>email_old</strong> pour débloquer le doublon.
</p>

<div class="grid-container">
    <div class="medium-8 medium-offset-2 cell">
        <form method="POST" action="<?= HOST; ?>person/searchEmail" id="formSearchEmail">
            <label>Email
                <div style="display:flex; gap:10px;">
                    <input type="text" name="email" id="emailSearch" value="<?= htmlspecialchars($params->email); ?>" placeholder="Rechercher un email...">
                    <button type="submit" class="button">Rechercher</button>
                </div>
            </label>
        </form>
    </div>
</div>

<?php if (!empty((array)$params->results)): ?>
<div class="grid-container margin-top-20">
    <div class="medium-12 cell">
        <table>
            <thead>
                <tr>
                    <th>Person ID</th>
                    <th>User ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($params->results as $person): ?>
                <tr>
                    <td><?= $person->personId; ?></td>
                    <td><?= $person->user_id; ?></td>
                    <td><?= htmlspecialchars($person->lastname); ?></td>
                    <td><?= htmlspecialchars($person->firstname); ?></td>
                    <td><?= htmlspecialchars($person->email); ?></td>
                    <td>
                        <?php if (strpos($person->email, '_old') === false): ?>
                            <button class="button alert small btn-free-email"
                                data-user-id="<?= $person->user_id; ?>"
                                data-email="<?= htmlspecialchars($person->email); ?>">
                                Passer en _old
                            </button>
                        <?php else: ?>
                            <span style="color:grey; font-style:italic;">Déjà passé en _old</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php elseif ($params->email != ''): ?>
<div class="grid-container margin-top-20">
    <div class="medium-12 cell">
        <p class="text-center">Aucun résultat pour "<?= htmlspecialchars($params->email); ?>"</p>
    </div>
</div>
<?php endif; ?>
