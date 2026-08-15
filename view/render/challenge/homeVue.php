<?php
$title = "Challenge";
?>

<h1>Challenge</h1>

<input type="hidden" value="<?= htmlspecialchars(json_encode($params->seasons), ENT_QUOTES, 'UTF-8'); ?>" id="seasonsData">
<div id="challenge-app">Problème à l'application vue.js</div>