const urlApi = $('#urlApi').val();

let fromRequest, orderRequest, limitRequest, table, keyFilter;
let selectRequest = [];
let joinBase = [];
let joinRequest = [];
let whereRequest = [];
let aliaseTable = [];
let groupByRequest = "keyFilter";

/**************  event listenner */
$('.selectCriteria').change( function() {
    let typeCriteria = $(this).find('option:selected').attr('data-type');
    $('.typeCriteria').hide();
    $("#"+typeCriteria+"Criteria").show();
})

$('.typeCriteriaSelect').change(function() {
    let myOpt = this.options[this.selectedIndex];

    let comparatifType = myOpt.getAttribute('data-type');
    let comparatifVars = myOpt.getAttribute('data-vars');

    $('.inputCriteriaValue').hide();

    if(comparatifVars == "val") {
        $('#'+comparatifVars+'Input').show();
    } else {
        let el = comparatifVars.split('-');
        $('#'+el[0]+'Input').show();
        $('#'+el[1]+'Input').show();
    }
    $('#addButtonCriteria').show();
})

// START SELECTION
$('#tableSearchSelect').change(function() {

    let selectedValue = $(this).val();
    $('[id^="paramsData"]').hide();
    $('[id^="selectCriteria"]').hide();

    $('[id^="paramsData"] input[type="checkbox"]').prop('checked', false);

    if (selectedValue === 'child as c') {
        $('#paramsDataChild').show();
        $('#selectCriteriaChild').show();
        table = "child";
        keyFilter = "c.child_id, cp.person_id";

    } else if (selectedValue === 'call_twilio as clt') {
        $('#paramsDataCallTwilio').show();
        $('#selectCriteriaCallTwilio').show();
        table = "call_twilio";
        keyFilter = "clt.call_sid, clt.id";
    }
    updateSqlFrom();
})

$('.fieldSelected').change(function() {
    updateSqlSelect();
})

$('#addButtonCriteria').click(function(){
    updateSqlWhere();

})

$('#validExtractList').click(function(event) {
    event.preventDefault();
    sendFormExtractList();
});


const deleteLiWhereFunc = (whereRequestString) => {

    $('.liFlexBox[data-element="'+whereRequestString+'"]').remove();
    for(let i = 0; i < whereRequest.length; i++) {
        if(whereRequest[i] == whereRequestString) {
            whereRequest.splice(i,1);
        }
    } 

    // update join
    updateSqlJoin();
    showSqlWhere();
}




/************* créatation des elements de la requete  **/


const updateSqlSelect = () => {

    selectRequest = [];

    updateAliaseTable();

    $('.fieldSelected').each(function() {
        
        if( $(this).is(':checked')  ) {       
            let value = $(this).attr('name');
            selectRequest.push(value);
        } 
    });
    updateSqlJoin();
    showSqlSelect();
}


const updateSqlFrom = () => {
    let tableSearched = $('#tableSearchSelect').val();
    $('#values_table_name').val(tableSearched);
    fromRequest = tableSearched;
    showSqlFrom();
}

/**
 * create Join from Aliase
 */
const updateSqlJoin = () => {

    if(table == "child") {

        let joinString = "";

        // reset join request
        joinRequest = [];

        // add base and key filter if select is child
        joinString = " INNER JOIN child_person_link as cp ON c.child_id = cp.child_id <br/>INNER JOIN person as p ON cp.person_id = p.person_id";
        joinRequest.push(joinString);
        keyFilter = keyFilter;

        if (aliaseTable.includes('ph')) {
            joinString = " INNER JOIN person_phone_link as pp ON p.person_id = pp.person_id <br/>INNER JOIN phone as ph ON pp.phone_id = ph.phone_id ";
            joinRequest.push(joinString);
            keyFilter = keyFilter + ", ph.phone_id";
        }

        if (aliaseTable.includes('u')) {
            joinString = " INNER JOIN user_person_link as up ON up.person_id = p.person_id <br/>LEFT JOIN user as u ON up.user_id = u.id ";
            joinRequest.push(joinString);
            keyFilter = keyFilter + ", u.id";
        }

        if (aliaseTable.includes('s')) {
            joinString = " LEFT JOIN school as s ON c.school_id = s.school_id ";
            joinRequest.push(joinString);
        }

        if (aliaseTable.includes('a')) {
            joinString = " INNER JOIN person_address_link as pa ON p.person_id = pa.person_id <br/>INNER JOIN address as a ON pa.address_id = a.address_id ";
            joinRequest.push(joinString);
        }

        if (aliaseTable.includes('cpr')) {
            joinString = " INNER JOIN child_presence as cpr ON cpr.child_id = c.child_id";
            joinRequest.push(joinString);
        }

        showSqlJoin();

    }
}

const updateSqlWhere = () => {
    let criteria, criteriaTxt;

    if(table == "child") {
        criteria = $('#selectCriteriaChild').val();
        criteriaTxt = $('#selectCriteriaChild option:selected').text();
    }

    if(table == "call_twilio") {
        criteria = $('#selectCriteriaCallTwilio').val();
        criteriaTxt = $('#selectCriteriaCallTwilio option:selected').text();
    }

    let comparaison = $('.typeCriteriaSelect:visible').val();
    let value;

    let comparaisonTxt = $.trim($('.typeCriteriaSelect:visible option:selected').prop('selected', true).text());

    if ( comparaison == "between") {
        value = $('#fromInput').val()+'|'+$('#toInput').val();
    } else {
        value = $('#valInput').val();
    }

    let valueTxt = value;


    createSqlWhere(criteria, comparaison, value, criteriaTxt, comparaisonTxt, valueTxt);
}

const createSqlWhere = (criteria, comparaison, value, criteriaTxt, comparaisonTxt, valueTxt) => {

    // transforme value if age
    if(criteria == "age") {

        // change criteria
        criteria = "c.birthdate";

        // change value
        let today = new Date();

        let monthString = "";
        let month = today.getMonth()+1;
        if(month < 10) {
            monthString = "0"+month;
        } else {
            monthString = month;
        }

        let dayWeekString = "";
        let dayWeek = today.getDate()+1;
        if(dayWeek < 10) {
            dayWeekString = "0"+dayWeek;
        } else {
            dayWeekString = dayWeek;
        }

        let targetDate = today.getFullYear() - parseInt(value) +'-'+monthString+'-'+dayWeekString;
        value = targetDate;

        // change comparaison
        switch (comparaison) {
            case 'after':
                comparaison = "before";
                break;
            case 'before':
                comparaison = "after";
                break;
            default:
                console.log('pb sur comparaison '+comparaison);
        }
    }


    // whereRequest string ti injet
    let whereRequestString = criteria+'***'+comparaison+'***'+value;

    // show line with the identification from WhereRequest
    let html = `
    <li class="liFlexBox" data-element="${whereRequestString}">
            <span>${criteriaTxt}</span>
            <span>${comparaisonTxt}</span>
            <span>${value}</span>
            <span class="deleteLiWhere" onclick = "deleteLiWhereFunc('${whereRequestString}')">SUPPRIMER</span>
        </li>`;

    $('#whereCriteriaElements').append(html);

    // push in whereRequest
    whereRequest.push(whereRequestString);

    // create aliase
    let aliase = criteria.split('.')[0];

    // add to aliase
    if(!aliaseTable.includes(aliase)) {
        aliaseTable.push(aliase);
    } 
    // update join
    updateSqlJoin();

    showSqlWhere();
}

const updateAliaseTable = () => {
    
    // reset aliaseTable
    aliaseTable = [];

    // boucle select 
    $('.fieldSelected').each(function() {
        
        if( $(this).is(':checked')  ) {       
            // update value in string and valueArray
            let value = $(this).attr('name');
            
            // retrieve age or field interpretate
            let aliase = value.split('.')[0];
             
            if(!aliaseTable.includes(aliase)) {
                aliaseTable.push(aliase);
            } 
        } 
    });


    // boucle where
    for(let i = 0; i < whereRequest.length; i++) {
        let elementWhereRequest = whereRequest[i].split('***');
        let aliase = elementWhereRequest[0].split('.')[0];
        if(!aliaseTable.includes(aliase)) {
            aliaseTable.push(aliase);
        } 
    }
    
}


/********* affichae des elements de la requete */

const showSqlSelect = () => {

    let selectString = "";
    for(let i = 0; i < selectRequest.length; i++) {   
        
        let selectElement = "";

        if( selectRequest[i] == "age") {
            selectElement = "TIMESTAMPDIFF(year,c.birthdate, now()) as age";
        } else {
            selectElement = selectRequest[i];
        }

        if( i > 0) { selectString += ", " ;}
        selectString += selectElement; 
       
    }

    $('#selectRequest').html("SELECT "+selectString+", CONCAT("+keyFilter+") as keyFilter ");
}


const showSqlFrom = () => {
    $('#fromRequest').html(' FROM '+fromRequest);
}


const showSqlJoin = () => {
    let joinRequestString = ""
    for(let i = 0; i < joinRequest.length; i++) {
        joinRequestString = joinRequestString + joinRequest[i] + "<br/>";
    }

    $('#joinRequest').html(joinRequestString);    
}

const showSqlWhere = () => {

    let whereString = "  WHERE 1 = 1 <br/>";

    for(let i = 0;  i < whereRequest.length; i++) {

        let el = whereRequest[i].split('***');

        criteria    = el[0];
        comparaison = el[1];
        value       = el[2];


        if( comparaison == "after") {
            whereString += ` AND ${criteria} > "${value}" `;
        }
    
        if( comparaison == "before") {
            whereString += ` AND ${criteria} < "${value}" `;
        }
    
        if( comparaison == "between") {
            let valueStart = value.split('|')[0];
            let valueTo    = value.split('|')[1];
            whereString += ` AND  ( ${criteria} > "${valueStart}" AND ${criteria} < "${valueTo}" ) `;
        }
    
        if( comparaison == "egal") {
            whereString += ` AND ${criteria} = "${value}" `;
        }
    
        if( comparaison == "in") {
            whereString += ` AND ${criteria} IN (${value}) `;
        }
    
        if( comparaison == "like") {
            whereString += ` AND ${criteria} LIKE "%${value}%" `;
        }

        whereString += "<br/>";
    }

    // creation du where
    $('#whereRequest').html(whereString);

    // creation du groupby
    $('#groupByRequest').html(" GROUP BY "+groupByRequest);

}





/***** SEND FORM */

const sendFormExtractList = () => {
    let sqlString = $('#showSqlRequest').text();
    let destinationType = $('#destinationType').val();
    let listName = $('#listName').val();

    if(listName == "") {
        listName = "liste sans nom";
    }

    let url = urlApi + 'extractList/create';

    whereRequest.push('GROUP BY '+groupByRequest);

    let data = {
                selectRequest : selectRequest,
                fromRequest : fromRequest,
                joinRequest : joinRequest,
                whereRequest : whereRequest,
                keyFilter : keyFilter,
                destinationType : destinationType,
                sqlString : sqlString,
                listName : listName,
                listId: listId
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
        }, success(data) {
            toastr.success("Saved");
            console.log(data);

            if(!haslist) {
                let urlReloaded = `${urlHost}requestBuilder/create/id/${data.ExtractList.id}/`;
                location = urlReloaded;
            }



        }, error(data) {
            console.log("error");
            console.log(data);
        }
    });
}


/**** update if exit */
if( haslist == true) {
    console.log(listId);

    listWhereRequestArr = listWhereRequest.split(',');

    for(el of listWhereRequestArr) {
        let whereElement = el.split('***');

        let criteria    = whereElement[0];
        let comparaison = whereElement[1];
        let value       = whereElement[2];

/*
        if ( comparaison == "between") {
            value = $('#fromInput').val()+'|'+$('#toInput').val();
        } else {
            value = $('#valInput').val();
        }
    
        let valueTxt = value;
*/


        createSqlWhere(criteria, comparaison, value, criteria, comparaison, value);

        console.log(el);
    }


}




/*** default when page loaded */
//updateSqlFrom();
//updateSqlSelect();