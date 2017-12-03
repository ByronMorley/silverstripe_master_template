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
};var exercise_init = function () {

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

;var max_image_event = function() {
    $(".overlay").on("click", function () {
        var tab_item = $(this).parent();
        var img = tab_item.find('.cover-image');

        $('#imagepreview').attr('src', img.attr('src'));
        $('#myModalLabel').text(tab_item.find('.menu-title').text());
        $('#imagemodal').modal('show');
    });
};

var video_init = function(){
    $('.anim-enter').find('video').attr('id');
    var id = $('video').attr('id');
    if(videojs.getPlayers()[id]) {
        delete videojs.getPlayers()[id];
    }
    videojs(id, { "aspectRatio":"16:9", "playbackRates": [1, 1.5, 2] }, function(){
        console.log('video player initialised');
    });
};;/*---------------- HADES DRAG AND DROP PLUGIN -----------------*/
;(function($, doc, win) {
    "use strict";

    /*---------------------- GLOBAL VARIABLES ------------------------*/

    var name = 'hades_dnd';
    var $self;
    var $el;
    var defaults;

    var over_another_element = false;
    var $hover_element;
    var draggable_item_is_active = true;
    var $active_drag_item;
    var clicked_item_selected = false;
    var $clicked_item = null;
    var hovering_over_an_item = false;

    /*---------------------- INITIALISATION ------------------------*/

    function App(el, opts) {
        console.log("Hades Drag and Drop Activated");

        this.$el = $(el);
        this.$el.data(name, this);

        this.defaults = {

            dnd_tag_type: 'li',

            area_class_name: 'area',
            highlight_class_name: 'highlight',

            click_and_drop_active:true,
            drag_and_drop_active:true

        };

        var meta = this.$el.data(name + '-opts');
        this.opts = $.extend(this.defaults,opts, meta);

        this.init();
    }

    App.prototype.init = function() {

        /*---------------------- VARIABLES ------------------------*/

        $self = this;
        $el = $self.$el;
        defaults = $self.defaults;

        bind_events();
    };
    /*---------------------- PRIVATE FUNCTIONS ------------------------*/

    /**
     * Create an object that contains all variables need to manipulate a drag and drop event
     * The function is polymorphic and will construct the object based on the input outlined in the param opts below
     *
     * @param opts  {origin_element: jquery_element,  destination_area: jquery_element, destination_element}
     * @returns {{}}
     */
    function create_dnd_object(opts) {
        var dnd_object =  {};

        if (opts.origin_element) {
            var $origin_area = opts.origin_element.parent();

            dnd_object.origin_element = opts.origin_element;
            dnd_object.origin_element_id = opts.origin_element.attr('id');
            dnd_object.origin_element_inner_html = opts.origin_element.html();

            dnd_object.origin_area = $origin_area;
            dnd_object.origin_area_id = $origin_area.attr('id');
            dnd_object.origin_index = opts.origin_element.index();
        }
        
        if (opts.destination_area) {
            dnd_object.destination_area = opts.destination_area;
            dnd_object.destination_area_id = opts.destination_area.attr('id');
        }
        
        if (opts.destination_element) {
            dnd_object.destination_element = opts.destination_element;
            dnd_object.destination_element_id = opts.destination_element.attr('id');
            dnd_object.destination_index = opts.destination_element.index();

            dnd_object.destination_area = opts.destination_element.parent();
            dnd_object.destination_area_id = opts.destination_element.parent().attr('id');
        }

        return dnd_object;
    }

    /*---------------------- BINDING FUNCTIONS ------------------------*/
    function bind_events() {
        var $areas = $el.find('.'+defaults.area_class_name);
        var $dnd_items = $areas.find(defaults.dnd_tag_type);

        if (defaults.click_and_drop_active) {
            $dnd_items.add_click_to_drop_function();
        }
        
        if (defaults.drag_and_drop_active) {
            $dnd_items
                .add_drag_function_to_element()
                .add_drop_function_to_element();
            $areas.add_drop_function_to_area();
        }
        click_elsewhere();
    }
    
    function click_elsewhere() {
        $('body').on('click', function() {
            if (clicked_item_selected) {
               if (!hovering_over_an_item) {
                   $clicked_item.removeClass('selected');
                   $clicked_item = null;
                   clicked_item_selected = false;
               }
            }
        });
    }

    function swap_elements(dnd_event, tag) {
        dnd_event.origin_area.find(tag).eq(dnd_event.origin_index).before(dnd_event.destination_element);

        if (dnd_event.destination_index<dnd_event.origin_index) {
            dnd_event.destination_area.find(tag).eq(dnd_event.destination_index).before(dnd_event.origin_element);
        }
        else {
            dnd_event.destination_area.find(tag).eq(dnd_event.destination_index).after(dnd_event.origin_element);
        }
    }
    /*---------------------- CUSTOM BINDING EVENTS ------------------------*/

    $.fn.add_click_to_drop_function = function() {
        return this.each(function () {
            $(this).on('click', function() {
                console.log('click');

                if (clicked_item_selected) {
                    console.log('swap items');

                    var tag = defaults.dnd_tag_type;
                    var dnd_event = create_dnd_object({origin_element:$clicked_item, destination_element:$(this)});

                    swap_elements(dnd_event, tag);

                    $clicked_item.removeClass('selected');
                    $clicked_item = null;
                    clicked_item_selected = false;

                }
                else {
                    console.log('item selected');
                    $clicked_item = $(this);
                    clicked_item_selected = true;
                    $clicked_item.addClass('selected');
                }
            });

            $(this).on('mouseover', function() {
                //console.log("mouseover");
                hovering_over_an_item = true;
            });
            $(this).on('mouseleave', function() {
                //console.log("mouseLeave");
                hovering_over_an_item = false;
            });
        });
    };

    $.fn.add_drag_function_to_element = function() {
        return this.each(function () {
            $(this).draggable({
                helper:'clone',
                start: function(event, ui) {
                    if ($clicked_item!=null) {
                        $clicked_item.removeClass('selected');
                        $clicked_item = null;
                        clicked_item_selected = false;
                    }

                    draggable_item_is_active = true;
                    $active_drag_item = $(this);

                    console.log("Started dragging "+ $(this).attr('id'));
                    $(this).css('visibility', 'hidden');
                },
                stop:function(event, ui) {
                    draggable_item_is_active = false;
                    console.log("Stopped dragging "+ $(this).attr('id'));
                    $(this).css('visibility', 'visible');
                }
            });
        });
    };

    $.fn.add_drop_function_to_element = function() {
        return this.each(function() {
            $(this).droppable({
                over: function(event, ui) {
                    over_another_element = true;
                    $hover_element = $(this);
                    $hover_element.addClass(defaults.highlight_class_name);
                },
                out: function (event, ui) {
                    over_another_element = false;
                    $hover_element = $(this);
                    $hover_element.removeClass(defaults.highlight_class_name);
                },
                deactivate: function(event, ui) {
                    //console.log("deactivate droppable "+ $(this).attr('id'));
                }
            });
        });
    };

    $.fn.add_drop_function_to_area = function() {
        return this.each(function () {
            $(this).droppable({
                drop: function(event, ui) {
                    var dnd_event = create_dnd_object({origin_element:$(ui.draggable),  destination_area:$(this)});
                    var tag = defaults.dnd_tag_type;
                    var new_element = '<'+tag+' id="' + dnd_event.origin_element_id + '" answer-id="'+dnd_event.origin_element.attr('answer-id')+'">' + dnd_event.origin_element_inner_html + '</>';
                    dnd_event.origin_element.remove();

                    if (over_another_element) { //swap places with item
                        $hover_element.removeClass(defaults.highlight_class_name);
                        var hover_element_index = $hover_element.index();
                        $(this).find(tag).eq(hover_element_index).before(new_element);
                        $('#'+dnd_event.origin_area_id+' '+tag).eq(dnd_event.origin_index).before($hover_element);
                    }
                    else {
                        $('#' + dnd_event.destination_area_id).append(new_element);
                    }
                    
                    // re-bind events to the new element
                    $('#' + dnd_event.origin_element_id)
                        .add_drag_function_to_element()
                        .add_drop_function_to_element()
                        .add_click_to_drop_function();
                }
            });
        });
    };

    //-----------------------------------------
    //				INVOCATION
    //-----------------------------------------

    $.fn.hades_dnd = function(opts) {
        return this.each(function() {
            new App(this, opts);
        });
    };

})(jQuery, document, window);;;

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
})(jQuery, document, window);;;(function ($, doc, win) {
    "use strict";


    //--------------------------------------//
    //              GLOBALS
    //--------------------------------------//

    var name = 'app_name';
    var ID = 678401;

    
    $.app_name = function (element, options) {


        //--------------------------------------//
        //       DEFAULT PLUGIN SETTINGS
        //--------------------------------------//

        var defaults = {

			required:true

        };


        //--------------------------------------//
        //       PLUGIN PRIVATE VARIABLES
        //--------------------------------------//

        var plugin = this; //use plugin instead of "this"
        var id = ID;  //set unique ID for plugin instance

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

            console.log("initialised plugin " + name + " -- " + id);

      


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

        plugin.foo_public_method = function () {

            // code goes here

        };


        //--------------------------------------//
        //              PRIVATE METHODS
        //--------------------------------------//
        /**
         *  these methods can be called only from inside the plugin like:
         *  methodName(arg1, arg2, ... argn)
         */

        var private_method = function () {
			
			// code goes here
            

        };

       


        //--------------------------------------//
        //    CUSTOM BINDING EVENTS
        //--------------------------------------//
		
		/**
		*	Add custom methods to selectors
		*	These are called by adding the function to the selectors
		*	eg: $('.element).bind_event(args);
		*/
		
        $.fn.bind_event = function (args) {
            
		
			// code goes here
			
        };

        
   

      


        //-----------------------------------------
        //				INITIALISATION
        //-----------------------------------------

        plugin.init();


    };


    //-----------------------------------------
    //				INVOCATION
    //-----------------------------------------

    /**
     *  element.data('pluginName').publicMethod(arg1, arg2, ... argn) or
     *  element.data('pluginName').settings.propertyName
     *
     */

    $.fn.app_name = function (options) {
        return this.each(function () {
            if (undefined == $(this).data(name)) {
                var plugin = new $.app_name(this, options);
                $(this).data(name, plugin);
            }
        });
    };
})(jQuery, document, window);;/*---------------- PLUGIN -----------------*/

;(function($, doc, win){
    "use strict";

    /*---------------------- GLOBAL VARIABLES ------------------------*/

    var name = 'plugin name';
    var self, $el, opts;

    /*---------------------- INITIALISATION ------------------------*/

    function App(el, opts){

        console.log(name+" activated");

        this.$el = $(el);
        this.$el.data(name, this);

        this.defaults = {

            required:true

        };

        var meta = this.$el.data(name + '-opts');
        this.opts = $.extend(this.defaults,opts, meta);

        this.init();
    }

    App.prototype.init = function() {

        /*---------------------- VARIABLES ------------------------*/

        self = this;
        $el = self.$el;
        opts = self.defaults;


    };

    /*---------------------- BINDING FUNCTIONS ------------------------*/





    /*---------------------- PRIVATE FUNCTIONS ------------------------*/


    //-----------------------------------------
    //				INVOCATION
    //-----------------------------------------

    $.fn.plugin_name = function(opts) {
        return this.each(function() {
            new App(this, opts);
        });
    };

})(jQuery, document, window);




;/**
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
};;

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
};;/**
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

};;$(document).ready(function(){

});


