<div class="reveal" id="createSurvey" data-reveal>
  <p class="lead">Sondage </p>

  <div class="containerLoader displayNone" id="loaderFormEditVehicle" ><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>

  <form method="post" id="vehicleForm" action="vehicle/create">
    <input type="hidden" name="photo" id="photoUrl" value="" />
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div class="medium-12 cell">
          <label>Titre du sondage *
            <input type="text" name="title" placeholder="Titre du sondage" required>
          </label>
        </div>
        <div class="medium-12 cell">
          <select name="type" required>
            <option value="0">Choisir un type de sondage</option>
          </select>  
        </div>  
        <div class="medium-12 cell">  
          <fieldset class="fieldset" style="margin:auto; width: 100%;"><legend><a class="button" href="javascript:void(0)">Ajouter la question </a></legend> 
          <div class="medium-12 cell">
            <label>Intitulé de la question *
              <input type="text" name="title" placeholder="La question" required>
            </label>
          </div>
          <div class="medium-12 cell">
            <div class="rating-block">
              <p class="ratings-type">Note maximal*</p>
              <div class="rating-block-rating" data-rating>
                <div class="star">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="37" viewBox="0 0 40 37">
                    <polygon fill="none" points="272 30 260.244 36.18 262.489 23.09 252.979 13.82 266.122 11.91 272 0 277.878 11.91 291.021 13.82 281.511 23.09 283.756 36.18" transform="translate(-252)"/>
                  </svg>
                </div>
                <div class="star">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="37" viewBox="0 0 40 37">
                    <polygon fill="none" points="272 30 260.244 36.18 262.489 23.09 252.979 13.82 266.122 11.91 272 0 277.878 11.91 291.021 13.82 281.511 23.09 283.756 36.18" transform="translate(-252)"/>
                  </svg>
                </div>
                <div class="star">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="37" viewBox="0 0 40 37">
                    <polygon fill="none" points="272 30 260.244 36.18 262.489 23.09 252.979 13.82 266.122 11.91 272 0 277.878 11.91 291.021 13.82 281.511 23.09 283.756 36.18" transform="translate(-252)"/>
                  </svg>
                </div>
                <div class="star">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="37" viewBox="0 0 40 37">
                    <polygon fill="none" points="272 30 260.244 36.18 262.489 23.09 252.979 13.82 266.122 11.91 272 0 277.878 11.91 291.021 13.82 281.511 23.09 283.756 36.18" transform="translate(-252)"/>
                  </svg>
                </div>
                <div class="star">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="37" viewBox="0 0 40 37">
                    <polygon fill="none" points="272 30 260.244 36.18 262.489 23.09 252.979 13.82 266.122 11.91 272 0 277.878 11.91 291.021 13.82 281.511 23.09 283.756 36.18" transform="translate(-252)"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <fieldset class="fieldset" style="margin:auto; width: 100%;"><legend><a class="button" href="javascript:void(0)">Ajouter le badge </a></legend> 
            <div class="medium-12 cell">
              <label>Titre du badge *
                <input type="text" name="title" placeholder="Ex : super conducteur" required>
              </label>
            </div>

            <div class="medium-12 cell flexEvenly">

              <?php foreach($params->icons as $icon):
                    if(strlen($icon) > 3): ?>
                    <div class="radioImg">
                      <label>
                        <input type="radio" name="icon" value="<?= $icon; ?>" onclick="addClass(this)"> 
                        <img src="<?= IMG.'icons/'.$icon; ?>">
                      </label>
                    </div>
                <?php endif;
                endforeach ;?>


            </div>
          </fieldset>


          </fieldset>
        </div>


        <div class="medium-12 cell" style="margin-top: 20px;">
          <center><button type="submit" class="button">Envoyer </button></center>
        </div>
      </div>
    </div>
  </form>

  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
  <p>* champ obligatoire</p>
</div>
