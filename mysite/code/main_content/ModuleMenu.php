<?php
class ModuleMenu extends Page {


}
class ModuleMenu_Controller extends ContentController {

    public function init() {
        parent::init();
        Requirements::javascript($this->ThemeDir()."/ext_scripts/toggle_menu.js");
    }

}
