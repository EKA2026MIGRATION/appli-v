$(() => {
  countPlaces();
  colorRide();
});


var colorRide = () => {
  $(".column2")
    .find("section")
    .each(function() {
      if ($(this).attr("data-hour") <= 1159) {
        $(this)
          .find("header")
          .css("background-color", "#FFDC00");
      }

      if (
        $(this).attr("data-hour") > 1200 &&
        $(this).attr("data-hour") < 1400
      ) {
        $(this)
          .find("header")
          .css("background-color", "#3D9970");
      }

      if (
        $(this).attr("data-hour") >= 1400 &&
        $(this).attr("data-hour") < 1700
      ) {
        $(this)
          .find("header")
          .css("background-color", "#FF851B");
      }

      if ($(this).attr("data-hour") >= 1700) {
        $(this)
          .find("header")
          .css("background-color", "#B10DC9");
      }
    });
};


var countPlaces = () => {
  const nbRide = $(".column2 > section > ul").length;
  let x = 0;
  let nbRideFull = 0;
  $(".column2")
    .find("section")
    .each(function() {
      x++;
      const idRide = $(this).attr("data-id-ride");
      const nbPickUpInRide = $(`[data-id-ride=${idRide}] ul > li`).length;
      const nbPlacesMax = $(`[data-id-ride=${idRide}] .nbPlacesMax`).html();


      $(`[data-id-ride=${idRide}] .nbPlaces`).html(nbPickUpInRide);

      if (nbPickUpInRide > nbPlacesMax) {
        nbRideFull++;
        $(`[data-id-ride=${idRide}] .nbPlaces`).addClass(
          "nbPlacesWarning"
        );


      } else {
        $(`[data-id-ride=${idRide}] .nbPlaces`).removeClass(
          "nbPlacesWarning"
        );



      }

    });
};
