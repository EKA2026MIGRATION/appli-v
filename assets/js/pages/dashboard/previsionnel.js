
const openDatePicker = () => {
    $('#datePickerInline').show();
    $("#datePickerInline").datepicker({
      closeText: "Fermer",
      prevText: "Précédent",
      nextText: "Suivant",
      firstDay: 1,
      yearRange: "-2:+5",
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
      dateFormat: "yy-mm-dd",
      changeYear: true,
      onSelect(dateText) {
        jumpToDay(dateText);
      }
    });
  };
  
  function jumpToDay(dateText) {

          let currentPage = $('#currentPage').val();
          let url = "";

          if(currentPage == "inventory") {
              url = `${urlHost}/stock/inventory/date/${dateText}/`;
          } else {
              url = `${urlHost}/dashboard/previsionnel/date/${dateText}/`;
          }

          currentDate = dateText;
          $('#date').val(dateText);
          $('#datePickerInline').hide();
          locationRedirect(url);
  }
  
  $('.jumpToDayButton').click(function(e) {
      let currentDate = $('#date').val();
      let dateText;
      e.preventDefault();
      let direction = $(this).attr('id');
      if(direction == "previousDay") {
        dateText = previousDay(currentDate);
      } else {
        dateText = nextDay(currentDate);
      }
      jumpToDay(dateText);
  })
  
  function previousDay(myDate) {
    let newDate = myDate.split('-');
    let newDay = parseInt(newDate[2]) - 1;
    if(newDay < 10) {
      newDay = '0'+newDay;
    }
    return newDate[0]+'-'+newDate[1]+'-'+newDay;
  }
  
  function nextDay(myDate) {
    let newDate = myDate.split('-');
    let newDay = parseInt(newDate[2]) + 1;
    if(newDay < 10) {
      newDay = '0'+newDay;
    }
    return newDate[0]+'-'+newDate[1]+'-'+newDay;
  }
  
  $(() => {
    moveMenuLeft();
  });

  var moveMenuLeft = () => {

    var width = $(window).width();
    if(width > 1023)
    {
      let menuLeft = document.getElementsByClassName("menu__left")[0];
  
      $(menuLeft).animate(
        {
          marginLeft: "-=260px"
        },
        0
      );
  
      setTimeout(() => {
        $(".container__menu__left").css("width", "40px");
        $(".page__container").css("width", "calc(100% - 100px)");
        $(".closeLeftMenu i").html("arrow_forward");
      }, 0);
  
    }
  };