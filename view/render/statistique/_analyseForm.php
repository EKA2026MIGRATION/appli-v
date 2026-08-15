<style>
    .center {
        text-align: center;
    }
</style>

<h2>Analyse stratégique par mois</h2>
<br/>
<br/>

<div class="horizontalCard">
    <div style="display: flex; width: 400px">
        <select name="month" id="analyseMonth">
            <?php
            $months = [
                '01' => 'Janvier', '02' => 'Février', '03' => 'Mars', '04' => 'Avril', '05' => 'Mai', '06' => 'Juin',
                '07' => 'Juillet', '08' => 'Août', '09' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre','12' =>  'Décembre'
            ];

            foreach ($months as $index => $month) {
                echo "<option value='{$index}'>{$month}</option>";
            }
            ?>
        </select>

        <select name="year" id="analyseYear">
            <?php
            $currentYear = date("Y");
            $years = [$currentYear - 1, $currentYear, $currentYear + 1];

            foreach ($years as $year) {
                ($year == date('Y')) ? $selected = 'selected' : $selected = '';
                echo "<option value='{$year}' ".$selected.">{$year}</option>";
            }
            ?>
        </select>

        <input type="submit" class="button" id="submitAnalyse" value="Chercher"/>

    </div>
</div>

<div id="showResult"></div>
