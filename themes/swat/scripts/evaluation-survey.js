var exercise_init = function () {

    bind_exercise_events();

};

var bind_exercise_events = function () {

    $('.tick-box').on('click', function () {
        click_choice($(this));
    });

    $('#submit-evaluation').on('click', function (e) {
        evaluation_submission();
        submit_eval_form();
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });
};

var evaluation_submission = function () {

    console.log('setup submission');

    $('.eval-choice').each(function () {

        var $choice = $(this);
        var form_choice_id = "form-" + $choice.attr('id') + "-choice";

        if (has_extended_textarea($choice)) {

            var form_text_id = "form-" + $choice.attr('id') + "-text";

            $('#' + form_text_id ).val($choice.find('textarea').val());
            $('#' + form_choice_id).val(1);

        }else{
            if ($choice.find('.tick-box').hasClass('checked')) {
                $('#' + form_choice_id).val(1);
            }
        }
    });
};

var submit_eval_form = function(){

    var $form = $('#Form_evaluationForm');
    var url = $form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: $form.serialize(),
        success: function(data){
            console.log('updated table');
        }
    });
};

var is_choice_checked = function ($choice) {
    return $choice.find('.tick-box').hasClass('checked');
};

var click_choice = function ($click_item) {

    var $question = get_question($click_item);
    var $choice = $click_item.parent();

    if ($click_item.hasClass('checked')) {
        $click_item.removeClass('checked');
        fold_text_area($question.find('.unfold'));
    } else {
        perform_click_function($question, $click_item, $choice);
    }
};

var perform_click_function = function ($question, $click_item, $choice) {

    if ($question.find('.unfold').length > 0) {
        fold_text_area($question.find('.unfold'));
    }

    if (multiple_clicks_enabled($question)) {
        $click_item.addClass('checked');

    } else {
        $question.find('.eval-choice').each(function () {
            $(this).find('.tick-box').removeClass('checked');
        });
        $click_item.addClass('checked');
    }

    if (has_extended_textarea($choice)) {

        var $textarea = $choice.find('textarea');

        if ($textarea.hasClass('fold')) {
            unfold_text_area($textarea);
        }
    }
};

var unfold_text_area = function ($textarea) {

    $textarea.css("display", "block");

    $textarea.animate({
        height: "100px"
    }, 500, function () {
        $textarea.attr("class", "unfold");
    });
};

var fold_text_area = function ($textarea) {

    $textarea.animate({
        height: "0px"
    }, 500, function () {
        $textarea.attr("class", "fold");
        $textarea.css("display", "none");
    });
};

var has_extended_textarea_by_question = function ($question) {

    var $choice = $question.find('.eval-choice');

    var $textarea = null;

    $choice.each(function () {
        if (has_extended_textarea($(this))) {
            $textarea = $(this);
        }
    });

    return $textarea;
};

var get_textarea = function ($question) {

    return $question.find('textarea');

};


var has_extended_textarea = function ($choice) {

    return parseInt($choice.attr('type')) == 1;
};

var multiple_clicks_enabled = function ($question) {

    return parseInt($question.attr('type')) == 1;
};

var get_question = function ($click_item) {

    var id = $click_item.parent().attr('id');
    var $question = null;

    $('.eval-question').each(function () {
        if ($(this).find('#' + id).length > 0) {
            $question = $(this);
        }
    });

    return $question;
};

