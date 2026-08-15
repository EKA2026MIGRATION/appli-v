
        <div class="tabs-panel is-active" id="panel1">
          <?php if(strlen($params->person->email) > 3): ?>


          <div data-closable class="callout alert-callout-subtle info">
            <strong>Information !<br></strong> Cet utilisateur est l'utilisateur principal du compte. Cliquez sur "Afficher" à droite de l'email pour afficher son profil utilisateur et toutes les personnes associées.
            <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
              <span aria-hidden="true">⊗</span>
            </button>
          </div>


            <div id="email_block">
                <div class="card-wrap horizontal">
                    <div class="card-img-container">
                        <figure>
                            <i class="material-icons">email</i>
                        </figure>
                    </div>

                    <div class="card-info">
                        <div class="card-primary with-second">
                            <figure>
                                <p class="card-title">Email du compte</p>
                                <p><?=$params->person->email; ?> </p>
                            </figure>
                        </div>

                        <div class="card-secondary">
                            <a href="<?= HOST ?>user/modify/id/<?= $params->person->identifier; ?>/"><span><i class="material-icons">mode_edit</i></span> Modifier</a>
                            <a href="<?= HOST ?>user/display/id/<?= $params->person->identifier; ?>/"><span><i class="material-icons">arrow_right</i></span> Afficher</a>
                        </div>

                    </div>
                </div>
            </div>
          <?php endif; ?>


            <div class="flex space-arround">

                <?php foreach($params->person->relations as $relation):?>
                    <div class="card-ea-profil">

                        <div class="card-banner">
                            <div class="card-profile" style="background-image: url('<?= ($relation->photo != "") ? HOST.$relation->photo : IMG.'no_photo.jpg';  ?>');">
                            </div>
                            <h3><?= $relation->firstname.' '.$relation->lastname; ?> </h3>
                            <aside>
                                <a href="<?= HOST ?>person/display/id/<?= $relation->personId; ?>/">Afficher le profil</a>
                            </aside>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>




        </div>
