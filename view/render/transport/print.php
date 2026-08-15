<?php use_helper('dates');?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
      body { width: 95%; margin: 0 auto; font-size: 11px!important; font-family: Arial, Helvetica, sans-serif; color: darkblue}
      #groupListPrint { display: flex; flex-wrap: wrap; justify-content: space-between; margin-top: 30px; padding-left: 30px}
      .item { width: 285px; border: 1px solid black; padding: 5px 10px 0px 5px; border-radius: 10px; margin: 10px}
      ul { list-style-type: none; margin-left:0;padding-left:0;}
      .childName { color: black; font-weight: bold; font-size: 16px}
    </style>
  </head>
  <body>

    <h2 style="text-align: center">Transport <?= showDate($params->date);?></h2>
    <h1><?= $params->driver->person->firstname;?></h1>

    <?php foreach($params->rides as $ride):?>

        
        <h1><?= $ride->name;?></h1>
        <strong> Départ </strong> : <?php echo date('H:i', strtotime($ride->start)); ?>  - <?php echo $ride->startPoint; ?> <br />
        <strong> Arrivée </strong> : <?php echo date('H:i', strtotime($ride->arrival)); ?> - <?php echo $ride->endPoint; ?> <br />


        <div id="groupListPrint">
            <?php foreach($ride->pickups as $pickup):?>

                    <div class="item">

                        <div style="font-size: 12px; font-weight: bold; background-color: darkblue; color: white; padding: 6px">
                            <?= date('H:i', strtotime($pickup->start));?>
                        </div>
                        <br/>
                        <div class="childName">
                            <?= $pickup->child->firstname.' '.$pickup->child->lastname;?>
                            (<?= showAge($pickup->child->birthdate); ?>)
                        </div>

                        <div style="color: darkred; font-size: 13px">
                            <?= $pickup->address?>
                        </div>

                        <?php $test = []; foreach($pickup->child->persons as $person):?>

                            <?php $personname = $person->firstname.' '.$person->lastname;?>
                            <?php if(!in_array($personname, $test)):?>
                            
                                <!--<div class="personName"><?php echo $personname;?></div>-->
                                <?php $test[] = $personname;?>

                                <ul>
                                    <?php foreach($person->phones as $phone):?>
                                        <li><?= $phone->name.' '.$phone->phone;?>
                                    <?php endforeach;?>
                                </ul>

                                <div style="font-style: italic; color: darkred; font-size: 11px"><?= $pickup->comment;?></div>


                            <?php endif;?>

                        <?php endforeach;?>
                    </div>


            <?php endforeach;?>
        </div>




        <hr/>
        <hr/>

    <?php endforeach;?>



    <script type="text/javascript">
    javascript:window.print();
    </script>

  </body>
</html>
