<?php use_helper('translation');?>
<?php use_helper('dates');?>

<style>
  section.title { min-height: 50px; height: auto}
</style>

<div class="masonry-css">

<!--
        <div class="masonry-css-item">
          <div class="block-stats white bg-blue">
            <aside class="title">Inscription aujourd'hui</aside>
            <aside class="number"><?= $params->caDay; ?> €</aside>
          </div>
        </div>

        <div class="masonry-css-item">
          <div class="block-stats white bg-olive">
            <aside class="title">Inscription ce mois</aside>
            <aside class="number"><?= $params->caMonth; ?> €</aside>
          </div>
        </div>-->

        <div class="masonry-css-item">
          <section class="title bg-silver black">10 dernières inscriptions </section>
          <section class="block-list expandable">
            <ul>
                  <?php foreach($params->registrations as $registration):?>

                    <?php if(is_object($registration)):?>


                      <?php if($registration->status == "delete") continue;?>

                      <li>
                        <a href="<?= HOST ?>registration/display/id/<?= $registration->registrationId ;?>/" >
                          <div>
                            <p class="list-header">
                              <?php if(isset($registration->person->firstname)):?>
                                <?= date('d/m/Y H:i', strtotime($registration->createdAt)); ?> - <?= $registration->child->firstname; ?> <?= $registration->child->lastname; ?>
                                  <div style="color: black; font-weight: bold;"><?= strip_tags($registration->product->nameFr); ?></div>
                                  <div style="font-size: 14px; color: darkblue">
                                      <?php foreach($registration->sports as $sport):?>
                                          <?php $arr[] = $sport->name;?>
                                      <?php endforeach;?>
                                      <?php if(isset($arr)):?>
                                        <?php echo implode(' | ', $arr); unset($arr);?>
                                      <?php endif;?>
                                        - 
                                      <?php if($registration->sessions):?>
                                        <?php foreach($registration->sessions as $session):?>
                                            <?php $arr[] = showDate($session->date, 'd/m').' <span style="font-size:10px; color: black">'.showHour($session->start).' '.showHour($session->end).'</span>';?>
                                        <?php endforeach;?>
                                        <?php echo implode(' | ', $arr); unset($arr);?>
                                      <?php endif;?>

                                  </div>
                                  <i style="font-size: 12px"><?= trans($registration->status); ?> - <?= $registration->person->firstname; ?> <?= $registration->person->lastname; ?></i>
                              <?php else:?>
                                  <span style="color: red; font-style: italic">Vérifier l'inscription <?= $registration->registrationId;?> _ impossible de retrouver le commanditaire</span>
                              <?php endif;?>
                              <div class="with-icon">
                                <i class="material-icons">send</i>
                              </div>
                            </p>
                          </div>
                        </a>
                      </li>
                    <?php endif;?>
                  <?php endforeach ?>

            </ul>
          </section>
        </div>

        <div class="masonry-css-item">
          <section class="title bg-silver black">100 dernières connexions</section>
          <section class="block-list expandable">
            <ul>
                  <?php foreach($params->historicActions as $action):?>
                    <li>
                      <span class="content">
                        <div>
                          <p class="list-header">

                            <?= showDate($action->createdAt->date, 'd/m/Y H:i');?>
                            <b><?= $action->person ;?></b>


                            <div class="with-icon">
                              <i class="material-icons">send</i>
                            </div>
                          </p>
                        </div>
                      </span>
                    </li>
                  <?php endforeach ?>
            </ul>
          </section>
        </div>

        <div class="masonry-css-item">
          <section class="title bg-silver black">Transactions non abouties</section>
          <section class="block-list expandable">
            <ul>
                  <?php foreach($params->transactions_failed as $transaction):?>
                    <li>
                      <span class="content">
                        <div>
                          <p class="list-header">
                                <?= date('d/m/Y H:i', strtotime($transaction->date)); ?> - <?= trans($transaction->status); ?><br/>
                                <b><?= $transaction->amount; ?> €</b> par 
                                <?php if(isset($transaction->invoice)):?>
                                  <?= $transaction->invoice->nameFr;?>
                                <?php else:?>
                                  // 
                                <?php endif;?>

                                <?php if(!isset($transaction->registrations[0])):?>
                                    <br/>
                                    <span style="color: red; font-style: italic; font-size: 13px">Pb sur Transaction id #<?= $transaction->transactionId;?><span>
                                <?php endif;?>
                                <br/>

                            <div class="with-icon">
                              <i class="material-icons">send</i>
                            </div>
                          </p>
                        </div>
                      </span>
                    </li>
                  <?php endforeach ?>

            </ul>
          </section>
        </div>


        <!--
        <div class="masonry-css-item">
          <section class="title bg-silver black">Les dernières transactions du mois</section>
          <section class="block-list expandable">
            <ul>
                  <?php foreach($params->transactions as $transaction):?>


                    <li>
                      <span class="content">
                        <div>
                          <p class="list-header">
                                <?= date('d/m/Y H:i', strtotime($transaction->date)); ?> - <?= trans($transaction->status); ?><br/>
                                <b><?= $transaction->amount; ?> €</b> par 
                                <?php if(isset($transaction->invoice)):?>
                                  <?= $transaction->invoice->nameFr;?>
                                <?php else:?>
                                  // 
                                <?php endif;?>
                            <div class="with-icon">
                              <i class="material-icons">send</i>
                            </div>
                          </p>
                        </div>
                      </span>
                    </li>
                  <?php endforeach ?>

            </ul>
          </section>
        </div>-->


        <div class="masonry-css-item">
          <section class="title bg-silver black">Les réservations en cours</section>
          <section class="block-list expandable">
            <ul>
                  <?php foreach($params->registrationCarts as $registration):?>
                    <li>
                      <span class="content">
                        <div>
                          <p class="list-header">
                                <?= date('d/m/Y H:i', strtotime($registration->createdAt)); ?> - <?= $registration->child->fullname; ?><br/>
                                <b><?= strip_tags($registration->product->nameFr); ?></b>
                                <?php if(isset($registration->sessions)):?>
                                    <?php foreach($registration->sessions as $session):?>
                                        <?php $dates[] = showDate($session->date);?>
                                    <?php endforeach;?>
                                    <?php echo implode(' | ', $dates);?>
                                    <?php unset($dates);?>
                                <?php endif;?>
                            <div class="with-icon">
                              <i class="material-icons">send</i>
                            </div>
                          </p>
                        </div>
                      </span>
                    </li>
                  <?php endforeach ?>

            </ul>
          </section>
        </div>

      

</div>
