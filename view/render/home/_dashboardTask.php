<?php use_helper('dates'); ?>
<?php (!isset($params->callBack)) ? $myCallback = null : $myCallback = str_replace('/', '-', $params->callBack); ?>
<div class="masonry-css">

    <?php $taskStaffs = $params->tasks_todo; ?>

    <?php foreach ($taskStaffs as $type => $tasks):?>

          <div class="masonry-css-item">
            <section class="title bg-silver black"><?= $type; ?></section>
            <section class="block-list expandable">
                <?php $staff_name = ''; ?>
                <?php foreach ($tasks as $task):?>


                    <?php ob_start();?>

                        <?php if ($staff_name != $task->staff):?>
                            <div style="font-size: 14px; color: darkblue; font-weight: bold; display: inline-block"><?= $task->staff; ?></div>
                            <?php $staff_name = $task->staff; ?>
                        <?php endif; ?>

                        <?php (diffDate($task->date_limit, date('Y-m-d')) > 0) ? $color = 'color: red!important' : $color = ''; ?>

                        <li class="aTaskDashboard" >
                        
                          <a href="<?= HOST; ?>task/editTaskStaff/id/<?= $task->id; ?>/callBack/<?= $myCallback; ?>/" style="<?= $color; ?>">
                            <?= $task->name; ?>
                          </a>
                          <div class="aTaskDashboardDate">A faire le <?= showDate($task->date_task); ?><br/>Date limite :  <?= showDate($task->date_limit); ?></div>
                        </li>

                    <?php $taskLi = ob_get_clean();?>

                    <?php if(preg_match('/SUPERVISION/', $task->name)):?>
                        <?php $supervisons[] = $taskLi;?>
                    <?php else:?>
                        <?= $taskLi;?>
                    <?php endif;?>

                    <?php unset($taskLi);?>
                <?php endforeach; ?>
            </section>
          </div>
    <?php endforeach; ?>

      <div class="masonry-css-item">
            <section class="title bg-silver black">SUPERVISION</section>
            <section class="block-list expandable" style="background-color: lightyellow">
              <?php foreach($supervisons as $supervison):?>
                  <?= $supervison;?>
              <?php endforeach;?>
            </section>
      </div>

</div>
