<?php



function showScaleBarSurvey($item, $answer, $scale = 5) {


    ($answer== null) ? $answerValue = 0 : $answerValue = $answer;
    
    $answerId = null;

    $html = "";
    for($i = 1; $i <= $scale; $i++) {

        if($i <= $answerValue) {
            $class = "rateChecked";
        } else {
            $class = "rateDefault";
        }


        $html .= '<i class="material-icons '.$class.' rateIcon answer-'.$answerId.'" data-answer="'.$answerId.'" data-value="'.$i.'" >
                    star_rate
                  </i>';
    }

    echo $html;


}

function showScaleBar($item, $answer, $scale, $prev = false) {


        ($answer->answer == null) ? $answerValue = 0 : $answerValue = $answer->answer ;

        $html = "";
        for($i = 1; $i <= $scale; $i++) {

            if($i <= $answerValue) {
                $class = "rateChecked";
            } else {
                $class = "rateDefault";
            }

            if($prev == false) {
                $rateIcon = "rateIcon";
                $size = "";
            } else {
                $rateIcon = "";
                $size = "font-size: 12px;";
            }

            $html .= '<i  style="'.$size.'" class="material-icons '.$class.' '.$rateIcon.' answer-'.$answer->id.'" data-answer="'.$answer->id.'" data-value="'.$i.'" >
                        star_rate
                      </i>';
        }

        // add reset button
        if($prev == false) {
            $html .= '<i style="cursor: pointer; margin-left: 10px; color: darkred" class="material-icons resetIcon answer-'.$answer->id.'" data-answer="'.$answer->id.'" data-value="0" >
                        clear
                      </i>';
        }

        echo $html;
 

}

function showEvaluationIconStatus($status) {
    if($status == "draft") {
        $html = '<i class="material-icons">gesture</i>';
    };
    if($status == "ready") {
        $html = '<i class="material-icons">verified</i>';
    };
    if($status == "toreread") {
        $html = '<i class="material-icons">pan_tool_alt</i>';
    };
    if($status == "published") {
        $html = '<i class="material-icons">check</i>';
    };
    return $html;

}