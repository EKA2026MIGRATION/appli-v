<?php $title = "Les derniers appels"; ?>

<h1>Liste des derniers appels</h1>

<section class="block-list">
    <table class="table" role="grid">
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Numéro</th>
                <th>Personne</th>
                <th>Durée</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($params->calls as $call):?>
                <tr>
                    <td><?= $call['date_fr'];?></td>
                    <td><?= $call['time'];?></td>
                    <td><?= $call['number'];?></td>
                    <td><?= $call['fromPerson'];?></td>
                    <td><?= $call['duration'];?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
    </table>
</section>