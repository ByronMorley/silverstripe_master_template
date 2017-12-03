$(document).ready(function(){

    $('.module-choices li').on('click', function(){
        toggle_content($(this));
    });
});

var toggle_content = function($el){

    //Remove current active boxes
    $('.module-intro-text').removeClass('active');
    $('.module-choices li').removeClass('active');
    $('.mod-button').removeClass('active');

    //add selected active box
    var id = $el.attr('for');
    $('#'+id).addClass('active');
    $('.'+id).addClass('active');
    $el.addClass('active');
};