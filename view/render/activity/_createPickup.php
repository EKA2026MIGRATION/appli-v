<div class="reveal" id="revealCreatePickupActivity" data-reveal>
    <p class="lead">Créer/Modifier une activité</p>

    <div class="containerLoader"id="loaderFormEditPickupActivity">
        <div class="lds-roller">
            <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
        </div>
    </div>

    <button class="close-button"data-close aria-label="Close modal"type="button">
        <span aria-hidden="true">&times;</span>
    </button>

    <form method="post"id="pickupActivityForm"action="pickup-activity/create">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <input type="hidden" name="date" id="datePickupActivity" value="<?php echo date('Y-m-d H:i:s', strtotime($params->date)); ?>">

                <div class="medium-12 cell"id="listChildPickUpActivity">
                    <label>Nom de l'enfant *
                        <input type="search"id="autocompleteChild" placeholder="Nom de l'enfant"value=""required>
                        <input type="hidden"id="formChildId"name="child"value="">
                    </label>
                    <div id="listChild"></div>
                </div>


                <div class="medium-12 cell">
                    <label>Heure de début *
                        <input type="time" id="start_pickup" value="08:00:00" placeholder="Heure de début" required>
                        <input type="hidden" id="start_pickup_2" name="start" value="08:00:00">
                    </label>
                </div>
                <div class="medium-12 cell">
                    <label>Heure de fin *
                        <input type="time" id="end_pickup" value="08:00:00" placeholder="Heure de fin" required>
                        <input type="hidden" id="end_pickup_2" name="end" value="08:00:00">

                    </label>
                </div>


                <div class="medium-12 cell">
                    <label>Lieux *
                        <select id="selectLocationPickup" name="location" required>
                            <option value="0">Choisir un lieu</option>
                            <?php foreach($params->locations as $location):?>
                                <option class="locationAll selectLocation<?= $location->locationId;?>" data-id-location="<?php echo $location->locationId; ?>"value="<?php echo $location->locationId; ?>"><?php echo $location->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>


                <div class="medium-12 cell">
                    <label>Activité *
                        <select id="selectSport"name="sport"required>
                            <option value="0">Choisir une activité</option>
                            <?php foreach($params->sports as $sport):?>
                                <option data-id-sport="<?php echo $sport->sportId; ?>"value="<?php echo $sport->sportId; ?>"><?php echo $sport->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <style type="text/css">
                    .group .zselect {
                        width: 400px;
                    }
                </style>

                <div class="medium-12 cell group groupsCheckBoxs">
                    <label>Groupe</label>
     
                        <?php foreach($params->groups as $group):?>
                               <label class="locationAll selectLocation<?= $group->location->locationId;?>">
                                <input 
                                    type="checkbox"
                                    data-id-group="<?php echo $group->groupActivityId; ?>"
                                    value="<?php echo $group->groupActivityId; ?>"
                                ><?php foreach ($group->staff as $staff): echo $staff->person->firstname . ' - '; endforeach; ?><?php echo date('H:i', strtotime($group->start)); ?> - <?php echo date('H:i', strtotime($group->end)); ?> - <?php echo strtoupper($group->sport->name); ?> - <?php echo strtoupper($group->area); ?>
                                </label>


                        <?php endforeach; ?>
 

                </div>

                  <section class="block-list" id="create_pickup">
                      <div>
                        <ul>
                            <li style="padding-left: 0;">
                                    <div>
                                        <p class="list-header second-row" style="padding-left: 0; margin-left: 1rem !important;">
                                            <span style="color: darkred">Voulez-vous modifier les inscriptions liées ?</span>
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon">
                                               <div class="switch">
                                                      <input class="switch-input"  id="updateAllRegistration" type="checkbox" >
                                                      <label class="switch-paddle" for=updateAllRegistration></label>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                            </li>
                             <li style="padding-left: 0;">
                                <a href="javascript:void(0)">
                                    <div>
                                        <p class="list-header second-row" style="padding-left: 0; margin-left: 1rem !important;">
                                            Souhaitez-vous créer une présence ?
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon">
                                               <div class="switch">
                                                      <input class="switch-input"  id="addPresence" type="checkbox" >
                                                      <label class="switch-paddle" for=addPresence></label>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                </a>
                            </li>
                             <li style="padding-left: 0;">
                                <a href="javascript:void(0)">
                                    <div>
                                        <p class="list-header second-row" style="padding-left: 0; margin-left: 1rem !important;">
                                            Souhaitez-vous créer un transport ?
                                            <aside class="subtitles"></aside>
                                            <div class="with-icon">
                                               <div class="switch">
                                                      <input class="switch-input"  id="addTransport" type="checkbox" >
                                                      <label class="switch-paddle" for=addTransport></label>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                      </div>
                  </section>




                <div class="medium-12 cell">
                    <center><input type="submit"class="button"value="Envoyer"/></center>
                </div>
                <p>* champs obligatoires</p>
            </div>
        </div>
    </form>
</div>
