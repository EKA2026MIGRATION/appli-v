<?php use_helper('dates');?>
<?php
    function isInCoachList($coachList, $coach) {
        if (strpos($coachList, $coach) !== false) {
            return true;
        } else {
            return false;
        }
    }


    $datesArray = [];
?>

<script>
    let dates = new Array();
    let newDate = "";
</script>

<style>
    .spanValidButton {
        cursor: pointer;
        font-size: 11px;
        border-radius: 10px;
        border: 1px solid black;
        color: darkblue;
        padding: 3px;
        margin-right: 6px
    }

    .filterDateBar {
        display: flex;
        justify-content: space-around;
    }

    .filterDateBar {
        list-style:none;
        margin-left:0;
        padding-left:0;
    }

    .row-draft {
        background-color: lightblue!important;
    }

    .row-toreread {
        background-color: lightgreen!important;

    }

    .bookletChildList {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    tr:nth-child(odd) {background: lightgrey}
    th {background: darkred; color: white}

    #legend {
        display: flex; justify-content: space-around;
    }

    #legend div {
        padding: 10px;
    }

</style>

<h3>Liste des enfants</h3>

<div>
    <label> Date de rérérence
        <input type="text" id="refDate"  placeholder="Date de naissance" value="<?=  showDate($params->date);?>" style="width: 200px">
    </label>
    <input type="hidden" id="datepicker" name="refDate" value="<?= $params->date?>">
</div>


<div id="legend">
    <div class="row-draft">En brouillon</div>
    <div class="row-toreread">En relecture</div>
</div>

<div id="filterDate">

</div>


<table class="bookletChildList">

    <tr>
        <th>
            Child Id
        </th>
        <th>
            Lieu
        </th>
        <th>
            Nom
        </th>
        <th>
            Age
        </th>
        <th>
            Date
        </th>
        <th>
            Sport
        </th>
        <th>
            Coachs
        </th>
        <th>
            Dernier livret
        </th>
        <th colspan="2">
            Proposition
        </th>

    </tr>


    <?php $i = 0; foreach($params->childs as $childName => $element):?>

        <?php foreach($element as $activity):?>

            <?php $i++;?>
            <?php $currentDate = showDate($activity['date'], 'l-d');?>

            <?php

                $latestBooklets = null; $latest = ""; $status = null;

                if($activity['latestBooklets'] != null) {
                    foreach ($activity['latestBooklets'] as $element) {
                        if (stripos($element->name, $activity['sport']) !== false) {
                            $latestBooklets .= 'Date Evaluation : ' . showDate($element->dateEval) . ' - ' . $element->name . ' par ' . $element->staffName . '<br/>';
                            $latest = $element->name;
                            if($element->status == "draft") $status = "draft";
                            if($element->status == "toreread") $status = "toreread";

                        };
                    };
                }

              ?>


            <tr class="date-<?=$currentDate;?> row-<?= $status;?>">
                <td>
                    <?= $activity['childId'];?>
                </td>
                <td>
                    <?= $activity['locationName'];?>
                </td>
                <td>
                    <?= $childName;?>
                </td>
                <td>
                    <?= $activity['age'];?>
                </td>
                <td>
                    <?= showDate($activity['date'], 'l d');?>
                </td>
                <td>
                    <?= $activity['sport'];?>
                </td>
                <td>
                    <?= $activity['staffs'];?>
                </td>
                <td>

                    <?php echo $latestBooklets;?>

                </td>
                <td>
                    <select name="book_id" id="select-booklet-row<?= $i;?>">
                        <option></option>
                        <?php foreach($params->bookList as $id => $book_name):?>
                            <option value="<?= $id;?>" <?php if(isset($latest) && $book_name == $latest) echo " selected ";?>>
                                <?= $book_name;?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="staff_id" id="select-staff-row<?= $i;?>">
                        <option></option>
                        <?php foreach($params->staffs as $aStaff):?>
                            <option value="<?= $aStaff->staffId;?>" <?php if (isInCoachList($activity['staffs'], $aStaff->person->firstname)) echo ' selected ';?>>
                                <?= $aStaff->person->firstname;?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </td>
                <td>
                    <span title="valider" class="spanValidButton" data-refid="row<?= $i;?>" data-childid="<?= $activity['childId'];?>">
                        Créer
                    </span>
                </td>

            </tr>

            <?php $datesArray[$currentDate] = $currentDate;?>

            <script>

                newDate = "<?php echo $currentDate;?>";

                if(dates.indexOf(newDate) === -1) {
                    dates.push(newDate);
                }

            </script>

        <?php endforeach;?>

    <?php endforeach;?>

    <div id="test"></div>

</table>


<script>

    const datesSorted = dates.sort((a, b) => {
        const numA = parseInt(a.split('-')[1]);
        const numB = parseInt(b.split('-')[1]);
        return numA - numB;
    });


    let filterDiv = document.getElementById('filterDate');


    let html = `<ul class="filterDateBar">`;

    for(let i = 0; i < datesSorted.length; i++) {

        html +=  `<li>
            <input type="checkbox" onclick="filterAllDate('${datesSorted[i]}', this)" checked/> ${datesSorted[i]}
            </li>
        `;
    }

    html += "</li>";


    filterDiv.innerHTML = html;


    const filterAllDate = (currentDate, checkbox) => {

        console.log(currentDate);

        let displayValue = "";

        if( checkbox.checked == true) {

            displayValue = "table-row";

            console.log("show");

        } else {

            displayValue = "none";
        }

        document.querySelectorAll('.date-'+currentDate).forEach(element => {
            element.style.display = displayValue;
        });

    }

</script>

