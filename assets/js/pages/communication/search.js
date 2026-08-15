$(".block-list header a").click(function() {
    let element = $(this)
        .parent()
        .next("ul");

    if (
        $(element)
            .find("li")
            .css("display") == "none"
    ) {
        $(element)
            .find("li")
            .show();
        $(element)
            .find("div")
            .show();
        $(this).find('i').html("keyboard_arrow_up");
    } else {
        $(element)
            .find("li")
            .hide();
        $(element)
            .find("div")
            .hide();
        $(this).find('i').html("keyboard_arrow_down");
    }
});

