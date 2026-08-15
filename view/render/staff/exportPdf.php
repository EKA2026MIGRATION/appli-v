<?php use_helper('dates, translation');?>

<?php $person = $params->currentStaff->person;?>
<?php $staff = $params->currentStaff;?>
<?php $presences = get_object_vars($params->presences->presences);?>

<style>
    .tdStyle { padding: 10px;}
    .title { background-color: darkred; color: white; font-style: 10px; font-weight: bold}

    .typeABSENCE { background-color: lightgrey; color: darkred}
    .typeCATCHING { background-color: lightblue; color: darkblue}
    .typeBONUS { background-color: lightgreen; color: black}
    .typePRESENCE { background-color: #3a87ad; color: white}
    .typeVACATION { background-color: lightpink; COLOR: black;}
    .typeFORMATION { background-color: orangered; color: black }

</style>
<?php

 $color['typeABSENCE'] = "darkred";
 $color['typeCATCHING'] = "#lightblue";
 $color['typeBONUS'] = "#lightgreen";
 $color['typePRESENCE'] = "#";
 $color['typeVACATION'] = "lightpink";
 $color['typestage'] = "#FCF6E3";
 $color['typeecole'] = "#F0FEFE";
 $color['typeinter'] = "#E2F3D2";
 $color['typeFORMATION'] = "orangered";
;?>

<?php ob_start();?>

<?php $currentMonth = "";?>

<?php  
        $total_TYPE = [];
        $total_GROUPNAME = [];
        $total_GROUPNAMEDAY = [];
        $total_KIND = [];
        $total_KIND_HOURS = [];
        $total_presences = 0;
        $presence_months = null;
        $totalTime = 0;
        $total_day = [];
;?>

<table>

    <?php $nbRow = 0; $col = 0?>
    <?php foreach($params->season->weeks as $week):?>
        <?php if( $currentMonth != getMonth($week->dateStart)):?>
            <?php
                if( $col == 1) {
                    echo '<td></td></tr>';
                    $col = 0;
                }
            ;?>

            <tr>
                <td class="title" colspan="2">
                    <?= getMonth($week->dateStart);?> <?= showDate($week->dateStart, 'Y');?>
                </td>
            </tr>
            <?php $nbRow++;?>
            <?php $currentMonth = getMonth($week->dateStart);?>
        <?php endif;?>

        <?php 
            if($col == 0) {
                echo '<tr>';
            }
        ;?>

        <!--- content cell --->
        <td class="tdStyle" style="background-color: <?= $color['type'.$week->kind];?>">

            <span style="font-size: 12px; font-weight: bold"><?= $week->code;?> - <?= $week->name;?> <?= $week->groupName;?></span>
            <br/>
            <?php $nbRow++;?>

            <?php $currentDate =  $week->dateStart;?>
            <?php for($i = 0; $i<7; $i++):?>
                        <?php if(key_exists($currentDate, $presences)):?>
                            <?php $duration = timeSpend($presences[$currentDate]->start, $presences[$currentDate]->end);?>
                            <?php $typeName = $presences[$currentDate]->typeName;?>
                            <?php $keycolor = 'type'.$typeName;?>
                                <span style="font-size: 10px">
                                    <?= showDate($currentDate, 'l j/m') ?> : <span class="<?= $keycolor;?>"><?= maj(trans($typeName));?></span> - <?= $presences[$currentDate]->location;?>
                                    <?php if($params->hours == 1):?>
                                    - (<?= $duration ;?>)
                                    <?php endif;?>
                                </span>
                                <br/>
                                <?php $nbRow++;?>

                            <!-- increment total by type -->      
                            <?php if(!isset($total_TYPE[$typeName])) $total_TYPE[$typeName] = 0;?>
                            <?php $total_TYPE[$typeName]++;?>

                            <!-- increment kind -->
                            <?php if(!isset($total_KIND[$week->kind][$typeName])) $total_KIND[$week->kind][$typeName] = 0;?>
                            <?php $total_KIND[$week->kind][$typeName]++;?>

                            <!-- increment kind hours -->
                            <?php if($typeName != "VACATION"):?>
                                <?php if(!isset($total_KIND_HOURS[$week->kind][$typeName])) $total_KIND_HOURS[$week->kind][$typeName] = '00:00';?>
                                <?php $total_KIND_HOURS[$week->kind][$typeName] = incrementTime($total_KIND_HOURS[$week->kind][$typeName], $duration);?>
                            <?PHP endif;?>

                            <!-- increment groupName -->
                            <?php if(!isset($total_GROUPNAME[$week->groupName][$typeName])) $total_GROUPNAME[$week->groupName][$typeName] = 0;?>
                            <?php $total_GROUPNAME[$week->groupName][$typeName]++;?>

                            <!--- increment by day and group ---->
                            <?php //if($typeName != "VACATION" || $typeName != "ABSENCE"):?>
                            <?php  if($typeName == "PRESENCE"):;?>
                                <?php if(!isset($total_GROUPNAMEDAY[$week->groupName][showDate($currentDate, 'l')])) $total_GROUPNAMEDAY[$week->groupName][showDate($currentDate, 'l')] = 0;?>
                                <?php $total_GROUPNAMEDAY[$week->groupName][showDate($currentDate, 'l')]++;?>
                            <?php endif;?>

                        <?php endif;?>
                <?php $currentDate = nextDay($currentDate);?>
            <?php endfor;?>
        </td>

        <?php $col++;?>
        <?php 
            if($col == 2) { 
                echo '</tr>';
                $col = 0;
        };?>
    <?php endforeach;?>
</table>



<?php $contentCalendar = ob_get_clean();?>

<table>

    <tr>
        <td>
            <h1><?php echo $staff->fullname;?></h1>
            <img src="<?= ($person->photo != "") ? HOST.$person->photo : IMG.'no_photo.jpg';  ?>" height="240">
            <br/>&nbsp;&nbsp;<br/>&nbsp;
        </td>
        <td>
                <h3>Répartition des jours sur la saison</h3>
                <?php foreach($total_KIND as $kind => $types):?>
                        <span class="center" style="color: darkred; font-style: 10px; font-weight: bold"><?= strtoupper(trans($kind)) ;?></span>
                        <br/>
                        
                        <?php foreach($types as $type => $val):?>
                            <b>* <?= ucfirst(trans($type, 1));?></b>
                            <ul>
                                <li>Nombres de jours :<?= $val;?></li>
                                <?php if($params->hours == 1):?>
                                    <?php if($type != "VACATION"):?>
                                        <li>Nombres d'heures : <?= $total_KIND_HOURS[$kind][$type] ;?></li>
                                    <?php endif;?>
                                <?php endif;?>
                            </ul>
                        <?php endforeach;?>
                <?php endforeach;?>           
        </td>
    </tr>

    <tr style="background-color: lightblue;">
        <td colspan="2" style="text-align: center">
            <h3>Planning prévisionnel - <?php echo $params->season->name ;?></h3>
            <?php $i = 0;foreach($total_TYPE as $typeName => $val):?>
                <b>Total <?= maj(trans($typeName, 1));?></b> : <?= $val;?>
                <?php $i++; if($i < 3):?>
                    &nbsp;&nbsp;-&nbsp;&nbsp;
                <?php endif;?>
            <?php endforeach;?>
            <br/><br/>
        </td>
    </tr>
</table>
<br/>
<?php echo $contentCalendar;?>