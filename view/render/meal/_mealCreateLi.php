<?php use_helper('age');?>
<?php ob_start();?>
<li>
    <a href="javascript:void(0)" data-open="action-repas<?= $meal->mealId ?>"> <!--TODO changer le data-open avec revealJS -->
        <div>
            <p class="list-header" style="color: darkblue">
                <img src="<?php if (null !== $meal->child &&  null !== $meal->child->photo):
                    echo  HOST.$meal->child->photo;
                elseif (null !== $meal->person && null !== $meal->person->photo):
                    echo  HOST.$meal->person->photo;
                else:
                    echo  IMG.'no_photo.jpg';
                endif ?>" class="width-30 height-30" height="" width="" alt="">
                <?php if (null !== $meal->child):
                    echo $meal->child->firstname.' '.$meal->child->lastname;
                    if( strlen($meal->child->medical) > 0){
                        echo '<i class="material-icons" style="color: darkblue" title="'.$meal->child->medical.'">local_hospital</i>';
                    }
                    echo " <span style='font-size: 10px'>".showAge($meal->child->birthdate)."</span>";
                elseif (null !== $meal->person):
                    echo $meal->person->firstname.' '.$meal->person->lastname;
                else:
                    echo $meal->freeName;
                endif ?>

                <?php foreach($meal->foods as $f):?>

                    <?php $arrFood[] = $f->name;?>

                <?php endforeach;?>
                <?php echo '&nbsp;&nbsp;<span style="font-style: italic; color: gray; font-size: 14px">'.implode(', ', $arrFood).'</span>';?>
                <?php unset($arrFood);?>
                <br/>
                <?php if (null !== $meal->child):;?>
                    <?php if(strlen($meal->child->medical) > 0) echo "<i style='font-size:12px; color: black'>".$meal->child->medical.'</i>';?>
                <?php endif;?>
            <div class="with-icon">
                <i class="material-icons" style="color: darkblue">send</i>
            </div>
            </p>
        </div>
    </a>
</li>
<?php $line = ob_get_clean(); ?>

<?php if($meal->child) $mealChild[$meal->child->childId] = $line;?>
<?php if($meal->person) $mealPerson[$meal->person->personId] = $line;?>
<?php if($meal->freeName) $mealFreeName[] = $line;?>
<?php if( (isset($meal->person)) && !key_exists($meal->person->personId, $presencePersons)) $mealNoContext[] = $line;?>
<?php if( (isset($meal->child)) && !key_exists($meal->child->childId, $presenceChildArray)) $mealNoContext[] = $line;?>
