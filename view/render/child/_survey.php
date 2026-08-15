<?= use_helper('loader'); ?>
<div class="tabs-panel" id="panel9">

    <div class="flex space-between" style="margin: 24px 0;">
        <button class="button" style="max-height: 42px;" onclick="openRevealJS('linkSurvey')">Ajouter un sondage</button>
    </div>

    <div class="reveal" id="linkSurvey" data-reveal>
        <p class="lead">Ajouter un sondage</p>

        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">

                <?php
                $mappingRegistrationPickup = array();

                foreach ($params->pickups as $month => $allPickups) :
                    foreach ($allPickups as $week => $pickups) :
                        foreach ($pickups as $pickup) :
                            if ($pickup->ride && $pickup->ride->date) {
                                $mappingRegistrationPickup[$pickup->ride->date][] = $pickup->ride->rideId;
                            }

                        endforeach;
                    endforeach;
                endforeach;
                ?>



                <form method="post" id="surveyChildForm" action="surveySession/create">
                    <div class="grid-container">
                        <div class="grid-x grid-padding-x">
                            <input type="hidden" id="childIdSurvey" name="child" value="<?= $params->child->childId; ?>" />
                            <input type="hidden" name="registration" id="registrationPresanceId" />
                            <input type="hidden" id="surveyHasDriver" />
                            <input type="hidden" id="surveyHasCoach" />
                            <input type="hidden" name="drivers" id="driversIds">
                            <input type="hidden" name="coachs" id="coachsIds">
                            <div class="medium-12 cell">
                                <label>Sondage *
                                    <select onchange="getSurveyInformation()" id="selectSurvey" name="survey" required>
                                        <option value="0">Choisir un sondage</option>

                                        <?php foreach ($params->surveys as $survey) :

                                        dd($survey, false);
                                            $hasDriver = 0;
                                            $hasCoach = 0;
                                            foreach ($survey->chapters as $chapter) :
                                                if ($chapter->type == 'driver') :
                                                    $hasDriver = 1;
                                                endif;
                                                if ($chapter->type == 'coach') :
                                                    $hasCoach = 1;
                                                endif;
                                            endforeach;

                                            if ($survey->isActive == 1) : ?>
                                                <option data-coach="<?= $hasCoach; ?>" data-driver="<?= $hasDriver; ?>" value="<?= $survey->id; ?>"> <?= $survey->name; ?> </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                            </div>

                            <div class="medium-12 cell" style="display: none;" id="selectPerson">
                                <label>Personne
                                    <select id="selectPersonSurvey" name="person" required>
                                        <?php foreach($params->child->persons as $person):?>
                                            <option value="<?= $person->personId;?>">
                                                <?= $person->firstname.' '.$person->lastname; ?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>
                                </label>
                            </div>


                            <div class="medium-12 cell" style="display: none;" id="selectPresanceGlobal">
                                <label>Présence *
                                    <select id="selectPresenceSurvey" onchange="getPresanceLinkedInformation(this)" name="presence" required>
                                        <option value="0">Choisir une présence</option>
                                        <?php foreach ($params->presences as $month => $presences) : ?>
                                            <?php foreach ($presences as $presence) : ?>

                                                <option data-date="<?= date('Y-m-d', strtotime($presence->date)); ?>" data-ride-start="<?= $mappingRegistrationPickup[date('Y-m-d', strtotime($presence->date))][0]; ?>" data-ride-return="<?= $mappingRegistrationPickup[date('Y-m-d', strtotime($presence->date))][1]; ?>" data-registration="<?= $presence->registration->registrationId; ?>" value="<?= $presence->childPresenceId; ?>">
                                                    <?= showDate($presence->date, 'l d F Y'); ?> - <?= $presence->category; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                            </div>

                            <div id="loaderSurvey" style="display: none; margin:auto;">
                                <?= loader("Recherche d'informations en cours"); ?>
                            </div>


                            <div id="membersFounded" style="display:none">
                                <h5>Membres de l'équipe concernés</h5>
                                <div>
                                    Driver
                                    <ul id="driverFounded"></ul>
                                </div>
                                <div>Coach(s)
                                    <ul id="coachFounded"></ul>
                                </div>
                            </div>
                           



                            <div class="medium-12 cell">
                                <center><input type="submit" class="button" value="Créer" /></center>
                            </div>
                            <p>* champs obligatoires</p>
                        </div>
                    </div>
                </form>


            </div>
        </div>


    </div>


    <section class="block-list">
        <h3>Sondage envoyé</h3>
        <ul id="surveyList">

            <?php if(count((array) $params->surveySessions) > 0):?>
                <?php foreach ($params->surveySessions as $surveySession) : ?>

                    <li>
                        <a href="<?= HOST; ?>surveySession/display/id/<?= $surveySession->id; ?>/">
                            <div>
                                <p style="padding: 0; margin: 0;" class="list-header">
                                    <?= $surveySession->survey->name; ?> -
                                    <?= $surveySession->status ;?>
                                    <div class="with-icon">
                                        <i class="material-icons">send</i>
                                    </div>
                                </p>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else :?>
                Aucun sondage
            <?php endif;?>
        </ul>
    </section>

    <script>
        function getSurveyInformation() {


          

            const optionSelected = $('#selectSurvey :selected');
            const hasCoach = $(optionSelected).attr('data-coach');
            const hasDriver = $(optionSelected).attr('data-driver');
            $('#surveyHasDriver').val(hasDriver);
            $('#surveyHasCoach').val(hasCoach);
            $('#registrationPresanceId').val();
            $('#driversIds').val();
            $('#coachsIds').val();



            $('#selectPresanceGlobal').show();
            $('#selectPerson').show();
        }

        function getPresanceLinkedInformation() {

            $('#driverFounded').html(' ');
            $('#coachFounded').html(' ');

            const optionSelected = $('#selectPresenceSurvey :selected');
            const registrationId = $(optionSelected).attr('data-registration');
            const date = $(optionSelected).attr('data-date');
            const rideStartId = $(optionSelected).attr('data-ride-start');
            const rideReturnId = $(optionSelected).attr('data-ride-return');
            const hasCoach = $('#surveyHasCoach').val();
            const hasDriver = $('#surveyHasDriver').val();
            const childId = $('#childIdSurvey').val();
            const personId = $('#selectPersonSurvey :selected');
            let driversIds = [];
            $('#registrationPresanceId').val(registrationId);
            $('#driversIds').val();
            $('#coachsIds').val();

            // Uniquement si le survey a driver en type
            if (hasDriver == 1) {
                var url1 = `ride/display/${rideStartId}`;
                var url2 = `ride/display/${rideReturnId}`;

                $.ajax({
                    type: "POST",
                    url: urlRequest,
                    data: {
                        url: url1,
                        type: "GET"
                    },
                    dataType: "json",
                    beforeSend() {
                        $('#loaderSurvey').show();
                    },
                    success(json) {
                        $('#driversIds').val(json.staff.staffId);

                        $('#driverFounded').append('<li>'+json.staff.fullname+'</li>');
                        $.ajax({
                            type: "POST",
                            url: urlRequest,
                            data: {
                                url: url2,
                                type: "GET"
                            },
                            dataType: "json",
                            beforeSend() {},
                            success(json) {
                                $('#driversIds').val(`${$('#driversIds').val()},${json.staff.staffId}`);
                                $('#loaderSurvey').hide();
                                $('#membersFounded').show();
                            }
                        });
                    }
                });

            }

            // Uniquement si le survey a coach en type
            if (hasCoach == 1) {
                var url3 = `group-activity/list/${date}`;

                $.ajax({
                    type: "POST",
                    url: urlRequest,
                    data: {
                        url: url3,
                        type: "GET"
                    },
                    dataType: "json",
                    beforeSend() {
                        $('#loaderSurvey').show();
                    },
                    success(json) {


                        console.log('activity');console.log(json);

                        let groupActivities = json;
                        let staffInArray = [];
                        groupActivities.map(groupActivity => {
                            let hasChildIn = false;

                            groupActivity.pickupActivities.map(pickupActivity => {
                                if (pickupActivity.child.childId == childId) {
                                    hasChildIn = true;
                                }
                            })

                            if (hasChildIn) {
                                groupActivity.staff.map(staff => {
                                    if (!staffInArray.includes(staff.staffId)) {
                                        staffInArray.push(staff.staffId);

                                        $('#coachFounded').append('<li>'+staff.fullname+'</li>');
                                        $('#coachsIds').val(`${$('#coachsIds').val()}${staff.staffId},`);
                                    }

                                })
                            }
                        })

                        $('#loaderSurvey').hide();
                        $('#membersFounded').show();
                    }
                });
            }

        }


        document.getElementById("surveyChildForm").addEventListener(
            "submit",
            event => {
                event.preventDefault();
                let form = $("#surveyChildForm");
                let url = form.attr("action");
                let type = "POST";

                let survey = $("#selectSurvey").val();
                let presence = $("#selectPresenceSurvey").val();
                let child = $("#childIdSurvey").val();
                let registration = $("#registrationPresanceId").val();
                let drivers = $("#driversIds").val();
                let coachs = $("#coachsIds").val();
                let person = $('#selectPersonSurvey').val();

                // Remove comma
                coachs = coachs.replace(/,\s*$/, "");

                let data = {
                    survey,
                    presence,
                    child,
                    registration,
                    drivers,
                    coachs,
                    person
                };


                console.log(data);

                $.ajax({
                    type: "POST",
                    url: urlRequest,
                    data: {
                        type,
                        url,
                        data
                    },
                    dataType: "json",
                    beforeSend() {
                        $("#surveyChildForm [type=submit]")
                            .attr("disabled", true)
                            .attr("value", "Envoi en cours..");
                    },
                    success(json) {
                        $("#surveyChildForm [type=submit]")
                            .attr("disabled", false)
                            .attr("value", "Créer");

                        if (json.status == true) {
                            setTimeout(function() {
                                swal({
                                    title: "Sondage créé",
                                    text: "Le sondage a bien été créé",
                                    type: "success",
                                    confirmButtonText: "Retour à la liste",
                                    showCancelButton: false
                                }).then(result => {
                                    if (result.value) {
                                        location.reload();
                                    }
                                });
                            }, 2000);
                        } else {
                            swal({
                                title: "Erreur",
                                text: "Une erreur est survenue.",
                                type: "warning"
                            });
                        }
                    }
                });
            },
            false
        );
    </script>

</div>