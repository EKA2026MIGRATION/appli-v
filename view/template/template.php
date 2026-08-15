<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
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
  <link rel="stylesheet" href="<?= CSS; ?>print.css" type="text/css" media="print">
  <link rel="stylesheet" href="<?= CSS; ?>animate.css">

</head>

<body>
  <?php if (IFRAME == 0) : ?>

    <div class="loading" style="display: none;">Loading&#8230;</div>

    <div id="fastSearchResult" style="display: none; padding: 10px; text-align: center; width: auto; box-shadow: -5px 5px 5px black; position: fixed; z-index: 999; top: 55px; right: 0; background-color: whitesmoke;  overflow: auto;">
      <span onclick="closeFastSearchResult()" style="cursor: pointer; border-radius: 6px; line-height: 1; float: right; font-size: 30px; width: 40px; height: 36px; font-weight: bold; border: 2px solid darkblue; color: darkred">x</span>
      <div id="fastSearchResultContent" style="text-align: left; float: right; margin-right: 20px; padding: 10px; max-height: 650px">
      </div>
    </div>

    <div class="content">
      <!-- CONTENT OVERLAY LOADER -->

      <div class="top-bar mobile-top-bar" data-animate="hinge-in-from-top spin-out">
        <div class="top-bar-left">
          <ul class="dropdown menu" data-dropdown-menu>
            <li class="menu-text"><i class="material-icons menu_link">menu</i></li>
          </ul>
          <div style="display: flex; position: absolute; top: 8px; left: 60px;">
            <div class="divResultSearchPage" style="position: absolute; top: -3px; left: 90px; display: none;">
              <span class="nbResultActual" style="font-size:11px;"></span>
              <span style="font-size:11px">/</span>
              <span class="nbResultSearchPage" style="font-size:11px;"></span>
            </div>
            <!--<input type="text" style="margin-right: 6px !important;" class="searchFieldMobile" id="searchOnPage" placeholder="Recherche dans page" />-->
            <!--<button style="height: 40px; padding-top: 10px; width: 150px !important;" class="button" onclick="openNativeSearch2()">Recherche page</button>-->
          </div>

          <?php if(hasCredential('child::searchAll')):?>
            <input type="text" class="fastSearchChild" id="fastSearchChildMobile" placeholder="Recherche rapide" />
          <?php endif;?>
        </div>
      </div>

      <div class="top-bar pc-top-bar" data-animate="hinge-in-from-top spin-out">
        <div class="top-bar-left">
          <ul class="dropdown menu" data-dropdown-menu>
            <li class="menu-text">Energy Kids Academy</li>
          </ul>
        </div>
        <div class="pc-top-bar-right">
          <ul class="dropdown menu" data-dropdown-menu>
            <li style="margin-right: 5px;">
              <div style="display: flex; position: relative;">
                <div class="divResultSearchPage" style="position: absolute; top: -3px; right: 72px; display: none;">
                  <span class="nbResultActual" style="font-size:11px;"></span>
                  <span style="font-size:11px">/</span>
                  <span class="nbResultSearchPage" style="font-size:11px;"></span>
                </div>
                <input type="text" class="searchField" id="searchOnPage" placeholder="Rechercher dans la page" />
                <button style="height: 40px; padding-top: 8px;" class="button" onclick="searchOnPage()"><i class="material-icons">search</i></button>
              </div>
            </li>
            <?php if(hasCredential('child::searchAll')):?>
              <li><input type="text" class="fastSearchChild" id="fastSearchChildDesktop" placeholder="Recherche rapide" /></li>
            <?php endif;?>
            <li id="notificationBlock" style="position: relative; display: none">
              <i class="material-icons" id="notificationBell" style="color: black; padding-top: 6px; cursor: pointer; font-size: 2.3em" id="notificationIcon">notifications</i>
              <div id="notificationBellCount" style="color: red; position: absolute; top: -3px;left: 5px; font-weight: bold"></div>
              <div id="notificationContainer" style="display: none; padding: 10px; color: black; background-color: white; box-shadow: 5px 5px 5px grey; border: 3px solid darkred; position: absolute; width: 400px; left: -380px">
                <b>Dernières notifications</b>
                <div id="notificationList"></div>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <div class="site__container" style="position: relative">
    
        <div class="container__menu__left">
          <div class="menu__left">
            <div class="closeLeftMenu"><i class="material-icons">arrow_back</i></div>
            <div class="active__user">
              <img src="<?php echo !empty(PERSON_CONNECTED['photo']) ? HOST . PERSON_CONNECTED['photo'] : IMG . 'no_photo.jpg'; ?>">

              <span class="user__name"><?php echo (PERSON_CONNECTED['firstname'] ?? '') . ' ' . (PERSON_CONNECTED['lastname'] ?? ''); ?></span>
              <span class="user__fonction"><?= showRoles(); ?></span>

              <div style="display: flex; justify-content: space-around">
                  <a href="<?= HOST; ?>person/display/id/<?php echo PERSON_CONNECTED['personId'] ?? ''; ?>/" title="profil">
                    <i class="material-icons" style="color: black">miscellaneous_services</i>
                  </a>
                  <a href="<?= HOST; ?>staffPresence/calendar/staffId/<?php echo PERSON_CONNECTED['staff']['staffId'] ?? ''; ?>/" title="calendrier">
                      <i class="material-icons" style="color: black">date_range</i>
                  </a>
                  <a href="<?= HOST.$_REQUEST['r'].'?i='.rand(1,1000000000);?>" title="reload">
                    <i class="material-icons" style="color: black">restart_alt</i>
                  </a>
                  <a href="<?= HOST; ?>auth/logout" title="déconnexion">
                    <i class="material-icons" style="color: black">phonelink_erase</i>
                  </a>
              </div>

            </div>

            <ul class="multilevel-accordion-menu vertical menu" data-accordion-menu>

              <li <?php echo (ROUTE == 'app/home') ? 'class="active"' : ''; ?>>
                <a href="<?= HOST; ?>" class="parent"><i class="material-icons">home</i> Accueil</a>
              </li>

              <?php if ( hasCredential('menu::admin') || hasCredential('menu::manager') ) : ?>
                <?php include '_menu_admin_manager.php'; ?>
              <?php endif; ?>

              <?php if (  !hasCredential('menu::admin') && !hasCredential('menu::manager')   ) : ?>

                  <?php if (hasCredential('menu::driver')) : ?>
                      <li class="parent <?php echo (ROUTE == 'transport/ride') ? 'active' : ''; ?>"><a href="<?= HOST; ?>transport/ride"> <i class="material-icons">directions_car</i>Trajet</a></li>
                  <?php endif; ?>
                  <li class="parent <?php echo (ROUTE == 'activity/display') ? 'active' : ''; ?>"><a href="<?= HOST; ?>activity/display"> <i class="material-icons">list_alt</i>Activité</a></li>
                  <li class="parent <?php echo (ROUTE == 'meal/list') ? 'active' : ''; ?>"><a href="<?= HOST; ?>meal/list"><i class="material-icons">list</i> Repas </a></li>
                  <li class="parent <?php echo (ROUTE == 'meal/add') ? 'active' : ''; ?>"><a href="<?= HOST; ?>meal/add"><i class="material-icons">add</i> Ajouter un repas </a></li>
                  <li class="parent <?php echo (ROUTE == 'vehicle/add-fuel') ? 'active' : ''; ?>"><a href="<?= HOST; ?>vehicle/add-fuel"><i class="material-icons">local_gas_station</i> Ajouter de l'essence </a></li>
                  <li class="parent <?php echo (ROUTE == 'vehicle/add-wash') ? 'active' : ''; ?>"><a href="<?= HOST; ?>vehicle/add-wash"><i class="material-icons">shower</i> Ajouter un lavage </a></li>
                  <li class="parent <?php echo (ROUTE == "booklet/list") ? 'active':'';  ?>"><a href="<?= HOST; ?>booklet/list"><i class="material-icons">list</i>Livrets</a></li>
                  <li class="parent <?php echo (ROUTE == "stock/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>stock/list" ><i class="material-icons">list</i> Etat </a></li>
                  <li  class="subitem <?php echo (ROUTE == "media/photoTake") ? 'active':'';  ?>"><a href="<?= HOST; ?>media/photoTake"> <i class="material-icons">camera</i>Prende une photo</a></li>
                  <li  class="subitem <?php echo (ROUTE == "media/serie") ? 'active':'';  ?>"><a href="<?= HOST; ?>media/serie"> <i class="material-icons">photo_library</i>Série de photo</a></li>


                <?php if (hasCredential('menu::challenge')) : ?>

                    <li style="cursor:pointer;" <?php echo (ROUTE_FIRST_ELEMENT == "challenge") ? 'class="active"' : '';  ?>>
                      <a style="cursor:pointer;" href="#" class="parent"><i class="material-icons">rocket_launch</i> Challenge</a>
                      <ul class="menu vertical sublevel-1">
                          <li class="subitem <?php echo (ROUTE == "foot-match/home") ? 'active':'';  ?>"><a href="<?= HOST; ?>challenge/home"><i class="material-icons">event_seat</i>Challengers</a></li>
                      </ul>
                      <ul class="menu vertical sublevel-1">
                          <li class="subitem <?php echo (ROUTE == "foot-match/home") ? 'active':'';  ?>"><a href="<?= HOST; ?>foot-match/home"><i class="material-icons">noise_aware</i>Foot</a></li>
                      </ul>
                  </li>

                <?php endif;?>



              <?php endif; ?>

              <br/><br/><br/><br/>

            </ul>
      
            <img src="<?= IMG; ?>energy-kids-academy.svg" class="imgMenu" />

          </div>
        </div>
        
        <div id="loadSpinnerDiv" style="opacity: 0.8; background-color: lightblue; color: white; z-index: 9999;  text-align: center; display: table; height: 100%; position: absolute; overflow: hidden; width: 100%;">
            <img src="<?= IMG; ?>loadSpinner3.gif" style="width: 50px; height: 50px; margin: 40% auto"/>
        </div>



        <div class="page__container">

        <?php endif; ?>

        <?php echo $contentPage; ?>

        </div>
      </div>
    </div>
    

    <div class="reveal" id="reveal-iframe" style="width: 100vw; height:100vh;" data-reveal>
      <button class="close-button" id="close-iframe-full" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>

      <iframe src="" class="frameFullScreen" style="width:100%; height:100%;"></iframe>
    </div>
    <button class="add-button" id="btnAdd" onclick="addToHome()"></button>


    <input type="hidden" id="urlSendSMSFactor" value="<?= HOST; ?>smsFactor/sendSms">
    <input type="hidden" id="urlSMS" value="<?= HOST; ?>sendSMS">
    <input type="hidden" id="urlPhoto" value="<?= HOST; ?>savePhoto">
    <input type="hidden" id="urlRequest" value="<?= HOST; ?>sendRequest">
    <input type="hidden" id="urlHost" value="<?= HOST; ?>">
    <input type="hidden" id="mapsApiKey" value="<?= MAPS_API_KEY; ?>">
    <input type="hidden" id="photoProfilDefault" value="<?= IMG; ?>no_photo.jpg">
    <input type="hidden" id="noPhoto" value="<?= IMG; ?>no_photo_2.jpg">
    <input type="hidden" id="tokenAuth" value="<?= TOKEN; ?>">
    <input type="hidden" id="urlApi" value="<?= API;?>" >


    <script src="<?= JS; ?>vendor/jquery.js"></script>
    <script src="<?= JS; ?>vendor/toast.min.js"></script>
    <script src="<?= JS; ?>vendor/what-input.js"></script>
    <script src="<?= JS; ?>vendor/mfb.min.js"></script>
    <script src="<?= JS; ?>vendor/foundation.js"></script>
    <script src="<?= JS; ?>app.js"></script>
    <?php if (IFRAME == 0) : ?>
      <script type="text/javascript">
        $(document).scroll(() => {
          let menuLeft = document.getElementsByClassName("menu__left")[0];
          let height = $(window).height() - 55;

          $(menuLeft).css("height", `${height}px`);
        });

        document.getElementsByClassName("menu_link")[0].addEventListener(
          "click",
          event => {
            let menuLeft = document.getElementsByClassName("menu__left")[0];

            if ($(menuLeft).css("margin-left") == "-300px") {
              $(menuLeft).animate({
                  marginLeft: "+=300px"
                },
                500
              );
            } else if ($(menuLeft).css("margin-left") == "0px") {
              $(menuLeft).animate({
                  marginLeft: "-=300px"
                },
                500
              );
            }
          },
          false
        );


        document.getElementsByClassName("closeLeftMenu")[0].addEventListener(
          "click",
          event => {


            let menuLeft = document.getElementsByClassName("menu__left")[0];


            if ($(menuLeft).css("margin-left") == "-260px") {
              $(menuLeft).animate({
                  marginLeft: "+=260px"
                },
                500
              );

              $(".container__menu__left").css("width", "300px");
              $(".page__container").css("width", "calc(100% - 350px)");
              $(".closeLeftMenu i").html("arrow_back");
            } else if ($(menuLeft).css("margin-left") == "0px") {

              if ($(window).width() < 1025) {

                $(menuLeft).animate({
                    marginLeft: "-=300px"
                  },
                  500
                );

              } else {


                $(menuLeft).animate({
                    marginLeft: "-=260px"
                  },
                  500
                );

                $(".closeLeftMenu i").html("arrow_forward");

                setTimeout(() => {
                  $(".container__menu__left").css("width", "40px");
                  $(".page__container").css("width", "calc(100% - 100px)");
                }, 500);

              }
            }
          },
          false
        );
      </script>
    <?php endif; ?>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
  <!--
    <script src="https://www.gstatic.com/firebasejs/6.2.3/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.2.3/firebase-messaging.js"></script>-->

    <!-- TODO: Add SDKs for Firebase products that you want to use
         https://firebase.google.com/docs/web/setup#config-web-app -->

    <script>
      var firebaseConfig = {
        apiKey: "AIzaSyAimHpaMBAoC03CTgRQisN2hFSLeb-IKtk",
        authDomain: "appli-v-1542366567784.firebaseapp.com",
        databaseURL: "https://appli-v-1542366567784.firebaseio.com",
        projectId: "appli-v-1542366567784",
        storageBucket: "appli-v-1542366567784.appspot.com",
        messagingSenderId: "924511921691",
        appId: "1:924511921691:web:9f512e71c60fc83c"
      };
/*      firebase.initializeApp(firebaseConfig);
      const messaging = firebase.messaging();
      messaging.usePublicVapidKey("BFOyvMrB1Sx14A6rhQCIxCZ4zujEBcC77X4u1CFdPG8rvkSYuUwqtY2SrU-FLCDzAiEZHE7cnddlfqrxssZd7pM");
      Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {} else {}
      });

      messaging.getToken().then((currentToken) => {
        if (currentToken) {
          setTokenSentToServer(currentToken);
        } else {

          console.log('No Instance ID token available. Request permission to generate one.');

          updateUIForPushPermissionRequired();
          setTokenSentToServer(false);
        }
      }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        console.log('Error retrieving Instance ID token. ', err);
        setTokenSentToServer(false);
      });


      messaging.onTokenRefresh(() => {
        messaging.getToken().then((refreshedToken) => {
          console.log('Token refreshed.');
          setTokenSentToServer(false);
          sendTokenToServer(refreshedToken);

        }).catch((err) => {});
      });
      messaging.onMessage((payload) => {
        toastr.success(JSON.stringify(payload.data));

      });

      const setTokenSentToServer = token => {
        if (token != false) {

          let requete = JSON.stringify({
            user_id: "<?= PERSON_CONNECTED['user_id'] ?? ''; ?>",
            device_id: token,
            datas: 'pwa'
          });

          $.ajax({
            url: '<?= API; ?>device/add/user',
            type: 'POST',
            contentType: "application/json",
            headers: {
              'Authorization': 'Bearer <?= TOKEN; ?>'
            },
            contentLength: requete.length,
            crossDomain: true,
            dataType: "json",
            data: requete,
            beforeSend() {},
            success(data) {


            },
            error(data) {}
          });



        }

      }*/
    </script>

    <?php
    // AUTLOAD FILES JS -> REDUCTION TEMPS CHARGEMENTS
    if (isset(FILES_ROUTE[ROUTE])) {
      foreach (FILES_ROUTE[ROUTE]['js'] as $item) {
        if ($item != '' && $item != 'google-maps') {
    ?>
          <script src="<?= JS; ?><?php echo $item; ?>"></script>
        <?php
        } elseif ($item == 'google-maps') {
        ?>
          <script src="https://maps.googleapis.com/maps/api/js?key=<?= MAPS_API_KEY; ?>&libraries=places"></script>
    <?php
        }
      }
    }
    ?>

    <!-- fastsearch --->
    <script>
      const closeFastSearchResult = () => {
        $('#fastSearchResult').hide();
      }

      $('.fastSearchChild').keyup(function() {
        let search = $(this).val();

        if (search.length > 2) {

          const regex = /'/gi;
          search = search.replace(regex, '27');

          let url = `child/fastsearch/${search}`;

          $.ajax({
            type: "POST",
            url: urlRequest,
            data: {
              url,
              type: "GET"
            },
            dataType: "json",
            beforeSend() {
              $('#fastSearchResult').show();
              $('#fastSearchResultContent').empty();

              console.log(url);
            },
            success(json) {

              const numberOfElements = json.length;

              if (numberOfElements > 0) {
                let line = "<ul>";
                for (i = 0; i < numberOfElements; i++) {
                  line += `<li style="list-style: none; border-bottom: 1px solid lightgrey; display: flex; justify-content: space-between;"> 
                                     
                                        <div style="padding-top: 10px; color: darkblue">
                                        #${json[i].id} - ${json[i].fullname}
                                        </div>
                                        <div>
                                          <a href="${urlHost}/child/display/id/${json[i].id}/">
                                          <i class="material-icons" style="font-size: 40px; margin-right: 20px;">face</i>
                                          </a>
                                          <a href="${urlHost}registration/add/id/${json[i].id}/">
                                          <i class="material-icons" style="font-size: 40px;">assignment_ind</i>
                                          </a>
                                          <a href="${urlHost}invoice/create/childId/${json[i].id}/">
                                          <i class="material-icons" style="font-size: 40px;">euro_symbol</i>
                                          </a>
                                        </div>
                                  </li>`;
                }
                line += "</ul>";
                $("#fastSearchResultContent").html(line);
              } else {
                $("#fastSearchResultContent").html(
                  "<p><strong><center>Aucun résultat.</center></strong></p>"
                );
              }
            }
          });
        }
      })


      $('document').ready(function() {
        $('#loadSpinnerDiv').hide();
      })


      // add notificationIcon


    </script>

    <?php  if(ROUTE == "app/home"):?>
      <script>
          $('#notificationBlock').show();
          let urlNotification = urlHost+"notification/list/personId/<?php echo PERSON_CONNECTED['personId']; ?>/";
          $('#notificationList').load(urlNotification);
          $('#notificationBell').click(function(){
              $('#notificationContainer').toggle();
          })
      </script>


    <?php endif;?>
</body>

</html>