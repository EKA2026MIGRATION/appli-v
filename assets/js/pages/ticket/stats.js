const filter = () => {
  var date = $("#dateStart").val();
  var d = new Date(
    date
      .split("/")
      .reverse()
      .join("-")
  );
  var dd = d.getDate();
  var mm = d.getMonth() + 1;
  var yy = d.getFullYear();
  var date_from = yy + "-" + mm + "-" + dd;

  var date2 = $("#dateEnd").val();
  var d2 = new Date(
    date2
      .split("/")
      .reverse()
      .join("-")
  );
  var dd2 = d2.getDate();
  var mm2 = d2.getMonth() + 1;
  var yy2 = d2.getFullYear();
  var date_to = yy2 + "-" + mm2 + "-" + dd2;

  let data = {
    date_from,
    date_to,
    persona: $("#persona").val(),
    type: $("#type").val(),
    category_id: $("#category").val(),
    location_id: $("#location").val(),
    recall: $("#recall").val(),
    origin: $("#origin").val(),
    has_been_treated: $("#has_been_treated").val(),
    limit: 250
  };

  let url = "ticket/list/criteria";
  let type = "POST";
  $.ajax({
    type: "POST",
    url: urlRequest,
    data: { type, url, data },
    dataType: "json",
    beforeSend() {},
    success(json) {
      $(".resultTicket").fadeIn();
      $("#ticketList").html("");
      var nbTickets = 0;
      if (json.message) {
        toastr.error(json.message);
      } else {
        var all = [];
        var category = [];
        var location = [];
        var persona = [];
        var origin = [];
        var has_been_treated = [];
        var recall = [];
        var type = [];

        Object.keys(json).forEach(function(k) {
          var heading = convertDate(k);
          $("#ticketList").append(`<header>${heading}</header>`);

          Object.keys(json[k]).forEach(function(e) {
            nbTickets++;
            $("#ticketList").append(
              `<li><a href="display/id/${json[k][e].id}/"><div><p class="list-header">${json[k][e].name} par ${json[k][e].tel}<div class="with-icon"> <i class="material-icons">send</i></div> </p>  </div> </a></li>`
            );

            all[json[k][e].tel] = (all[json[k][e].tel] || 0) + 1;
            if (json[k][e].category != null) {
              category[json[k][e].category.name] =
                (category[json[k][e].category.name] || 0) + 1;
            } else {
              category["Pas de catégorie"] =
                (category["Pas de catégorie"] || 0) + 1;
            }

            if (json[k][e].location != null) {
              location[json[k][e].location.name] =
                (location[json[k][e].location.name] || 0) + 1;
            } else {
              location["Pas de lieu"] = (location["Pas de lieu"] || 0) + 1;
            }

            if(json[k][e].persona == 'prospect') {
              var personaText = "Prospect";
            } else if(json[k][e].persona == 'customer') {
              var personaText = "Client";
            } else if(json[k][e].persona == 'old_customer') {
              var personaText = "Ancien client";
            } else if(json[k][e].persona == 'new_customer') {
              var personaText = "Nouveau client";
            } else if(json[k][e].persona == 'human_ressources') {
              var personaText = "RH";
            } else if(json[k][e].persona == 'providers') {
              var personaText = "Prestataire";
            } else if(json[k][e].persona == 'other') {
              var personaText = "Autre";
            } else {
              var personaText = "Non renseigné";
            }

            persona[personaText] =
              (persona[personaText] || 0) + 1;

            if(json[k][e].originCall == 'flyer') {
              var originText = "Flyers";
            } else if(json[k][e].originCall == 'internet') {
              var originText = "Internet";
            } else if(json[k][e].originCall == 'newspaper') {
              var originText = "Journaux";
            } else if(json[k][e].originCall == 'relatives') {
              var originText = "Relations";
            } else if(json[k][e].originCall == 'bus') {
              var originText = "Bus";
            } else if(json[k][e].originCall == 'other') {
              var originText = "Autre";
            } else {
              var originText = "Non renseigné";
            }

            origin[originText] =
              (origin[originText] || 0) + 1;

              if(json[k][e].hasBeenTreated == true) {
                var hasBeenTreatedText = "Oui";
              } else {
                var hasBeenTreatedText = "Non";
              }
            has_been_treated[hasBeenTreatedText] =
              (has_been_treated[hasBeenTreatedText] || 0) + 1;

              if(json[k][e].recall == true) {
                var recallText = "Oui";
              } else {
                var recallText = "Non";
              }
            recall[recallText] = (recall[recallText] || 0) + 1;

            if(json[k][e].type == 'info') {
              var typeText = "Info";
            } else if(json[k][e].type == 'change') {
              var typeText = "Changement";
            } else if(json[k][e].type == 'problem') {
              var typeText = "Relations";
            } else if(json[k][e].type == 'other') {
              var typeText = "Autre";
            } else {
              var typeText = "Non renseigné";
            }


            type[typeText] = (type[typeText] || 0) + 1;

          });
        });
        console.log(category);
        $("#nbTickets").html(nbTickets);

        var ctx = document.getElementById("myChart").getContext("2d");
        var myChart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: Object.keys(all),
            datasets: [
              {
                label: "Appels par numéro",
                data: Object.values(all),
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              yAxes: [
                {
                  ticks: {
                    beginAtZero: true
                  }
                }
              ]
            }
          }
        });

        var ctx2 = document.getElementById("myChart2").getContext("2d");
        var myChart2 = new Chart(ctx2, {
          type: "bar",
          data: {
            labels: Object.keys(category),
            datasets: [
              {
                label: "Répartition par catégories",
                data: Object.values(category),
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              yAxes: [
                {
                  ticks: {
                    beginAtZero: true
                  }
                }
              ]
            }
          }
        });

        var ctx3 = document.getElementById("myChart3").getContext("2d");
        var myChart3 = new Chart(ctx3, {
          type: "bar",
          data: {
            labels: Object.keys(location),
            datasets: [
              {
                label: "Répartition par lieu",
                data: Object.values(location),
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              yAxes: [
                {
                  ticks: {
                    beginAtZero: true
                  }
                }
              ]
            }
          }
        });

        var ctx4 = document.getElementById("myChart4").getContext("2d");
        var myChart4 = new Chart(ctx4, {
          type: "bar",
          data: {
            labels: Object.keys(has_been_treated),
            datasets: [
              {
                label: 'Répartition par "a été traité"',
                data: Object.values(has_been_treated),
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              yAxes: [
                {
                  ticks: {
                    beginAtZero: true
                  }
                }
              ]
            }
          }
        });

        var ctx5 = document.getElementById("myChart5").getContext("2d");
        var myChart5 = new Chart(ctx5, {
          type: "bar",
          data: {
            labels: Object.keys(recall),
            datasets: [
              {
                label: "Répartition par rappeler",
                data: Object.values(recall),
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              yAxes: [
                {
                  ticks: {
                    beginAtZero: true
                  }
                }
              ]
            }
          }
        });

        var ctx6 = document.getElementById("myChart6").getContext("2d");
        var myChart6 = new Chart(ctx6, {
          type: "bar",
          data: {
            labels: Object.keys(persona),
            datasets: [
              {
                label: "Répartition par persona",
                data: Object.values(persona),
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              yAxes: [
                {
                  ticks: {
                    beginAtZero: true
                  }
                }
              ]
            }
          }
        });

        var ctx7 = document.getElementById("myChart7").getContext("2d");
        var myChart7 = new Chart(ctx7, {
          type: "bar",
          data: {
            labels: Object.keys(type),
            datasets: [
              {
                label: "Répartition par type",
                data: Object.values(type),
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              yAxes: [
                {
                  ticks: {
                    beginAtZero: true
                  }
                }
              ]
            }
          }
        });

        var ctx8 = document.getElementById("myChart8").getContext("2d");
        var myChart8 = new Chart(ctx8, {
          type: "bar",
          data: {
            labels: Object.keys(origin),
            datasets: [
              {
                label: "Répartition par origine",
                data: Object.values(origin),
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              yAxes: [
                {
                  ticks: {
                    beginAtZero: true
                  }
                }
              ]
            }
          }
        });
      }
    }
  });
};

const convertDate = (date) => {
  date = new Date(date);
  date = date.toLocaleString('fr-FR');
  date = date.substring(0, date.length - 10);
  return date;
}
