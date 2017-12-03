<?php

class ModulePage extends Page
{

    private static $has_many = array(
        'Sections' => 'Section',
    );

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        /*$fields->addFieldToTab('Root.ContentTabs', GridField::create(
            'Contents',
            'Contents',
            $this->Contents(),
            GridFieldConfig_RecordEditor::create()
        ));*/

        /*********************************
         *      COMPONENT BUILDER
         ********************************/

        $dataColumns = new GridFieldDataColumns();
        $dataColumns->setDisplayFields(
            array(

                'ClassName' => 'Class Name'
            )
        );

        $multiClassConfig = new GridFieldAddNewMultiClass();
        $multiClassConfig->setClasses(
            array(
                'SectionImageBlock' => SectionImageBlock::get_section_type(),
                'SectionTextBlock'  => SectionTextBlock::get_section_type(),
                //'SectionConversationBlock'  => SectionConversationBlock::get_section_type(),
                'SectionGalleryBlock'  => SectionGalleryBlock::get_section_type(),
                'SectionYouTubeVideoBlock'  => SectionYouTubeVideoBlock::get_section_type(),
                'SectionLinkBlock'  => SectionLinkBlock::get_section_type(),
                //'SectionRevealAnswerBlock'  => SectionRevealAnswerBlock::get_section_type(),
                'SectionAudioBlock'  => SectionAudioBlock::get_section_type(),
                'SectionVideoBlock'  => SectionVideoBlock::get_section_type(),
            )
        );

        $config = GridFieldConfig_RelationEditor::create()
            ->removeComponentsByType('GridFieldAddNewButton')
            ->addComponents(
                new GridFieldOrderableRows('SortOrder'),
                new GridFieldDeleteAction(),
                $multiClassConfig,
                $dataColumns
            );

        $gridField = GridField::create('Sections', "Section", $this->Sections(), $config);
        $fields->addFieldToTab("Root.Sections", $gridField);



        return $fields;
    }
}

class ModulePage_Controller extends Page_Controller
{


    public function VideoFile($id)
    {
        return VideoFile::get()->filter('ID', $id);
    }

    public function module_number()
    {

        $sitetree = SiteTree::get()->filter('ID', $this->ParentID)->first();
        $module_number = explode('-', $sitetree->URLSegment)[1];

        SS_Log::log("module number " . $module_number, SS_Log::WARN);

    }

    public function is_the_last_module()
    {

        $page_type = "ModulePageHolder";
        $module = SiteTree::get()->filter('ClassName', $page_type)->sort('Sort', 'DESC')->first();

        if($this->parent->ID == $module->ID){
            return true;
        }
        return false;

    }

    public function is_the_last_page(){

        $page = SiteTree::get()
            ->filter('ParentID', $this->parent->ID)
            ->sort('Sort', 'DESC')->first();

        if($this->ID == $page->ID){
            return true;
        }
        return false;

    }
}