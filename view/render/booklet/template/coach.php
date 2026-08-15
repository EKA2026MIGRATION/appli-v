<div id="coachWord" class="board content background-blue">
    <div data-id="backgroundImgVar" class="background-white right-border defaultBackground">
        <header class="flexRow">
            <img class="logo" src="<?= IMG;?>energy-kids-academy.svg"/>
            <div id="title" class="title">
                LIVRET <span data-id="bookletNameVar">NOM DU LIVRET</span>
            </div>
            <div id="date" class="dateEvaluation">
                <span data-id="dateEvaluationVar">DD/MM/YYYY</span>
            </div>
        </header>

        <div class="flexColumn">
            <div class="coachWord">
                Le mot du coach
            </div>
            
            <div data-id="coachCommentVar" class="coachComment"></div>
            
            <div class="coachInfos">
                <span data-id="staffFirstnameVar"></span><br/>
                Coach Référent
                <div id="coachWordImgElement">
                    <img class="angle-coach-right" src="<?= IMG ;?>angle-coach.svg"/>
                    <img class="coachWordImg" data-id="staffPhotoUrlVar" src="https://www.energykidsacademy.fr/assets/img/coach-thomas.jpg"/>
                    <img class="angle-coach-left" src="<?= IMG ;?>angle-coach.svg"/>
                </div>
            </div>
            
        </div>

        <!-- footer button-->
        
        <div data-id="prevButton" class="navButton prevButton">
            <div>
                <img src="<?= IMG;?>Icon-awesome-arrow.png"/>
            </div>
            <div class="textButton">
                <b>Précédent</b><br/>
                <span data-id="prevBoardVar">Le livret</span>
            </div>
        </div>

        <div data-id="buttonBack" class="buttonBack">
            <span>
                <br/><br/>
                RETOUR A<br/>
                LA CARTE
            </span>
        </div>

    </div>
</div>