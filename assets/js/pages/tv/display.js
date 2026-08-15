$(() => {
  initTVEA();
});

const initTVEA = () =>
{
  setInterval(function() {
    $("#nbSecondes").html(parseInt($("#nbSecondes").html()) - 1);
  }, 1000);


  var owl = $('.owl-carousel');
  owl.owlCarousel({
      items:1,
      loop:true,
      margin:0,
      autoplay:true,
      autoplayTimeout:12000,
      autoplayHoverPause:true,
      navigation : true, 
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem: true,
      pagination: false,
      rewindSpeed: 500

  });

  owl.on('changed.owl.carousel', function(event) {
    $("#nbSecondes").html(12);
  })

}


