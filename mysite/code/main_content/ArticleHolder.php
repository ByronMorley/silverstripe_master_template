<?php
class ArticleHolder extends Page {

    private static $db = array (
        'TabCount'=>'Varchar(20)',
    );

    private static $allowed_children = array(
        'Article',

    );

    private static $has_one = array (
        'Banner' => 'Image',
    );

    public function getCMSFields() {

        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Banner', $photo = UploadField::create('Banner'));
        $photo->setFolderName('banners');

        $fields->addFieldToTab('Root.Layout',
            DropdownField::create(
                'TabCount',
                'Tabs per row',
                array(
                    'row-2' => '2',
                    'row-3' => '3',
                    'row-4' => '4',
                )
            )
        );
        return $fields;
    }



}
class ArticleHolder_Controller extends ContentController {



}
