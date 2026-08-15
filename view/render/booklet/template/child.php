<div id="child" class="content background-blue">
    <div class="background-white right-border left-border">
        <header class="flexRow">
            <img class="logo" src="<?= IMG;?>energy-kids-academy.svg"/>
            <div id="title" class="title">
                LIVRET <span data-id="bookletNameVar">NOM DU LIVRET</span>
            </div>
            <div id="date" class="dateEvaluation">
                <span data-id="dateEvaluationVar">01/12/2021</span>
            </div>
        </header>
        <div class="flexRow">
            <div id="leftChild">
                <img class="tiret tiret-right" src="<?= IMG;?>tiret-right.svg"/>
                <div id="childData">
                    <header>
                        <img data-id="childPhotoUrlVar" src="https://appli-v.net/uploads/child/8708.jpg"/>
                    </header>
                    <div class="childName" data-id="childNameVar">Prénom NOM</div>
                    <table>
                        <tr>
                            <td><img src="<?= IMG;?>Icon_open-eye.svg"/></td>
                            <td>Oeil directeur</td>
                            <td data-id="guidingEyeVar">oeil</td>
                        </tr>
                        
                        <tr>
                            <td><img src="<?= IMG;?>Icon_awesome-hand-paper.svg"/></td>
                            <td>Main préférée</td>
                            <td data-id="childHandVar">Main</td>
                        </tr>
                        
                        <tr>
                            <td><img src="<?= IMG;?>Icon_awesome-child.svg"/></td>
                            <td>Pied d'appuis</td>
                            <td data-id="childFootVar">pied</td>
                        </tr>
                        
                        <tr>
                            <td><img src="<?= IMG;?>Icon_awesome-child.svg"/></td>
                            <td>Profil sportif</td>
                            <td data-id="sportifProfilVar">profil</td>
                        </tr>
                    </table>
                </div>
                <img class="tiret tiret-left" src="<?= IMG;?>tiret-left.svg"/>
            </div>

            <div data-id="rightChild" id="rightChild">
                <div  data-id="dynamicMap" id="dynamicMap">
                </div>
                <div data-id="simpleMenu" id="simpleMenu" style="display:none">
                </div>
            </div>

            <div data-id="nextButton" class="navButton nextButton">
                <div>
                    <b>COMMENCER</b><br/>
                    <span data-id="nextBoardVar">Le livret</span>
                </div>
                <div>
                    <img src="<?= IMG;?>Icon-awesome-arrow-white.svg"/>
                </div>
            </div>
        </div>
    </div>
</div>