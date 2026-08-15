<div class="reveal"id="multipleGroups"data-reveal>
    <p class="lead">Groupes multiples</p>

    <button class="close-button"data-close aria-label="Close modal"type="button">
        <span aria-hidden="true">&times;</span>
    </button>

    <div class="grid-container">
        <div class="grid-x grid-padding-x">

            <table id="groupMultipleForm">
                <thead>
                <tr>
                    <th>Moniteurs</th>
                    <th>TM</th>
                    <th>TA</th>
                    <th>TJ</th>
                    <th>FM</th>
                    <th>FA</th>
                    <th>FJ</th>
                    <th>GM</th>
                    <th>GA</th>
                    <th>GJ</th>
                    <th>MM</th>
                    <th>MA</th>
                    <th>MJ</th>
                    <th>DM</th>
                    <th>DA</th>
                    <th>DJ</th>
                    <th>GyM</th>
                    <th>GyA</th>
                    <th>GyJ</th>
                    <th>AM</th>
                    <th>AA</th>
                    <th>AJ</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($params->drivers as $driver):?>
                    <?php if(isset($driver->staff->staffId)): ?>
                        <tr>
                            <td>
                                <?php echo $driver->staff->person->firstname; ?> <?php echo $driver->staff->person->lastname; ?>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="tm"data-start="09:00:00"data-end="11:30:00"data-name="Groupe 1"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="tm<?php echo $driver->staff->staffId; ?>"data-area="terrain 1"data-sport="tennis"data-lunch="1"type="checkbox"name="tm<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="tm<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="ta"data-start="14:00:00"data-end="17:00:00"data-name="Groupe 2"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="ta<?php echo $driver->staff->staffId; ?>"data-area="terrain 1"data-sport="tennis"data-lunch="1"type="checkbox"name="ta<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="ta<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="td"data-start="09:00:00"data-end="17:00:00"data-name="Groupe 3"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="td<?php echo $driver->staff->staffId; ?>"data-area="terrain 1"data-sport="tennis"data-lunch="1"type="checkbox"name="td<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="td<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="fm"data-start="09:00:00"data-end="11:30:00"data-name="Groupe 4"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="fm<?php echo $driver->staff->staffId; ?>"data-area="terrain 2"data-sport="foot"data-lunch="1"type="checkbox"name="fm<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="fm<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="fa"data-start="14:00:00"data-end="17:00:00"data-name="Groupe 5"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="fa<?php echo $driver->staff->staffId; ?>"data-area="terrain 2"data-sport="foot"data-lunch="1"type="checkbox"name="fa<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="fa<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="fd"data-start="09:00:00"data-end="17:00:00"data-name="Groupe 6"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="fd<?php echo $driver->staff->staffId; ?>"data-area="terrain 2"data-sport="foot"data-lunch="1"type="checkbox"name="fd<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="fd<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>

                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="gm"data-start="09:00:00"data-end="11:30:00"data-name="Groupe 7"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="gm<?php echo $driver->staff->staffId; ?>"data-area="terrain 3"data-sport="golf"data-lunch="1"type="checkbox"name="gm<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="gm<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="ga"data-start="14:00:00"data-end="17:00:00"data-name="Groupe 8"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="ga<?php echo $driver->staff->staffId; ?>"data-area="terrain 3"data-sport="golf"data-lunch="1"type="checkbox"name="ga<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="ga<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="gd"data-start="09:00:00"data-end="17:00:00"data-name="Groupe 9"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="gd<?php echo $driver->staff->staffId; ?>"data-area="terrain 3"data-sport="golf"data-lunch="1"type="checkbox"name="gd<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="gd<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>

                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="mm"data-start="09:00:00"data-end="11:30:00"data-name="Groupe 10"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="gm<?php echo $driver->staff->staffId; ?>"data-area="gymnase 1"data-sport="multisport"data-lunch="1"type="checkbox"name="mm<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="mm<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="ma"data-start="14:00:00"data-end="17:00:00"data-name="Groupe 11"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="ga<?php echo $driver->staff->staffId; ?>"data-area="gymnase 1"data-sport="multisport"data-lunch="1"type="checkbox"name="ma<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="ma<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="md"data-start="09:00:00"data-end="17:00:00"data-name="Groupe 12"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="gd<?php echo $driver->staff->staffId; ?>"data-area="gymnase 1"data-sport="multisport"data-lunch="1"type="checkbox"name="md<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="md<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>

                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="dm"data-start="09:00:00"data-end="11:30:00"data-name="Groupe 13"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="dm<?php echo $driver->staff->staffId; ?>"data-area="salle 1"data-sport="déjeuner"data-lunch="1"type="checkbox"name="dm<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="dm<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="da"data-start="14:00:00"data-end="17:00:00"data-name="Groupe 14"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="da<?php echo $driver->staff->staffId; ?>"data-area="salle 1"data-sport="déjeuner"data-lunch="1"type="checkbox"name="da<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="da<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="dd"data-start="09:00:00"data-end="17:00:00"data-name="Groupe 15"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="dd<?php echo $driver->staff->staffId; ?>"data-area="salle 1"data-sport="déjeuner"data-lunch="1"type="checkbox"name="dd<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="dd<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>

                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="gym"data-start="09:00:00"data-end="11:30:00"data-name="Groupe 16"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="gym<?php echo $driver->staff->staffId; ?>"data-area="salle 2"data-sport="gym"data-lunch="1"type="checkbox"name="gym<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="gym<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="gya"data-start="14:00:00"data-end="17:00:00"data-name="Groupe 17"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="gya<?php echo $driver->staff->staffId; ?>"data-area="salle 2"data-sport="gym"data-lunch="1"type="checkbox"name="gya<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="gya<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="gyd"data-start="09:00:00"data-end="17:00:00"data-name="Groupe 18"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="gyd<?php echo $driver->staff->staffId; ?>"data-area="salle 2"data-sport="gym"data-lunch="1"type="checkbox"name="gyd<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="gyd<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>

                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="am"data-start="09:00:00"data-end="11:30:00"data-name="Groupe 19"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="am<?php echo $driver->staff->staffId; ?>"data-area="salle 3"data-sport="anglais"data-lunch="1"type="checkbox"name="am<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="am<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="aa"data-start="14:00:00"data-end="17:00:00"data-name="Groupe 20"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="aa<?php echo $driver->staff->staffId; ?>"data-area="salle 3"data-sport="anglais"data-lunch="1"type="checkbox"name="aa<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="aa<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                            <td>
                                <div class="switch">
                                    <input class="switch-input"data-constante="ad"data-start="09:00:00"data-end="17:00:00"data-name="Groupe 21"data-coach="<?php echo $driver->staff->person->firstname; ?>" data-id-coach="<?php echo $driver->staff->staffId; ?>"data-location="6"id="ad<?php echo $driver->staff->staffId; ?>"data-area="salle 3"data-sport="anglais"data-lunch="1"type="checkbox"name="ad<?php echo $driver->staff->staffId; ?>">
                                    <label class="switch-paddle"for="ad<?php echo $driver->staff->staffId; ?>"></label>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>

                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="medium-12 cell">
                <center><input type="submit"class="button"value="Créer les trajets"id="createRideMultiple"/></center>
            </div>
        </div>
    </div>


</div>
