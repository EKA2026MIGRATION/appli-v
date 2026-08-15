$('[data-rating] .star').on('click', function() {
  var selectedCssClass = 'selected';
  var $this = $(this);
  $this.siblings('.' + selectedCssClass).removeClass(selectedCssClass);
  $this
    .addClass(selectedCssClass)
    .parent().addClass('is-voted');
});

const addClass = data => {
    if ($(data).hasClass("asso-food") === true) {
        $(data).removeAttr("checked");
    } else {
        $(data).attr("checked");
    }
    $(data).toggleClass("asso-food");
};
