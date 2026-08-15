<style>
    .locationBarButton { background-color: #eeeee4; color: lightgrey; border: 1px solid darkblue; border-radius: 15px; text-align: center; padding: 2px 12px 2px 12px; cursor: pointer}
    .locationBarButton:hover { color: darkblue}
    .locationIsActive { background-color: darkblue; color: white}
</style>
<div id="locationBar" style="display: flex; justify-content: space-around">
    <div id="locationButton-all" class="locationBarButton locationIsActive">
        Tout
    </div>
    <?php foreach($params->locations as $location):?>
        <?php if($location->locationId != 99):?>
            <div id="locationButton-<?= $location->locationId;?>" class="locationBarButton">
                <?php echo $location->name;?>
            </div>
        <?php endif;?>
    <?php endforeach;?>
</div>
<br/>
