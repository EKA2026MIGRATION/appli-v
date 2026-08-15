<?php use_helper('translation');?>
<?php $reserved = ['Arrivée', 'DEPART'];?>
<h4>Gérer les tâches de base</h4>

<ul>
<?php foreach($params->basicTasks as $moment => $list):?>

    <h5><?= ucfirst(trans($moment));?></h5>

    <table>
        <?php $i = 1; foreach($list as $key => $taskname):?>
            <?php if(!in_array($taskname, $reserved)):?>
                <?php $i = $i * -1;?>
                <?php ($i == 1) ? $back = "background-color: rgba(242,242,242,0.5);" : $back = "background-color: white;";?>
                <tr style="<?= $back ;?>" id="tr-<?= $key;?>">
                    <td>
                      <?= $taskname;?>
                    </td>
                    <td>
                      <i class="material-icons deleteTask" id="task-<?= $key;?>" data-name = "<?= $taskname;?>" style="color: darkred; float: right; cursor: pointer">delete</i>
                    </td>
                </tr>
            <?php endif;?>
        <?php endforeach;?>
        <tr>
            <td>
              <input type="text" id="input-taskname-<?= $moment;?>" class="addTaskInput" placeholder="Ajouter une tâche <?=trans($moment);?>"/>
            </td>
            <td>
              <i class="material-icons submitAddBasickTask"
                style="color: white; background-color: darkblue; padding: 10px; cursor: pointer"
                id="submit-taskname-<?= $moment;?>"
              >subdirectory_arrow_left</i>
            </td>
          </tr>
    </table>

    <br/>

<?php endforeach;?>
<Ul>

  <div id="nomessageBox"></div>
