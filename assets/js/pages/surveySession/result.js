$('.titleResult').click(function() {
    
    let type = $(this).attr('data-type');
    let col = $(this).attr('data-col');

    let table = "";
    table = $(this).attr('data-table');

    if (table == undefined) {
        table = "";
    }

    let elements = [];

    $('.notationRow'+type+table).each(function() {

        let colValue = "";            
        colValue = $(this).attr('data-'+col);
        if(col == "notation") {
            colValue = parseFloat(colValue);
        }
        elements.push({ colKey: colValue, row: $(this).prop('outerHTML')});
    })

    // reorder
    if(col == "notation") {
        elements.sort((a, b) => {
            return a.colKey - b.colKey;
        });
    
    }

    if(col == "name" || col == "childname") {
        elements.sort((a, b) => {
            let fa = a.colKey.toLowerCase(),
                fb = b.colKey.toLowerCase();
            if (fa < fb) {
                return -1;
            }
            if (fa > fb) {
                return 1;
            }
            return 0;
        });
    }

    if(col == "date") {
        elements.sort((a, b) => {
            let da = new Date(a.colKey),
                db = new Date(b.colKey);
            return da - db;
        });
    }

   let html = "";
    elements.forEach((e) => {
        console.log(`${e.colKey}`);

        html += e.row;
    });

    $('#containerResult'+type+table).html(html);

    



})
