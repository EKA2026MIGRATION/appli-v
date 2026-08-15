<div id="dialog">

    <div id="dialogContent">
        <br/>
            <i class="material-icons" id="closeDialogButton">close</i>
        <br/>
        <h3 style="padding: 0px 20px">Liste des enfants</h3>
        <h4 style="padding: 0px 20px" id="nameProductFr"></h4>
        <h5 style="padding: 0px 20px" id="nbResult"></h5>

        <div id="barButton">
            <div  class="button" id="goUpButton" >
                UP
            </div>
            <div id="infoChecked">&nbsp;</div>
            <div class="button" id="saveButton">
                SAVE
            </div>

            <div>
                <select id="selectFirstLetter">
                    <option value=""></option>
                    <?php foreach (range ( 'A', 'Z' ) as $letter):?>
                        <option value="<?= $letter;?>"><?= $letter;?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>

        <img src="<?= IMG; ?>loadSpinner3.gif" style="width: 50px; height: 50px; margin: 200px 45%" id="loadSpinner"/>

        <br/><br/><br/><br/><br/>


        <ul id="ulDialog">
        </ul>
        <br/>
   
      
    </div> 
</div>