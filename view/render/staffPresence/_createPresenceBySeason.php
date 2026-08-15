<div class="reveal" id="reveal-season" data-reveal>
    <h2> Saisons actives</h2>
    <div class="dragDispatch">
        <section class="block-list">
            <div id="seasonList">
                <?php foreach($params->actives as $activeSeason):?>

                    <p>
                        <a href="#" onclick="checkAll()">Tout cocher </a> - 
                        <a href="#" onclick="unCheckAll()">Tout décocher </a>
                    </p>
                    <header data-id-season="<?= $activeSeason->seasonId; ?>">
                        <i class="material-icons arrow">keyboard_arrow_down</i>  <?= $activeSeason->name; ?>
                    </header>

                    <ul id="weekList" style="max-height: 350px; overflow: auto;">
                        <?php foreach($activeSeason->weeks as $week): ?>
                            <li data-id-week="<?= $week->weekId; ?>"  style="display: none;">
                                <a href="javascript:void(0)">
                                <div>
                                    <p class="list-header second-row">
                                        <?= $week->code .' - '.  $week->name ?>
                                        <aside class="subtitles"></aside>
                                        <div class="with-icon">
                                            <div class="switch">
                                                <input class="switch-input" data-start="<?= $week->dateStart; ?>" data-end="<?= $week->dateEnd; ?>" id="week<?= $week->weekId; ?>" type="checkbox" name="week<?= $week->weekId; ?>" checked>
                                                <label class="switch-paddle" for="week<?= $week->weekId; ?>"></label>
                                            </div>
                                        </div>
                                    </p>
                                </div>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                <?php endforeach; ?>

                <div class="margin-top-10">
                    <p>Horaires pour la sélection </p>
                    <input type="time" id="start-hour-season" placeholder="Heure de début" value="<?= $hour_start_value;?>">
                    <input type="time" id="end-hour-season" placeholder="Heure de fin" value="<?= $hour_end_value;?>">
                </div>

                <div class="text-center">
                    <p><button class="button" id="createPresenceSeason">Créer les présences</button></p>
                </div>
            </div>
        </section>
    </div>


    <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
    </button>
</div>