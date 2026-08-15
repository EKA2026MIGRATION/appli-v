<style>
    ul {
        list-style-type: none;
    }
</style>
<h4>Associer des enfants aux livrets</h4>

<ul>
    <li>
        Sélectionner un livret
        <select name="booklet_id" id="createBookletBookletId">
            <option/>
            <?php foreach($params->booklets as $booklet):?>
                <option value="<?= $booklet->id;?>"><?= $booklet->name;?></option>
            <?php endforeach;?>
        </select>
    </li>
    <li style="position: relative">
        Sélectionner un enfant
        <input type="text" id="fastSearchBooklet" placeholder="Recherche par enfant" />


        <div id="fastSearchResultBooklet" style="display: none; padding: 10px; width: 100%; position: absolute; z-index: 999;background-color: whitesmoke;  overflow: auto;">
            <span onclick="closeFastSearchResultBooklet()" style="cursor: pointer; border-radius: 6px; line-height: 1; float: right; font-size: 30px; width: 40px; height: 36px; font-weight: bold; border: 2px solid darkblue; color: darkred">x</span>
            <div id="fastSearchResultContentBooklet" style="text-align: left; margin-right: 20px; padding: 10px; max-height: 650px">
            </div>
        </div>
        <input type="hidden" name="child_id" id="createBookletChildId"/>
        <div id="showChildName" style="font-weight: bold; color: darkblue"></div>
    </li>

    <li>
        Sélectionner un coach
        <select name="staff_id" id="createBookletStaffId">
            <option/>
            <?php foreach($params->staffs as $staff):?>
                <option value="<?= $staff->staffId;?>"><?= $staff->fullname;?></option>
            <?php endforeach;?>
        </select>
    </li>



    <!--
    <li>
        ou créer une liste
        <div class="flexRow">
            <div>
                <b>Date de présence</b><br/>
                <input type="date">
            </div>
            <div>
                <b>Sport effectué</b><br/>
                <select name="sport_id">
                    <option/>
                    <?php foreach($params->sports as $sport):?>
                        <option value="<?= $sport->sportId;?>"><?= $sport->name;?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div>
                <b>Age</b><br/>
                <div style="display: flex">
                    Entre&nbsp;&nbsp;
                    <input type="number" min="2" max="18"/>
                    &nbsp;&nbsp;
                    et
                    &nbsp;&nbsp;
                    <input type="number" min="3" max="18"/>
                </div>
            </div>
            <div>
                <b>Max result</b><br/>
                <input type="number" min="100" max="300" value="100"/>
            </div>
        </div>
       
    </li>
                    -->

    <div>
        <input type="submit" class="button" id="createBooklet" value="Créer" style="width: 100%"/>
    </div>
</ul>

<div id="resultSaved" style="visibility:hidden">

</div>

