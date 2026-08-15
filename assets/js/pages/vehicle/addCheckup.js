document.getElementById("checkVehicleForm").addEventListener(
  "submit",
  event => {
    event.preventDefault();
    let form = $("#checkVehicleForm");
    let url = form.attr("action");
    let type = "POST";
    var is_ok = 1;
    var items = [];
    var staff = $("#staff_id_checkup").val();
    var vehicle_id = $("#vehicule_id_checkup").val();
    var comment = $("#comment_checkup").val();
    var date_checkup = $("#date_checkup_send").val();


    $("#list_checkup")
      .find(":checkbox")
      .each(function () {

        var constant_ok = 0;

        if ($(this).is(":checked")) {
          constant_ok = 1;
        } else {
          // Créer un rappel

          var currentDate = moment();
          var dateFormat = moment(currentDate).format('YYYY-MM-DD')
 
          let dataReminder = {
            staff_id: staff,
            vehicle: vehicle_id,
            name: $(this).parent().parent().parent().find('p').text(),
            description: 'Checkup non valide - élement à vérifier',
            criteria: 'date',
            criteriaValue: '>',
            criteriaComparison: dateFormat,
            status : 'todo',
            url: 'https://appli-v.net/vehicle/list'
          };


          $.ajax({
            type: "POST",
            url: urlRequest,
            data: {
              type,
              url: 'reminder/create',
              data: dataReminder
            },
            dataType: "json",
            beforeSend() {},
            success(json) {}
          });

          is_ok = 0;
        }

        let constant = $(this).attr('id');
        var obj = {};
        obj[constant] = constant_ok;

        items.push(obj);

      });

    let data = {
      staff,
      vehicle_id,
      is_ok,
      comment,
      date_checkup,
      items
    };

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: {
        type,
        url,
        data
      //  items: arrayConstant
      },
      dataType: "json",
      beforeSend() {
        $("#checkVehicleForm [type=submit]")
          .attr("disabled", true)
          .attr("value", "Envoyer");
      },
      success(json) {
        $("#checkVehicleForm [type=submit]")
          .attr("disabled", false)
          .attr("value", "Envoyer");
          
          toastr.success('Merci les informations sont validées !');
          $('#revealAddCheckup').close;
          $( "#closeCheckForm" ).trigger( "click" );

      }
    });

  },
  false
);



$('#closeCheckForm').click(function() {
  $('#revealAddCheckup').close;
})