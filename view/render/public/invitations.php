<!doctype html>
<html class="no-js" lang="fr" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0, minimal-ui">

    <title>Invitations Energy Kids Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Montserrat:wght@700&family=Patrick+Hand&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= CSS; ?>foundation.css">
    <link rel="stylesheet" href="<?= CSS; ?>toast.min.css">
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

<header style="width: 600px; margin: auto; display: flex; justify-content: center">
    <img id="logo" src="<?= IMG;?>energy-kids-academy.svg"/>
    <div>
        <h1>ENERGY KIDS ACADEMY</h1>
        On a tout le temps de grandir
    </div>
</header>
<hr/>

<main id="mainContent" style="width: 600px; margin: 0 auto">
    <div class="intro">
       <ul>
           <li><a href="<?= ASSETS;?>anniversaires/le_bus_de_zlatan.pdf" target="_blank">Le bus de Zlatan</a></li>
           <li><a href="<?= ASSETS;?>anniversaires/le_smash_de_roger.pdf" target="_blank">Le smash de Roger</a></li>
           <li><a href="<?= ASSETS;?>anniversaires/le_shoot_de_tony.pdf" target="_blank">Le shoot de Tony</a></li>
           <li><a href="<?= ASSETS;?>anniversaires/le_choix_du_roi_de_la_reine.pdf" target="_blank">Le choix du Roi et de la Reine</a></li>

       </ul>
    </div>

</main>


<script src="<?= JS; ?>vendor/jquery.js"></script>
<script src="<?= JS; ?>vendor/toast.min.js"></script>
<script src="<?= JS; ?>vendor/what-input.js"></script>
<script src="<?= JS; ?>vendor/mfb.min.js"></script>
<script src="<?= JS; ?>vendor/foundation.js"></script>

<?php
if (isset(FILES_ROUTE[ROUTE])) {
    foreach (FILES_ROUTE[ROUTE]['js'] as $item) {
        echo '<script src="'.JS.$item.'"></script>';
    }
}
?>

</body>

</html>