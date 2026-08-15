<div style="margin: 20px;">
  <div>
    <h1 style="float: left; display: inline">Energy Kids Academy</h1>
    <img src="<?= IMG ?>energy-kids-academy.svg"  style="width: 100px; height: 100px; float: right"/>
  </div>
  <br style="clear: both"/>
  <hr style="border-bottom: 2px solid darkred; max-width: 100%"/>

  <h2>Hello <?= $params->user['name'];?></h2>

  <br/>
  Voici le point sur tes tâches en cours:
  <br/><br/>
  <?php foreach($params->tasks as $type => $taskArray):?>

          <h4><?= $type;?></h4>
          <hr style="border: 1px solid darkred; max-width: 100%"/>

          <ul>
              <?php foreach($taskArray as $task):?>

                  <li>
                    <?= $task['name'];?>
                    <ul>
                      <li style="font-style: italic; font-size; 6px">
                          Date de la tâche : <?=$task['dateTask'];?>
                          &nbsp;-&nbsp;
                          Date limite : <?=$task['dateLimit'];?>
                      </li>
                    </ul>
                  </li>

              <?php endforeach;?>
          </ul>

  <?php endforeach;?>

  <br/><br/>
  <h5>Energy Kids Academy</h5>

</div>
