<style>
    .flexTable ul { list-style: none; padding: 0px; margin: 0px;}
    .flexTable { display: flex; flex-wrap: wrap; }
    .flexTable > div { border: 1px solid black; min-width: 160px}

    .title { background-color: lightblue; color: darkblue; font-weight: bold; text-align: center; padding: 10px 20px 10px 20px}
    .content { padding: 10px 20px 10px 10px;}

    @media only screen and (max-width: 600px) {
      
    } 
</style>


<div class="tableResult">


    <h3>Répartition des jours sur la saison</h3>

    <div class= "flexTable" id="repartionByGroupName">
        <?php foreach($total_GROUPNAME as $groupName => $types):?>
            <div>
                <div class="title"><?= $groupName ;?></div>
                <div class="content">
                    <ul>
                        <?php foreach($types as $type => $val):?>
                            <li><?= $val;?> <?= trans($type, 1); ?></li>
                        <?php endforeach;?>
                        <hr/>
                        <b>Présences par jour</b>
                        <ul>
                            <?php if(isset($total_GROUPNAMEDAY[$groupName])):?>
                                <?php foreach($total_GROUPNAMEDAY[$groupName] as $day => $nb):?>
                                    <li><?= $nb;?> <?= $day;?></li>
                                <?php endforeach;?>
                            <?php else:?>
                                /
                            <?php endif;?>
                        </ul>
                    </ul>
                </div>
            </div>
        <?php endforeach;?>
    </div>

    <br/>
        
    <div class="flexTable" style="align-items: center;justify-content: center;">
        <?php foreach($total_TYPE as $typeName => $val):?>
            <div class="title">Total <?= maj(trans($typeName, 1));?> : <?= $val;?></div>
        <?php endforeach;?>
    </div>

    <br/><hr/><br/>
    
    <h3>Répartition des heures sur la saison</h3>
 
    <div class="flexTable">
        <?php foreach($total_KIND as $kind => $types):?>
            <div>
                <div class="title">Période <?= ucfirst(trans($kind)) ;?></div>
                <div class="content">
                    <?php foreach($types as $type => $val):?>
                        <b>* <?= maj(trans($type, 1));?></b>
                        <ul>
                            <li>Nombres de jours :<?= $val;?></li>
                            <?php if($type != "VACATION"):?>
                                <li>Nombres d'heures : <?= $total_KIND_HOURS[$kind][$type] ;?></li>
                            <?php endif;?>
                        </ul>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endforeach;?>
   
</div>