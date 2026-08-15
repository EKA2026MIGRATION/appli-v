<?php use_helper('buttons');?>


<style>
  #invoiceList p { display: flex; justify-content: space-between}
  #invoiceList div { color: darkblue!important}
  .infoCreation { font-size: 0.7rem; font-style: italic; color: black!important}
  #invoiceList div > span { font-weight: bold}

  #ui-datepicker-div {
      z-index: 999!important
  }
</style>
<?php use_helper('dates');?>
<?php $title = "Facture"; ?>

<h1>Liste des factures</h1>


<?php include('_invoices.php');?>
