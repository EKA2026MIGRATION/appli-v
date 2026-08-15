<?php use_helper('evaluation, translation');?>
<?php use_helper('dates');?>
<style>
        .draftStatus i, .readyStatus i {  width: 30px; 
                                      height: 30px ; 
                                      border-radius: 50px;
                                      font-size: 18px;
                                      line-height: 30px;
                                      text-align: center;
                                      padding-left: 6px;
                                }
    .draftStatus i { background-color: darkred; color: white}
    .readyStatus i { background-color: green; color: white}

    .flexRow {
        display: flex; flex-wrap: wrap;
    }

    .flexRow select {
        width: 30%;
    }


    #statButton {
        padding: 20px;
        background-color: darkblue;
        color: white;
        font-weight: bold;
        font-size: 14px;
        cursor: pointer;
    }



    @media screen and (max-width: 674px) {
        thead { display: none}
        td { display: block}

        tr td:first-child {
            float: left;
            width: 50%;
        }
        tr td:nth-child(2) {
            float: left;
            width: 50%;
        }

        tr td:nth-child(3) {
            float: left;
            width: 50%;
        }


        tr td:nth-child(4) {
            float: left;
            width: 40%;
        }

        tr td:last-child {
            float: right;
            width: 10%
        }

    }                         

</style>
<?php $currentChildId = null;?>


<?php if(count((array) $params->bookletChilds) < 1):?>

    Aucun livret à afficher.

<?php else:?>


    <button id="statButton">Statistiques</button>
    <div id="showStats" style="display: none">

    </div>

    <br/><br/>

    <div class="flexRow">
        <select name="filterstaff" id="filterByStaff" class="filterSelect">
        </select>

        <select name="filterbooklet" id="filterByBooklet" class="filterSelect">
        </select>

        <select name="filterstatus" id="filterByStatut" class="filterSelect">
            <option value="all">Tous les status</option>
            <option value="draft">Brouillon</option>
            <option value="toreread">A relire</option>
            <option value="ready">Prêt</option>
        </select>

        <div>
            <input type="checkbox" id="filterMonth">&nbsp;&nbsp;Afficher les 2 derniers mois
        </div>
    </div>



    <table class="bookletChildList">
        <thead>
            <tr>
                <th>Enfant</th>
                <th>Livret</th>
                <th>Coach</th>
                <th>Dernière modification</th>
                <th>Statut</th>
                <th>Date évaluation</th>
                <th/>
            </tr>
        </thead>


        <tbody>

            <?php foreach($params->bookletChilds as $bookletChild):?>

                <?php $status = str_replace('-', '/', $bookletChild->status);?>

                <?php $child = $bookletChild->child;?>
                <?php $border = null;?>
                <?php if($child->childId != $currentChildId) $border="border-top: 1px solid darkred";?>

                <tr class="row bookletChildRow" id="bookletChildRow<?= $bookletChild->id;?>" data-month="<?= showDate($bookletChild->updatedAt, 'm');?>" data-filterstaff="<?= $bookletChild->staff->fullname;?>" data-filterstatus="<?= $status;?>" data-filterbooklet="<?= $bookletChild->booklet->name;?>" style="<?= $border;?>">
                    <td>
                        <?php if( $status == 'toreread'):?>
                            <i class="material-icons" style="color: green">check</i>
                        <?php endif;?>
                        <?php if( $status == 'draft'):?>
                            <i class="material-icons" style="color: darkred">close</i>
                        <?php endif;?>
                        <?php if( $status == 'ready'):?>
                            <i class="material-icons" style="color: green">verified</i>
                        <?php endif;?>
                        <b><?= $child->fullnameReverse;?></b>
                    </td>
                    <td>
                        <?php echo $bookletChild->booklet->name;?>
                    </td>
                    <td>
                        <i><?php echo $bookletChild->staff->fullname;?></i>
                    </td>
                    <td>
                        <?php echo showDate($bookletChild->updatedAt);?>
                        <?php if(isset($bookletChild->updatedBy)):?>
                            <br/>par <?php echo $bookletChild->updatedBy;?>
                        <?php endif;?>
                    </td>
                    <td class="<?= $bookletChild->status ;?>Status">
                        <?php echo showEvaluationIconStatus($status);?>
                        <?php echo trans($status);?>
                    </td>
                    <td>
                        <?php echo showDate($bookletChild->dateEvaluation);?>
                    </td>
                    <td>
                        <a href="<?= HOST ?>booklet/edit/id/<?php echo $bookletChild->id;?>/" target="_blank">
                            <i class="material-icons" style="cursor: pointer; color: darkblue">edit</i>
                        </a>

                        <a href="<?= HOST ?>livret/energy/enfant/<?= encodeInt($bookletChild->id);?>/<?= sha1($child->firstname);?>" target="_blank">
                            <i class="material-icons" style="cursor: pointer; color: green">visibility</i>
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;

                        <i class="material-icons" onclick="deleteBookChild(<?= $bookletChild->id;?>)" style="cursor: pointer; color: darkred">delete</i>

                    </td>
                </tr>

                <?php $currentChildId = $child->childId;?>


                <?php $staffList[$bookletChild->staff->staffId] = $bookletChild->staff->fullname;?>
                <?php $bookletList[$bookletChild->booklet->id] = $bookletChild->booklet->name;?>


                <?php

                    if(!isset($statsBooket[$bookletChild->staff->fullname]['totalBooket'])) $statsBooket[$bookletChild->staff->fullname]['totalBooket'] = 0;
                    $statsBooket[$bookletChild->staff->fullname]['totalBooket'] ++;


                    if(!isset($statsBooket[$bookletChild->staff->fullname][$status])) $statsBooket[$bookletChild->staff->fullname][$status] = 0;
                    $statsBooket[$bookletChild->staff->fullname][$status] ++;

                ;?>

            <?php endforeach;?>

        </tbody>

    </table>

    <?php ksort($statsBooket);?>
    <?php $statsBooketJson = json_encode($statsBooket);?>
    <?php sort($staffList);?>
    <?php sort($bookletList);?>

<?php endif;?>

<script>

    let statsBooklet = JSON.parse('<?php echo $statsBooketJson;?>');

    let showStatsDiv = document.getElementById('showStats');
    let showStatsButton = document.getElementById('statButton');
    let openStat = false;


    let date = new Date();
    let currentMonth = (date.getMonth() + 1).toLocaleString('en-US', { minimumIntegerDigits: 2, useGrouping: false });
    let previousMonth = (parseInt(currentMonth, 10) - 1).toString().padStart(2, "0");


    showStatsButton.addEventListener('click', function() {
        if (!openStat) {
            showStatsDiv.style.display = 'block';
            openStat = true;
        } else {
            showStatsDiv.style.display = 'none';
            openStat = false;
        }
    });

    let htmlStat = "<ul id='statUl'>";

    let proprieteText = "";

    for (let name in statsBooklet) {
        if (statsBooklet.hasOwnProperty(name)) {
            htmlStat += `<li><b>${name}</b> : `;
            let count = 0;
            for (let propriete in statsBooklet[name]) {
                if (statsBooklet[name].hasOwnProperty(propriete)) {

                    if(propriete == "totalBooket") { proprieteText = "Total"};
                    if(propriete == "toreread") { proprieteText = "A relire"};
                    if(propriete == "draft") { proprieteText = "Brouillon"};
                    if(propriete == "ready") { proprieteText = "Prêt"};
                    if(propriete == "published") { proprieteText = "Publié"};


                    if(count > 0) htmlStat += ' - ';

                    htmlStat += `${proprieteText}: ${statsBooklet[name][propriete]} `;

                    count++;
                }
            }

            htmlStat += `</li>`;
        }
    }

    htmlStat += `</ul>`;

    showStatsDiv.innerHTML = htmlStat;

    staffList = <?php echo json_encode($staffList); ?>;
    bookletList = <?php echo json_encode($bookletList); ?>;

  html = "<option value='all'>Tout le staff</option>";
  for(var key in staffList) {
    let value = staffList[key];

    html += `<option value="${staffList[key]}">${staffList[key]}</option>`;
  

  }

  document.getElementById('filterByStaff').innerHTML = html;


  html = "<option value='all'>Tout les livrets</option>";
  for(var key in bookletList) {
    let value = bookletList[key];
    html += `<option value="${bookletList[key]}">${bookletList[key]}</option>`;

  }

  document.getElementById('filterByBooklet').innerHTML = html;


  hideAll = () => {
    let rows = document.getElementsByClassName('bookletChildRow');
      for(let i = 0; i < rows.length; i++) {
          rows[i].hidden = true;
      }
  }

  showAll = () => {
        let rows = document.getElementsByClassName('bookletChildRow');
        for(let i = 0; i < rows.length; i++) {
            rows[i].hidden = false;
        }
  }

   showElements = (targetName) => {
        let targets = document.querySelectorAll(targetName);
        for(let i = 0; i < targets.length; i++) {
            targets[i].hidden = false;
        }
  }

   resetSelect = (name) => {
      let items = document.getElementsByClassName('filterSelect');
      for(let i = 0; i < items.length; i++) {
          console.log(name+' '+items[i].name);
            if(name != items[i].name) {
                items[i].selectedIndex = 0; 
            }
        }

  }


   filterList = (event) => {
        let name  = event.target.name;
        let value = event.target.value;

        if(value == "all") {
            showAll();
        } else {
            hideAll();
            resetSelect(name);
            showElements("tr[data-"+name+"='"+value+"']");
        }
  }


  selects = document.getElementsByClassName('filterSelect');
  for(let i = 0; i < selects.length; i++) {
      selects[i].addEventListener('change', function(event) {
            filterList(event);
      });
  }



    let checkboxFilterMonth = document.querySelector('#filterMonth');

    checkboxFilterMonth.addEventListener('click', function() {
        if (this.checked) {

            hideAll();

            let rows = document.getElementsByClassName('bookletChildRow');
            for(let i = 0; i < rows.length; i++) {
                if(row[i].dataset.month == currentMonth || row[i].dataset.month == previousMonth) {
                    rows[i].hidden = false;
                }
            }
        } else {
            showAll();
        }
    });


</script>