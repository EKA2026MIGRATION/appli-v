$('.taskName').click(function() {
  let id = $(this).attr('id');
  let taskId = id.split('-')[1];
  $('#taskDescription-'+taskId).toggle();
//  $(this).next('div').toggle();
})
/*
$('.taskInfo').mouseleave(function() {
  $(this).next('div').hide();
})*/
$('.showDescription').click(function() {
  $(this).hide();
})
