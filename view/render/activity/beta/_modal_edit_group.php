<div id="editModalGroupDiv">

    <button class="close-button"data-close aria-label="Close modal"type="button" id="closeEditModalGroupDiv">
        <span aria-hidden="true">&times;</span>
    </button>

    <div>

        <form id="editGroupForm" method="post">

            <!--- group id -->
            <input type="hidden" id="editGroupId" value="">

            <!-- name group -->
            <input type="text" name="name" placeholder="Nom du groupe" id="editNameGroup" style="width: 90%">

            <!-- heure de début - heure de fin -->
            <div style="display: flex; justify-content: space-between">
                <input type="time" id="editStartGroup" value="08:00" placeholder="Heure de début">
                <input type="time" id="editEndGroup" value="08:00" placeholder="Heure de fin">
            </div>

            <!-- list of monitors -->
            <label>Moniteurs</label>
            <div class="multi-column">
                <?php foreach($params->staff_presence['COACH'] as $coach):?>
                    <label data-locationcoach="<?= $coach['location'];?>">
                        <input type="checkbox" class="editCoachName" value="<?= $coach['id']; ?>"> <?= $coach['name'];?>
                    </label>
                <?php endforeach; ?>
            </div>

            <!-- locations -->
            <label>Lieux</label>
            <select id="editLocationGroup">
                <option/>
                <?php foreach($_SESSION['LOCATIONS'] as $location):?>
                    <option value="<?= $location->locationId; ?>"><?= $location->name; ?></option>
                <?php endforeach; ?>
            </select>


            <!-- activities -->
            <label>Activités</label>
            <select id="editSportGroup">
                <option/>
                <?php foreach($_SESSION['SPORTS'] as $sport):?>
                    <option value="<?= $sport['sportId']; ?>"><?= $sport['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <!-- lunch (repas oui/non) -->
            <input type="checkbox" id="editLunchGroup" value="1"> Repas


            <!-- comment -->
            <textarea id="editCommentGroup" placeholder="Commentaire"></textarea>


            <!-- submit button -->
            <button id="saveGroupButton" class="button" style="width: 100%; background-color: darkblue">Modifier</button>

            <button id="deleteGroupButton" class="button" style="width: 100%">Supprimer</button>

            <button id="closeEditModalGroupDiv2" class="button" style="width: 20%; background-color: black">FERMER</button>



    </div>


</div>
