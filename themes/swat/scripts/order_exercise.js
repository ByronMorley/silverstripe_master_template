/**
 * Created by Admin on 29/03/2017.
 */

var order_exercise_init = function () {

    bind_order_events();

};

var bind_order_events = function () {

    $('.submit-answers').on('click', function (e) {
        update_order_input_form();
        submit_order_form();
        e.preventDefault();
    });
};

var update_order_input_form = function () {

    $('#selection-area>li').each(function () {

        var id = 'form-' + $(this).attr('id');
        $('#' + id).attr('value', $(this).index() + 1);
    });
};

var submit_order_form = function () {

    var $form = $('#Form_orderForm');
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