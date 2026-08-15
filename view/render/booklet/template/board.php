<div class="board content background-blue">
    <div data-id="backgroundImgVar" class="background-white right-border defaultBackground">
        <header data-id="header" class="flexRow">
            <img class="logo" src="<?= IMG;?>energy-kids-academy.svg"/>
            <div id="title" class="title">
                LIVRET <span data-id="bookletNameVar">NOM DU LIVRET</span>
            </div>
            <div id="date" class="dateEvaluation">
                <span data-id="dateEvaluationVar">DD/MM/YYYY</span>
            </div>
        </header>

        <div class="flexRow boardElement">
            <div class="leftBoard">
                <div class="boardData">
                    
                    <div data-id="boardNameVar" class="boardName">Titre Board</div>

                    <div data-id="boardDescriptionVar" class="boardDescription">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </div>
                    <div class="tableDiv">
                        <table data-id="tableAnswer">
                        </table>
                    </div>
                    <img class="tiret tiret-left" src="<?= IMG;?>tiret-left.svg"/>
                </div>
                <img class="tiret tiret-right" src="<?= IMG;?>tiret-right.svg"/>
            </div>
            
            <img data-id="totemImgVar" class="totem" src="<?= IMG;?>animaux/Ours.svg"/>

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
                RETOUR<br/>
                AU MENU
            </span>
        </div>

        <div data-id="nextButton" class="navButton nextButton">
            <div class="textButton">
                <b>Continuer</b><br/>
                <span data-id="nextBoardVar">Le livret</span>
            </div>
            <div>
                <img src="<?= IMG;?>Icon-awesome-arrow.png"/>
            </div>
        </div>

    </div>
</div>