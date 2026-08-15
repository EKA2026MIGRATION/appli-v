if(activeForm == "active") {
    $('.rateIcon').mouseover(function() {
    
        let answerId = $(this).attr('data-answer');
        let val      = $(this).attr('data-value');
    
        $('.answer-'+answerId).each(function() {
            if($(this).attr('data-value') <= val) {
                $(this).addClass('hoverIconRate');
            }
        })
    
    });
    
    
    $('.rateIcon').mouseout(function() {
        let answerId = $(this).attr('data-answer');
        let val      = $(this).attr('data-value');
    
        $('.answer-'+answerId).removeClass('hoverIconRate');
    });
    
    
    
    $('.rateIcon').click(function() {
        let answerId = $(this).attr('data-answer');
        let val      = $(this).attr('data-value');
    
    
        $('#questionId-'+answerId).val(val);
        $('#questionStaff-'+answerId).val(val);
        
        $('.answer-'+answerId).removeClass('hoverIconRate');
        $('.answer-'+answerId).removeClass('rateChecked');
    
        $('.answer-'+answerId).each(function() {
            if($(this).attr('data-value') <= val) {
                $(this).addClass('rateChecked');
            }
        })
        
    });
}

