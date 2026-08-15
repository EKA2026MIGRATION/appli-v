const createCommentButton = document.querySelector("#createComment");
let targetAnswer = document.querySelector("#commentResult");
let childName = document.querySelector("#childFirstname").value;
let childAge = document.querySelector("#age").value;
let bookletName = document.querySelector("#bookletName").textContent;
let gender = document.querySelector("#gender").value;
let commentPrevDiv = document.querySelector("#commentPrev");
let commentPrev = "";
if(commentPrevDiv !== null){
    commentPrev = commentPrevDiv.textContent;
}


// je récupère tous les étoiles cochés dans evaluations
const extractRatings = () => {
    const ulElements = document.querySelectorAll('.allItems');
    const results = [];

    ulElements.forEach(ul => {
        const title = ul.previousElementSibling.textContent.trim();
        const items = ul.querySelectorAll('li');

        items.forEach(item => {
            const text = item.querySelector('span:first-child').textContent.trim();
            const currentRating = item.querySelectorAll('.rateChecked:not(.responsePrev .rateChecked)').length;
            const previousRating = item.querySelectorAll('.responsePrev .rateChecked').length;

            results.push({
                title: title,
                text: text,
                currentRating: currentRating,
                previousRating: previousRating,
                ratingChanged: currentRating !== previousRating
            });
        });
    });
console.log(results);
    return results;
}

// je demande à chatgpt de me donner une réponse
let apiKey = "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";

const sendToOpenAI = (promptText) => {

    console.log(promptText);

    targetAnswer.innerHTML = "<span class='text-clignotant'>... en recherche de suggestion...</span>";

    fetch("https://api.openai.com/v1/chat/completions", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${apiKey}`,
        },
        body: JSON.stringify({
            model: "gpt-4",
            messages: [
                { role: "user", content: promptText }
            ],
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            // Get and display ChatGPT's reply
            const reply = data.choices[0].message.content;

            console.log(reply);

            targetAnswer.innerText = reply;
        })
        .catch((error) => console.error("Error:", error));
}


// listenner quand je demande une réponse
createCommentButton.addEventListener("click", () => {
    // description du contexte
    let promptText = "";

    promptText =
        `Contexte : \n Tu joues le rôle d'un coach de sport d'Energy Kids Academy spécialisé dans le sport dans l'enfance. Ta priorité est le développement de l'enfant, la bienveillance, la psychopédagogie.
         Tu es dans l'esprit Montessori, tu es un adepte de la CNV (communication non violente) et tu as une approche positive de l'éducation.
         Tu vas devoir mettre un commentaire sur le livret d'évaluation d'un enfant, je te demande de me proposer ce commentaire. Tu peux rédiger entre et 1 et 5 phrases.
         Je vais te donner les évaluations sur chaque item du livret. Je te donne également si c'est possible d'autres informations : la progression par rapport à la dernière évaluation si je l'ai.
         Enfin si j'ai déjà un commentaire générale, je te le donne : sers de toi de ce commentaire pour t'inspirer, trouver le style adéquate .
         
         Dans tous les cas tu dois trouver au MINIMA un point fort.
         
         Je vais maintenant te donner les informations :
         
            Livret : ${bookletName} 
            Enfant : ${childName} 
            Age : ${childAge} 
            Genre : ${gender} 
            
            Evaluations sur chaque items : 
`
        ;

    const ratings = extractRatings();
    let nbRatingChange = 0;
    ratings.forEach(rating => {
        if (rating.ratingChanged) {
            promptText += `${rating.title} : ${rating.text} : ${rating.currentRating} étoiles - ancienne étoiles : ${rating.previousRating}\n`;
            nbRatingChange += rating.currentRating;
        }
    });
    
    if(nbRatingChange < 6){
        alert('Attention, il n\'y a pas assez de changement dans les évaluations, il faut trouver au moins 6 items qui ont changé');
        return false;
    }

    promptText += "ATTENTION : si l'ancienne étoile est à 0 cela signifie que l'enfant n'a pas encore été évalué sur cet item. Ce n'est donc pas une progression exceptionnelle, juste une nouvelle notation";

    // si le commentaire précédent existe je l'ajoute
    if (commentPrev !== "") {
        promptText += `Commentaire sur l'évaluation précédente (à prendre compte pour le style et la progression) :
         ${commentPrev}`;
    }

    // si le coach a déjà ajouté un nouveau commentaire je dois en tenir compte
    if (document.querySelector("#currentComment").value !== "") {
        promptText += `Commentaire déjà ajouté par le coach  (à prendre compte pour le style et les nouvelles informations non présentes dans les items comme le comportement, etc.) 
         ${document.querySelector("#currentComment").value}`;
    }


    promptText += "\n\n Voilà tu as toutes les infos pour rédiger ton commentaire.\n\n" +
        "Pour ta réponse je veux que tu la formules ainsi\n " +
        "1- Tu me fais une analyse des différents items évalués en précisant ceux dont tu as tenu compte. Tu donneras auussi ton avais sur l'ensemble : tu constates une progression ou pas, par exemple\n" +
        "2- Tu donnes ton avis sur la qualité du commentaire donné par le coach (uniquement le contenu rien sur le style). Si tu penses qu'il est en phase avec les items si il a ajouté des choses intéressantes, bref tu lui fais une analyse de son propre commentaire pour qu'il s'améliore\n" +
        "3- Tu proposes ton nouveau commentaire\n\n" +
        "Effectue deux passages à la lignes entre ces 3 parties. Adresse toi directement au coach dans la partie 2, tu peux le tutoyer directement. Voici les titres de chaque partie : 1/ Analyse des itmes 2/ Analyse du commentaire 3/ Suggestion de commentaire"
    ;

    console.log(promptText);

    sendToOpenAI(promptText);
});
console.log('go');

