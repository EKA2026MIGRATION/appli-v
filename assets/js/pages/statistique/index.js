const urlApi = $('#urlApi').val();
const colorList = [
    '#800000', '#e6194B', '#fabed4', '#dcbeff', '#4363d8', 
    '#D8BFD8', '#bfef45', '#ffd8b1', '#000075', '#aaffc3',
    '#f58231', '#fffac8', '#808000', '#469990', '#ffe119', 
    '#911eb4', '#ffd8b1', '#1E90FF', '#A0522D', '#4363d8',
]

$("#date_invoice1").datepicker({
    altField: "#datepicker1",
    altFormat: "yy-mm-dd",
    firstDay: 1,
    yearRange: "-5:+0",
    closeText: "Fermer",
    prevText: "Précédent",
    nextText: "Suivant",
    currentText: "Aujourd'hui",
    monthNames: [
        "Janvier",
        "Février",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juillet",
        "Août",
        "Septembre",
        "Octobre",
        "Novembre",
        "Décembre"
    ],
    monthNamesShort: [
        "Janv.",
        "Févr.",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juil.",
        "Août",
        "Sept.",
        "Oct.",
        "Nov.",
        "Déc."
    ],
    dayNames: [
        "Dimanche",
        "Lundi",
        "Mardi",
        "Mercredi",
        "Jeudi",
        "Vendredi",
        "Samedi"
    ],
    dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
    dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
    weekHeader: "Sem.",
    dateFormat: "dd/mm/yy",
    changeYear: true
});


$("#date_invoice2").datepicker({
    altField: "#datepicker2",
    altFormat: "yy-mm-dd",
    closeText: "Fermer",
    firstDay: 1,
    prevText: "Précédent",
    nextText: "Suivant",
    currentText: "Aujourd'hui",
    monthNames: [
        "Janvier",
        "Février",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juillet",
        "Août",
        "Septembre",
        "Octobre",
        "Novembre",
        "Décembre"
    ],
    monthNamesShort: [
        "Janv.",
        "Févr.",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juil.",
        "Août",
        "Sept.",
        "Oct.",
        "Nov.",
        "Déc."
    ],
    dayNames: [
        "Dimanche",
        "Lundi",
        "Mardi",
        "Mercredi",
        "Jeudi",
        "Vendredi",
        "Samedi"
    ],
    dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
    dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
    weekHeader: "Sem.",
    dateFormat: "dd/mm/yy",
    changeYear: true
});

$('#showListProductButton').click(function() {
    $('#showListProduct').toggle();
})


$('.selectFamilyProduct').change(function() {
    let val = $(this).val();
    if($(this).prop('checked')) {
        $('.'+val).prop('checked', true);

        console.log('ok');
    } else {
        $('.'+val).prop('checked', false);

                console.log('ko');

    }
})



let dateStart, dateEnd, modePayment;


$('.submitButtonForm').click(function(e) {
    e.preventDefault();
    dateStart   = $('#datepicker1').val();
    dateEnd     = $('#datepicker2').val();
    modePayment = $('#modePayment').val();
    metaGroup   = $('#metaGroups').val();

    let url = urlApi + 'statistique/repartition';
    let data = {dateStart : dateStart, dateEnd : dateEnd, modePayment : modePayment, metaGroups : metaGroups};
    data = JSON.stringify(data);

    console.log(data);

    $.ajax({
        url: url,
        type: 'POST',
        contentType: "application/json",
        headers: {
            'Authorization':'Bearer ' + tokenkAuth
        },
        contentLength: data.length,
        crossDomain: true,
        dataType: "json",
        data,
        beforeSend() {
            toastr.info("Recherche des stats");
        }, success(data) {
            
          console.log(data);


          let html = `<div class="" style="width: 100%; text-align: center"><b>Classement par MÉTA GROUP - CA TOTAL : ${data.caTotal} € pour ${data.nbTotal} produits</b></div>
                        <table class="weekData" style="width: auto; margin: 0 auto">
                            <tr>
                                <th style="padding: 4px">Catégorie</th>
                                <th>Total</th>
                                <th>%</th>
                            </tr>
                        `;
        
          let labelPies = [];
          let valuePies = [];
          let colorPies = [];
        

          let i = 0;
          for(const metaGroup in data.caMetagroup) {

            let val =  data.caMetagroup[metaGroup];
            let valPercent = val*100/data.caTotal;
            valPercent = Math.round(valPercent * 100) / 100;


            labelPies.push(metaGroup);
            valuePies.push(valPercent);
            colorPies.push(colorList[i]);

            html += `<tr>
                        <th style="padding: 0 40px; color: ${colorList[i]}">
                            ${metaGroup}
                        </th>
                        <td style="text-align: right; padding: 0 40px">
                            ${val} €
                        </td>
                        <td style="text-align: right; padding: 0 40px">
                           ${valPercent} %
                        </td>
                    </tr>`;
            
            i++;

          }



          html += `</table>`;

          $('#showResultRepartition').html(html);

          new Chart(document.getElementById("pie-chart"), {
            type: 'pie',
            data: {
            labels: labelPies,
            datasets: [{
                label: "Part du CA en %",
                backgroundColor: colorPies,
                data: valuePies
            }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Classement par Méta group - CA TOTAL : '+data.caTotal+' € pour '+data.nbTotal+' produits'
                },
                 plugins: {
                    datalabels: {
                        display: true,
                        align: 'bottom',
                        backgroundColor: '#ccc',
                        borderRadius: 3,
                        font: {
                            size: 14,
                        },
                        formatter: (value) => {
                            return value + ' %';
                        }
                    },
                }
            }
        });


        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });


})





// ca comparatif year by year


$('.selectSeason').change(function() {
    let value = $(this).val();
    let url = urlApi + 'season/display/' + value;
    let data = {};
    data = JSON.stringify(data);

    $.ajax({
        url: url,
        type: 'GET',
        contentType: "application/json",
        headers: {
            'Authorization':'Bearer ' + tokenAuth
        },
        contentLength: data.length,
        crossDomain: true,
        dataType: "json",
        data,
        beforeSend() {
            toastr.success("Recherche des semaines");
        }, success(data) {
            let html = " <p class='cartTitle'>Semaine</p><p><select id='selectWeek'><option>";
            for(let i = 0; i < data.weeks.length; i++) {
                let week = data.weeks[i];
                html += `<option class="type${week.kind}" value="${week.dateStart}|${week.dateEnd}|${week.name}">
                            Nom: ${week.name} - Du <b>${week.dateStart}</b> au <b>${week.dateEnd}</b>
                        </option>`;
            }
            html += "</select></p>";
            $('#listWeeks').html(html);
            let selectWeek = document.getElementById('selectWeek');
            selectWeek.addEventListener('change', function() {
                showStats(this.value);
            });
        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });
})


const percentEvol = (current, ref) => {
    let progressValue = (current  * 100 / ref) - 100;
    progressValue = Math.round(progressValue * 100) / 100;
    let progressDirection = "";

     if(progressValue > 0) {
        progressDirection = "arrow_upward";
    } else {
        progressDirection = "arrow_downward";
    }

    return [progressValue, progressDirection];
}

const createTdPercent = (current, ref) => {
     let progressValue = (current  * 100 / ref) - 100;
    progressValue = Math.round(progressValue * 100) / 100;
    let progressDirection = "";

     if(progressValue > 0) {
        progressDirection = "arrow_upward";
    } else {
        progressDirection = "arrow_downward";
    }

    let html = `
                <td>${progressValue} %</td>
                <td>
                    <i class="material-icons  ${progressDirection}Progress">
                        ${progressDirection}
                    </i>
                </td>`;
    return html;
}


const showStats = (elements) => {
    
    let el = elements.split('|');
    let dateStart = el[0];
    let dateEnd = el[1];
    let weekName = el[2];

    let seasonRefId = $('#selectReference').val();


    let url = urlApi + 'statistique/ca';
    let data = {    
        dateStart : dateStart,
        dateEnd : dateEnd,
        weekName : weekName,
        seasonRefId : seasonRefId

    };
    data = JSON.stringify(data);

    $.ajax({
        url: url,
        type: 'POST',
        contentType: "application/json",
        headers: {
            'Authorization':'Bearer ' + tokenAuth
        },
        contentLength: data.length,
        crossDomain: true,
        dataType: "json",
        data,
        beforeSend() {
            toastr.info("Recherche des stats");
        }, success(data) {
            
            let html = "";

            console.log(data.week);
            console.log(data.weekRef);

            let tempoValue = "";

            if(data.week != null || data.weekRef != null) {

                if(data.week.totalTtcWeek != "0.00" && data.weekRef.totalTtcWeek != "0.00") {

                        let progressWeekValue = percentEvol(data.week.totalTtcWeek, data.weekRef.totalTtcWeek)[0];
                        let progressWeekDirection = percentEvol(data.week.totalTtcWeek, data.weekRef.totalTtcWeek)[1];
                        
                        html = `<div class="" style="width: 100%">
                            <div class="${progressWeekDirection}Progress"><b>Bilan semaine - évolution CA : ${progressWeekValue} %</b></div>
                            <table class="weekData">
                                <tr>
                                    <th></th>
                                    <th class="currentWeek">Semaine en cours</th>
                                    <th>Semaine de référence</th>
                                    <th>Evolution</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th>CA TOTAL TTC</th><td class="currentWeek">${data.week.totalTtcWeek } €</td><td>${data.weekRef.totalTtcWeek } €</td>
                                    ${createTdPercent(data.week.totalTtcWeek, data.weekRef.totalTtcWeek )}
                                </tr>
                                 <tr>
                                    <th>CA TOTAL HT </th><td class="currentWeek">${data.week.totalHtWeek } €</td><td>${data.weekRef.totalHtWeek } €</td>
                                    ${createTdPercent(data.week.totalHtWeek, data.weekRef.totalHtWeek )}

                                </tr>
                                 <tr>
                                    <th>NB enfants</th><td class="currentWeek">${data.week.nbChildPresenceWeek }</td><td>${data.weekRef.nbChildPresenceWeek }</td>
                                    ${createTdPercent(data.week.nbChildPresenceWeek, data.weekRef.nbChildPresenceWeek )}
                                </tr>`
                                
                                
                                ;

                        for (const location in data.week.totalTtcByLocationWeek) {
                        

                            if(data.weekRef.totalTtcByLocationWeek[location] == undefined) {
                                tempoValue = "0";
                            } else {
                                tempoValue = data.weekRef.totalTtcByLocationWeek[location];
                            }

                            html += 
                                `
                                <tr>
                                    <th>CA TTC ${location} </th><td class="currentWeek">${data.week.totalTtcByLocationWeek[location]} €</td><td>${tempoValue} €</td>
                                    ${createTdPercent(data.week.totalTtcByLocationWeek[location], tempoValue )}
                                </tr>`;
                            
                            if(tempoValue != "0") {
                                tempoValue = data.weekRef.totalHtByLocationWeek[location];
                            }
                            
                            html += 
                                `
                                 <tr>
                                    <th>CA HT ${location} </th><td class="currentWeek">${data.week.totalHtByLocationWeek[location]} €</td><td>${tempoValue} €</td>
                                    ${createTdPercent(data.week.totalHtByLocationWeek[location], tempoValue )}
                                </tr>`;
                            ;

                        }

                        tempoValue = "";




                        for (const location in data.week.nbPresencesByLocationWeek) {
                        

                            if(data.weekRef.nbPresencesByLocationWeek[location] == undefined) {
                                tempoValue = 0;
                            } else {
                                tempoValue = data.weekRef.nbPresencesByLocationWeek[location];
                            }

                            html += 
                                `
                                <tr>
                                    <th>Présences enfants ${location} </th><td class="currentWeek">${data.week.nbPresencesByLocationWeek[location]}</td><td>${tempoValue}</td>
                                    ${createTdPercent(data.week.nbPresencesByLocationWeek[location], tempoValue )}
                                </tr>`;

                        }

                        tempoValue = "";

                            
                        
                                
                         html +=    `</table>
                        
                        </div>`;
                }
            }

            for(let i = 0; i < data.result.length; i++) {


                html += "<ul class='ulResult'>";

                let element = data.result[i];
                let elementRef;

                if(data.resultRef == null) {
                    elementRef = null;

                } else {
                    elementRef = data.resultRef[i];
                }


                let currentObject;

                html += `
                <li style='text-align:center; padding-left: 4px; padding-right: 4px'>
                    <b style="color: darkblue">${element.date}</b><br/>`;
            
                if(element.hasData == true) {
                    html += `
                            <ul>
                                <b>PRESENCES</b>
                                <ul>
                                    <li>Total : ${element.presences.nbTotalPresences}</li>`;
                        
                                    currentObject = element.presences.nbTotalByLocation;
                                    html += `<ul>`;
                                    for (const location in currentObject) {
                                        html += `<li><b>${location}</b>: ${currentObject[location]}<br/>`;


                                        for(const moment in element.presences.nbByLocationByMoment[location]) {
                                            html += ` ${moment}:  ${element.presences.nbByLocationByMoment[location][moment]} `;
                                        }

                                        html += `</li>`;
                                        
                                        if( element.presences.amountRefDay[location] != null) {
                                            html += `<i>Valeur moyenne Day : ${element.presences.amountRefDay[location]} € <br/> soit ${element.presences.nbDayByTtcDayAmount[location]} journées</i>`;
                                        }

                                    }
                                    html += `</ul>`;     

                    html += `
                                </ul>
                            </ul>
                    `;

                    html += `
                            <ul class="totalCaUl">
                                <br/>
                                <ul>
                                    <li>
                                        <b>Total TTC: ${element.total.totalTtcByDate} €</b><br/>
                                        <ul>
                                        <li>Total HT : ${element.total.totalHtByDate} €</li>`;
                                        
                                        for (const property in element.total.totalVatByDate) {
                                            html += `<li>TVA à ${property} %: ${element.total.totalVatByDate[property]} €</li>`;
                                        }

                                    html += `</ul>

                                    </li>`;
                };


                // element ref
                if(elementRef != null && elementRef.hasData == true) {

                    let progressDirection = "";
                    let progressValue = "";

                    if(element.hasData == true) {

                        progressValue = (element.total.totalTtcByDate * 100 / elementRef.total.totalTtcByDate) - 100;
                        progressValue = Math.round(progressValue * 100) / 100;

                        if(progressValue > 0) {
                            progressDirection = "arrow_upward";
                        } else {
                            progressDirection = "arrow_downward";
                        }

                    }

                    let dayRef = elementRef.date.replace('<br/>', ' ');

                    html += `<li class="dataRef">
                        Données de comparaison<br/>
                        ${dayRef}<br/>
                        <b>Total TTC : ${elementRef.total.totalTtcByDate} €</b><br/>

                        <ul>
                        <li>Total HT : ${elementRef.total.totalHtByDate} €</li>`;
                        
                        for (const property in elementRef.total.totalVatByDate) {
                            html += `<li>TVA à ${property} %: ${elementRef.total.totalVatByDate[property]} €</li>`;
                        }

                    html += `</ul>

                    </li>
                    
                    <br/>`;

                    if(element.hasData == true) {
                        html += `<li class="${progressDirection}Progress">${progressValue} %</li>`;
                    }
                }

                html += `<br/>`;

                if(element.hasData == true) {            

                                    currentObject = element.total.totalTtcByFamily;
                                    html += `Par produit<ul>`;
                                    for (const family in currentObject) {
                                        html += `<li><b>${family}</b>: ${currentObject[family]} €</li>`;
                                    }
                                    html += `</ul>`;
                        
                                    currentObject = element.total.totalTtcByLocation;
                                    html += `<hr/><ul>`;
                                    for (const location in currentObject) {
                                        html += `<li><b>${location}</b>: ${currentObject[location]} €<br/>`;

                                        for(const moment in element.total.totalTtcByLocationByMoment[location]) {
                                            html += ` ${moment}:  ${element.total.totalTtcByLocationByMoment[location][moment]} €`;
                                        }

                                        html += `</li>`;

                                    }
                                    html += `</ul>`;
                    
                    html += `
                                </ul>
                                <br/>
                            </ul>
                    `;

            
                    html += `
                            <ul>
                                <b>MOYENNE</b><br/>
                                `;



                                    currentObject = element.averageTotal.averageTtcByLocation;
                                    
                                    html += `Moyenne par lieu (total/nb presence)<ul>`;
                                    for (const location in currentObject) {
                                        html += `<li><b>${location}</b>: ${currentObject[location]} €<br/>`;


                                        for(const moment in element.averageTotal.listAmountByLocationMoment[location]) {

                                            html += `<ul>`;

                                                let costString;

                                                if(element.averageTotal.averageTtcLocMomentProp[location] != undefined) {
                                                    costString = ` - coût moyen opti: ${element.averageTotal.averageTtcLocMomentProp[location][moment]} €`;
                                                } else {
                                                    costString = '';
                                                }

                                                html += `<i>${moment} ${costString}</i><br/>`;
                                                
                                                for(const price in element.averageTotal.listAmountByLocationMoment[location][moment] ) {
                                                    html += ` <li>${element.averageTotal.listAmountByLocationMoment[location][moment][price]} à ${price} €</li>`;
                                                }
                                            html += `</ul>`;

                                        }

                                        html += `</li>`;



                                    }
                                    html += `</ul>`;
                            

                    html += `
                            </ul>
                    `;

                }
                  
                html += `</li>`;

                html += "</ul>";
            }
           
            $("#showResult").html(html);

        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });
}


document.getElementById('submitAnalyse').addEventListener('click', function() {
    let year = document.getElementById('analyseYear').value;
    let month = document.getElementById('analyseMonth').value;
    let url = urlApi + 'statistique/estimation/' + month + '/' + year;
    let data = {};
    data = JSON.stringify(data);

    $.ajax({
        url: url,
        type: 'GET',
        contentType: "application/json",
        headers: {
            'Authorization': 'Bearer ' + tokenAuth
        },
        contentLength: data.length,
        crossDomain: true,
        dataType: "json",
        data,
        beforeSend() {
            toastr.info("Recherche des stats");
        }, success(data) {
            updateData(data);
        }
    });

});


const updateData = (data) => {


    const dataJson = JSON.stringify(data, null, 2);

    console.log(dataJson);

    let current = data.current;
    let history = data.history;
    let currentWeeks = '';
    let historyWeeks = '';

    for (let key of Object.keys(current.season.weeks)) {
        let week = current.season.weeks[key];
        let formattedFrom = cleanDateTime(week.from);
        let formattedTo = cleanDateTime(week.to);
        currentWeeks += `<li>${key} (${week.kind}) - ${formattedFrom} - ${formattedTo}</li>`;
    }

    for (let key of Object.keys(history.season.weeks)) {
        let week = history.season.weeks[key];
        let formattedFrom = cleanDateTime(week.from);
        let formattedTo = cleanDateTime(week.to);
        historyWeeks += `<li>${key} (${week.kind}) - ${formattedFrom} - ${formattedTo}</li>`;
    }


    let historyRegistration = createRegistrationList(history.registration);
    let currentRegistration = createRegistrationList(current.registration);

    let currentActivitiesHtml = buildHtmlForData(current.activitys, "Activités en cours ", history.activitys);
    let historyActivitiesHtml = buildHtmlForData(history.activitys, "Activités passées");
    let currentPresencesHtml = buildHtmlForData(current.presences, "Présences en cours", history.presences);
    let historyPresencesHtml = buildHtmlForData(history.presences, "Présences passées");

    let html = `
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr><th class="center">Date de référence</th><th class="center">Date cible</th></tr>
                <tr>
                    <th class="center">${cleanDateTime(history.season.dateStart)} - ${cleanDateTime(history.season.dateEnd)}</th>    
                    <th class="center">${cleanDateTime(current.season.dateStart)} - ${cleanDateTime(current.season.dateEnd)}</th>
                    
                </tr>
            </thead>
                
            <tbody>
                <tr>
                    <td>
                        <ul>
                            ${historyWeeks}
                        </ul>
                    </td>
                    <td>
                        <ul>
                             ${currentWeeks}
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Inscriptions</b><br/>
                        ${historyRegistration}
                    </td>
                    <td>
                         <b>Inscriptions</b><br/>
                         ${currentRegistration}
                    </td>
                </tr>
                
                <tr>
                    <td>${historyActivitiesHtml}</td>
                    <td>${currentActivitiesHtml}</td>
                </tr>
                
                 <tr>
                    <td>${historyPresencesHtml}</td>
                    <td>${currentPresencesHtml}</td>
                </tr>
            </tbody>
        </table>
    `;

    $("#showResult").html(html);



}

const cleanDateTime = (date) => {
    let dateArray = date.split(' ');
    let dateArray2 = dateArray[0].split('-');
    return dateArray2[2] + '/' + dateArray2[1] + '/' + dateArray2[0];
}
const buildHtmlForData = (data, title, dataRef = null) => {
    let html = `<b style="font-size:20px; color: darkblue">${title}</b><br/>`;

    const buildPath = (path, key) => path ? [...path, key] : [key];

    const processValue = (key, value, path) => {
        let trend = '';
        if (dataRef) {
            const refValue = getValueAtPath(dataRef, path);
            trend = compareTrend(refValue, value);
        }

        if (typeof value === 'object' && !Array.isArray(value) && value !== null) {
            html += `<li><b>${key}</b><ul>`;
            for (let [innerKey, innerValue] of Object.entries(value)) {
                processValue(innerKey, innerValue, buildPath(path, innerKey));
            }
            html += `</ul></li>`;
        } else {
            // La couleur est déterminée ici pour les valeurs non-objets
            let color = getColor(value, data, path);
            html += `<li style="color:${color}">${key}: ${value} ${trend}</li>`;
        }
    };

    const getColor = (value, data, path) => {
        if (!path || path.length === 0) return ''; // Pas de chemin, pas de couleur

        // Accéder au parent de la valeur actuelle
        let parent = data;
        for (let i = 0; i < path.length - 1; i++) {
            parent = parent[path[i]];
        }

        // Calculer min et max sur les valeurs numériques du parent
        const numericValues = Object.values(parent).filter(v => typeof v === 'number');
        const minValue = numericValues.length > 0 ? Math.min(...numericValues) : null;
        const maxValue = numericValues.length > 0 ? Math.max(...numericValues) : null;

        if (minValue !== null && value === minValue) return 'red';
        if (maxValue !== null && value === maxValue) return 'green';
        return '';
    };

    const getValueAtPath = (dataRef, path) => {
        let value = dataRef;
        for (const key of path) {
            if (value[key] === undefined) return null;
            value = value[key];
        }
        return value;
    };

    for (let [key, value] of Object.entries(data)) {
        processValue(key, value, [key]);
    }

    return html;
};


const compareTrend = (referenceValue, value) => {
    if (referenceValue === null || referenceValue === undefined) return '';
    if (referenceValue === 0) return value > 0 ? '+++' : '';
    if (value === referenceValue) return '';

    const percentChange = ((value - referenceValue) / Math.abs(referenceValue)) * 100;
    if (percentChange >= 50) return '+++';
    if (percentChange >= 25) return '++';
    if (percentChange > 0) return '+';
    if (percentChange <= -50) return '---';
    if (percentChange <= -25) return '--';
    if (percentChange < 0) return '-';
    return '';
};

const createRegistrationList = (registration) => {

    let registrationList = '';

    // Fonction de tri par ordre décroissant
    const sortByValueDesc = (obj) => Object.entries(obj)
        .sort((a, b) => b[1] - a[1])
        .map(entry => `<li>${entry[0]}: ${entry[1]}</li>`)
        .join('');

    // Total By Family
    registrationList += '<b>Total par famille</b><ul>';
    registrationList += sortByValueDesc(registration.totalByFamily);
    registrationList += '</ul>';

    // Total By Location
    registrationList += '<b>Total par lieu</b><ul>';
    registrationList += sortByValueDesc(registration.totalByLocation);
    registrationList += '</ul>';

    // Total By Product - Seulement les 6 premiers
    registrationList += '<b>Total par produits (6 premiers)</b><ul>';
    registrationList += Object.entries(registration.totalByProduct)
        .sort((a, b) => b[1] - a[1])
        .slice(0, 6)
        .map(entry => `<li>${entry[0]}: ${entry[1]}</li>`)
        .join('');
    registrationList += '</ul>';

    // Ajouter totalHasLunch, totalHasTransport et totalRegistration
    registrationList += `<li><b>Total de repas:</b> ${registration.totalHasLunch}</li>`;
    registrationList += `<li><b>Total produit avec transport:</b> ${registration.totalHasTransport}</li>`;
    registrationList += `<li><b>Total d'inscriptions:</b> ${registration.totalRegisration}</li>`;

    return registrationList;
}








