<?php

class Page_Controller extends ContentController
{
    private static $allowed_actions = array();

    public function init(){

        parent::init();
        // You can include any CSS or JS required by your project here.
        // See: http://doc.silverstripe.org/framework/en/reference/requirements
    }
    public function index()
    {
        if(Director::is_ajax()) {
            return $this->renderWith("ajax_page");
        } else {
            return $this->render();
        }
    }

    public function messageTest(){

        SS_Log::log(serialize('log here'), SS_Log::NOTICE);
    }

    public function PageByLang($url, $lang) {
        $SQL_url = Convert::raw2sql($url);
        $SQL_lang = Convert::raw2sql($lang);

        $page = Translatable::get_one_by_lang('SiteTree', $SQL_lang, "URLSegment = '$SQL_url'");

        if ($page->Locale != Translatable::get_current_locale()) {
            $page = $page->getTranslation(Translatable::get_current_locale());
        }
        return $page;
    }

}
