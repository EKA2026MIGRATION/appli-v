<?php
$title = "STAFF PRESENCE";
?>

<h1>Présence Calendrier</h1>


<input type="hidden" value="<?= htmlspecialchars(json_encode($params->date), ENT_QUOTES, 'UTF-8'); ?>" id="date">
<input type="hidden" value="<?= htmlspecialchars(json_encode($params->month), ENT_QUOTES, 'UTF-8'); ?>" id="month">
<input type="hidden" value="<?= htmlspecialchars(json_encode($params->year), ENT_QUOTES, 'UTF-8'); ?>" id="year">
<input type="hidden" value="<?= htmlspecialchars(json_encode($params->teams), ENT_QUOTES, 'UTF-8'); ?>" id="teams">
<input type="hidden" value="<?= $params->currentStaffId;?>" id="currentStaffId">
<div id="staffPresence-app">Problème à l'application vue.js</div>