var line = "";

// dispatch driver zones

$('.editDriverZones').click(function() {
    $(this).next().toggle();
})


function loadListenerClick() {
    $('.selectButtonDriversZone').click(function() {
        console.log('hello');
        let newPriority;
        let idElement = $(this).attr('id');
        let zoneId = idElement.split('-')[2];
        console.log(idElement);
        let direction = idElement.split('-')[0];
        let priority = $('#driversZone-priority-value-'+zoneId).text();
        if(direction == "plus") {
            newPriority = parseInt(priority) + 1;
        } else {
            newPriority = parseInt(priority) - 1;
            if(newPriority == 0 ) {
                newPriority = 1;
            }
        }
        // update the priority
        let url = "staff/updatePriorityZone/"+zoneId+"/"+newPriority;


        console.log(url);


        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type: "GET" },
            dataType: "json",
            beforeSend() {
            },
            success(json) {
                console.log(json);
                $('#driversZone-priority-value-'+zoneId).text(newPriority);
            }
        });


    })
}

loadListenerClick();


$('.addDriverZone').keypress(function(e) {
    if(e.which === 13){
        let idElement = $(this).attr('id');
        let staffId = idElement.split('-')[1];
        let postal  = $('#'+idElement).val();

        // add addDriverZone
        let url = "staff/fastAddDriveZone/"+staffId;

        let dataDriverZone = {postal: postal};

         $.ajax({
            type: "POST",
            url: urlRequest,
            data: { type: "PUT", url, data: dataDriverZone },
            dataType: "json",
            beforeSend() {
            },
            success(json) {
                console.log(json);

                $('#'+idElement).val("");


                line = `${json.postal} 
                        <i  class="material-icons selectButtonDriversZone" 
                            style="cursor: pointer; line-height: 0; font-size: 12px" 
                            id="minus-driversZone-${json.driverZoneId}-value">
                            keyboard_arrow_left
                        </i>
                            <span id="driversZone-priority-value-${json.driverZoneId}">${json.priority}</span>
                        <i  class="material-icons selectButtonDriversZone"
                            style="cursor: pointer; line-height: 0; font-size: 12px" 
                            id="plus-driversZone-${json.driverZoneId}-">
                            keyboard_arrow_right
                        </i>
                        `;
                $('#divListDriverZone-'+staffId).append(line);

                 $('.selectButtonDriversZone').off('click');
                 loadListenerClick();
            }
        });



    }
      

})
