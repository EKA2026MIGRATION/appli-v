<style>
    .tagReminder { cursor: pointer}
</style>

<?php $colorTag = ['awaiting' => 'orange', 'todo' => 'red', 'inprogress' => 'blue', 'done' => 'green'];?>
<?php $colorText = ['awaiting' => 'En attente', 'todo' => 'A faire', 'inprogress' => 'En cours', 'done' => 'Fait'];?>
<script>
    var colorTag = <?php echo json_encode($colorTag); ?>;
    var colorText = <?php echo json_encode($colorText); ?>;

</script>


<div class="reminders" style="padding: 20px; overflow: auto">
 
    <p class="lead">Rappels véhicules</p>
    <table class="fuelTable">
      <thead>
        <tr>
          <th width="200">Crée le</th>
          <th width="200">Véhicule</th>
          <th width="200">Nom</th>
          <th width="150">Description</th>
          <th width="150">Status</th>
          <th width="200">Conditions</th>

        </tr>
      </thead>
      <tbody>
        <?php foreach ($params->reminders as $reminder) : ?>
          <tr>
            <td><?= date('d/m/Y', strtotime($reminder->dateReminder)); ?></td>
            <td><?= $reminder->vehicle->name; ?></td>
            <td><?= $reminder->name; ?></td>
            <td><?= $reminder->description; ?></td>
            <td>
                <div id="reminderTag-<?= $reminder->id;?>" class="tag <?= $colorTag[$reminder->status];?> tagReminder" data-status="<?= $reminder->status;?>" data-id="<?= $reminder->id;?>">
                    <?= $colorText[$reminder->status];?>
                </div>
            </td>
            <td>
                <?php 
                    if($reminder->criteriaComparison == ">") {
                        if($reminder->criteria == "km") echo 'Au delà de '.$reminder->criteriaValue.' km';
                        if($reminder->criteria == "date") echo 'Après le '.showDate($reminder->criteriaValue);
                    }

                    if($reminder->criteriaComparison == "<") {
                      if($reminder->criteria == "km") echo 'En deçà de '.$reminder->criteriaValue.' km';
                      if($reminder->criteria == "date") echo 'Avant le'.showDate($reminder->criteriaValue);
                  }
                ;?>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>

</div>
