<?php $title="Gestion des saisons"; ?>

<h1> Saisons </h1>

<div class="reveal mobile-ios-modal" id="action-season" data-reveal>

    <div class="mobile-ios-modal-options-stacked">
        <button data-close class="button" data-open="createSeason" onclick="editSeason()">Modifier</button>
        <button data-close class="button" onclick="deleteSeason()">Supprimer</button>
        <button data-close class="button red" >Fermer</button>
    </div>
</div>

<div class="reveal" id="createSeason" data-reveal>
    <p class="lead">Saisons </small></p>

    <div class="containerLoader displayNone" id="loaderFormEditSeason" ><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

    <form method="post" id="seasonForm" action="season/create">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="medium-12 cell">
                    <label>Nom de la saison *
                        <input type="text" name="name" placeholder="Nom de la saison" required>
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Statut *
                        <select name="status">
                            <option value="active">Actif</option>
                            <option value="disabled">Non actif</option>
                            <option value="draft">En préparation</option>

                        </select>
                    </label>
                </div>

                <div class="medium-6 cell">
                    <label> Date de début *
                        <input type="text" id="datepickerStart"  placeholder="Choisir une date" value="" required >
                    </label>
                    <input type="hidden" id="dateStart" name="dateStart" value="">

                </div>
                <div class="medium-6 cell" >
                    <label> Date de fin *
                        <input type="text" id="datepickerEnd"  placeholder="Choisir une date" value="" required >
                    </label>
                    <input type="hidden" id="dateEnd" name="dateEnd" value="">
                </div>


                <div class="medium-12 cell margin-top-10">
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

<!-- Part for weeks -->
<div class="reveal mobile-ios-modal" id="action-week" data-reveal>

    <div class="mobile-ios-modal-options-stacked">
        <button data-close class="button" data-open="createWeek" onclick="editWeek()">Modifier</button>
        <button data-close class="button red" >Fermer</button>
    </div>
</div>

<div class="reveal" id="createWeek" data-reveal>
    <p class="lead">Semaine </small></p>

    <div class="containerLoader displayNone" id="loaderFormEditWeek" ><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

    <form method="post" id="weekForm" action="week/create">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">

                <div class="medium-6 cell">
                    <label>Code de la semaine *
                        <input type="text" name="code" placeholder="Exemple : S1" required>
                    </label>
                </div>
                <div class="medium-6 cell">
                    <label>Nom de groupe *
                        <input type="text" name="groupName" placeholder="Exemple : STrimestre 1" required>
                    </label>
                </div>
                <div class="medium-6 cell">
                    <label>Nom de la semaine *
                        <select id="weekNameSelect">
                            <option value="École">École</option>
                            <option value="Toussaint">Toussaint</option>
                            <option value="Noël">Noël</option>
                            <option value="Hiver">Hiver</option>
                            <option value="Printemps">Printemps</option>
                            <option value="Été">Été</option>
                            <option value="Intersaison">Intersaison</option>
                        </select>
                    </label>
                    <input type="hidden" id="weekName" name="name" value="">
                </div>
                <div class="medium-6 cell">
                    <label>Numéro de la semaine *
                        <input type="number" id="weekNumber" placeholder="1" required>
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Saison associée
                        <input type="text" name="season" placeholder="Nom de la saison" disabled>
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Type *
                        <select name="kind">
                            <option value="ecole">École</option>
                            <option value="stage">Stage</option>
                            <option value="inter">Intersaison</option>
                        </select>
                    </label>
                </div>

                <div class="medium-12 cell">
                    <label> Date de début *
                        <input type="text" id="weekDatepickerStart"  placeholder="Choisir une date" value="" required >
                    </label>
                    <input type="hidden" id="weekDateStart" name="dateStart" value="">
                </div>

                <div class="medium-12 cell margin-top-10">
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
<div class="text-center"><button class="button" onclick="changeActionSeason()" data-open="createSeason"> Ajouter une saison </button></div>


<h2> Saisons actives</h2>
<div class="dragDispatch">
<section class="block-list">
    <div id="seasonList">

    <?php foreach($params->actives as $activeSeason):?>
        <header data-id-season="<?= $activeSeason->seasonId; ?>">
            <i class="material-icons arrow">keyboard_arrow_down</i>  <?= $activeSeason->name; ?>
            <div class="icons_trajet">
                <a href="javascript:void(0)" onclick="getIdSeason('<?= $activeSeason->seasonId; ?>')" data-open="action-season" >
                    <i class="material-icons">edit</i>
                </a>
            </div>
        </header>
        <ul id="weekList" >
            <?php foreach($activeSeason->weeks as $week): ?>
                    <li data-id-week="<?= $week->weekId; ?>"  style="display: none;">
                        <a href="javascript:void(0)" onclick="editWeek('<?= $week->weekId; ?>')" data-open="createWeek">
                            <div>
                                <p class="list-header second-row">
                                    <?= $week->code .' - '.  $week->name ?>
                                    <aside class="subtitles"></aside>
                                    <div class="with-icon">
                                        <i class="material-icons">edit</i>
                                    </div>
                                </p>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
    </div>
</section>
</div>


<h2 class="margin-top-20">Saisons en préparation</h2>
<div class="dragDispatch">
    <section class="block-list">
        <div id="seasonList">
            <?php foreach($params->draft as $draftSeason):?>
                <header data-id-season="<?= $draftSeason->seasonId; ?>">
                    <i class="material-icons arrow">keyboard_arrow_down</i>  <?= $draftSeason->name; ?>
                    <div class="icons_trajet">
                        <a href="javascript:void(0)" onclick="getIdSeason('<?= $draftSeason->seasonId; ?>')" data-open="action-season" >
                            <i class="material-icons">edit</i>
                        </a>
                    </div>
                </header>
                <ul id="weekList" >
                    <?php foreach($draftSeason->weeks as $week): ?>
                            <li data-id-week="<?= $week->weekId; ?>" style="display: none;">
                                <a href="javascript:void(0)" onclick="getIdWeek('<?= $week->weekId; ?>')" data-open="action-week">
                                    <div>
                                        <p class="list-header second-row">
                                            <?= $week->code .' - '.  $week->name ?>
                                            <aside class="subtitles"></aside>
                                        <div class="with-icon">
                                            <i class="material-icons">edit</i>
                                        </div>
                                        </p>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach ?>
                </ul>
            <?php endforeach; ?>
        </div>
    </section>
</div>


<h2 class="margin-top-20">Saisons inactives</h2>
<div class="dragDispatch">
    <section class="block-list">
        <div id="seasonList">
            <?php foreach($params->disabled as $disabledSeason):?>
                <header data-id-season="<?= $disabledSeason->seasonId; ?>">
                    <i class="material-icons arrow">keyboard_arrow_down</i>  <?= $disabledSeason->name; ?>
                    <div class="icons_trajet">
                        <a href="javascript:void(0)" onclick="getIdSeason('<?= $disabledSeason->seasonId; ?>')" data-open="action-season" >
                            <i class="material-icons">edit</i>
                        </a>
                    </div>
                </header>
                <ul id="weekList" >
                    <?php foreach($disabledSeason->weeks as $week): ?>
                            <li data-id-week="<?= $week->weekId; ?>" style="display: none;">
                                <a href="javascript:void(0)" onclick="getIdWeek('<?= $week->weekId; ?>')" data-open="action-week">
                                    <div>
                                        <p class="list-header second-row">
                                            <?= $week->code .' - '.  $week->name ?>
                                            <aside class="subtitles"></aside>
                                        <div class="with-icon">
                                            <i class="material-icons">edit</i>
                                        </div>
                                        </p>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach ?>
                </ul>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<div class="text-center margin-top-12">
    <button class="button" data-page="1" data-size="<?= SIZE_LIST ?>" id="loadMoreSeason"> Afficher plus </button>
</div>


<input type="hidden" id="pageSearch">
<input type="hidden" id="lastIdSeason">
<input type="hidden" id="lastIdWeek">