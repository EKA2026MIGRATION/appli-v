
<div class="reveal"id="revealCreateActivityGroup"data-reveal>
    <p class="lead">Créer/Modifier un groupe</p>

    <div class="containerLoader"id="loaderFormEditGroup">
        <div class="lds-roller">
            <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
        </div>
    </div>

    <button class="close-button"data-close aria-label="Close modal"type="button">
        <span aria-hidden="true">&times;</span>
    </button>

    <form method="post"id="activityGroupForm"action="group-activity/create">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <input type="hidden"name="date"value="<?php echo date('Y-m-d H:i:s', strtotime($params->date)); ?>">

                <div class="medium-12 cell">
                    <label>Nom du groupe
                        <input type="text"name="name"placeholder="Nom du groupe">
                    </label>
                </div>

                <div class="medium-12 cell">
                    <label>Heure de début *
                        <input type="time" id="start_group" value="08:00:00" placeholder="Heure de début" required>
                        <input type="hidden" name="start" id="start_group_2" value="08:00:00" />
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Heure de fin *
                        <input type="time" id="end_group" value="08:00:00" placeholder="Heure de fin" required>
                        <input type="hidden" name="end" id="end_group_2" value="08:00:00" />
                    </label>
                </div>

                <div class="medium-12 cell forMultiselectWidth monitorCheckBoxs">
                    <label>Moniteurs</label>


                            <?php foreach($params->coaches as $coach):?>
                               <label><input type="checkbox"data-id-monitor="<?= $coach->staff->staffId; ?>"value="<?= $coach->staff->staffId; ?>"><?= $coach->staff->person->firstname; ?> <?= $coach->staff->person->lastname; ?></label>
                            <?php endforeach; ?>
                            <?php foreach($params->drivers as $driver):?>
                               <label><input type="checkbox"data-id-monitor="<?= $driver->staff->staffId; ?>"value="<?= $driver->staff->staffId; ?>"><?= $driver->staff->person->firstname; ?> <?= $driver->staff->person->lastname; ?></label>
                            <?php endforeach; ?>
                            <?php foreach($params->trainees as $trainee):?>
                                <label><input type="checkbox"data-id-monitor="<?= $trainee->staff->staffId; ?>"value="<?= $trainee->staff->staffId; ?>"><?= $trainee->staff->person->firstname; ?> <?= $trainee->staff->person->lastname; ?></label>

                            <?php endforeach; ?>

                    <input type="hidden"id="liveResultMonitor"/>
                </div>

                <div class="medium-12 cell">
                    <label>Lieux *
                        <select id="selectLocation"name="location"required>
                            <option value="0">Choisir un lieu</option>
                            <?php foreach($params->locations as $location):?>
                                <option class="locationAll selectLocation<?= $location->locationId;?>"
                                data-id-location="<?php echo $location->locationId; ?>"value="<?php echo $location->locationId; ?>"
                                <?php if($location->locationId == 6) echo 'selected';?>
                                >
                                <?php echo $location->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Infrastruture
                        <select id="selectLocation" name="area" > <!-- name="area"required-->
                            <option value="0">Choisir une infrastructure</option>

                            <option value="Tennis ext1">Tennis ext1</option>
                            <option value="Tennis ext2">Tennis ext2</option>
                            <option value="Tennis bulle">Tennis bulle</option>
                            <option value="Chalet 1">Chalet 1</option>
                            <option value="Chalet 2">Chalet 2</option>
                            <option value="Chalet 3">Chalet 3</option>
                            <option value="Chalet 4">Chalet 4</option>
                            <option value="Chalet 5">Chalet 5</option>
                            <option value="Chalet gym">Chalet gym</option>
                            <option value="Chalet trampoline">Chalet trampoline</option>
                            <option value="Foot couvert 1">Foot couvert</option>
                            <option value="Foot couvert 2">Foot couvert</option>
                            <option value="Foot ext">Foot ext</option>
                            <option value="Golf putting">Golf putting</option>
                            <option value="Golf practice">Golf practice</option>
                            <option value="Golf intermédiaire">Golf intermédiaire</option>
                            <option value="Circuit QD - KT">Circuit QD - KT</option>
                            <option value="Toboggan gonflable">Toboggan gonflable</option>
                            <option value="Trampoline ext">Trampoline ext</option>
                            <option value="Trampoline élastique">Trampoline élastique</option>
                            <option value="Ping-Pong">Ping-Pong</option>
                            <option value="Gonflable petits">Gonflable petits</option>
                            <option value="Tyrolienne">Tyrolienne</option>
                            <option value="Salle de gym">Salle de gym</option>
                            <option value="Club-house">Club-house</option>
                            <option value="Piscine">Piscine</option>
                            <option value="Racing">Racing</option>
                            <option value="Terrasse">Terrasse</option>
                            <option value="Chalet Berlitz">Chalet Berlitz</option>
                            <option value="Cour Roland">Cour Roland</option>
                            <option value="Foot Urban">Foot Urban</option>
                        </select>
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Activité *
                        <select id="selectSport"name="sport"required>
                            <option value="0">Choisir une activité</option>
                            <?php foreach($params->sports as $sport):?>
                                <option data-id-sport="<?php echo $sport->sportId; ?>"value="<?php echo $sport->sportId; ?>"><?php echo $sport->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

                <div class="medium-12 cell">
                    <label> Repas *
                        <select id="mealSelectable"name="lunch"required>
                            <option value="0">non</option>
                            <option value="1">oui</option>
                        </select>
                    </label>
                </div>

                <div class="medium-12 cell">
                    <label>Commentaire
                        <textarea name="comment"rows="3" placeholder="Saisir un commentaire"></textarea>
                    </label>
                </div>

                <div class="medium-12 cell">
                    <center><input type="submit"class="button"value="Envoyer"/></center>
                </div>
                <p>* champs obligatoires</p>
            </div>
        </div>
    </form>

</div>