/**
 * Created by Admin on 30/03/2017.
 */

var scenario_exercise_init = function () {

    bind_scenario_events();

};


var bind_scenario_events = function () {

    $('.submit-answers').on('click', function (e) {

        submit_scenario_form($(this).attr('id'));
        e.preventDefault();
    });

};
var submit_scenario_form = function (answer) {

    var $form = $('#Form_scenarioForm');
    $form.find('#Form_scenarioForm_answer_given').attr('value', answer);
    var url = $form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: $form.serialize(),
        success: function (data) {
            console.log('updated table');
        }
    });

};