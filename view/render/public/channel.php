<?php $title = "TV ENERGY KIDS ACADEMY"; ?>
<input type="hidden" name="sequences" value='<?= $params->jsonSequences; ?>' id="sequencesInfo" />

<div id="contentBack" style="height: 100%">
    <div id="contentTv">
    </div>
</div>



<script>
    var urlHost = $('#urlHost').val();
    var sequences = JSON.parse($('#sequencesInfo').val());
    var age = sequences[0].age;
    var instant_module = "";
    var instant_background = "";
    var nbSlides;
    var currentSlideId = 0;
    var next_i;
    var next_module_start;

    setInterval(function() {
        location.reload();
    }, 600000);

    callSequence();

    function callSequence() {

        // create the instant    
        var moment = new Date();
    //   moment = new Date(2024, 12, 11, 15, 45, 0); // to test

        var hours = moment.getHours();
        var min = moment.getMinutes();

        if (min < 10) {
            minString = "0" + min;
        } else {
            minString = "" + min;
        }
        var instant = hours + "" + minString;

        // create the instant module
        for (var i = 0; i < sequences.length; i++) {
            if (instant > sequences[i].start && instant < sequences[i].end) {
                instant_module = sequences[i].module;
                instant_background = sequences[i].background;

                next_id = i + 1;
                if (next_id >= sequences.length) {
                    next_id = 0;
                }
                next_module_start == sequences[next_id].start;
            }
        }

        document.getElementById('contentBack').style.backgroundImage = 'url(../uploads/tv/background/' + instant_background + ')';

        // call the right module
        var myUrl = urlHost + 'public/instant/module/' + instant_module + '/';

        if(age != 0) {
            myUrl += 'age/'+age + '/';
        }

        $('#contentTv').load(myUrl, function(event) {
            nbSlides = $('.instantViewSlide').length;

            if(nbSlides > 1) {
                intervalID = setInterval(changeSlide, 5000);
            } else {
                // stop the interval if intervalId is defined
                if (typeof intervalID !== 'undefined') {
                    clearInterval(intervalID);
                }

            }
        });
    }


    function checkChangeSequence() {

        var checkMoment = new Date();
        var checkHours = checkMoment.getHours();
        var checkMin = checkMoment.getMinutes();

        if (checkMin < 10) {
            minString = "0" + checkMin;
        } else {
            minString = "" + checkMin;
        }
        var checkInstant = checkHours + "" + minString;

        if (checkInstant > next_module_start) {
            clearInterval(intervalID);
            callSequence();
        }

    }


    function changeSlide() {

        checkChangeSequence();

        var currentImg = '#slide-' + currentSlideId;
        // show next
        currentSlideId++;
        if (currentSlideId == nbSlides) {
            currentSlideId = 0;
        }
        var nextImg = '#slide-' + currentSlideId;
        currentSlideId;

        var transitions = [
            // "cut
            "swipeLeft",
            "swipeRight",
            "translationLR",
            "translationRL"
            //"zoomIn"  
        ];

        var transition = transitions[Math.floor(Math.random() * transitions.length)];

        makeTransition(transition, currentImg, nextImg);

        // set display flex
        $(nextImg).css('display', 'flex');
    }

    function makeTransition(type, firstImg, secondImg) {


        if (type == "cut") {
            $(secondImg).show();
            $(firstImg).hide();
        };

        if (type == "swipeLeft") {
            $(firstImg).animate({
                left: "+=1500px",
            }, "slow", function() {
                $(secondImg).fadeIn('slow');
                $(firstImg).hide();
                $(firstImg).animate({
                    left: "-=1500px"
                });
            });
        }


        if (type == "swipeRight") {
            $(firstImg).animate({
                left: "-=1500px",
            }, "slow", function() {
                $(secondImg).fadeIn('slow');
                $(firstImg).hide();
                $(firstImg).animate({
                    left: "+=1500px"
                });
            });
        }


        if (type == "translationLR") {
            $(secondImg).animate({
                left: "-=1500px"
            });
            $(firstImg).animate({
                left: "+=1500px",
            }, "slow", function() {
                $(secondImg).animate({
                    left: "+=1500px"
                }, "slow");
                $(firstImg).hide();
                $(firstImg).animate({
                    left: "-=1500px"
                });
            });
        }

        if (type == "translationRL") {
            $(secondImg).animate({
                left: "+=1500px"
            });
            $(firstImg).animate({
                left: "-=1500px",
            }, "slow", function() {
                $(secondImg).animate({
                    left: "-=1500px"
                }, "slow");
                $(firstImg).hide();
                $(firstImg).animate({
                    left: "+=1500px"
                });
            });
        }
    }
</script>