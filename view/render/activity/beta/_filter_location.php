<label>Lieux *
    <select id="selectLocationPickup" name="location" required>
        <option value="0">Tous</option>
        <?php foreach($_SESSION['LOCATIONS'] as $location):?>
            <option value="<?php echo $location->locationId; ?>"><?php echo $location->name; ?></option>
        <?php endforeach; ?>
    </select>
</label>