;

/** AJAX TRANSITION MANAGER PLUGIN
 *
 *  Author: Byron Morley
 *  updated: 13/03/17
 *
 */

/**     HOW TO USE
 *
 *
 *      Add code to php page you want to use ajax transition
 *
 *      public function index(){
 *
 *          if(Director::is_ajax()) {
 *              return $this->renderWith("ajax_template");
 *          } else {
 *              return $this->render();
 *          }
 *      }
 *
 *      create "ajax_template.ss"
 *
 *      add this code to it
 *
 *      <div id="trans-page-info" class="no-display" dec="$Transition_dec" inc="$Transition_inc"></div>
 *      <div class="animation-layer anim-leave" id="ajax-source">
 *      </div>
 *      <div class="animation-layer anim-enter" sort="$Sort">
 *
 *           !! ----   CONTENT GOES HERE   ---- !!
 *
 *      </div>
 *
 *
 *
 *      Add CMS Fields to Page.php
 *
 *
 *       public function getCMSFields()
         {
             $fields = parent::getCMSFields();
             $fields->addFieldToTab('Root.Ajax',
                 DropdownField::create(
                     'Transition_inc',
                     'Transition Increment',
                     array(
                         'slide-left' => 'Slide Left',
                         'slide-right' => 'Slide Right',
                         'fade-in' => 'Fade In',
                         'slide-down' => 'Slide Down',
                     )
                 )
             );
             $fields->addFieldToTab('Root.Ajax',
                 DropdownField::create(
                     'Transition_dec',
                     'Transition Decrement',
                     array(
                         'slide-right' => 'Slide Right',
                         'slide-left' => 'Slide Left',
                         'fade-in' => 'Fade In',
                         'slide-down' => 'Slide Down',
                     )
                 )
             );
             $fields->addFieldToTab('Root.Ajax', TextField::create('Ajax_class', 'Container Class'));
             $fields->addFieldToTab('Root.Layout', TextField::create('Page_class', 'Page Class'));

             return $fields;
         }
        private static $db = array(
         'Transition_inc'=>'Varchar(100)',
         'Transition_dec'=>'Varchar(100)',
         'Page_class'=>'Text',
         'Ajax_class'=>'Text',
         );


 *       add transition to less folder
 *
 *       add html to page holder
 *
 *      <div id="ajax-plugin-area" class="$Ajax_class">
        </div>

        add this script at the bottom of the holder

         <script>
         $(document).ready(function(){
                $('#ajax-plugin-area').ajax_plugin({

                    child_list:$('#ajax-child-list'),
                    ajax_container:'$Ajax_class',

                    nav_next_frame:'next-arrow',
                    nav_prev_frame:'back-arrow',

                    initialise_javascript_dependencies:function(){
                       //add callbacks here
                    }
                });
            });
         </script>

 *
 *
 *
 */


;(function ($, doc, win) {
    "use strict";


    //--------------------------------------//
    //              GLOBALS
    //--------------------------------------//

    var name = 'ajax_plugin';

    $.ajax_plugin = function (element, options) {

        //--------------------------------------//
        //       DEFAULT PLUGIN SETTINGS
        //--------------------------------------//

        var defaults = {

            //Div Classes and IDs

            ajax_link_class:        'ajax-link',
            ajax_container:         'ajax-container',
            animation_layer:        'animation-layer',
            source_id:              'ajax-source',
            animation_enter:        'anim-enter',
            animation_leave:        'anim-leave',

            //Callbacks

            initialise_javascript_dependencies:     null,
            load_page_callback:                     null,
            page_loaded_callback:                   null,
            start_animation_callback:               null,
            end_animation_callback:                 null,

            //navigation divs

            child_list:             null,
            nav_next_frame:         null, //class of the a tag for next nav
            nav_prev_frame:         null,  //class of the a tag for next nav

            url:                    null,
            abs_link:               null,

            freezable_content: []


        };


        //--------------------------------------//
        //       PLUGIN PRIVATE VARIABLES
        //--------------------------------------//

        var plugin = this; //use plugin instead of "this"
        var page_loading = false;

        var $child_list;
        var child_count;
        var current_page = 0;
        var $nav_next_frame;
        var $nav_prev_frame;

        //--------------------------------------//
        //       CUSTOM SETTING SETUP
        //--------------------------------------//


        plugin.settings = {}; //initialise empty settings object

        var $element = $(element),  // reference to the jQuery version of DOM element the plugin is attached to
            element = element;        // reference to the actual DOM element

        //gather individual plugin defaults from the attr tags in the plugin element
        //example attribute: <div data-{plugin name}-opts='{"custom_variable":"value"}' />*
        var meta = $element.data(name + '-opts');


        //--------------------------------------//
        //              CONSTRUCTOR
        //--------------------------------------//

        plugin.init = function () {

            // the plugin's final properties are the merged default and user-provided options (if any)
            plugin.settings = $.extend({}, defaults, options, meta);
            console.log("initialised plugin " + name);
            $element.css('position', 'relative');
            add_ajax_links();

            //setup initial frame, no animation
            if (plugin.settings.child_list) {

                setup_child_list();
                examine_url();

                if(plugin.settings.url){
                    load_url(plugin.settings.abs_link, false);
                }else{
                    navigate_to_child(current_page + 1);
                }

            } else {
                console.log('no child list found, failed to initialise ajax plugin');
            }
        };

        plugin.get_current_index = function(){
            return current_page;
        };


        //--------------------------------------//
        //              PUBLIC METHODS
        //--------------------------------------//

        /**
         *  these methods can be called like:
         *  plugin.methodName(arg1, arg2, ... argn) from inside the plugin or
         *  element.data('pluginName').publicMethod(arg1, arg2, ... argn) from outside the plugin, where "element"
         *  is the element the plugin is attached to;
         */

        //--------------------------------------//
        //              PRIVATE METHODS
        //--------------------------------------//
        /**
         *  these methods can be called only from inside the plugin like:
         *  methodName(arg1, arg2, ... argn)
         */

        var load_url = function (url, animate) {


            console.log("url "+url);
            load_page_static_callback();

            check_function_and_call(plugin.settings.load_page_callback);
            var $previous_page = $('.' + plugin.settings.animation_layer);
            var $container = $('.' + plugin.settings.ajax_container);

            $previous_page.removeClass('style');

            $.ajax(url)
                .done(function (response) {

                    check_function_and_call(plugin.settings.page_loaded_callback);
                    page_loaded_static_callback($container, $previous_page, response, animate, url);

                })
                .fail(function (xhr) {
                    alert('Error: ' + xhr.responseText);
            });
        };

        var transition = function ($previous_page, animate) {

            //Start Animation
            check_function_and_call(plugin.settings.start_animation_callback);
            start_animation_static_callback();

            var $ng_leave = $('.' + plugin.settings.animation_leave);
            var $ng_enter = $('.' + plugin.settings.animation_enter);

            var $animation_layer = $('.' + plugin.settings.animation_layer);
            $animation_layer.addClass('running');

            if (animate) { //checking which direction up or down the current menu system the animation is going

                var previous_sort_value = parseInt($previous_page.attr('sort'));
                var current_sort_value = parseInt($ng_enter.attr('sort'));

                //console.log("leave sort value " + previous_sort_value);
                //console.log("enter sort value " + current_sort_value);

                var incremental_animation = $('#trans-page-info').attr('inc');
                var decremental_animation = $('#trans-page-info').attr('dec');

                //console.log("incremental_animation " + incremental_animation);
                //console.log("decremental_animation " + decremental_animation);

                var transition_animation = (previous_sort_value < current_sort_value) ? incremental_animation : decremental_animation;
                //console.log("transition_animation " + transition_animation);
                $animation_layer.addClass(transition_animation);

            } else {
                $animation_layer.addClass('no-animation');
            }

            $ng_leave.attr('style', $previous_page.attr('style'));
            $ng_enter.attr('style', $previous_page.attr('style'));
            $ng_leave.html($previous_page.html());

            //end animation listener
            $ng_leave.css_animation_event_listener($animation_layer);

        };

        var setup_child_list = function () {
            $child_list = plugin.settings.child_list.find('li');
            child_count = $child_list.length;
        };

        var navigate_to_child = function (frame_number) {
            var $frame = $child_list.eq(frame_number - 1);
            load_url($frame.attr('link'), false);
        };

        var container_size_adjustments = function () {
            //add_ajax_links();
            setTimeout(function () {
                var $container = $('.' + plugin.settings.ajax_container);

                $('.animation-layer').css({
                    width: 100+'%',
                    height: 'auto',// $container.height(),
                    top: 0,
                    left: 0
                })
            }, 100);
        };

        var setup_navigation = function ($container) {

            var page_number = current_page;

            $nav_next_frame = $container.find('.' + plugin.settings.nav_next_frame);
            $nav_prev_frame = $container.find('.' + plugin.settings.nav_prev_frame);

            $nav_next_frame.add_click_navigation();
            $nav_prev_frame.add_click_navigation();

            reset_buttons();

            if (page_number == 0) {
                $nav_prev_frame.css('display', 'none');
            }
            if (page_number == child_count - 1) {
                $nav_next_frame.css('display', 'none');
            }

            $nav_prev_frame.attr('href', $child_list.eq(page_number - 1).attr('link'));
            $nav_next_frame.attr('href', $child_list.eq(page_number + 1).attr('link'));
        };

        var reset_buttons = function () {

            $nav_prev_frame.css('display', 'block');
            $nav_next_frame.css('display', 'block');

        };

        var examine_url = function(){

            var current_url = window.location.href;
            plugin.settings.abs_link = current_url.replace("#", "/");
            if(current_url.indexOf("#")!=-1){
                var hashtag = current_url.substr(current_url.indexOf("#") + 1);
                plugin.settings.url = hashtag;
                set_current_page_by_url(hashtag);
            }
        };

        var  set_current_page_by_url = function(url){

            $child_list.each(function(){

                if(url == extract_path_name($(this).attr('link'))){
                    current_page = $(this).index();
                }
            });
        };

        var extract_path_name = function(url){

            //Remove unwanted slash from end of path
            if(url.substr(-1) == "/"){
                url = url.substr(0,url.length -1);
            }
            return url.substr(url.lastIndexOf('/')+1);
        };

        var create_hash_url = function(url){

            if(url.substr(-1) == "/"){
                url = url.substr(0,url.length -1);
            }
            return url.replaceAt(url.lastIndexOf('/'), "#");

        };


        var initialise_dependencies = function () {

            console.log("add dependencies");

        };

        //--------------------------------------//
        //      STATIC CALLBACKS
        //--------------------------------------//
        /**
         * static callbacks should not be overridden by the user
         */

        var end_animation_static_callback = function () {
            console.log(name + ' - animation finished');
            container_size_adjustments();
            unfreeze_after_content();
        };

        var start_animation_static_callback = function(){
            console.log(name + ' - start animation');

            freeze_after_content();

        };

        var load_page_static_callback = function(){
            console.log(name + ' - loading page');
            page_loading = true;
        };

        var page_loaded_static_callback = function($container, $previous_page, response, animate, url){

            console.log(name + ' - page loaded');

            $container.html(response);
            setup_navigation($container);

            check_function_and_call(plugin.settings.initialise_javascript_dependencies);
            transition($previous_page, animate);
            window.history.pushState("string", "Title", create_hash_url(url));
            page_loading = false;

        };


        var freeze_after_content = function(){

            var freezable_content = plugin.settings.freezable_content;

            $(freezable_content).each(function(){
                var $freeze_element = $(this);
                var topPos   = $freeze_element[0].getBoundingClientRect().top    + $(window)['scrollTop']();
                $freeze_element.css({top:topPos, position:'absolute'});
            });
        };

        var unfreeze_after_content = function(){


            //do nothing

        };

        var get_footer_pos = function(){


            var leftPos  = $('.footer')[0].getBoundingClientRect().left   + $(window)['scrollLeft']();
            var rightPos = $('.footer')[0].getBoundingClientRect().right  + $(window)['scrollLeft']();
            var topPos   = $('.footer')[0].getBoundingClientRect().top    + $(window)['scrollTop']();
            var bottomPos= $('.footer')[0].getBoundingClientRect().bottom + $(window)['scrollTop']();

            console.log(leftPos + " : "+ rightPos + " : "+ topPos + " : "+ bottomPos);


        };

        var check_function_and_call = function(function_name){
            if(function_name){function_name();}
        };

        var add_ajax_links = function () {

            $('a').each(function () {

                if ($(this).hasClass('ajax-link')) {
                    $(this).add_click_function();
                }
            });
        };

        var adjust_page_position = function (direction) {

            if (direction == 'back' && current_page != 0) {
                current_page--;
            }
            if (direction == 'next' && current_page < child_count) {
                current_page++;
            }
        };

        //--------------------------------------//
        //    CUSTOM BINDING EVENTS
        //--------------------------------------//

        /**
         *    Add custom methods to selectors
         *    These are called by adding the function to the selectors
         *    eg: $('.element).bind_event(args);
         */

        $.fn.add_click_function = function (args) {
            return this.each(function () {

                $(this).on('click', function (e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    load_url(url, true);
                });
            });
        };

        $.fn.add_click_navigation = function (args) {
            return this.each(function () {

                $(this).on('click', function (e) {

                    e.preventDefault();
                    adjust_page_position($(this).attr('direction'));
                    var url = $(this).attr('href');
                    load_url(url, true);
                });
            });
        };

        $.fn.css_animation_event_listener = function ($animation_layer) {
            return this.each(function () {

                $(this).bind('oanimationend animationend webkitAnimationEnd', function () {

                    $animation_layer.removeClass('running');
                    $(this).remove();
                    //Start Animation
                    check_function_and_call(plugin.settings.end_animation_callback);
                    end_animation_static_callback();

                });
            });
        };

        //-----------------------------------------
        //				INITIALISATION
        //-----------------------------------------

        plugin.init();
    };
    String.prototype.replaceAt=function(index, character) {
        return this.substr(0, index) + character + this.substr(index+character.length);
    }

    //-----------------------------------------
    //				INVOCATION
    //-----------------------------------------

    /**
     *  element.data('pluginName').publicMethod(arg1, arg2, ... argn) or
     *  element.data('pluginName').settings.propertyName
     *
     */

    $.fn.ajax_plugin = function (options) {
        return this.each(function () {
            if (undefined == $(this).data(name)) {
                var plugin = new $.ajax_plugin(this, options);
                $(this).data(name, plugin);
            }
        });
    }
})(jQuery, document, window);