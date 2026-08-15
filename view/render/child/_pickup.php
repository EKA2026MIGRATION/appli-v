<div class="tabs-panel" id="panel7">
        <section class="block-list">
            <div class="vehicle flexEvenly">
                <section>
                    Du <br/>
                    <input type="date" id="pickupFrom" name="pickupFrom" value="<?= $params->from2; ?>">
                </section>

                <section>
                    Au <br/>
                    <input type="date" id="pickupTo" name="pickupTo" value="<?= $params->to2; ?>">
                </section>

                <section>
                    <button class="button" style="margin-top: 20px;" onclick="updateData('pickup')">Afficher</button>
                </section>
            </div>
        </section>

        <div id="pickupContent">
            <section class="block-list">   
                <section class="block-list">
                    <div id="pickupList">
                       <?php include('_pickupsList.php');?>
                    </div>
                </section>
            </section>
        </div>

</div>