<?php 
    $questions = ["Tout s'est bien passé durant le transport (malade, dispute...) ?", "Les enfants-ils tous eu leur goûter?", "La journée s'est-elle bien passée pour tous les enfants?", "Les enfants sont-ils tous bien rentrés avec leurs vêtements ?"];
    $uberQuestions = ["Le chauffeur a-t-il fait ses déposes devant la porte de chaque enfant?", "Le chauffeur a-t-il gardé une attitude positive devant les enfants (pas de plaintes) ?", "Globalement, le chauffeur a-t-il conduit prudemment?"];
    $k = 0; // key identification question
;?>

<i class="material-icons" style="float: right; cursor: pointer" id="closeReportTransport" >close</i>
<h3>Fin de transport</h3>


<div id="contentReportTransport">
    <ul id="standardQuestion">
        <?php foreach($questions as $question):?>
            <li>
                <?= $question;?><br/>
                <div class="divMood">
                    <i class="material-icons moodReportTransport neutral" data-questionkey="<?= $k;?>" data-mood="noanswer" id="moodReportTransport<?= $k;?>noanswer">contact_support</i>
                    <i class="material-icons moodReportTransport neutral" data-questionkey="<?= $k;?>" data-mood="good" id="moodReportTransport<?= $k;?>good">thumb_up</i>
                    <i class="material-icons moodReportTransport neutral" data-questionkey="<?= $k;?>" data-mood="bad"  id="moodReportTransport<?= $k;?>bad" >thumb_down</i>
                </div>
                <input type="hidden" class="inputQuestions" name="<?= $question;?>" id="question<?= $k;?>" value=""/>

            </li>
            <?php $k++;?>
        <?php endforeach;?>
        <input type="hidden" name="questionRideId" value="<?= $ride->rideId; ?>"/>
    </ul>

    <div id="uberQuestions">

        <h3>Autres questions</h3>

        <ul>
            <?php foreach($uberQuestions as $question):?>
                <li>
                    <?= $question;?><br/>
                    <div class="divMood">
                        <i class="material-icons moodReportTransport neutral" data-questionkey="<?= $k;?>" data-mood="noanswer" id="moodReportTransport<?= $k;?>noanswer">contact_support</i>
                        <i class="material-icons moodReportTransport neutral" data-questionkey="<?= $k;?>" data-mood="good" id="moodReportTransport<?= $k;?>good">thumb_up</i>
                        <i class="material-icons moodReportTransport neutral" data-questionkey="<?= $k;?>" data-mood="bad"  id="moodReportTransport<?= $k;?>bad" >thumb_down</i>
                    </div>
                    <input type="hidden" class="inputQuestions uberQuestions" name="<?= $question;?>" id="question<?= $k;?>" value=""/>
                </li>
                <?php $k++;?>
            <?php endforeach;?>
            <input type="hidden" name="questionRideId" value="<?= $ride->rideId; ?>"/>
        </ul>
    </div>


</div>
<div id="nextReportTransport">
    Suivant
</div>

<div id="validReportTransport">
    Envoyer
</div>
