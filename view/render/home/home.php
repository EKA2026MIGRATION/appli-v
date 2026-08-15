<?php $title = "Dashboard - Energy Academy"; ?>
<?php (isset($params->currentDashboard)) ? $currentDash = $params->currentDashboard : $currentDash = "Operationnel"?>
<input type="hidden" id="currentDashboard" value="<?= $currentDash;?>"/>
<?php include_once(HELPER.'dates.php');?>

<script>
    let totalInvoiceDay, myPriceDate, totalInvoiceWeek, showDateColButtonInvoices;
    let totalInvoiceHt, totalInvoiceTtc, totalInvoiceVat10, totalInvoiceVat20, totalInvoiceTva, detailsInvoiceLineTva;
    let totalWeekHt, totalWeekVat10, totalWeekVat20, totalWeekTva, detailsInvoiceLineTvaWeek;
</script>

<h1>DashBoard</h1>

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

<div class="text-center">
  <?php if(hasCredential('dashboard::transportRealTime')):?>
    <a href="<?= HOST;?>transport/supervision/date/" id="gotToSupervision" target="_blank">
      <button class="button">
       <i class="material-icons" style="font-size: 40px">emoji_transportation</i>
       </button>
    </a>    
  <?php else:?>
    <!--
    <a href="<?= HOST; ?>staff/resume/id/<?= PERSON_CONNECTED['personId'];?>/">
      <button class="button">Synthèse</button>
    </a>-->
    <a href="<?= HOST; ?>transport/ride">
      <?php ( PERSON_CONNECTED['personId'] == "4") ? $text = "THE BOSS" : $text = "TRANSPORT";?>
      <button class="button"><?= $text;?></button>
    </a>
  <?php endif;?>
</div>

<?php include('_realTimeTransport.php');?>

<?php if ($params->reminders != null && count((array) $params->reminders) > 0) : ?>
  <?php include('_reminder.php');?>
<?php endif;?>

<?php if(isset($params->stockAlert)):?>
    <?php if($params->stockAlert != null && count(array($params->stockAlert)) > 0):?>
        <div style=" margin: 0 auto; text-align: center">
            <b id="showProductAlert" style="cursor: pointer">Certains produits du stock sont manquants - voir la liste</b
        </div>
        <br/>&nbsp;<br/>
        <div id="listStockAlert" style="display: none">
            <?php include VIEW . 'render/stock/order.php';?>
        </div>
    <?php endif;?>
<?php endif;?>

<ul id="dashboardMenuLi">
  <li data-dash="Operationnel" class="liButtonMenu" id="buttonOperationnel">
    <i class="material-icons">group_work</i>
    <div class="textButtonMenu">Opérationnel</div>
  </li>
  <li data-dash="Club" class="liButtonMenu" id="buttonClub">
    <i class="material-icons">house</i>
    <div class="textButtonMenu">Club</div>
  </li>
  <?php if(hasCredential('dashboard::task')):?>
    <li data-dash="Task" class="liButtonMenu" id="buttonTask">
      <i class="material-icons">build</i>
      <div class="textButtonMenu">Tâches</div>
    </li>
  <?php endif;?>
  <?php if(hasCredential('dashboard::registration')):?>
    <li data-dash="Registration" class="liButtonMenu" id="buttonRegistration">
      <i class="material-icons">receipt</i>
      <div class="textButtonMenu">Inscription</div>
    </li>
  <?php endif;?>
  <?php if(hasCredential('dashboard::transaction')):?>
    <li data-dash="Transaction" class="liButtonMenu" id="buttonTransaction">
      <i class="material-icons">euro</i>
      <div class="textButtonMenu">Transaction</div>
    </li>
  <?php endif;?>
</ul>

<div id="dashboardContent"></div>

<?php if(1 == 0):?>

    <div class="">
      <section class="title bg-silver black">AGENDA</section>
      <section class="block-list expandable">
        <center><iframe src="https://calendar.google.com/calendar/embed?src=sandy%40energyacademy.fr&ctz=Europe%2FParis" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe></center>
      </section>
    </div>

<?php endif;?>


<script>
    document.getElementById('showProductAlert').addEventListener('click', function() {
        let stockAlertDiv = document.getElementById('listStockAlert');
        if (stockAlertDiv.style.display === 'none' || stockAlertDiv.style.display === '') {
            stockAlertDiv.style.display = 'block';
        } else {
            stockAlertDiv.style.display = 'none';
        }
    });

</script>