<?php


class VideoAdmin extends ModelAdmin {

    private static $menu_title = 'Videos';

    private static $url_segment = 'videos';

    private static $managed_models = array (
        'VideoFile'
    );

}