<h2>Recherche du CA par saison</h2>
<br/>
<br/>

<div class="horizontalCard" style="display: flex">
    <div class="cardIcon" style="width: 100px;">
            <i class="material-icons" style="font-size: 60px">settings_ethernet</i>
    </div>
    <div>
        <div class="cardInfo flexList">
            
            <div>
                <p class="cartTitle">Saison</p>
                <p>
                    <select class="selectSeason" id="selectCriteria" name="season">
                        <option/>
                        <optgroup label="Saison active">
                            <?php foreach($params->seasonActives as $season):?>
                                <option value="<?= $season->seasonId;?>"><?= $season->name ;?></option>
                            <?php endforeach;?>
                        </optgroup>
                        <optgroup label="Saison brouillon">
                            <?php foreach($params->seasonDraft as $season):?>
                                <option value="<?= $season->seasonId;?>"><?= $season->name ;?></option>
                            <?php endforeach;?>
                        </optgroup>
                        <optgroup label="Saison désactivée">
                            <?php foreach($params->seasonDisabled as $season):?>
                                <option value="<?= $season->seasonId;?>"><?= $season->name ;?></option>
                            <?php endforeach;?>
                        </optgroup>
                    </select>
                </p>
            </div>
        </div>
        
    </div>

    <div style="margin-left: 20px">
            <p class="cartTitle">Saison de Référence</p>
            <p>

                <select class="selectReference" id="selectReference" name="reference" style="width: 300px">
                    
                    <option/>
                    <optgroup label="Saison active">
                        <?php foreach($params->seasonActives as $season):?>
                            <option value="<?= $season->seasonId;?>"><?= $season->name ;?></option>
                        <?php endforeach;?>
                    </optgroup>
                    <optgroup label="Saison brouillon">
                        <?php foreach($params->seasonDraft as $season):?>
                            <option value="<?= $season->seasonId;?>"><?= $season->name ;?></option>
                        <?php endforeach;?>
                    </optgroup>
                    <optgroup label="Saison désactivée">
                        <?php foreach($params->seasonDisabled as $season):?>
                            <option value="<?= $season->seasonId;?>"><?= $season->name ;?></option>
                        <?php endforeach;?>
                    </optgroup>

                </select>
            </p>
    </div>
    
    <div id="listWeeks">
    
    </div>
</div>

<div id="showResult"></div>
