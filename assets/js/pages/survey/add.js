const addQuestion = (e) => {
    const questionsEl = $(e).parent().find('.questions');
    const questions = $(questionsEl).find('.question').length;
    $(questionsEl).append(`
    <div class="question" style="margin-top: 20px;">
    <div class="medium-12 cell">
        <label>Question n°${questions + 1}
            <input type="text" class="chapterQuestion" required>
        </label>
    </div>
    <div class="medium-12 cell">
        <label>Description pour cette question
            <textarea class="chapterQuestionDescription"></textarea>
        </label>
    </div>
    </div>
    `);
}

const deleteQuestion = (e) => {
    $(e).parent().parent().remove();
}

const addChapter = () => {
    const chaptersNb = $('.chapters').find('.chapter').length;

    $('.chapters').append(`
        <div class="chapter">
        <p class="lead" style="text-align: center">Chapitre ${chaptersNb + 1}</p>

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
    `);
}

const deleteChapter = (e) => {
    $(e).parent().parent().remove();
}

document.getElementById("surveyForm").addEventListener(
    "submit",
    event => {
        event.preventDefault();
        let form = $("#surveyForm");
        let url = form.attr("action");
        let type = "POST";
        let name = $("#name").val();
        let description = $("#description").val();
        let is_active = $("#is_active").val();

        if (is_active != 1) {
            is_active = 0;
        }

        let data = { name, description, is_active };

        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type, url, data },
            dataType: "json",
            beforeSend() {
                $("#surveyForm [type=submit]")
                    .attr("disabled", true)
                    .attr("value", "Envoi en cours..");
            },
            success(json) {
                $("#surveyForm [type=submit]")
                    .attr("disabled", false)
                    .attr("value", "Envoyer");

                if (json.status == true) {
                    $(`.chapter`).each(function () {
                        createChapter(this, json.survey.id);
                    });
                    setTimeout(function () {
                        swal({
                            title: "Sondage ajouté",
                            text: "Le sondage a bien été ajouté",
                            type: "success",
                            confirmButtonText: "Retour à la liste",
                            showCancelButton: false
                        }).then(result => {
                            if (result.value) {
                                location.href = `${urlHost}survey/list`;
                            }
                        });
                    }, 2000);
                } else {
                    swal({
                        title: "Erreur",
                        text: "Une erreur est survenue.",
                        type: "warning"
                    });
                }
            }
        });
    },
    false
);

const createChapter = (e, surveyId) => {
    let type = "POST";
    let name = $(e).find(".chapterName").val();
    let typeChapter = $(e).find(".chapterType").val();
    let is_active = $(e).find(".chapterIsActive").val();
    let description = $(e).find(".chapterDescription").val();

    if (is_active != 1) {
        is_active = 0;
    }

    let data = { name, description, type: typeChapter, is_active, survey_id: surveyId };

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type, url: 'survey/chapter/create', data },
        dataType: "json",
        beforeSend() {
            $("#surveyForm [type=submit]")
                .attr("disabled", true)
                .attr("value", "Envoi en cours..");
        },
        success(json) {
            $("#surveyForm [type=submit]")
                .attr("disabled", false)
                .attr("value", "Envoyer");

            if (json.status == true) {
                $(e).find('.question').each(function () {
                    createQuestion(this, json.SurveyChapter.id);
                });
            } else {
                swal({
                    title: "Erreur",
                    text: "Une erreur est survenue.",
                    type: "warning"
                });
            }
        }
    });
}

const createQuestion = (e, chapterId) => {
    let type = "POST";
    let name = $(e).find(".chapterQuestion").val();
    let description = $(e).find(".chapterQuestionDescription").val();

    let data = { name, description, scale: 5, chapter_id: chapterId };

    $.ajax({
        type: "POST",
        url: urlRequest,
        data: { type, url: 'survey/question/create', data },
        dataType: "json",
        beforeSend() {
            $("#surveyForm [type=submit]")
                .attr("disabled", true)
                .attr("value", "Envoi en cours..");
        },
        success(json) {
            $("#surveyForm [type=submit]")
                .attr("disabled", false)
                .attr("value", "Envoyer");

            if (json.status == true) {

            } else {
                swal({
                    title: "Erreur",
                    text: "Une erreur est survenue.",
                    type: "warning"
                });
            }
        }
    });
}