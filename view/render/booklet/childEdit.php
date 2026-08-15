<?php
  use_helper('evaluation, translation, age');
  $bookletChild     = $params->bookletChild;
  $bookletChildPrev = $params->bookletChildPrev;
  $booklet      = $bookletChild->booklet;
  $child        = $bookletChild->child;
  $currentStaff = $bookletChild->staff;
  $navigation   = $params->navigation;
  $itemFormSum  = 0;
  $childFormSum = 0;
;?>
<!doctype html>
<html class="no-js" lang="fr" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <!--- manifest JSON --->   

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

  <title>Livret Enfant</title>
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
  <link rel="stylesheet" href="<?= CSS; ?>animate.css">

  <style>
    body { padding: 0 10px}
    .flexRow { display: flex; flex-wrap: wrap; justify-content: space-between}
    .buttonNavigation { background-color: darkblue; color: white; padding: 4px 8px; border-radius: 20px; cursor: pointer}
    .buttonNavigation:hover { background-color: darkred}
    a:hover {color: white}
    h2 { color: darkred}
    h1, h5 { color: darkblue}
    .formDiv { width: 180px}


    #finalValidation { border-radius: 0px; background-color: darkred; color: white; padding: 10px; width: 100%; border: 2px solid darkblue; cursor: pointer}

    li:hover { background-color: gainsboro; }

    textarea { border: 1px solid darkblue;}

    .rateIcon { cursor: pointer}
    .rateDefault { color: lightgrey}
    .rateChecked { color: darkblue}
    .hoverIconRate { color: #DFAF2C}

    #draftStatus i, #readyStatus i {  width: 30px; 
                                      height: 30px ; 
                                      border-radius: 50px;
                                      font-size: 18px;
                                      line-height: 30px;
                                      text-align: center;
                                      padding-left: 6px;
                                }
    #draftStatus i { background-color: darkred; color: white}
    #readyStatus i { background-color: green; color: white}

    .responsePrev .rateIcon { font-size: 14px}

    .responsePrev .rateChecked { color: darkred;}

    p.responsePrev { font-style: italic; color: darkred;font-size: 14px}

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }

    .texte-clignotant {
        animation: blinker 1s linear infinite;
    }

    @media screen and (min-width: 1200px) { 
          body { width: 1200px; margin: 0 auto; border: 1px solid darkblue }
      }


    @media screen and (max-width: 674px) { 
      .buttonNavigation { text-align: center}  
    }
  </style>



</head>

<body>

  <header>

    <div class="flexRow">

        <a href="<?= HOST ?>booklet/list">
          <i class="material-icons" style="cursor: pointer; color: darkblue">home</i>
        </a>
        <?php if($navigation):?>
          <div>
          <?= $navigation->totalBooklet;?> livrets : <?= $navigation->totalReady;?> prêt<?php if($navigation->totalReady>1) echo 's';?>  - <?= $navigation->totalToreread;?> à relire
          </div>
        <?php endif;?>

    </div>

    <div class="flexRow" id="navigationBar">

        <?php if($navigation && $navigation->prevBooklet->name != ""):?>
            <a href="<?= HOST ?>booklet/edit/id/<?php echo $navigation->prevBooklet->bookletId;?>/" class="buttonNavigation">
              &nbsp;&nbsp;< Fiche <?= $navigation->prevBooklet->name ;?>&nbsp;&nbsp;
            </a>
        <?php else:?>
            <div></div>
        <?php endif;?>

        <a href="<?= HOST ?>livret/energy/enfant/<?= encodeInt($bookletChild->id);?>/<?= sha1($child->firstname);?>" target="_blank">
          <i class="material-icons" style="cursor: pointer; color: darkred">visibility</i>
        </a>

        <?php if($navigation && $navigation->nextBooklet->name != ""):?>
                  <a href="<?= HOST ?>booklet/edit/id/<?php echo $navigation->nextBooklet->bookletId;?>/" class="buttonNavigation">
                    &nbsp;&nbsp;Fiche <?= $navigation->nextBooklet->name ;?>
                    >&nbsp;&nbsp;
                  </a>
        <?php else:?>
            <div></div>
        <?php endif;?>

    </div>
    <hr/>


    <div class="flexRow">
      <div>
        <h1><?= $child->fullname;?> </h1>
        <h2 id="bookletName"><?= $booklet->name;?></h2>
        <input type="hidden" id="childFirstname" value="<?= $child->firstname;?>"/>
        <input type="hidden" id="age" value="<?= showAge($child->birthdate);?>"/>
          <input type="hidden" id="gender" value="<?= $child->gender;?>"/>
      </div>
      <?php if($bookletChildPrev):?>
        <div>
            Livret précédent - Date évaluation : <?= showDate($bookletChildPrev->dateEvaluation);?>
            <br/>
            <input type="checkbox" checked = 'checked' id="showPreviousResultButton">&nbsp;&nbsp;<b>Voir les évaluation précédentes</b>

        </div>
      <?php endif;?>
      <div id="bookletStatus">

        <?= trans($bookletChild->status);?>

        <br/>
        <div id="<?= $bookletChild->status ;?>Status">
          <?php echo showEvaluationIconStatus($bookletChild->status);?>
        </div>
      </div>
    </div>



    <div class="flexRow">
        <div class="formDiv">
          Date d'évaluation
          <input type="date" name="date_evaluation" class="bookletChildForm" value="<?= $bookletChild->dateEvaluation ;?>">
        </div>

        <div class="formDiv">
          Evaluateur 
          <select name="staffId" class="bookletChildForm">
            <option/>
            <?php foreach($params->staffs as $staff):?>
              <?php if($staff->staffId == 70) continue;?>
              <option value="<?= $staff->staffId;?>" <?php if($staff->staffId == $currentStaff->staffId) echo 'selected' ;?>><?= $staff->fullname;?></option>
            <?php endforeach;?>
          </select>
        </div>

    </div>

    <hr/>

  </header>
  <main>
    
    <section class="flexRow">
        <div>
            <img src="<?= ('' != $child->photo) ? HOST.$child->photo : IMG.'no_photo.jpg'; ?>" />
        </div>
        <div>
            <div class="formDiv">
                Main directrice
                <select name="childHand" class="childForm">
                    <option/>
                      <option value="right" <?php if($child->childHand == "right") echo 'selected' ;?>>Droite</option>
                      <option value="left" <?php if($child->childHand == "left") echo 'selected' ;?>>Gauche</option>
                      <option value="both" <?php if($child->childHand == "both") echo 'selected' ;?>>Ambidextre</option>
                      <option value="unknown" <?php if($child->childHand == "unknown") echo 'selected' ;?>>Indéterminée</option>
                </select>
                <?php $childFormSum++;?>
            </div>

            <div class="formDiv">
                Pied directeur
                <select name="childFoot" class="childForm">
                    <option/>
                      <option value="right" <?php if($child->childFoot == "right") echo 'selected' ;?>>Droit</option>
                      <option value="left" <?php if($child->childFoot == "left") echo 'selected' ;?>>Gauche</option>
                      <option value="both" <?php if($child->childFoot == "both") echo 'selected' ;?>>Ambidextre</option>
                      <option value="unknown" <?php if($child->childFoot == "unknown") echo 'selected' ;?>>Indéterminé</option>
                </select>
                <?php $childFormSum++;?>
            </div>

            <div class="formDiv">
                Oeil directeur
                <select name="guidingEye" class="childForm">
                    <option/>
                      <option value="right" <?php if($child->guidingEye == "right") echo 'selected' ;?>>Droit</option>
                      <option value="left" <?php if($child->guidingEye == "left") echo 'selected' ;?>>Gauche</option>
                      <option value="unknown" <?php if($child->guidingEye == "unknown") echo 'selected' ;?>>Indéterminé</option>
               </select>
               <?php $childFormSum++;?>

            </div>


            <div class="formDiv">
                Profil Sportif
                <select name="sportifProfil" class="childForm">
                    <option/>
                      <option value="aerien" <?php if($child->sportifProfil == "aerien") echo 'selected' ;?>>Aérien</option>
                      <option value="terrien" <?php if($child->sportifProfil == "terrien") echo 'selected' ;?>>Terrien</option>
                </select>
                <?php $childFormSum++;?>

            </div>

        </div>

    </section>

    <hr/>


    <section>
        <div>
          <?php foreach($booklet->boards as $k => $board):?>

              <h5><?= $board->name;?></h5>

              <ul class="allItems">
              <?php foreach($board->response as $l => $response):?>

                <li class="flexRow">
                  <span><?php echo ucfirst($response->item->name);?></span>
                  <span>
                      <?php showScaleBar($response->item, $response->answer, 5);?>

                      <?php if($bookletChildPrev):?>
                        <br/>
                          <?php $responsePrev = $bookletChildPrev->booklet->boards[$k]->response[$l];?>
                          <span class="responsePrev">
                            <?php showScaleBar($responsePrev->item, $responsePrev->answer, 5, true);?>
                        </span>
                      <?php endif;?>
                  </span>
                </li>
                <?php $itemFormSum++;?>
              <?php endforeach;?>
              </ul>

          <?php endforeach;?>

        </div>
    </section>

    <hr/>

    <section>
        Commentaire du coach
        <textarea id="currentComment" rows="8" cols="50" class="bookletChildForm" name="comment"><?= $bookletChild->comment;?></textarea>

        <?php if($bookletChildPrev):?>
            <p class="responsePrev">
              <b>Commentaire précédent</b><br/>
                <div id="commentPrev">
                  <?= $bookletChildPrev->comment;?>
            </div>
            </p>
          <?php endif;?>
        <br/><br/>

        <?php if( hasCredential('booklet::returnDraft')) :?>
            <span class="" id="createComment" style="border-bottom: 1px solid darkblue; cursor: pointer">En manque d'inspiration ? ... clique ici.</span>
            <div id="commentResult" style="color: darkblue; font-style: italic">

            </div>
        <?php endif;?>

        <br/><br/>
    </section>

    <section>
      <?php if($bookletChild->status == "draft")     { $from = "draft"; $to = "toreread" ;};?>
      <?php if($bookletChild->status == "toreread")  { $from = "toreread"; $to = "ready" ;};?>
      <?php if($bookletChild->status == "ready")     { $from = "ready"; $to = "published" ;};?>
      <?php if($bookletChild->status == "published") { $from = "published"; $to = "archived" ;};?>

      <i style="font-size: 12px">
          Les données sont enregistrées automatiquement.<br/>
      </i>
      <br/>
      <input type="checkbox" id="validationPass">&nbsp;&nbsp;<b>Cliquez sur ce bouton pour passer la fiche de "<?= trans($from) ;?>" à "<?= trans($to) ;?>" </b>
      <br/><br/>

      <?php if( hasCredential('booklet::returnDraft') || $from == "draft" || $from=="ready"):?>
          <button id="finalValidation" data-from="<?= $from ;?>" data-to="<?= $to ;?>">
              Passer la fiche de "<?= trans($from) ;?>" à "<?= trans($to) ;?>"
          </button>
          <br/><br/>
      <?php endif;?>

      <?php if( hasCredential('booklet::toReady') && $from == "published"):?>
          <br/><br/>         
          <button id="returnDraft" class="button" data-from="<?= $from ;?>" data-to="draft" style="background-color: lightblue; color: black">
              Remettre la fiche en "<?= trans('draft') ;?>"
          </button>
          <br/><br/>
      <?php endif;?>
    </section>

  </main>

  <footer>

  </footer>



  <input type="hidden" id="urlRequest" value="<?= HOST; ?>sendRequest">
  <input type="hidden" id="urlHost" value="<?= HOST; ?>">
  <input type="hidden" id="tokenAuth" value="<?= TOKEN; ?>">
  <input type="hidden" id="urlApi" value="<?= API;?>" >

  <input type="hidden" id="bookletChilId" value="<?= $bookletChild->id;?>"/>
  <input type="hidden" id="childId" value="<?= $child->childId;?>"/>

  <input type="hidden" id="totalChildForm" value="<?= $childFormSum ?>"/>
  <input type="hidden" id="totalItemForm" value="<?= $itemFormSum ?>"/>

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