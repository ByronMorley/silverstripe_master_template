

var question_exercise_init = function(){

    add_selected_answers();
    bind_events();

};

var add_selected_answers = function(){

    $('#answers-given').find('li').each(function(){

        var question_id = $(this).attr('questionid');
        var answer_given = parseInt($(this).text());
        var $answer = $('#question-'+question_id).find('.answers li').eq(answer_given-1);
        select_answer($answer);
    });
};

var select_answer = function($answer){

    var $answer_list = $answer.parent();
    $answer_list.find('li').removeClass('selected');
    $answer.addClass('selected');
    var $question = $answer_list.parent();
    $question.attr('answer', $answer.index()+1);

    update_input_form();

};

var update_input_form = function(){

    $('.questions>li').each(function(){

        var id = 'form-' +$(this).attr('id');
        $('#'+id).attr('value', $(this).attr('answer'));
    });
};

var bind_events = function(){

    $('.answers li').on('click', function(){
        select_answer($(this));
    });

    $('.submit-answers').on('click', function(e){
        submit_form();
        e.preventDefault();
    });
};

var submit_form = function(){

    var $form = $('#Form_questionForm');
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