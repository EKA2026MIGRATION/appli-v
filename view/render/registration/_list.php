<?php use_helper('dates');?>
<?php if(!isset($currentRegistrations)) $currentRegistrations = $params->registrations;?>
<?php if(!isset($lightView)) $lightView = 1;?>

<style>
  .aRegistration { padding: 0px!important}


    #showInvoice {
        position: absolute;
        z-index: 99;
        background-color: white;
        border: 3px solid #182d61;
        border-radius: 10px;
        padding: 20px;
        width: 80%;
    }


</style>

<div id="showInvoice" style="display:none">
</div>


<ul id="registrationList">   

    <?php foreach($currentRegistrations as $registration):?>

      <?php  (!isset($registration->product->productId)) ? $product = null : $product = $registration->product;?>

      <li data-id-registration="<?= $registration->registrationId; ?>">
      <!--
        <input  class="checkbox-registration" 
                type="checkbox" 
                style="position: relative; left: 0px"
                value='checkbox-childPresence-<?= $registration->registrationId ?>' 
                />
    -->

        <a class="aRegistration" href="javascript:void(0)" onclick="getIdRegistration('<?= $registration->registrationId;?>','<?= $registration->invoice; ?>')" data-open="action-registration">
          <div>
            <p class="list-header">
                <span style="color: darkblue"><?php if($product) echo strip_tags($registration->product->nameFr);?></span>
                -  <b><?= $registration->child->lastname; ?> <?= $registration->child->firstname; ?></b>
                <!-- add sessins dates --->
                <?php if($registration->sessions ):?>
                  <?php foreach($registration->sessions as $session):?>
                        <?php $currentResult =  showDate($session->date).' <span style="font-size:10px; color: black">';?>
                      
                        <?php  if(isset($session->start)) { $currentResult .= showHour($session->start);}?>
                        <?php  if(isset($session->end)) { $currentResult .= ' '.showHour($session->end);}?>

                        <?php $currentResult .= "</span>";?>

                        
                        <?php $result[] = $currentResult;?>
                  <?php endforeach;?>
                  <?php echo '<br/>'.implode(' | ', $result); unset($result)?>
                <?php endif;?>
                
                <span style="color: darkblue">
                  <?php if($registration->sports ):?>
                    <?php foreach($registration->sports as $sport):?>
                          <?php $result[] = $sport->name;?>
                    <?php endforeach;?>
                    <?php echo implode(' | ', $result); unset($result)?>
                  <?php endif;?>
                </span>

                <?php if(!$lightView):?>
                    <br/>
                    <?php if($product):?>
                        <?php ($registration->product->isDateSelectable == false) ?  $arrayDates = $registration->product->dates : $arrayDates = $registration->sessions?>
                        <?php $datesLine = []; foreach($arrayDates as $date):?>
                            <?php (isset($date->date)) ? $myDate = $date->date : $myDate = $date;?>
                            <?php $datesLine[$myDate] = showDate($myDate);?>
                        <?php endforeach;?>
                        <?php sort($datesLine);?>
                        <span style="font-size: 10px;">
                          <?php echo implode(' | ', $datesLine);?>
                        </span>
                        <br/>
                    <?php else :?>
                        Pas de produit trouvé !!
                    <?php endif;?>
                  
                    <span style="color: black; font-size: 12px">
                        <?= $registration->location->name;?> -
                        <?php foreach($registration->sports as $sport):?>
                            <?= $sport->name;?>
                        <?php endforeach;?>
                    </span>
                <?php endif;?>
                <br/>
                <span style="color: black; font-style: italic; font-size: 10px">
                    Effectuée le <?= showDate($registration->registration); ?>
                    par <?= $registration->person->firstname; ?> <?= $registration->person->lastname; ?>
                </span>
                - 
                <?php ($registration->status == "payed") ? $style = "color: black; font-size: 10px" : $style = "font-size: 10px" ;?>
                <span style="<?= $style;?>">
                <?= ucfirst($registration->status); ?> - 
                  Montant payé : <?= (null != $registration->payed)? $registration->payed : '0' ; ?>€
                </span>
                <div class="with-icon">
                    <i class="material-icons">edit</i>
                </div>
            </p> 
          </div>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>