<!doctype html>
<html class="no-js" lang="fr" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0, minimal-ui">

  <title>Livret Enfant</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato&family=Montserrat:wght@700&family=Patrick+Hand&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="<?= CSS; ?>app.css">
  <?php if (isset(FILES_ROUTE[ROUTE])) {
    foreach (FILES_ROUTE[ROUTE]['css'] as $item) {
      if ($item != '') {
  ?>
        <link rel="stylesheet" href="<?= CSS; ?><?php echo $item; ?>">
  <?php
      }
    }
  } ?>

</head>

<body>

  <main id="mainContent">
  </main>

  <div id="windowsFullScreen">
    <p>
      Passer en plein écran ?
      <br/>
      <button class="button" id="swapToFullScreen">OUI</button>
      <button class="button" id="closeModalFullScreen">NON</button>
    </p>
  </div>

  <div id="buttonFullscreenNavigation">
      <i class="fas fa-expand-alt" id="enterFullscreenIcon"></i>
      <!--<i class="fas fa-window-close" id="exitFullScreenIcon"></i>-->
  </div>


  <input type="hidden" id="urlRequest" value="<?= HOST; ?>sendRequest">
  <input type="hidden" id="urlHost" value="<?= HOST; ?>">
  <input type="hidden" id="tokenAuth" value="<?= TOKEN; ?>">
  <input type="hidden" id="urlApi" value="<?= API;?>" >



  <script src="<?= JS; ?>vendor/jquery.js"></script>
  <script src="<?= JS; ?>vendor/foundation.js"></script>


  <script>
    const navElements      = <?php echo json_encode($params->navigation) ?>;
    const templates        = <?php echo json_encode($params->templates) ?>;
    const bookletChildData = <?php echo json_encode($params->bookletChild) ?>;


  </script>

  <?php
  if (isset(FILES_ROUTE[ROUTE])) {
    foreach (FILES_ROUTE[ROUTE]['js'] as $item) {          
        echo '<script src="'.JS.$item.'"></script>';
      }
    }    
    ?>

</body>

</html>