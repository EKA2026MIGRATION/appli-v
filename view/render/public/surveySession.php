<!doctype html>
<html class="no-js" lang="fr" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0, minimal-ui">

  <title>Sondage Energy Kids Academy</title>
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

<?php 
  $surveySession = $params->surveySession;
  use_helper('dates, evaluation');
;?>
</head>

<body>

  <header>
    <img id="logo" src="<?= IMG;?>energy-kids-academy.svg"/>
    <div>
      <h1>ENERGY KIDS ACADEMY</h1>
      On a tout le temps de grandir
    </div>
  </header>
  <hr/>

  <main id="mainContent">
      <div class="intro">
        <?php if('' != $surveySession->child->photo):?>
          <div class="photoProfil">
            <img src="<?= ('' != $surveySession->child->photo) ? HOST.$surveySession->child->photo : IMG.'no_photo.jpg'; ?>" />
        </div>
        <br/>
        <?php endif;?>
        <div class="childName">M.Mme <?= $surveySession->person->firstname;?> <?= $surveySession->person->lastname;?></div>
        <?php if($params->message == "updated"):?>
          Merci d'avoir pris le temps de répondre<br/>
          à ce sondage sur<br/>
        <?php elseif($params->status == "answered"):?>
          Voici les informations sur

        <?php else:?>
            Aidez-nous à progresser !
            <br/><br/>
            Donnez-nous votre avis sur<br/>   
        <?php endif;?>

        la journée du <?= showDate($surveySession->childPresence->date, ' l d F');?><br/>
        que <span class="childName"><?= $surveySession->child->firstname;?></span> a passée avec nous.
      
      
      
      </div>

      <form action="<?= HOST;?>survey/session/assigned/<?= encodeInt($surveySession->id); ?>/" method="POST"/>


          <input type="hidden" name="update" value="update"/>

          <?php $i = 0; foreach($surveySession->survey->chapters as $chapter):?>

                <div class="chapterName"><?= $chapter->name;?></div> 
                <br/>
                <div class="chapterDescription">
                  <?= $chapter->description;?>
                </div>
                <br/>
                <ul>
                  <?php foreach($chapter->questions as $question):?>
                    <li>
                        <?= $question->name;?>
                        <div class="rateiconBar">
                          <?php $questionId = $question->id;?>
                          <?php if( isset($surveySession->answers->$questionId) ){ $note = $surveySession->answers->$questionId ;} else { $note = 0;};?>
                          <?php $answer = ['id' => $question->id, 'answer' => $note]; ;?>
                          <?php showScaleBar(null, (object)$answer, 5);?>
                          <input type="hidden" id="questionId-<?= $question->id;?>" name="questionsId[<?= $question->id;?>]" value="<?= $note;?>"/>
                          <input type="hidden" id="questionStaff-<?= $question->id;?>" name="questionTypeNote[<?= $chapter->type ;?>][]" value="<?= $note;?>"/>
                        </div>
                    </li>
                    <?php $i++;?>
                  <?php endforeach;?>
                </ul>

          <?php endforeach;?>
          <br/>
          <br/>
          <?php if($params->activeForm == "active"):?>
            <div style="text-align: center">
              <button class="button" id="validForm">ENVOYER</button>
            </div>
            <br/><br/><br/><br/>
          <?php endif;?>
      </form>
  </main>

  <script>
    let activeForm = "<?= $params->activeForm ;?>";
  </script>

  <input type="hidden" id="urlRequest" value="<?= HOST; ?>sendRequest">
  <input type="hidden" id="urlHost" value="<?= HOST; ?>">
  <input type="hidden" id="tokenAuth" value="<?= TOKEN; ?>">
  <input type="hidden" id="urlApi" value="<?= API;?>" >

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