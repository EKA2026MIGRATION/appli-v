<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?= CSS;?>foundation.css">
    <link rel="stylesheet" href="<?= CSS;?>app.css">
    <link rel="stylesheet" href="<?= CSS;?>toast.min.css">
    <link href="https://fonts.googleapis.com/css?family=Mali|Pacifico|K2D|Poiret+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= CSS;?>animate.css">
    <link rel="shortcut icon" type="image/x-icon" href="https://www.energykidsacademy.fr/assets/img/favicon-eka.ico">
  </head>
  <body class="animateBackground">


    <div class="top-bar mobile-top-bar" data-animate="hinge-in-from-top spin-out">
      <div class="top-bar-left">
        <ul class="dropdown menu" data-dropdown-menu>
          <li class="menu-text"> Energy Academy</li>
        </ul>
      </div>
    </div>


    <div class="top-bar pc-top-bar" data-animate="hinge-in-from-top spin-out">
      <div class="top-bar-left">
        <ul class="dropdown menu" data-dropdown-menu>
          <li class="menu-text"> Energy Academy</li>
        </ul>
      </div>
      <div class="pc-top-bar-right">
      </div>

    </div>

    <div class="site__container">

      <div class="page__container__connexion" style="background-image: url(<?= IMG;?>energy-kids-academy.svg);">
        <?php echo $contentPage ;?>
      </div>

    </div>
    <input type="hidden" id="urlHost" value="<?= HOST; ?>">

    <script src="<?= JS;?>vendor/jquery.js"></script>
    <script src="<?= JS;?>vendor/toast.min.js"></script>
    <script src="<?= JS;?>vendor/what-input.js"></script>
    <script src="<?= JS;?>vendor/foundation.js"></script>

    <?php if(ROUTE == "auth/display"): ?>
    <script src="<?= JS; ?>pages/auth/auth.js"></script>
    <?php endif; ?>

    <?php if(ROUTE == "auth/lost-password"): ?>
    <script src="<?= JS; ?>pages/auth/lost-password.js"></script>
    <?php endif; ?>

    <?php if(ROUTE == "auth/lost-password-confirm"): ?>
    <script src="<?= JS; ?>pages/auth/lost-password-confirm.js"></script>
    <?php endif; ?>




  </body>
</html>



