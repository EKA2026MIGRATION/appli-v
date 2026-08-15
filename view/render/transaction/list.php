<?php $title="Présences du personnel"; ?>

<div class="text-center">
  <h1>

    <a href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>transaction/list/week/<?php echo date('W', strtotime('-1 week', strtotime($params->date))) ?>/year/<?php echo date('Y', strtotime('-1 week', strtotime($params->date))) ?>/')">
      <i class="material-icons" class="chevron_left_calendar">chevron_left</i>
    </a> Semaine <?= $params->week; ?> - <?= $params->year; ?>


    <a  href="javascript:void(0)" onclick="locationRedirect('<?= HOST; ?>transaction/list/week/<?php echo date('W', strtotime('+1 week', strtotime($params->date))) ?>/year/<?php echo date('Y', strtotime('+1 week', strtotime($params->date))) ?>/')">
      <i class="material-icons" class="chevron_right_calendar">chevron_right</i>
    </a>

  </h1>

</div>
<div class="tableScrollable">
  <table>
      <thead>
          <tr>
            <?php foreach ($params->transactions as $transaction): ?>
              <th><?= $transaction['day']; ?></th>
            <?php endforeach; ?>
          </tr>
      </thead>
      <tbody>
         <tr>
        <?php foreach ($params->transactions as $transaction): ?>
          <td style="vertical-align:top;">
            <table>
              <?php foreach ($transaction['transaction'] as $transac): ?>
      
                <tr>
                  <td style="cursor:pointer;" data-open="reveal-transaction<?= $transac->transactionId; ?>">
                    N°<?= $transac->internalOrder; ?><br/>
                    <?= $transac->amount; ?>€ <br/>   

                    <div class="reveal" id="reveal-transaction<?= $transac->transactionId; ?>" data-reveal>

                      <h2 class="text-center"><?= $transac->internalOrder; ?></h2>
                      <h3 class="text-center"><?= $transac->amount; ?>€</h3>


                      <section class="block-list">
                        <ul id="transactionList">    
                          <?php foreach($transac->registrations as $registration):?>
                            <li data-id-registration="<?= $registration->registrationId; ?>">
                              <a href="<?= HOST ?>registration/display/id/<?= $registration->registrationId; ?>/">
                                <div>
                                  <p class="list-header">
                                    <img src="<?= ("" != $registration->child->photo) ? HOST.$registration->child->photo : IMG.'no_photo.jpg';  ?>" class="width-30 height-30" />

                                  <?= date('d/m/Y', strtotime($registration->registration)); ?> - <?= $registration->status; ?> - Commande par <?= $registration->person->firstname; ?> <?= $registration->person->lastname; ?> pour  <?= $registration->child->firstname; ?> <?= $registration->child->lastname; ?>

                                    <div class="with-icon">
                                      <i class="material-icons">edit</i>
                                    </div>
                                  </p> 
                                </div>
                              </a>
                            </li>
                          <?php endforeach; ?>

                        </ul>
                      </section>

                    </div>

                  </td>
                </tr>
              <?php endforeach; ?>
            </table>
          </td>
        <?php endforeach; ?>
        </tr>
      </tbody>

      <tfoot>
         <tr>
        <?php 
        $totalAmount = 0;
        foreach ($params->transactions as $transaction): ?>
          <th style="vertical-align:top;">
            <?php
              $dayAmount = 0;
              foreach ($transaction['transaction'] as $transac):
                $dayAmount += $transac->amount;
                $totalAmount += $transac->amount;
              endforeach;
                echo $dayAmount."€"; 
            ?>
          </th>
        <?php endforeach; ?>
        </tr>
      </tfoot>

  </table>
</div>

<h3 class="text-center">Total semaine:  <strong><?= $totalAmount; ?>€ </strong></h3>

<input type="hidden" id="lastIdTransaction">
<input type="hidden" id="dateCalendar" value="<?= $params->date; ?>">