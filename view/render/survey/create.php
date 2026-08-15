<p class="lead">Créer un sondage </p>

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

<form method="post" id="surveyForm" action="survey/create">
    <div class="grid-container">
        <div>
            <div class="medium-12 cell">
                <label>Choisir un titre pour le sondage *
                    <input type="text" id="name" name="name" required>
                </label>
            </div>
            <div class="medium-12 cell">
                <label>Courte description
                    <input type="text" id="description" name="description">
                </label>
            </div>
            <div class="medium-12 cell">
                <label>
                    <input type="checkbox" id="is_active" name="is_active" value="1">
                    Activer le sondage *
                </label>
            </div>
            <div class="chapters">
                <div class="chapter">
                    <p class="lead" style="text-align: center">Chapitre 1</p>

                    <div class="medium-12 cell">
                        <label>Choisir un titre pour ce chapitre *
                            <input type="text" class="chapterName" required>
                        </label>
                    </div>

                    <div class="medium-12 cell">
                        <label>Description pour ce chapitre
                            <textarea class="chapterDescription"></textarea>
                        </label>
                    </div>
                    <div class="medium-12 cell">
                        <label>
                            <input type="checkbox" class="chapterIsActive" value="1" checked>
                            Activer ce chapitre
                        </label>
                    </div>

                    <div class="medium-12 cell">
                        <select class="chapterType" required>
                            <option value="" disabled select>Choisir un type pour ce chapitre *</option>
                            <option value="driver">Driver</option>
                            <option value="coach">Coach</option>

                        </select>
                    </div>

                    <hr />

                    <p class="title-anwser">
                        Questions
                    </p>

                    <div class="questions-blocks">
                        <div class="questions">
                            <div class="question">
                                <div class="medium-12 cell">
                                    <label>Question n°1
                                        <input type="text" class="chapterQuestion" required>
                                    </label>
                                </div>
                                <div class="medium-12 cell">
                                    <label>Description pour cette question
                                        <textarea class="chapterQuestionDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="button-add" onclick="addQuestion(this)">
                            Ajouter une question
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" onclick="addChapter()" class="button-add button-add--chapter">
                Ajouter un chapitre
            </button>



            <div class="medium-12 cell" style="margin-top: 20px;">
                <button type="submit" class="button-add">Créer le sondage </button>
            </div>
        </div>
    </div>
</form>

<button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
</button>
<p>* champ obligatoire</p>