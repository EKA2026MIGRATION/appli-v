<style>
    .listCredentials { display: flex; flex-wrap: wrap}
    .listCredentials div { margin-right: 20px}
    .partTitle { width: 100%; margin-top: 10px; font-weight: bold; border-bottom: 1px solid lightgrey; margin-bottom: 2px}
    .roleTitle { background-color: darkblue; color: white; height: 40px; line-height: 40px; text-align: center; font-weight: bold}
</style>

<h1>Gestion des droits par rôle</h1>

<div style="margin-bottom: 30px">
    <?php foreach($params->profils as $profil):?>
        <div class="roleTitle">
            <?= $profil;?>
        </div>
        <div class="listCredentials">
            <?php $partRef = ""; foreach($params->credentials as $credential):?>

                <?php $part = explode('::', $credential->name)[0]; ?>
                <?php if($part != $partRef) echo '<div class="partTitle">'.ucfirst($part).'</div>'; $partRef = $part?>

                <div>
                    <input 
                        type="checkbox"
                        <?php if(in_array($credential->name, $params->$profil)) echo " checked ";?>
                        value="<?php echo $credential->id;?>"
                        class="checkboxCredential"
                        data-profil = "<?= $profil;?>"/>
                    &nbsp;<?php echo explode('::', $credential->name)[1]?>
                    &nbsp;
                    <i style="font-size:12px">(<?= $credential->description;?>)</i>
                </div>
            <?php endforeach;?>
        </div>
    <?php endforeach;?>
</div>