var animationInactive = true;
var menuOpen = false;

$(document).ready(function () {

    $('#hamburger-menu').on('click', function () {
        toggle_menu($(this));
    });

    var toggle_menu = function ($hamburger) {

        var $menu = $('.condensed-menu');

        if (menuOpen) { //close menu

            $hamburger.removeClass('active');
            animationInactive = false;
            $menu.animate({
                height:"0"
            },500, function(){
                animationInactive = true;
                menuOpen = false;
            });

        } else { //open menu

            var menu_height = get_menu_height();
            $hamburger.addClass('active');
            animationInactive = false;
            $menu.animate({
                height:menu_height+"px"
            },500, function(){
                animationInactive = true;
                menuOpen = true;
            });
        }
    };
});


function get_menu_height(){

    var $menu = $('.condensed-menu');
    $menu.css("height","auto");
    var height = $menu.height();
    $menu.css("height","0");

    return height;
}