<?php use_helper('dates,staffPresence'); ?>
<?php use_helper('translation'); ?>

<?php $staff = $params->staff; ?>
<?php $title = 'Profil '.$staff->person->firstname.' '.$staff->person->lastname; ?>

<h1 class="text-center"><?= 'Synthèse: '.$staff->person->firstname.' '.$staff->person->lastname; ?></h1>

<div class="actionsPage">
  <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
  <a href="<?= HOST; ?>person/display/id/<?= $staff->person->personId; ?>/"> <button class="button"><i class="material-icons">remove_red_eye</i> </button></a>
</div>

<div style="display: flex; justify-content: space-between; flex-wrap: wrap">

    <?php include('_previsionnel.php');?>

    <div style="max-width: 350px">
        <section class="title bg-silver black">Tâches à faire</section>
        <section class="block-list expandable" id="todoTask">
          <?php $tasks = $params->tasks_todo; ?>
          <?php include VIEW.'render/task/_day.php'; ?>
          <?php unset($tasks); ?>
        </section>
    </div>

    <div style="max-width: 350px">
        <section class="title bg-silver black">Tâches faites</section>
        <section class="block-list expandable"  id="doneTask">
          <?php $tasks = $params->tasks_done; ?>
          <?php include VIEW.'render/task/_day.php'; ?>
          <?php unset($tasks); ?>
        </section>
    </div>




<!--
    <div class="masonry-css-item ui-sortable-handle">
      <section class="title bg-silver black">Ajouter une tâche</section>
      <section class="block-list expandable">

        <div style="padding: 20px">
          <?php //$staff = $params->staff;?>
          <?php //include(VIEW.'render/task/_addTaskForm.php');?>
        </div>
    </div>
-->
</div>
