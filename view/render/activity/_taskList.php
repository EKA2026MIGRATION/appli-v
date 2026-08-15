<table>
  <?php foreach($params->tasksStaff as $id => $taskStaff):?>
    <?php if($taskStaff->step == "DONE"):?>
        <tr style="color: darkgreen">
          <td><?= $taskStaff->name;?></td>
          <td><?= date('H:i', strtotime($taskStaff->dateTask->date));?></td>
          <td>
            <?= $taskStaff->remoteAddress;?>
          </td>
          <?php if(ACTIVITY_AUTH_VALID):?>
            <td class="clearActivityButton" id="clearActivityButton-<?= $taskStaff->id;?>">
              <i class="material-icons" style="color: darkred; cursor: pointer" >clear</i>
            </td>
          <?php endif;?>
        </tr>
    <?php endif;?>

  <?php endforeach;?>
</table>
