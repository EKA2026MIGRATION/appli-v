<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Energy Kids Academy Graduate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            font-family: 'Montserrat', Helvetica, Arial, sans-serif;
            height: 100%;
            width: 100%;
        }

        body {
            display: flex;
            flex-wrap: wrap;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }

        #main-text {
            flex-grow: 1;
            display: flex;
            justify-content: space-between;
            overflow: hidden;
            padding: 20px;
            max-width: 1200px;
            width: 100%;
        }

        #left-text {
            padding: 20px;
            flex-grow: 1;
            flex-basis: 0;
            overflow: hidden;
        }

        #left-text p {
            padding-top: 20px;
            word-wrap: break-word;
            font-size: 1.6rem;
        }

        #card-col {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            flex-shrink: 0;
        }

        #logo {
            width: 150px;
            max-width: 100%;
            height: auto;
        }

        #card {
            width: 100%;
            max-width: 400px;
            height: auto;
        }

        h2 {
            font-size: 1.6rem;
            color: white;
        }

        #top-title {
            display: flex;
            align-items: center;
        }

        #top-title h1 {
            flex-grow: 1;
            text-align: center;
            font-size: 2.4rem;
            font-family: 'Pacifico', cursive;
            font-weight: normal;
            color: #182d61;
            margin: 0 20px;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
                height: auto;
            }

            #main-text {
                flex-direction: column;
                padding: 20px;
            }

            #left-text, #card-col {
                width: 100%;
                padding: 10px;
            }

            #left-text {
                overflow: initial;
            }

            #top-title {
                flex-direction: column;
            }

            #top-title h1 {
                margin: 20px 0;
                text-align: center;
            }

            #logo {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
<div id="main-text">
    <div id="left-text">
        <div id="top-title">
            <img id="logo" src="https://www.energykidsacademy.fr/assets/img/energy-kids-academy.svg" alt="log EKA"/>
            <h1>Félicitations à nos jeunes champions !</h1>
        </div>
        <p>
            Cette année a été remplie de défis et de succès, et nous sommes extrêmement fiers de célébrer les réalisations exceptionnelles
            de nos jeunes sportifs.<br/><br/>
            Chaque enfant a démontré non seulement des compétences impressionnantes sur le terrain,
            mais aussi un esprit sportif exemplaire.
            <br/><br/>
            <b>Bravo à <?= $params->child->firstname;?> pour cette année de foot !</b>
            <br/><br/>
            <b>Merci</b> à tous les parents pour votre soutien continu et à nos jeunes champions pour leur implication.<br/><br/>
            Félicitations encore une fois et on se retrouve l'année prochaine pour de nouveaux challenges...<br/>
            <br/>
            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <i>et de nouvelles surprises innovantes !</i>
            <br/><br/><br/>
        <div style="display: flex; justify-content: right; flex-direction: column; text-align: right">
            <span>Juillet 2024</span>
            <span style="font-size: 1.4rem; font-weight: bold">Energy Kids Academy</span>
        </div>
        </p>
    </div>
    <div id="card-col">
        <img id="card" src="https://appli-v.net/assets/image/cards/14/card-<?= $params->child->childId;?>.png" alt="Carte FOOT"/>
    </div>
</div>
</body>
</html>
