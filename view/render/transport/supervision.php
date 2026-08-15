<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--- manifest JSON --->
    <link rel="manifest" href="<?= HOST; ?>manifest.json">
    <!-- Chrome -->
    <link rel="icon" sizes="192x192" href="<?= HOST; ?>manifest/icons/icon-192x192.png">
    <!-- Safari -->
    <link rel="apple-touch-startup-image" href="<?= HOST; ?>manifest/icons/icon-512x512.png">
    <!-- Chrome -->
    <meta name="theme-color" content="#182d60">
    <!-- Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- Apple --->

    <link rel="apple-touch-icon" href="touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= HOST; ?>manifest/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= HOST; ?>manifest/icons/icon-192x192.png">
    <link rel="apple-touch-icon" sizes="167x167" href="<?= HOST; ?>manifest/icons/icon-152x152.png">

    <meta name="mobile-web-app-capable" content="yes">
    <link href="<?= HOST; ?>manifest/apple_splash/apple_splash_2048.png" sizes="2048x2732" rel="apple-touch-startup-image" />
    <link href="<?= HOST; ?>manifest/apple_splash/apple_splash_1668.png" sizes="1668x2224" rel="apple-touch-startup-image" />
    <link href="<?= HOST; ?>manifest/apple_splash/apple_splash_1536.png" sizes="1536x2048" rel="apple-touch-startup-image" />
    <link href="<?= HOST; ?>manifest/apple_splash/apple_splash_1125.png" sizes="1125x2436" rel="apple-touch-startup-image" />
    <link href="<?= HOST; ?>manifest/apple_splash/apple_splash_1242.png" sizes="1242x2208" rel="apple-touch-startup-image" />
    <link href="<?= HOST; ?>manifest/apple_splash/apple_splash_750.png" sizes="750x1334" rel="apple-touch-startup-image" />
    <link href="<?= HOST; ?>manifest/apple_splash/apple_splash_640.png" sizes="640x1136" rel="apple-touch-startup-image" />

    <title><?php echo (isset($title)) ? $title : 'APPLI-V'; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Mali|Pacifico|K2D|Poiret+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= CSS; ?>foundation.css">
    <link rel="stylesheet" href="<?= CSS; ?>toast.min.css">
    <?php if (isset(FILES_ROUTE[ROUTE])) {
    foreach (FILES_ROUTE[ROUTE]['css'] as $item) {
        if ($item != '') {
            ?>
      <link rel="stylesheet" href="<?= CSS; ?><?php echo $item; ?>">
    <?php
        }
    }
} ?>
    <!--<link rel="shortcut icon" type="image/x-icon" href="<?= IMG; ?>favicon.png">-->
    <link rel="stylesheet" href="<?= CSS; ?>mfb.min.css">
    <link rel="stylesheet" href="<?= CSS; ?>app.css">
  </head>
<body>

<div class="actionsPage">
    <a href="<?= HOST;?>" class="button"><i class="material-icons">arrow_back</i></a>
</div>


<input id="date" value="<?= $params->date ?>" type="hidden">
    <div class="text-center">
    <h1>
        <a href="#" id="previousDay" class="jumpToDayButton">
        <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
        </a>

        <span id="showCurrentDate">
        <?php echo date('d/m/Y', strtotime($params->date)); ?>
        </span>

        <a href="javascript:void(0)" onclick="openDatePicker()">
        <i class="material-icons" class="calendar_change_date">date_range</i>
        </a>

        <a href="#" id="nextDay" class="jumpToDayButton">
        <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
        </a>
    </h1>
    </div>
    <div id="datePickerInline"></div>

    <select name="kind" id="kind" class="selectButton">
        <option value="dropin" <?php if($params->kind == "dropin") echo 'selected="selected"';?>>Prise en charge</option>
        <option value="dropoff" <?php if($params->kind == "dropoff") echo 'selected="selected"';?>>Dépose</option>
    </select>

    <select name="moment" id="moment" class="selectButton">
        <option value="am" <?php if($params->moment == "am") echo 'selected="selected"';?>>Matin</option>
        <option value="pm" <?php if($params->moment == "pm") echo 'selected="selected"';?>>Après-midi</option>
    </select>

    <div style="padding: 10px; border: 2px solid darkred; border-radius: 20px; text-align: center; margin: 0px 20px 20px 20px">
        <?php if($params->showAddress == "show"):?>
            <a href="<?= HOST;?>transport/supervision/date/<?= $params->date;?>/filter/<?= $params->filter;?>/showAddress/hide/">
                Masquer les adresses
            </a>
        <?php else:?>
            <a href="<?= HOST;?>transport/supervision/date/<?= $params->date;?>/filter/<?= $params->filter;?>/showAddress/show/">
                Afficher les adresses
            </a>
        <?php endif;?>
    </div>

<div id="showSupervision">
    <?php include_once('supervisionReload.php');?>
</div>

<input type="hidden" id = "showAddress" value="<?= $params->showAddress;?>"/>
<input type="hidden" id="supervisionUrlBase" value="<?= HOST;?>transport/supervision/date/"/>
<input type="hidden" id="supervisionReload" value="<?= HOST;?>transport/supervisionReload/date/<?= $params->date;?>/filter/<?= $params->filter;?>/showAddress/<?= $params->showAddress;?>/"/>
<script src="<?= JS;?>vendor/jquery.js"></script>
<script src="<?= JS;?>vendor/jquery-ui.js"></script>
<script src="<?= JS;?>vendor/toast.min.js"></script>
<script src="<?= JS;?>vendor/what-input.js"></script>
<script src="<?= JS;?>vendor/foundation.js"></script>
<script src="<?= JS;?>pages/transport/supervision.js"></script>


</body>
</htmL>