<?php use_helper('dates');?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
      body { width: 95%; margin: 0 auto; font-size: 14px!important}
      ul { list-style-type: none; margin-left:0;padding-left:0;}
    </style>
  </head>
  <body>

    <h2 style="text-align: center">Prévisionnel <?= showDate($params->date);?></h2>
        <?php $print = 1;?>
        <?php include('previsionnel.php');?>
    <script type="text/javascript">
        javascript:window.print();
    </script>

  </body>
</html>
