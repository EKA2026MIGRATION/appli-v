<p class="lead">Modifier un sondage </p>

<div class="containerLoader displayNone" id="loaderFormEditVehicle">
    <div class="lds-roller">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<style>
    .chapter {
        padding: 24px;
        border-radius: 6px;
        background-color: #F0F4F6;
        border: 1px solid #E6ECF0;
        margin-bottom: 24px;
    }

    .title-anwser {
        font-size: 18px;
        font-weight: 500;
        margin-top: 32px;
    }

    .button-add {
        background-color: #98061a;
        border-radius: 6px;
        padding: 12px 48px;
        font-weight: 500;
        font-size: 13px;
        line-height: 17px;
        text-align: center;
        color: #fff;
        cursor: pointer;
        border: 2px solid #98061a;
    }

    .button-add--chapter {
        float: right;
        margin-top: 0;
    }
</style>


<form method="post" id="surveyForm" action="survey/modify/<?= $params->survey->id; ?>">
    <div class="grid-container">
        <div>
            <div class="medium-12 cell">
                <label>Choisir un titre pour le sondage *
                    <input type="text" id="name" name="name" value="<?= $params->survey->name; ?>" required>
                </label>
            </div>
            <div class="medium-12 cell">
                <label>Courte description
                    <input type="text" id="description" value="<?= $params->survey->description; ?>" name="description">
                </label>
            </div>
            <div class="medium-12 cell">
                <label>
                    <input type="checkbox" id="is_active" name="is_active" value="1" <?php if($params->survey->isActive == 1): ?>checked<?php endif; ?>>
                    Activer le sondage *
                </label>
            </div>
            <div class="chapters">
                <?php $i = 0; foreach($params->survey->chapters as $chapter): $i++; ?>
                <div class="chapter" data-edit="<?= $chapter->id; ?>">
                    <p class="lead" style="text-align: center">Chapitre <?= $i; ?></p>

                    <div class="medium-12 cell">
                        <label>Choisir un titre pour ce chapitre *
                            <input type="text" class="chapterName" value="<?= $chapter->name; ?>" required>
                        </label>
                    </div>

                    <div class="medium-12 cell">
                        <label>Description pour ce chapitre
                            <textarea class="chapterDescription"><?= $chapter->description; ?></textarea>
                        </label>
                    </div>
                    <div class="medium-12 cell">
                        <label>
                            <input type="checkbox" class="chapterIsActive" value="1" <?php if($chapter->isActive == 1): ?>checked<?php endif; ?>>
                            Activer ce chapitre
                        </label>
                    </div>

                    <div class="medium-12 cell">
                        <select class="chapterType" required>
                            <option value="" disabled select>Choisir un type pour ce chapitre *</option>
                            <option value="driver" <?php if($chapter->type == 'driver'): ?>selected<?php endif; ?>>Driver</option>
                            <option value="coach" <?php if($chapter->type == 'coach'): ?>selected<?php endif; ?>>Coach</option>
                        </select>
                    </div>

                    <hr />

                    <p class="title-anwser">
                        Questions
                    </p>

                    <div class="questions-blocks">
                        <div class="questions">
                            <?php $x = 0; foreach($chapter->questions as $question): $x++; ?>
                            <div class="question" data-edit="<?= $question->id; ?>">
                                <div class="medium-12 cell">
                                    <label>Question n°<?= $x; ?>
                                        <input type="text" class="chapterQuestion" value="<?= $question->name; ?>" required>
                                    </label>
                                </div>
                                <div class="medium-12 cell">
                                    <label>Description pour cette question
                                        <textarea class="chapterQuestionDescription"><?= $question->description; ?></textarea>
                                    </label>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="button-add" onclick="addQuestion(this)">
                            Ajouter une question
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <button type="button" onclick="addChapter()" class="button-add button-add--chapter">
                Ajouter un chapitre
            </button>



            <div class="medium-12 cell" style="margin-top: 20px;">
                <button type="submit" class="button-add">Modifier le sondage </button>
            </div>
        </div>
    </div>
</form>

<button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
</button>
<p>* champ obligatoire</p>