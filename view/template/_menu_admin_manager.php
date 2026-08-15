<li style="cursor:pointer;" <?php echo (ROUTE == "dashboard/previsionnel") ? 'class="active"' : '';  ?>>
  <a style="cursor:pointer;" href="<?= HOST; ?>dashboard/previsionnel" class="parent"><i class="material-icons">view_in_ar</i>Prévisionnel</a>
</li>

<?php if(hasCredential('child::searchAll')):?>

    <li style="cursor:pointer;" <?php echo (ROUTE_FIRST_ELEMENT == "child") ? 'class="active"' : '';  ?>>
      <a style="cursor:pointer;" href="#" class="parent"><i class="material-icons">child_care</i> Enfants</a>

      <ul class="menu vertical sublevel-1">
        <li class="subitem <?php echo (ROUTE == "child/list") ? 'active':'';  ?>"><a href="<?= HOST; ?>child/list"><i class="material-icons">list</i> Liste des enfants </a></li>
          <li class="subitem <?php echo (ROUTE == "child/school") ? 'active':'';  ?>"><a href="<?= HOST; ?>child/school"><i class="material-icons">school</i> Liste des écoles / enfants </a></li>
          <li  class="subitem <?php echo (ROUTE == "child/add") ? 'active':'';  ?>"><a href="<?= HOST; ?>child/add"> <i class="material-icons">add</i>Ajouter un enfant</a></li>
          <li  class="subitem <?php echo (ROUTE == "child/presence") ? 'active':'';  ?>"><a href="<?= HOST; ?>child/presence"> <i class="material-icons">calendar_today</i>Présences</a></li>
          <li  class="subitem <?php echo (ROUTE == "media/list") ? 'active':'';  ?>"><a href="<?= HOST; ?>media/list"> <i class="material-icons">done</i>Photo(s) à valider</a></li>
      </ul>
    </li>

    <li <?php echo (ROUTE_FIRST_ELEMENT == "person") ? 'class="active"' : '';  ?>>
      <a href="#" class="parent"><i class="material-icons">people</i> Personnes</a>
      <ul class="menu vertical sublevel-1">
        <li class="subitem <?php echo (ROUTE == "user/add") ? 'active':'';  ?>"><a href="<?= HOST; ?>user/add"  > <i class="material-icons">add</i>Créer une personne</a></li>
        <!--<li class="subitem <?php echo (ROUTE == "user/list") ? 'active':'';  ?>"><a href="<?= HOST; ?>user/list"  > <i class="material-icons">people</i>Gestion des utilisateurs </a></li>-->
        <li class="subitem <?php echo (ROUTE == "person/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>person/list" ><i class="material-icons">list</i> Liste des personnes </a></li>
          <li class="subitem <?php echo (ROUTE == "person/search") ? 'active':'';  ?>" ><a href="<?= HOST; ?>person/search" ><i class="material-icons">search</i> Recherche  </a></li>
          <li class="subitem <?php echo (ROUTE == "person/searchEmail") ? 'active':'';  ?>" ><a href="<?= HOST; ?>person/searchEmail" ><i class="material-icons">manage_accounts</i> Débloquer email doublon</a></li>

      </ul>
    </li>
<?php endif;?>

<li style="cursor:pointer;" <?php echo (ROUTE_FIRST_ELEMENT == "challenge") ? 'class="active"' : '';  ?>>
    <a style="cursor:pointer;" href="#" class="parent"><i class="material-icons">rocket_launch</i> Challenge</a>
    <ul class="menu vertical sublevel-1">
        <li class="subitem <?php echo (ROUTE == "foot-match/home") ? 'active':'';  ?>"><a href="<?= HOST; ?>challenge/home"><i class="material-icons">event_seat</i>Challengers</a></li>
    </ul>
    <ul class="menu vertical sublevel-1">
        <li class="subitem <?php echo (ROUTE == "foot-match/home") ? 'active':'';  ?>"><a href="<?= HOST; ?>foot-match/home"><i class="material-icons">noise_aware</i>Foot</a></li>
    </ul>
</li>

<li style="cursor:pointer;" <?php echo (ROUTE_FIRST_ELEMENT == "booklet") ? 'class="active"' : '';  ?>>
    <a style="cursor:pointer;" href="#" class="parent"><i class="material-icons">assignment_ind</i> Livrets</a>

    <ul class="menu vertical sublevel-1">
      <li class="subitem <?php echo (ROUTE == "booklet/list") ? 'active':'';  ?>"><a href="<?= HOST; ?>booklet/list"><i class="material-icons">list</i>Livrets</a></li>
      <li  class="subitem <?php echo (ROUTE == "booklet/create") ? 'active':'';  ?>"><a href="<?= HOST; ?>booklet/add"> <i class="material-icons">add</i>Créer un livret</a></li>
      <li  class="subitem <?php echo (ROUTE == "booklet/searchList") ? 'active':'';  ?>"><a href="<?= HOST; ?>booklet/searchList"> <i class="material-icons">add</i>Liste des enfants</a></li>

    </ul>
  </li>


<li>
    <a style="cursor:pointer;" href="#" class="parent"><i class="material-icons">camera</i> Photos</a>
    <ul class="menu vertical sublevel-1">
        <li  class="subitem <?php echo (ROUTE == "media/photoTake") ? 'active':'';  ?>"><a href="<?= HOST; ?>media/photoTake"> <i class="material-icons">camera</i>Prende une photo</a></li>
        <li  class="subitem <?php echo (ROUTE == "media/serie") ? 'active':'';  ?>"><a href="<?= HOST; ?>media/serie"> <i class="material-icons">photo_library</i>Série de photo</a></li>
    </ul>
</li>



<li <?php echo (ROUTE_FIRST_ELEMENT == "transport") ? 'class="active"' : '';  ?>>
  <a href="#" class="parent"><i class="material-icons">directions_car</i> Transport</a>
  <ul class="menu vertical sublevel-1">
    <li class="subitem <?php echo (ROUTE == "transport/calendar") ? 'active':'';  ?>" ><a href="<?= HOST; ?>transport/calendar" ><i class="material-icons">airport_shuttle</i>Vue semaine </a></li>
    <li class="subitem <?php echo (ROUTE == "transport/dispatch") ? 'active':'';  ?>"><a href="<?= HOST; ?>transport/dispatch"  > <i class="material-icons">edit</i>Dispatcher</a></li>
    <li class="subitem <?php echo (ROUTE == "staff/drivers") ? 'active':'';  ?>" ><a href="<?= HOST; ?>staff/drivers" ><i class="material-icons">drive_eta</i> Gestion des drivers </a></li>
    <li class="subitem <?php echo (ROUTE == "transport/ride") ? 'active':'';  ?>"><a href="<?= HOST; ?>transport/ride"  > <i class="material-icons">directions_car</i>Trajet driver individuel</a></li>
    <!--<li class="subitem <?php echo (ROUTE == "transport/optimize") ? 'active':'';  ?>"><a href="<?= HOST; ?>transport/optimize"  > <i class="material-icons">code</i>IA</a></li>-->

  </ul>
</li>
<li <?php echo (ROUTE_FIRST_ELEMENT == "activity") ? 'class="active"' : '';  ?>>
  <a href="#" class="parent"><i class="material-icons">golf_course</i> Activité </a>
  <ul class="menu vertical sublevel-1">
    <li class="subitem <?php echo (ROUTE == "activity/dispatch-activity") ? 'active':'';  ?>"><a href="<?= HOST; ?>activity/dispatch-activity"  > <i class="material-icons">edit</i>Dispatcher</a></li>
    <li class="subitem <?php echo (ROUTE == "activity/display") ? 'active':'';  ?>"><a href="<?= HOST; ?>activity/display"  > <i class="material-icons">list_alt</i>Activité (vue moniteur)</a></li>
  </ul>
</li>

<li <?php echo (ROUTE_FIRST_ELEMENT == "meal") ? 'class="active"':'';  ?>>
  <a href="#" class="parent"><i class="material-icons">fastfood</i> Repas </a>
  <ul class="menu vertical sublevel-1">
      <li class="subitem <?php echo (ROUTE == "meal/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>meal/list" ><i class="material-icons">list</i> Repas </a></li>
      <li class="subitem <?php echo (ROUTE == "meal/add") ? 'active':'';  ?>"><a href="<?= HOST; ?>meal/add"><i class="material-icons">add</i> Ajouter un repas </a></li>
      <li class="subitem <?php echo (ROUTE == "food/list") ? 'active':'';  ?>"><a href="<?= HOST; ?>food/list"  > <i class="material-icons">list</i> Liste des aliments</a></li>
      <li  class="subitem <?php echo (ROUTE == "food/add") ? 'active':'';  ?>"><a href="<?= HOST; ?>food/add" > <i class="material-icons">add</i>Ajouter un aliment</a></li>
  </ul>
</li>
<li <?php echo (ROUTE_FIRST_ELEMENT == "meal") ? 'class="active"':'';  ?>>
    <a href="#" class="parent"><i class="material-icons">dataset</i> Stock </a>
    <ul class="menu vertical sublevel-1">
        <li class="subitem <?php echo (ROUTE == "stock/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>stock/list" ><i class="material-icons">list</i>Etat</a></li>
        <li class="subitem <?php echo (ROUTE == "stock/inventory") ? 'active':'';  ?>" ><a href="<?= HOST; ?>stock/inventory" ><i class="material-icons">check</i>Inventaire</a></li>
        <li class="subitem <?php echo (ROUTE == "stock/orderList") ? 'active':'';  ?>" ><a href="<?= HOST; ?>stock/orderList" ><i class="material-icons">sell</i>Course</a></li>

    </ul>
</li>
<li <?php echo (ROUTE_FIRST_ELEMENT == "vehicle" OR ROUTE_FIRST_ELEMENT == "vehicle") ? 'class="active"':'';  ?>>
    <a href="#"  class="parent"><i class="material-icons">directions_car</i> Véhicules </a>
    <ul class="menu vertical sublevel-1">

        <?php if(hasCredential('vehicle::listAll')):?>
            <li class="subitem <?php echo (ROUTE == "vehicle/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>vehicle/list"><i class="material-icons">list</i>Véhicules</a></li>
        <?php endif;?>
        <li class="subitem <?php echo (ROUTE == 'vehicle/add-fuel') ? 'active' : ''; ?>"><a href="<?= HOST; ?>vehicle/add-fuel"><i class="material-icons">local_gas_station</i> Ajouter de l'essence </a></li>
        <li class="subitem <?php echo (ROUTE == 'vehicle/add-reminder') ? 'active' : ''; ?>"><a href="<?= HOST; ?>vehicle/add-reminder"><i class="material-icons">schedule</i> Ajouter un rappel </a></li>
        <li class="subitem <?php echo (ROUTE == 'vehicle/add-wash') ? 'active' : ''; ?>"><a href="<?= HOST; ?>vehicle/add-wash"><i class="material-icons">shower</i> Ajouter un lavage </a></li>
        <li class="subitem <?php echo (ROUTE == 'vehicle/add-maintenance') ? 'active' : ''; ?>"><a href="<?= HOST; ?>vehicle/add-maintenance"><i class="material-icons">engineering</i> Ajouter une maintenace </a></li>
        <li class="subitem <?php echo (ROUTE == 'vehicle/add-checkup') ? 'active' : ''; ?>"><a href="<?= HOST; ?>vehicle/add-checkup"><i class="material-icons">check</i> Ajouter un checkup </a></li>
      </ul>
</li>

<?php if(hasCredential('product::access')):?>

  <li <?php echo (ROUTE_FIRST_ELEMENT == "product") ? 'class="active"':'';  ?>>
      <a href="#"  class="parent"><i class="material-icons">shopping_cart</i> Produits </a>
      <ul class="menu vertical sublevel-1">
          <li class="subitem <?php echo (ROUTE == "product/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>product/list"><i class="material-icons">shopping_cart</i> Produits </a></li>
          <li class="subitem <?php echo (ROUTE == "product/add") ? 'active':'';  ?>" ><a href="<?= HOST; ?>product/add"><i class="material-icons">add</i> Ajouter un produit </a></li>
          <li class="subitem <?php echo (ROUTE == "product/archived") ? 'active':'';  ?>" ><a href="<?= HOST; ?>product/archived"><i class="material-icons">app_registration</i> Produits archivés</a></li>
          <li class="subitem <?php echo (ROUTE == "component/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>component/list"><i class="material-icons">shopping_cart</i> Liste des composants </a></li>
          <li class="subitem <?php echo (ROUTE == "product/mail") ? 'active':'';  ?>" ><a href="<?= HOST; ?>product/mail"><i class="material-icons">mail</i> Email liés aux produits </a></li>
      </ul>
  </li>
<?php endif;?>

  <?php if(hasCredential('registration::access')):?>

  <li <?php echo (ROUTE_FIRST_ELEMENT == "registration") ? 'class="active"':'';  ?>>
      <a href="#"  class="parent"><i class="material-icons">assignment_ind</i> Inscriptions</a>
      <ul class="menu vertical sublevel-1">
          <li class="subitem <?php echo (ROUTE == "registration/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>registration/list"><i class="material-icons">list</i> Liste des inscriptions </a></li>
          <li class="subitem <?php echo (ROUTE == "registration/add") ? 'active':'';  ?>" ><a href="<?= HOST; ?>registration/add" ><i class="material-icons">add</i>Ajouter une inscription </a></li>
          <li class="subitem <?php echo (ROUTE == "registration/awaitingPayment") ? 'active':'';  ?>" ><a href="<?= HOST; ?>registration/awaitingPayment"><i class="material-icons">account_balance_wallet</i>Paiement en attente</a></li>
      </ul>
  </li>

  <?php endif;?>

  <li <?php echo (ROUTE_FIRST_ELEMENT == "tv") ? 'class="active"':'';  ?>>
      <a href="#"  class="parent"><i class="material-icons">tv</i> TV </a>
      <ul class="menu vertical sublevel-1">
          <li class="subitem <?php echo (ROUTE == "public/tv") ? 'active':'';  ?>" ><a target="_blank" href="<?= HOST; ?>public/tv"><i class="material-icons">play_circle_outline</i> Lancer eaTV </a></li>
          <li class="subitem <?php echo (ROUTE == "tv/settings") ? 'active':'';  ?>" ><a href="<?= HOST; ?>tv/settings" ><i class="material-icons">settings</i> Paramètres </a></li>
      </ul>
  </li>


  <?php if(hasCredential('staff::access')):?>


  <li <?php echo (ROUTE_FIRST_ELEMENT == "activities") ? 'class="active"':'';  ?>>
      <a href="#"  class="parent"><i class="material-icons">people</i> Supervision Staff </a>
      <ul class="menu vertical sublevel-1">
          <li class="subitem <?php echo (ROUTE == "staff/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>staff/list"><i class="material-icons">perm_contact_calendar</i> Liste du personnel </a></li>
          <li class="subitem <?php echo (ROUTE == "staff/planning") ? 'active':'';  ?>" ><a href="<?= HOST; ?>staff/planning"><i class="material-icons">insert_chart</i> Planification </a></li>
          <?php  if(hasCredential('staff::planification')):?>
            <li class="subitem <?php echo (ROUTE == "staffPresence/calendar") ? 'active':'';  ?>" ><a href="<?= HOST; ?>staffPresence/calendar"><i class="material-icons">calendar_today</i> Calendrier des présences </a></li>
          <?php endif;?>
      </ul>
  </li>


  <?php endif;?>


  <li <?php echo (ROUTE_FIRST_ELEMENT == "activities") ? 'class="active"':'';  ?>>
      <a href="#"  class="parent"><i class="material-icons">assignment</i> Tâches </a>
      <ul class="menu vertical sublevel-1">
          <li class="subitem <?php echo (ROUTE == "task/view") ? 'active':'';  ?>" ><a href="<?= HOST; ?>task/view"><i class="material-icons">view_agenda</i>Vue quotidienne</a></li>
          <li class="subitem <?php echo (ROUTE == "task/dispatch") ? 'active':'';  ?>" ><a href="<?= HOST; ?>task/dispatch" ><i class="material-icons">edit</i>Dispatcher</a></li>
      </ul>
  </li>


  <?php if(hasCredential('standard::access')):?>


  <li <?php echo (ROUTE_FIRST_ELEMENT == "ticket") ? 'class="active"':'';  ?>>
      <a href="#"  class="parent"><i class="material-icons">call</i>Ticket</a>
      <ul class="menu vertical sublevel-1">
         <li class="subitem <?php echo (ROUTE == "ticket/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>ticket/list" ><i class="material-icons">assignment_ind</i> Ticket</a></li>
         <li class="subitem <?php echo (ROUTE == "ticket/stats") ? 'active':'';  ?>" ><a href="<?= HOST; ?>ticket/stats" ><i class="material-icons">bar_chart</i> Tickets statistiques </a></li>
         <li class="subitem <?php echo (ROUTE == "ticket/rdv") ? 'active':'';  ?>" ><a href="<?= HOST; ?>ticket/rdv" ><i class="material-icons">calendar_today</i> Rendez-vous </a></li>
      </ul>
  </li>

      <li <?php echo (ROUTE_FIRST_ELEMENT == "standard") ? 'class="active"':'';  ?>>
          <a href="#"  class="parent"><i class="material-icons">dataset</i>Standard</a>
          <ul class="menu vertical sublevel-1">
                 <li class="subitem <?php echo (ROUTE == "standard/calls") ? 'active':'';  ?>" ><a href="<?= HOST; ?>standard/calls" ><i class="material-icons">call</i> Derniers </a></li>
                 <li class="subitem <?php echo (ROUTE == "standard/all") ? 'active':'';  ?>" ><a href="<?= HOST; ?>standard/all" ><i class="material-icons">dataset</i> Tous </a></li>
          </ul>
      </li>

  <?php endif;?>

  <?php if(hasCredential('client::access')):?>


  <li <?php echo (ROUTE_FIRST_ELEMENT == "customerSite") ? 'class="active"':'';  ?>>
      <a href="#"  class="parent"><i class="material-icons">devices</i>Site client</a>
      <ul class="menu vertical sublevel-1">
         <li class="subitem <?php echo (ROUTE == "customerSite/display") ? 'active':'';  ?>" ><a href="<?= HOST; ?>customerSite/display" ><i class="material-icons">dashboard</i>Dates en ligne</a></li>
         <li class="subitem <?php echo (ROUTE == "customerSite/gymnases") ? 'active':'';  ?>" ><a href="<?= HOST; ?>customerSite/gymnases" ><i class="material-icons">dashboard</i>Gymnases</a></li>
      </ul>
  </li>

  <?php endif;?>

    <?php if(hasCredential('communication::access')):?>


        <li <?php echo (ROUTE_FIRST_ELEMENT == "communication" OR ROUTE_FIRST_ELEMENT == "communication") ? 'class="active"':'';  ?>>
            <a href="#"  class="parent"><i class="material-icons">mail_outline</i> Communication </a>
            <ul class="menu vertical sublevel-1">
               <!--  <li class="subitem <?php echo (ROUTE == "communication/search") ? 'active':'';  ?>" ><a href="<?= HOST; ?>communication/search"><i class="material-icons">send</i>Recherche & envoi</a></li>-->
                <li class="subitem <?php echo (ROUTE == "communication/indexSms") ? 'active':'';  ?>" ><a href="<?= HOST; ?>communication/indexSms"><i class="material-icons">sms</i>Campagne SMS</a></li>

            </ul>
        </li>
    <?php endif;?>

    <?php if(hasCredential('request::access')):?>
        <li <?php echo (ROUTE_FIRST_ELEMENT == "requestBuilder" OR ROUTE_FIRST_ELEMENT == "requestBuilder") ? 'class="active"':'';  ?>>
            <a href="#"  class="parent"><i class="material-icons">assessment</i>Exploitation Données</a>
            <ul class="menu vertical sublevel-1">
                <li class="subitem <?php echo (ROUTE == "requestBuilder/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>requestBuilder/list"><i class="material-icons">view_list</i>Requête</a></li>
                <li class="subitem <?php echo (ROUTE == "statistique/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>statistique/list"><i class="material-icons">view_list</i>Statistique</a></li>
            </ul>
        </li>
    <?php endif;?>

  <?php if(hasRole('ADMIN')):?>


        <li <?php echo (ROUTE_FIRST_ELEMENT == "invoice" OR ROUTE_FIRST_ELEMENT == "transaction") ? 'class="active"':'';  ?>>
            <a href="#"  class="parent"><i class="material-icons">euro_symbol</i> Facturation </a>
            <ul class="menu vertical sublevel-1">
                <li class="subitem <?php echo (ROUTE == "invoice/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>invoice/list"><i class="material-icons">list</i>Liste des factures</a></li>
                <li class="subitem <?php echo (ROUTE == "invoice/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>invoice/balance"><i class="material-icons">table_chart</i>Bilan</a></li>
                <li class="subitem <?php echo (ROUTE == "invoice/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>invoice/create"><i class="material-icons">euro_symbol</i>Saisie de facture</a></li>
               <li class="subitem <?php echo (ROUTE == "transaction/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>transaction/list"><i class="material-icons">payment</i>Transactions</a></li>

            </ul>
        </li>

        <li <?php echo (ROUTE_FIRST_ELEMENT == "activities") ? 'class="active"':'';  ?>>
            <a href="#"  class="parent"><i class="material-icons">settings</i> Paramètres </a>
            <ul class="menu vertical sublevel-1">
                <li class="subitem <?php echo (ROUTE == "location/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>location/list"><i class="material-icons">place</i>Gestion des lieux </a></li>
                <li class="subitem <?php echo (ROUTE == "season/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>season/list" ><i class="material-icons">date_range</i>Gestion des saisons </a></li>
                <li class="subitem <?php echo (ROUTE == "survey/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>survey/list" ><i class="material-icons">stars</i>Gestion des sondages </a></li>
                <li class="subitem <?php echo (ROUTE == "credential/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>credential/list" ><i class="material-icons">extension</i>Droits et rôles </a></li>
                <li class="subitem <?php echo (ROUTE == "shortUrl/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>shortUrl/list" ><i class="material-icons">language</i>Url raccourcie</a></li>
                <!--<li class="subitem <?php echo (ROUTE == "reminder/list") ? 'active':'';  ?>" ><a href="<?= HOST; ?>reminder/list" ><i class="material-icons">alarm</i> Gestion des rappels </a></li>-->
                <!--<li class="subitem <?php echo (ROUTE == "import/data") ? 'active':'';  ?>" ><a href="<?= HOST; ?>import/data" ><i class="material-icons">date_range</i> Import des données </a></li>-->
               <!-- <li class="subitem <?php echo (ROUTE == "cron/cron") ? 'active':'';  ?>" ><a href="<?= HOST; ?>import/data" ><i class="material-icons">date_range</i> Tâches automatiques </a></li>-->

            </ul>
        </li>
  <?php endif;?>
