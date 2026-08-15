<!doctype html>
<html class="no-js" lang="fr" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="-1" />
  <meta Http-Equiv="Cache-Control" Content="no-cache" />
  <title><?php echo $title; ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="https://www.energykidsacademy.fr/assets/img/favicon-eka.ico">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= CSS; ?>tv.css">
  <link rel="stylesheet" href="<?= CSS; ?>instant.css">
  <link rel="stylesheet" href="<?= CSS; ?>animate.css">
  <link rel="stylesheet" href="<?= CSS; ?>owl-carousel.min.css">
  <script src="<?= JS; ?>vendor/jquery.js"></script>

</head>

<body>

  <div class="containerLogoTv">
    <img class="logoTv" src="<?= IMG ?>energy-kids-academy.svg">
  </div>
  <input type="hidden" id="urlHost" value="<?= HOST ?>">

  <?= $contentPage; ?>
  <script src="<?= JS; ?>vendor/owl-carousel.min.js"></script>
</body>

</html>