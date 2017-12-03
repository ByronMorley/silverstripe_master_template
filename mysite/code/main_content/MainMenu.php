<?php
class MainMenu extends Page {


}
class MainMenu_Controller extends ContentController {

    public function MenuPages(){

        return SiteTree::get()->filter('ShowInMenus', 1);

    }
}
