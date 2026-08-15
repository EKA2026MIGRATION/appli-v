<?php use_helper('lunch');?>
<?php $title="Gestion des repas"; ?>
<?php use_helper('buttons');?>
<?php showFloatingActionButton($params->buttons); ?>
<?php $presences = $params->child_presence;?>
<?php $presenceCoachs = $params->staff_presence;?>
<?php $presencePersons = $params->person_presence;?>
<?php $presenceChildArray = $params->child_presence_array;?>
<?php $totalMeals = ['total' => 0, 'child' => 0, 'adult' => 0, 'other' => 0];?>

<h1 class="text-center">
    <a href="<?= HOST; ?>meal/list/date/<?= date('Y-m-d', strtotime('-1 day', strtotime($params->date))) ?>/">
        <i class="material-icons md-30" >chevron_left</i>
    </a> <?php echo date('d/m/Y', strtotime($params->date)); ?>

    <a href="javascript:void(0)" onclick="openDatePicker()">
        <i class="material-icons" class="calendar_change_date">date_range</i>
    </a>

    <a href="<?= HOST; ?>meal/list/date/<?php echo date('Y-m-d', strtotime('+1 day', strtotime($params->date))) ?>/">
        <i class="material-icons md-30" >chevron_right</i>
    </a>
</h1>
<input type="hidden" value="<?php echo $params->date; ?>" id="date">

<div id="datePickerInline"></div>

<?php foreach ($params->meals as $meal): ?>

    <div class="reveal" id="action-repas<?= $meal->mealId ?>" data-reveal> <!-- TODO changer pour mettre methode JS revealJS -->

        <p class="lead">

            <?php if (null !== $meal->child):
                echo $meal->child->firstname.' '.$meal->child->lastname;
                if( strlen($meal->child->medical) > 0){
                    echo '<i class="material-icons" style="color: darkblue" title="'.$meal->child->medical.'">local_hospital</i>';
                }
                $totalMeals['child']++;
            elseif (null !== $meal->person):
                echo $meal->person->firstname.' '.$meal->person->lastname;
                $totalMeals['adult']++;
            else:
                echo $meal->freeName;
                $totalMeals['other']++;
            endif ?><!--<small> (x ans) </small></p>-->

        <div class="cadrePec">
            <img src="<?php if (null !== $meal->child &&  null !== $meal->child->photo):
                echo  HOST.$meal->child->photo;
            elseif (null !== $meal->person && null !== $meal->person->photo):
                echo  HOST.$meal->person->photo;
            else:
                echo  IMG.'no_photo.jpg';
            endif ?>" />
            <div class="text">
                <p><?php if (null !== $meal->child):
                        // echo  $meal->child->person->addresses;
                    elseif (null !== $meal->person):
                        //echo  $meal->person->addresses;
                    else:
                        echo  '';
                    endif ?> </p>
            </div>
        </div>
        <hr/>
        <p class="lead">Repas </p>
        <form method="post" id="mealForm" action="meal/modify/<?= $meal->mealId;  ?>">
            <input type="hidden" name="child" value="<?= $meal->child->childId; ?>">
            <?php foreach($params->foodCategories as $categorie=>$value): ?>

                <fieldset class="fieldset">
                    <legend><?= $value ?> </legend>
                    <div class="radioImg">

                        <?php foreach($params->foods as $food):
                            $stringify = $food->foodId;
                            if ($categorie === $food->kind && 'active'=== $food->status): ?>
                                <label>
                                    <input <?php foreach ($meal->foods as $foodAsso):
                                        if ($foodAsso->foodId === $food->foodId):
                                            echo "class='asso-food'"; echo "checked=''";
                                        else:
                                            echo '';
                                        endif;
                                    endforeach;?> type="checkbox" value="<?= $food->foodId ?>" onclick="addClass(this)" > <!-- TODO enlever le onclick -->
                                    <img src="<?= ($food->photo != "") ? HOST.$food->photo : IMG.'no_photo.jpg';  ?>">
                                </label>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </fieldset>
            <?php endforeach ?>
            <center><input type="submit" class="button"  value="Modifier" /></center>
        </form>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php $totalMeals['total']++;?>

    <?php include('_mealCreateLi.php');?>

<?php endforeach ?>

<h2 class="margin-top-20"> Récapitulatif </h2>

<div class="recapRepas table-scroll">
  <?php include('_recapTable.php');?>
</div>


<ul class="tabs" data-tabs id="example-tabs">
  <li class="tabs-title"><a data-tabs-target="panel1" href="#panel2">Liste par enfants</a></li>
  <li class="tabs-title is-active"><a href="#panel2" aria-selected="true">Vue par groupe</a></li>
</ul>

<div class="tabs-content" data-tabs-content="example-tabs">
  <div class="tabs-panel" id="panel1">
      <?php include('_mealDetails.php');?>
  </div>
  <div class="tabs-panel is-active" id="panel2">
    <?php include('_mealGroups.php');?>
  </div>
</div>



<input type="hidden" id="pageSearch">
